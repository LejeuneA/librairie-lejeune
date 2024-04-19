<?php

require_once('settings.php');

// Check if user is not identified, redirect to login page
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}

$msg = null;
$tinyMCE = true;
$execute = false;

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Check if the form is submitted and it's an add operation
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form']) && $_POST['form'] === 'add') {

        // Gather data from the form
        $addData = [
            'titleLivre' => $_POST['title'],
            'content' => $_POST['content'],
            'published_article' => isset($_POST['published_article']) ? 1 : 0,
        ];

        // Add the article to the database
        $addResult = addLivreDB($conn, $addData);

        // Check the result and display appropriate message
        if ($addResult === true) {
            $msg = getMessage('L\'article a été ajouté avec succès.', 'success');
        } else {
            $msg = getMessage('Erreur lors de l\'ajout de l\'article. Veuillez réessayer.', 'error');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Ajouter un article');
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
        <?php displayNavigationAdmin(); ?>
        <!-----------------------------------------------------------------
							Navigation end
	    ------------------------------------------------------------------>
    </header>
    <!-----------------------------------------------------------------
							   Header end
	------------------------------------------------------------------>
    <div class="container">
        <!-- Display the title for adding an article -->
        <h2 class="title">Ajouter un article
        </h2>
        <div id="message">
            <?php echo $msg; ?>
        </div>
        <div id="content-add">

            <form action="add.php" method="post">
                <div class="form-ctrl">
                    <label for="title" class="form-ctrl">Titre</label>
                    <!-- Input field for article title -->
                    <input type="text" class="form-ctrl" id="title" name="title" value="" required>
                </div>
                <div class="form-ctrl">
                    <label for="published_article" class="form-ctrl">Status de l'article <small>(publication)</small></label>
                    <!-- Display radio button for article status -->
                    <?php displayFormRadioBtnArticlePublished(false, 'ADD'); ?>
                </div>
                <div class="form-ctrl">
                    <label for="content" class="form-ctrl">Contenu</label>
                    <!-- Textarea for article content -->
                    <textarea class="" id="content" name="content" rows="8"></textarea>
                </div>
                <input type="hidden" id="form" name="form" value="add">
                <!-- Submit button to add the article -->
                <button type="submit" class="btn-manager">Ajouter</button>
            </form>

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
    <?php
    displayJSSection($tinyMCE);
    ?>

    <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/3546d47201.js" crossorigin="anonymous"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>

</body>

</html>