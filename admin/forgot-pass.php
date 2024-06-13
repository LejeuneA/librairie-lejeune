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
            $message = "Your password is: " . htmlspecialchars($password);
        } else {
            // Email not found in the database
            $message = "Error: Email address not found.";
        }
    } else {
        // Invalid email format
        $message = "Error: Invalid email address.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection('Forgot Password'); ?>
</head>

<body>

    <!-----------------------------------------------------------------
							   Header
	------------------------------------------------------------------>
    <header>
        <!-----------------------------------------------------------------
							   Navigation
	    ------------------------------------------------------------------>
        <?php displayNavigationAdmin(); ?>
        <!-----------------------------------------------------------------
							Navigation end
	    ------------------------------------------------------------------>
    </header>
    <!-----------------------------------------------------------------
							   Header end
	------------------------------------------------------------------>
    <div class="login-container">
        <div class="login-title">
            <h1>Forgot Password</h1>
        </div>
        <div class="login-content container">
            <form class="login-form" method="post" action="">
                <label for="email" class="form-ctrl">Enter your email dddress</label>
                <input type="email" class="form-ctrl" name="email" id="email" required>
                <button type="submit" class="btn-primary">Submit</button>
            </form>
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
            }
            ?>
            <div class="background-vector">
                <img src="../assets/images/background-vector.png" alt="background-vector">
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