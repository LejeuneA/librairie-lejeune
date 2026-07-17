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
| Delete message request
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['action'] ?? '') === 'delete-message'
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
        $messageId = filter_input(
            INPUT_POST,
            'idContact',
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'min_range' => 1,
                ],
            ]
        );

        if (
            $messageId === false
            || $messageId === null
        ) {
            $_SESSION['message'] = getMessage(
                'Le message sélectionné est invalide.',
                'error'
            );
        } elseif (!isAdmin()) {
            $_SESSION['message'] = getMessage(
                'Compte de démonstration : la suppression des messages est désactivée.',
                'error'
            );
        } elseif (!$conn instanceof PDO) {
            $_SESSION['message'] = getMessage(
                'La connexion à la base de données est indisponible.',
                'error'
            );
        } else {
            $deleteResult = deleteMessageDB(
                $conn,
                $messageId
            );

            if ($deleteResult === true) {
                $_SESSION['message'] = getMessage(
                    'Le message a été supprimé avec succès.',
                    'success'
                );
            } else {
                $_SESSION['message'] = getMessage(
                    'Une erreur est survenue pendant la suppression du message.',
                    'error'
                );
            }
        }
    }

    header('Location: manager-messages.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Retrieve messages
|--------------------------------------------------------------------------
*/

if (isGuest()) {
    /*
     * Guest gerçek ziyaretçi mesajlarını görmez.
     * İsimler, e-posta adresleri ve mesaj içerikleri
     * kişisel veri olarak korunur.
     */

    $execute = false;
} elseif (!$conn instanceof PDO) {
    $msg = getMessage(
        'La connexion à la base de données est indisponible.',
        'error'
    );
} else {
    $result = getAllMessagesDB($conn);

    if (
        is_array($result)
        && !isset($result['error'])
        && !empty($result)
    ) {
        $execute = true;
    } elseif ($msg === null) {
        $msg = getMessage(
            'Il n’y a aucun message à afficher actuellement.',
            'error'
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Mes messages');
    displayJSSection();
    ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main class="table-messages container">

        <h1 class="title">
            Mes messages
        </h1>

        <?php if (isGuest()): ?>
            <div class="message">
                <?= getMessage(
                    'Compte de démonstration : les messages des visiteurs sont masqués afin de protéger leurs données personnelles.',
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
                <?php
                displayMessagesAsTable($result);
                ?>
            <?php endif; ?>
        </div>

        <form
            id="delete-message-form"
            action="manager-messages.php"
            method="post"
            hidden>
            <input
                type="hidden"
                name="action"
                value="delete-message">

            <input
                type="hidden"
                name="idContact"
                id="delete-message-id"
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
        function deleteMessage(messageId) {
            const confirmed = window.confirm(
                'Êtes-vous certain de vouloir supprimer ce message ?'
            );

            if (!confirmed) {
                return;
            }

            const messageIdInput =
                document.getElementById(
                    'delete-message-id'
                );

            const deleteForm =
                document.getElementById(
                    'delete-message-form'
                );

            messageIdInput.value = messageId;
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
