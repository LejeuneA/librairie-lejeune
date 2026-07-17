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
    && ($_POST['action'] ?? '') === 'delete-cadeau'
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
        $cadeauId = filter_input(
            INPUT_POST,
            'idCadeau',
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'min_range' => 1,
                ],
            ]
        );

        if (
            $cadeauId === false
            || $cadeauId === null
        ) {
            $_SESSION['message'] = getMessage(
                'Le cadeau sélectionné est invalide.',
                'error'
            );
        } elseif (!isAdmin()) {
            $_SESSION['message'] = getMessage(
                'Compte de démonstration : la suppression des cadeaux est désactivée.',
                'error'
            );
        } elseif (!$conn instanceof PDO) {
            $_SESSION['message'] = getMessage(
                'La connexion à la base de données est indisponible.',
                'error'
            );
        } else {
            $deleteResult = deleteCadeauDB(
                $conn,
                $cadeauId
            );

            if ($deleteResult === true) {
                $_SESSION['message'] = getMessage(
                    'Cadeau supprimé avec succès.',
                    'success'
                );
            } else {
                $_SESSION['message'] = getMessage(
                    'Erreur lors de la suppression du cadeau.',
                    'error'
                );
            }
        }
    }

    header('Location: manager-cadeau.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Retrieve gifts
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
    $result = getAllCadeauxDB($conn);

    if (
        is_array($result)
        && !isset($result['error'])
        && !empty($result)
    ) {
        $execute = true;
    } elseif ($msg === null) {
        $msg = getMessage(
            'Il n’y a pas de cadeau à afficher actuellement.',
            'error'
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Gestion des cadeaux');
    displayJSSection();
    ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main class="table-cadeaux container">

        <h1 class="title">
            Gérer les cadeaux
        </h1>

        <?php if (isGuest()): ?>
            <div class="message">
                <?= getMessage(
                    'Compte de démonstration : vous pouvez consulter les cadeaux et parcourir les pages de gestion, mais l’ajout, la modification et la suppression sont désactivés.',
                    'success'
                ) ?>
            </div>
        <?php endif; ?>

        <div id="message">
            <?= $msg ?? '' ?>
        </div>

        <div id="content">
            <?php if ($execute): ?>
                <?php displayCadeauxAsTable($result); ?>
            <?php endif; ?>
        </div>

        <form
            id="delete-cadeau-form"
            action="manager-cadeau.php"
            method="post"
            hidden>
            <input
                type="hidden"
                name="action"
                value="delete-cadeau">

            <input
                type="hidden"
                name="idCadeau"
                id="delete-cadeau-id"
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
        function modifierCadeau(cadeauId) {
            window.location.href =
                'edit-cadeau.php?idCadeau=' +
                encodeURIComponent(cadeauId);
        }

        function afficherCadeau(cadeauId) {
            window.location.href =
                'article-cadeau.php?idCadeau=' +
                encodeURIComponent(cadeauId);
        }

        function supprimerCadeau(cadeauId) {
            const confirmed = window.confirm(
                'Êtes-vous certain de vouloir supprimer le cadeau ci-dessous ?'
            );

            if (!confirmed) {
                return;
            }

            const cadeauIdInput =
                document.getElementById(
                    'delete-cadeau-id'
                );

            const deleteForm =
                document.getElementById(
                    'delete-cadeau-form'
                );

            cadeauIdInput.value = cadeauId;
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
