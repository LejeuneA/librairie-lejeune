<?php
require_once('settings.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email from the form
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email) {
        // Get the password for the provided email
        $password = getUserPasswordByEmail($conn, $email);

        if ($password) {
            // Display the password
            $message = "Votre mot de passe est: " . htmlspecialchars($password);
        } else {
            // Email not found in the database
            $message = "Erreur : L'adresse électronique n'a pas été trouvée.";
        }
    } else {
        // Invalid email format
        $message = "Erreur : L'adresse email n'est pas valide.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection('Mot de passe oublié'); ?>
</head>

<body>

    <!-----------------------------------------------------------------
							   Header
	------------------------------------------------------------------>
    <header>
        <!-----------------------------------------------------------------
							   Navigation
	    ------------------------------------------------------------------>
        <?php displayNavigation(); ?>
        <!-----------------------------------------------------------------
							Navigation end
	    ------------------------------------------------------------------>
    </header>
    <!-----------------------------------------------------------------
							   Header end
	------------------------------------------------------------------>
    <div class="login-container">
        <div class="login-title">
            <h1>Mot de passe oublié</h1>
        </div>
        <div class="login-content container">
            <form class="login-form" method="post" action="">
                <label for="email" class="form-ctrl">Entrez votre adresse e-mail</label>
                <input type="email" class="form-ctrl" name="email" id="email" required>
                <button type="submit" class="btn-primary">Envoyer</button>
            </form>
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
            }
            ?>
            <div class="background-vector">
                <img src="../assets/components/background-vector.png" alt="background-vector">
            </div>
        </div>
    </div>

    <!-----------------------------------------------------------------
                               Footer
    ------------------------------------------------------------------>
    <footer>
        <?php displayFooter(); ?>
    </footer>
    <!-----------------------------------------------------------------
                            Footer end
    ------------------------------------------------------------------>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Main Js -->
    <script src="../js/main.js"></script>

</body>

</html>