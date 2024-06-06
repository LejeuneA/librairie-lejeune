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
    // Fetch all livres from the database
    $result = getAllLivresDB($conn);

    // Check if livres exist
    if (is_array($result) && !empty($result)) {
        $execute = true;

        // Check if livre ID is provided in the URL for deletion
        if (isset($_GET['idLivre']) && is_numeric($_GET['idLivre'])) {

            $livreIdToDelete = $_GET['idLivre'];

            if ($_SESSION['user_permission'] == 1) {

                // Delete the livre from the database
                $deleteResult = deleteLivreDB($conn, $livreIdToDelete);

                // Check deletion result and display appropriate message
                if ($deleteResult === true) {
                    $_SESSION['message'] = getMessage('Livre supprimé avec succès.', 'success');

                    // Refresh the page to reflect the changes after deletion
                    header('Location: manager-livre.php');
                    exit();
                } else {
                    $_SESSION['message'] = getMessage('Erreur lors de la suppression du livre. ' . $deleteResult, 'error');
                }
            } else {
                $_SESSION['message'] = getMessage('Vous n\'avez pas le droit de supprimer le livre.', 'error');
            }
        }
    } else {
        $_SESSION['message'] = getMessage('Il n\'y a pas de livre à afficher actuellement', 'error');
    }
}

// On the redirected page (manager-livre.php), add this code to display the message
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
    displayHeadSection('Gestion des livres');
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
    <div class="table-livres container">
        <h1 class="title">Gérer les livres</h1>
        <div id="message">
            <?= isset($msg) ? $msg : ''; ?>
        </div>

        <div id="content" class="container">
            <?php
            // If livres exist, display them in a table
            if ($execute) {
                displayLivresAsTable($result);
            }
            ?>
        </div>
    </div>
    <!-----------------------------------------------------------------
								Footer
	------------------------------------------------------------------>
    <footer>
        <div data-include="footer"></div>
    </footer>
    <!-----------------------------------------------------------------
							  Footer end
	------------------------------------------------------------------>

    <script>
        // JavaScript functions for handling livre actions
        function modifierLivre(livreId) {
            // Redirect to the edit page with the specified livre ID
            window.location.href = 'edit-livre.php?idLivre=' + livreId;
        }

        function afficherLivre(livreId) {
            // Redirect to the livre page with the specified livre ID
            window.location.href = 'article-livre.php?idLivre=' + livreId;
        }

        function supprimerLivre(livreId) {
            // Confirm livre deletion
            if (confirm('Êtes-vous certain de vouloir supprimer le livre ci-dessous ?')) {
                // Redirect to manager-livre.php with the livre ID for deletion
                window.location.href = 'manager-livre.php?idLivre=' + livreId;
            }
        }
    </script>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>