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
    // Fetch all articles from the database
    $result = getAllArticlesDB($conn);

    // Check if articles exist
    if (is_array($result) && !empty($result)) {
        $execute = true;

        // Check if article ID is provided in the URL for deletion
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $articleIdToDelete = $_GET['id'];

            // Delete the article from the database
            $deleteResult = deleteArticleDB($conn, $articleIdToDelete);

            // Check deletion result and display appropriate message
            if ($deleteResult === true) {
                $msg = getMessage('Article supprimé avec succès.', 'success');
            } else {
                $msg = getMessage('Erreur lors de la suppression de l\'article. ' . $deleteResult, 'error');
            }
        }
    } else {
        $msg = getMessage('Il n\'y a pas d\'article à afficher actuellement', 'error');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // Include the head section
    displayHeadSection('Gestion des produits');
    displayJSSection();
    ?>
</head>

<body>

    <!-----------------------------------------------------------------
							   Header
	------------------------------------------------------------------>
    <header class="manager-header">
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
    <div class="manager-container">
        <?php echo '<div class="welcome"><div class="welcome-text"> Bienvenue <span>' . $_SESSION['user_email'] . '</span></div></div>'; ?>
        <div class="manager-content container">
            <h1 class="title">Gérer les produits</h1>
            <div class="category-container">
                <!-- Livres -->
                <div class="category-card">
                    <a class="btn-primary" href="./manager-livre.php">Gérer les livres</a>
                    <a class="btn-primary" href="./add-livre.php">Ajouter un livre</a>
                </div>

                <!-- Papeteries -->
                <div class="category-card">
                    <a class="btn-primary" href="./manager-papeterie.php">Gérer les papeteries</a>
                    <a class="btn-primary" href="./add-papeterie.php">Ajouter une papeterie</a>
                </div>

                <!-- Cadeaux -->
                <div class="category-card"> 
                    <a class="btn-primary" href="./manager-cadeau.php">Gérer les cadeaux</a>
                    <a class="btn-primary" href="./add-cadeau.php">Ajouter un cadeau</a>
                </div>

                <!-- Vector -->
                <div class="background-vector">
                    <img src="../assets/components/background-vector.png" alt="background-vector">
                </div>
            </div>

        </div>
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
        // JavaScript functions for handling article actions
        function modifierArticle(articleId) {
            // Redirect to the edit page with the specified article ID
            window.location.href = 'edit.php?id=' + articleId;
        }

        function afficherArticle(articleId) {
            // Redirect to the article page with the specified article ID
            window.location.href = 'article.php?id=' + articleId;
        }

        function supprimerArticle(articleId) {
            // Confirm article deletion and redirect to manager.php with the article ID
            if (confirm('Êtes-vous certain de vouloir supprimer l\'article ci-dessous ?')) {
                window.location.href = 'manager.php?id=' + articleId;
            }
        }
    </script>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>