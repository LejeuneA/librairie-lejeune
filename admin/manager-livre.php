<?php

require_once __DIR__ . '/settings.php';

requireLogin();

/*
|--------------------------------------------------------------------------
| CSRF token
|--------------------------------------------------------------------------
*/

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
    && ($_POST['action'] ?? '') === 'delete-livre'
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
        $livreId = filter_input(
            INPUT_POST,
            'idLivre',
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'min_range' => 1,
                ],
            ]
        );

        if ($livreId === false || $livreId === null) {
            $_SESSION['message'] = getMessage(
                'Le livre sélectionné est invalide.',
                'error'
            );
        } elseif (!isAdmin()) {
            $_SESSION['message'] = getMessage(
                'Compte de démonstration : la suppression des livres est désactivée.',
                'error'
            );
        } elseif (!$conn instanceof PDO) {
            $_SESSION['message'] = getMessage(
                'La connexion à la base de données est indisponible.',
                'error'
            );
        } else {
            $deleteResult = deleteLivreDB(
                $conn,
                $livreId
            );

            if ($deleteResult === true) {
                $_SESSION['message'] = getMessage(
                    'Livre supprimé avec succès.',
                    'success'
                );
            } else {
                $_SESSION['message'] = getMessage(
                    'Erreur lors de la suppression du livre.',
                    'error'
                );
            }
        }
    }

    header('Location: manager-livre.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Retrieve books
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
    $result = getAllLivresDB($conn);

    if (
        is_array($result)
        && !isset($result['error'])
        && !empty($result)
    ) {
        $execute = true;
    } elseif ($msg === null) {
        $msg = getMessage(
            'Il n’y a pas de livre à afficher actuellement.',
            'error'
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Gestion des livres');
    displayJSSection();
    ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main class="table-livres container">

        <h1 class="title">
            Gérer les livres
        </h1>

        <?php if (isGuest()): ?>
            <div class="message">
                <?= getMessage(
                    'Compte de démonstration : vous pouvez consulter les livres et parcourir les pages de gestion, mais l’ajout, la modification et la suppression sont désactivés.',
                    'success'
                ) ?>
            </div>
        <?php endif; ?>

        <div id="message">
            <?= $msg ?? '' ?>
        </div>

        <div
            id="content"
            class="container">
            <?php if ($execute): ?>
                <?php displayLivresAsTable($result); ?>
            <?php endif; ?>
        </div>

        <form
            id="delete-livre-form"
            action="manager-livre.php"
            method="post"
            hidden>
            <input
                type="hidden"
                name="action"
                value="delete-livre">

            <input
                type="hidden"
                name="idLivre"
                id="delete-livre-id"
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
        function modifierLivre(livreId) {
            window.location.href =
                'edit-livre.php?idLivre=' +
                encodeURIComponent(livreId);
        }

        function afficherLivre(livreId) {
            window.location.href =
                'article-livre.php?idLivre=' +
                encodeURIComponent(livreId);
        }

        function supprimerLivre(livreId) {
            const confirmed = window.confirm(
                'Êtes-vous certain de vouloir supprimer le livre ci-dessous ?'
            );

            if (!confirmed) {
                return;
            }

            const livreIdInput = document.getElementById(
                'delete-livre-id'
            );

            const deleteForm = document.getElementById(
                'delete-livre-form'
            );

            livreIdInput.value = livreId;
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
