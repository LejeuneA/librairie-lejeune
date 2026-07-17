<?php

require_once __DIR__ . '/settings.php';

if (
    isset($_SESSION['IDENTIFY'])
    && $_SESSION['IDENTIFY'] === true
) {
    header('Location: manager.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );
}

$_SESSION['login_attempts'] =
    (int) ($_SESSION['login_attempts'] ?? 0);

$_SESSION['login_locked_until'] =
    (int) ($_SESSION['login_locked_until'] ?? 0);

$user = null;
$msg = null;

if (!is_object($conn)) {
    $msg = getMessage(
        'La connexion à la base de données est indisponible.',
        'error',
    );
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentTime = time();

    if (
        $_SESSION['login_locked_until']
        > $currentTime
    ) {
        $msg = getMessage(
            'Trop de tentatives. Veuillez patienter cinq minutes.',
            'error',
        );
    } else {
        $submittedToken =
            (string) ($_POST['csrf_token'] ?? '');

        if (
            $submittedToken === ''
            || !hash_equals(
                $_SESSION['csrf_token'],
                $submittedToken,
            )
        ) {
            $msg = getMessage(
                'Votre session a expiré. Veuillez réessayer.',
                'error',
            );
        } elseif (
            ($_POST['form'] ?? '') !== 'login'
        ) {
            $msg = getMessage(
                'Requête invalide.',
                'error',
            );
        } else {
            $login = trim(
                (string) ($_POST['login'] ?? '')
            );

            $password =
                (string) ($_POST['pwd'] ?? '');

            if (
                $login === ''
                || $password === ''
            ) {
                $msg = getMessage(
                    'Veuillez remplir tous les champs.',
                    'error',
                );
            } elseif (
                !filter_var(
                    $login,
                    FILTER_VALIDATE_EMAIL,
                )
            ) {
                $msg = getMessage(
                    'Veuillez saisir une adresse e-mail valide.',
                    'error',
                );
            } elseif (
                strlen($login) > 190
                || strlen($password) > 255
            ) {
                $msg = getMessage(
                    'Les informations saisies sont invalides.',
                    'error',
                );
            } else {
                $user =
                    userIdentificationWithHashPwdDB(
                        $conn,
                        [
                            'login' => $login,
                            'pwd' => $password,
                        ],
                    );

                if ($user !== false) {
                    $permission = (int) (
                        $user['permission'] ?? 0
                    );

                    if (
                        !in_array(
                            $permission,
                            [1, 2],
                            true,
                        )
                    ) {
                        $msg = getMessage(
                            'Permission inconnue.',
                            'error',
                        );
                    } else {
                        session_regenerate_id(true);

                        $_SESSION['IDENTIFY'] = true;
                        $_SESSION['user_email'] =
                            $user['email'];

                        $_SESSION['user_permission'] =
                            $permission;

                        $_SESSION['login_attempts'] = 0;
                        $_SESSION['login_locked_until'] = 0;

                        if ($permission === 1) {
                            header(
                                'Location: manager.php'
                            );
                        } else {
                            header(
                                'Location: customer.php'
                            );
                        }

                        exit();
                    }
                } else {
                    $_SESSION['login_attempts']++;

                    if (
                        $_SESSION['login_attempts'] >= 5
                    ) {
                        $_SESSION['login_attempts'] = 0;

                        $_SESSION['login_locked_until'] =
                            time() + 300;

                        $msg = getMessage(
                            'Trop de tentatives. Veuillez patienter cinq minutes.',
                            'error',
                        );
                    } else {
                        $msg = getMessage(
                            'Votre e-mail ou votre mot de passe est incorrect.',
                            'error',
                        );
                    }
                }
            }
        }
    }
}

$loginValue = htmlspecialchars(
    (string) ($_POST['login'] ?? ''),
    ENT_QUOTES,
    'UTF-8',
);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection('S\'identifier'); ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <div class="login-container">
        <div class="login-title">
            <h1>Se connecter</h1>

            <p>
                Connectez-vous pour gérer votre page
            </p>

            <div class="message">
                <?php if ($msg !== null): ?>
                    <?= $msg ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="login-content container">
            <form
                class="login-form"
                action="login.php"
                method="post">
                <div class="form-ctrl">
                    <label
                        for="login"
                        class="form-ctrl">
                        E-mail
                    </label>

                    <input
                        type="email"
                        class="form-ctrl"
                        id="login"
                        name="login"
                        value="<?= $loginValue ?>"
                        maxlength="190"
                        autocomplete="username"
                        required>
                </div>

                <div class="form-ctrl">
                    <label
                        for="pwd"
                        class="form-ctrl">
                        Mot de passe
                    </label>

                    <input
                        type="password"
                        class="form-ctrl"
                        id="pwd"
                        name="pwd"
                        maxlength="255"
                        autocomplete="current-password"
                        required>
                </div>

                <a href="forgot-pass.php">
                    <p>Mot de passe oublié ?</p>
                </a>

                <input
                    type="hidden"
                    name="form"
                    value="login">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(
                                $_SESSION['csrf_token'],
                                ENT_QUOTES,
                                'UTF-8',
                            ) ?>">

                <button
                    type="submit"
                    class="btn-primary">
                    Se connecter
                </button>
            </form>

            <div class="background-vector">
                <img
                    src="../assets/components/background-vector.png"
                    alt="">
            </div>
        </div>
    </div>

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
