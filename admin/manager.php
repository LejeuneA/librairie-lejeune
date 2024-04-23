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
    // Fetch all items from the database
    $livres = getAllLivresDB($conn);
    $papeteries = getAllPapeteriesDB($conn);
    $cadeaux = getAllCadeauxDB($conn);

    // Check if any item exists
    if (
        (is_array($livres) && !empty($livres)) ||
        (is_array($papeteries) && !empty($papeteries)) ||
        (is_array($cadeaux) && !empty($cadeaux))
    ) {
        $execute = true;

        // Check if item ID is provided in the URL for deletion
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $itemIdToDelete = $_GET['id'];

            // Delete the item from the database
            $deleteResult = deleteItemFromDB($conn, $itemIdToDelete);

            // Check deletion result and display appropriate message
            if ($deleteResult === true) {
                $msg = getMessage('Item supprimé avec succès.', 'success');
            } else {
                $msg = getMessage('Erreur lors de la suppression de l\'item. ' . $deleteResult, 'error');
            }
        }
    } else {
        $msg = getMessage('Il n\'y a pas d\'article à afficher actuellement', 'error');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Gestion des articles');
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
    <div class="container">
        <!-- Display the title for article management -->
        <h2 class="title">Gérer les articles</h2>
        <div id="message">
            <?= isset($msg) ? $msg : ''; ?>
        </div>

        <div id="content">
            <?php
            // Check if the fetch was successful
            if ($execute) {
                // If items exist, display them with buttons
                if (!empty($livres)) {
                    echo "<h3>Livres</h3>";
                    displayItemsWithButtons($livres, 'livres');
                }
                if (!empty($papeteries)) {
                    echo "<h3>Papeteries</h3>";
                    displayItemsWithButtons($papeteries, 'papeteries');
                }
                if (!empty($cadeaux)) {
                    echo "<h3>Cadeaux</h3>";
                    displayItemsWithButtons($cadeaux, 'cadeaux');
                }
            } else {
                echo "Error fetching data from the database.";
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

    <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/3546d47201.js" crossorigin="anonymous"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
    </div>

    <script>
    // JavaScript functions for handling item actions
    function modifierItem(itemId, itemType) {
        console.log('Modifier item called with ID:', itemId, 'Type:', itemType);
        // Redirect to the edit page with the specified item ID and type
        window.location.href = 'edit.php?id=' + itemId + '&type=' + itemType;
    }

    function ajouterItem(itemType) {
        // Redirect to the add item page with the specified type
        window.location.href = 'add.php?type=' + itemType;
    }

    function afficherItem(itemId, itemType) {
        // Redirect to the display page with the specified item ID and type
        window.location.href = 'article.php?id=' + itemId + '&type=' + itemType;
    }

    function supprimerItem(itemId) {
        // Confirm item deletion
        var confirmation = confirm('Êtes-vous certain de vouloir supprimer l\'article ci-dessous ?');
        if (confirmation) {
            // Redirect to manager.php with the item ID
            window.location.href = 'manager.php?id=' + itemId;
        }
    }
</script>
</body>

</html>
