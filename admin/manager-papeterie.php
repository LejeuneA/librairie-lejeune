<?php

require_once __DIR__ . '/settings.php';

requireLogin();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );
}

$msg = null;
$result = [];
$execute = false;

/*
|--------------------------------------------------------------------------
| Flash message
|--------------------------------------------------------------------------
*/

if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];

    unset($_SESSION['message']);
}

/*
|--------------------------------------------------------------------------
| Delete request
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['action'] ?? '') === 'delete-papeterie'
) {
    $submittedToken = (string) (
        $_POST['csrf_token'] ?? ''
    );

    $sessionToken = (string) (
        $_SESSION['csrf_token'] ?? ''
    );

    if (
        $submittedToken === ''
        || $sessionToken === ''
        || !hash_equals(
            $sessionToken,
            $submittedToken
        )
    ) {
        $_SESSION['message'] = getMessage(
            'Votre session a expiré. Veuillez réessayer.',
            'error'
        );
    } else {
        $papeterieId = filter_input(
            INPUT_POST,
            'idPapeterie',
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'min_range' => 1,
                ],
            ]
        );

        if (
            $papeterieId === false
            || $papeterieId === null
        ) {
            $_SESSION['message'] = getMessage(
                'La papeterie sélectionnée est invalide.',
                'error'
            );
        } elseif (!isAdmin()) {
            $_SESSION['message'] = getMessage(
                'Compte de démonstration : la suppression des articles de papeterie est désactivée.',
                'error'
            );
        } elseif (!$conn instanceof PDO) {
            $_SESSION['message'] = getMessage(
                'La connexion à la base de données est indisponible.',
                'error'
            );
        } else {
            $deleteResult = deletePapeterieDB(
                $conn,
                $papeterieId
            );

            if ($deleteResult === true) {
                $_SESSION['message'] = getMessage(
                    'Papeterie supprimée avec succès.',
                    'success'
                );
            } else {
                $_SESSION['message'] = getMessage(
                    'Erreur lors de la suppression de la papeterie.',
                    'error'
                );
            }
        }
    }

    header('Location: manager-papeterie.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Retrieve stationery products
|--------------------------------------------------------------------------
*/

if (!$conn instanceof PDO) {
    if ($msg === null) {
        $msg = getMessage(
            'La connexion à la base de données est indisponible.',
            'error'
        );
    }
} else {
    $result = getAllPapeteriesDB($conn);

    if (
        is_array($result)
        && !isset($result['error'])
        && !empty($result)
    ) {
        $execute = true;
    } elseif ($msg === null) {
        $msg = getMessage(
            'Il n’y a pas de papeterie à afficher actuellement.',
            'error'
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Gestion des papeteries');
    displayJSSection();
    ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main class="table-papeteries container">

        <h1 class="title">
            Gérer les papeteries
        </h1>

        <?php if (isGuest()): ?>
            <div class="message">
                <?= getMessage(
                    'Compte de démonstration : vous pouvez consulter les articles et parcourir les pages de gestion, mais l’ajout, la modification et la suppression sont désactivés.',
                    'success'
                ) ?>
            </div>
        <?php endif; ?>

        <div id="message">
            <?= $msg ?? '' ?>
        </div>

        <div id="content">
            <?php if ($execute): ?>
                <?php
                displayPapeteriesAsTable($result);
                ?>
            <?php endif; ?>
        </div>

        <form
            id="delete-papeterie-form"
            action="manager-papeterie.php"
            method="post"
            hidden>
            <input
                type="hidden"
                name="action"
                value="delete-papeterie">

            <input
                type="hidden"
                name="idPapeterie"
                id="delete-papeterie-id"
                value="">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= escapeHtml(
                            $_SESSION['csrf_token']
                        ) ?>">
        </form>

    </main>

    <footer>
        <?php displayFooter(); ?>
    </footer>

    <script>
        function modifierPapeterie(papeterieId) {
            window.location.href =
                'edit-papeterie.php?idPapeterie=' +
                encodeURIComponent(papeterieId);
        }

        function afficherPapeterie(papeterieId) {
            window.location.href =
                'article-papeterie.php?idPapeterie=' +
                encodeURIComponent(papeterieId);
        }

        function supprimerPapeterie(papeterieId) {
            const confirmed = window.confirm(
                'Êtes-vous certain de vouloir supprimer la papeterie ci-dessous ?'
            );

            if (!confirmed) {
                return;
            }

            const papeterieIdInput =
                document.getElementById(
                    'delete-papeterie-id'
                );

            const deleteForm =
                document.getElementById(
                    'delete-papeterie-form'
                );

            papeterieIdInput.value = papeterieId;
            deleteForm.submit();
        }
    </script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="../js/functions.js"></script>

</body>

</html>
