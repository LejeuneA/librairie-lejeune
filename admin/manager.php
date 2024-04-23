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

        // Check if item ID and category are provided in the URL for deletion
        if (isset($_GET['id']) && isset($_GET['idCategory']) && is_numeric($_GET['id']) && is_numeric($_GET['idCategory'])) {
            $itemIdToDelete = $_GET['id'];
            $categoryToDelete = $_GET['idCategory'];

            // Delete the item from the database based on its category
            $deleteResult = deleteItemFromDB($conn, $itemIdToDelete, $categoryToDelete);

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
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Title</th><th>Feature</th><th>Price</th><th>Action</th></tr>";
                    foreach ($livres as $livre) {
                        echo "<tr>";
                        echo "<td>{$livre['id']}</td>";
                        echo "<td>{$livre['title']}</td>";
                        echo "<td>{$livre['feature']}</td>";
                        echo "<td>{$livre['price']}</td>";
                        echo "<td>";
                        echo "<button onclick=\"modifierItem({$livre['id']}, 'livres')\">Modifier</button>";
                        echo "<button onclick=\"afficherItem({$livre['id']}, 'livres')\">Afficher</button>";
                        echo "<button onclick=\"supprimerItem({$livre['id']}, 'livres')\">Supprimer</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                if (!empty($papeteries)) {
                    echo "<h3>Papeteries</h3>";
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Title</th><th>Feature</th><th>Price</th><th>Action</th></tr>";
                    foreach ($papeteries as $papeterie) {
                        echo "<tr>";
                        echo "<td>{$papeterie['id']}</td>";
                        echo "<td>{$papeterie['title']}</td>";
                        echo "<td>{$papeterie['feature']}</td>";
                        echo "<td>{$papeterie['price']}</td>";
                        echo "<td>";
                        echo "<button onclick=\"modifierItem({$papeterie['id']}, 'papeteries')\">Modifier</button>";
                        echo "<button onclick=\"afficherItem({$papeterie['id']}, 'papeteries')\">Afficher</button>";
                        echo "<button onclick=\"supprimerItem({$papeterie['id']}, 'papeteries')\">Supprimer</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                if (!empty($cadeaux)) {
                    echo "<h3>Cadeaux</h3>";
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Title</th><th>Feature</th><th>Price</th><th>Action</th></tr>";
                    foreach ($cadeaux as $cadeau) {
                        echo "<tr>";
                        echo "<td>{$cadeau['id']}</td>";
                        echo "<td>{$cadeau['title']}</td>";
                        echo "<td>{$cadeau['feature']}</td>";
                        echo "<td>{$cadeau['price']}</td>";
                        echo "<td>";
                        echo "<button onclick=\"modifierItem({$cadeau['id']}, 'cadeaux')\">Modifier</button>";
                        echo "<button onclick=\"afficherItem({$cadeau['id']}, 'cadeaux')\">Afficher</button>";
                        echo "<button onclick=\"supprimerItem({$cadeau['id']}, 'cadeaux')\">Supprimer</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
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
        function modifierItem(itemId, idCategory) {
            console.log('Modifier item called with ID:', itemId, 'Category ID:', idCategory);
            // Redirect to the edit page with the specified item ID and category ID
            window.location.href = 'edit.php?id=' + itemId + '&idCategory=' + idCategory;
        }

        function afficherItem(itemId, idCategory) {
            // Redirect to the display page with the specified item ID and category ID
            window.location.href = 'article.php?id=' + itemId + '&idCategory=' + idCategory;
        }

        function supprimerItem(itemId, idCategory) {
            // Confirm item deletion
            var confirmation = confirm('Êtes-vous certain de vouloir supprimer l\'article ci-dessous ?');
            if (confirmation) {
                // Redirect to manager.php with the item ID and category ID
                window.location.href = 'manager.php?id=' + itemId + '&idCategory=' + idCategory;
            }
        }
    </script>
</body>

</html>