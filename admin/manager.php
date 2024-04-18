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
        <div data-include="navigation-admin"></div>
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
            // If articles exist, display them with buttons
            if ($execute) {
                displayArticlesWithButtons($result);
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
</body>

</html>
