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
    // Fetch all papeteries from the database
    $result = getAllPapeteriesDB($conn);

    // Check if papeteries exist
    if (is_array($result) && !empty($result)) {
        $execute = true;

        // Check if papeterie ID is provided in the URL for deletion
        if (isset($_GET['idPapeterie']) && is_numeric($_GET['idPapeterie'])) {
            $papeterieIdToDelete = $_GET['idPapeterie'];

            // Delete the papeterie from the database
            $deleteResult = deletePapeterieDB($conn, $papeterieIdToDelete);

            // Check deletion result and display appropriate message
            if ($deleteResult === true) {
                $msg = getMessage('Papeterie supprimé avec succès.', 'success');
                // Refresh the page to reflect the changes after deletion
                header('Location: manager-papeterie.php');
                exit();
            } else {
                $msg = getMessage('Erreur lors de la suppression de la papeterie. ' . $deleteResult, 'error');
            }
        }
    } else {
        $msg = getMessage('Il n\'y a pas de papeterie à afficher actuellement', 'error');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Gestion des papeteries');
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
    <div class="table-papeteries container">
        <h1 class="title">Gérer les papeteries</h1>
        <div id="message">
            <?= isset($msg) ? $msg : ''; ?>
        </div>

        <div id="content">
            <?php
            // If papeteries exist, display them in a table
            if ($execute) {
                displayPapeteriesAsTable($result);
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
        // JavaScript functions for handling papeterie actions
        function modifierPapeterie(papeterieId) {
            // Redirect to the edit page with the specified papeterie ID
            window.location.href = 'edit-papeterie.php?idPapeterie=' + papeterieId;
        }

        function afficherPapeterie(papeterieId) {
            // Redirect to the papeterie page with the specified papeterie ID
            window.location.href = 'article-papeterie.php?idPapeterie=' + papeterieId;
        }

        function supprimerPapeterie(papeterieId) {
            // Confirm papeterie deletion
            if (confirm('Êtes-vous certain de vouloir supprimer la papeterie ci-dessous ?')) {
                // Redirect to manager-papeterie.php with the papeterie ID for deletion
                window.location.href = 'manager-papeterie.php?idPapeterie=' + papeterieId;
            }
        }
    </script>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>
