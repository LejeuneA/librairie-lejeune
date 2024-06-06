<?php
require_once('settings.php');

// Start the session at the beginning of your script if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is not identified, redirect to login page
if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit();
}

$msg = null;
$result = null;
$execute = false;

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Fetch all cadeaux from the database
    $result = getAllCadeauxDB($conn);

    // Check if cadeaux exist
    if (is_array($result) && !empty($result)) {
        $execute = true;

        // Check if cadeau ID is provided in the URL for deletion
        if (isset($_GET['idCadeau']) && is_numeric($_GET['idCadeau'])) {

            $cadeauIdToDelete = $_GET['idCadeau'];

            if ($_SESSION['user_permission'] == 1) {

                // Delete the cadeau from the database
                $deleteResult = deleteCadeauDB($conn, $cadeauIdToDelete);

                // Check deletion result and display appropriate message
                if ($deleteResult === true) {
                    $_SESSION['message'] = getMessage('Cadeau supprimé avec succès.', 'success');

                    // Refresh the page to reflect the changes after deletion
                    header('Location: manager-cadeau.php');
                    exit();
                } else {
                    $_SESSION['message'] = getMessage('Erreur lors de la suppression du cadeau. ' . $deleteResult, 'error');
                }
            } else {
                $_SESSION['message'] = getMessage('Vous n\'avez pas le droit de supprimer le cadeau.', 'error');
            }
        }
    } else {
        $_SESSION['message'] = getMessage('Il n\'y a pas de cadeau à afficher actuellement', 'error');
    }
}

// On the redirected page (manager-cadeau.php), add this code to display the message
if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying it
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Gestion des cadeaux');
    displayJSSection();
    ?>
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
    <div class="table-cadeaux container">
        <h1 class="title">Gérer les cadeaux</h2>
        <div id="message">
            <?= isset($msg) ? $msg : ''; ?>
        </div>

        <div id="content">
            <?php
            // If cadeaux exist, display them in a table
            if ($execute) {
                displayCadeauxAsTable($result);
            }
            ?>
        </div>
    </div><!-----------------------------------------------------------------
								Footer
	------------------------------------------------------------------>
    <footer>
        <div data-include="footer"></div>
    </footer>
    <!-----------------------------------------------------------------
							  Footer end
	------------------------------------------------------------------>

    <script>
        // JavaScript functions for handling cadeau actions
        function modifierCadeau(cadeauId) {
            // Redirect to the edit page with the specified cadeau ID
            window.location.href = 'edit-cadeau.php?idCadeau=' + cadeauId;
        }

        function afficherCadeau(cadeauId) {
            // Redirect to the cadeau page with the specified cadeau ID
            window.location.href = 'article-cadeau.php?idCadeau=' + cadeauId;
        }

        function supprimerCadeau(cadeauId) {
            // Confirm cadeau deletion
            if (confirm('Êtes-vous certain de vouloir supprimer le cadeau ci-dessous ?')) {
                // Redirect to manager-cadeau.php with the cadeau ID for deletion
                window.location.href = 'manager-cadeau.php?idCadeau=' + cadeauId;
            }
        }
    </script>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>
