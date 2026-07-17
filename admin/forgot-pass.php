<?php

require_once __DIR__ . '/settings.php';

$msg = null;
$emailValue = '';

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

/*
|--------------------------------------------------------------------------
| Password recovery request
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailValue = trim(
        (string) ($_POST['email'] ?? '')
    );

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
        $msg = getMessage(
            'Votre session a expiré. Veuillez réessayer.',
            'error'
        );
    } elseif (
        !filter_var(
            $emailValue,
            FILTER_VALIDATE_EMAIL
        )
    ) {
        $msg = getMessage(
            'L’adresse e-mail saisie n’est pas valide.',
            'error'
        );
    } else {
        /*
         * Bu proje şu anda güvenli e-posta tabanlı
         * parola sıfırlama sistemine sahip değil.
         *
         * Kullanıcının var olup olmadığı açıklanmaz.
         * Veritabanındaki parola hash'i gösterilmez.
         */

        $msg = getMessage(
            'La récupération automatique du mot de passe n’est pas disponible sur cette version de démonstration. Veuillez utiliser les identifiants de démonstration fournis ou contacter l’administratrice du site.',
            'success'
        );

        $emailValue = '';

        $_SESSION['csrf_token'] = bin2hex(
            random_bytes(32)
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Mot de passe oublié');
    ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main class="login-container">

        <div class="login-title">
            <h1>Mot de passe oublié</h1>

            <div class="message">
                <?= $msg ?? '' ?>
            </div>
        </div>

        <div class="login-content container">

            <form
                class="login-form"
                method="post"
                action="forgot-pass.php">
                <label
                    for="email"
                    class="form-ctrl">
                    Entrez votre adresse e-mail
                </label>

                <input
                    type="email"
                    class="form-ctrl"
                    name="email"
                    id="email"
                    value="<?= escapeHtml(
                                $emailValue
                            ) ?>"
                    maxlength="190"
                    autocomplete="email"
                    required>

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= escapeHtml(
                                $_SESSION['csrf_token']
                            ) ?>">

                <button
                    type="submit"
                    class="btn-primary">
                    Envoyer
                </button>

                <a href="login.php">
                    Retour à la connexion
                </a>
            </form>

            <div class="background-vector">
                <img
                    src="../assets/components/background-vector.png"
                    alt="">
            </div>

        </div>

    </main>

    <footer>
        <?php displayFooter(); ?>
    </footer>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="../js/functions.js"></script>

</body>

</html>
