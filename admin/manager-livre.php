<?php
require_once('settings.php');

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

            // Delete the livre from the database
            $deleteResult = deleteLivreDB($conn, $livreIdToDelete);

            // Check deletion result and display appropriate message
            if ($deleteResult === true) {
                $msg = getMessage('Livre supprimé avec succès.', 'success');
                // Refresh the page to reflect the changes after deletion
                header('Location: manager-livre.php');
                exit();
            } else {
                $msg = getMessage('Erreur lors de la suppression du livre. ' . $deleteResult, 'error');
            }
        }
    } else {
        $msg = getMessage('Il n\'y a pas de livre à afficher actuellement', 'error');
    }
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
