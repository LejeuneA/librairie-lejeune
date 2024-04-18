<?php

require_once('settings.php');

// Check if user is not identified, redirect to login page
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit; // Add exit after redirection
}

$msg = null;
$tinyMCE = true;
$article = null;

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Check if article ID is provided in the URL
    if (isset($_GET['id'])) {

        // Get the article ID from the URL
        $articleId = $_GET['id'];

        // Retrieve article details from the database
        $article = getLivreByIDDB($conn, $articleId);

        // Check if the form is submitted and the form type
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form'])) {

            // Check if the form type is 'update'
            if ($_POST['form'] === 'update') {
                // Update the article content on the page
                $article['titleLivre'] = $_POST['titleLivre'];
                $article['content'] = $_POST['content'];
                $article['active'] = isset($_POST['published_article']) ? 1 : 0;
                $msg = getMessage('Les modifications ont été enregistrées sur la page.', 'success');
            }

            // Check if the form type is 'submit' or the 'submit_and_afficher' button is clicked
            if ($_POST['form'] === 'submit' || isset($_POST['submit_and_afficher'])) {
                // Update the article in the database
                $updateData = [
                    'idLivre' => $articleId,
                    'titleLivre' => $_POST['titleLivre'],
                    'content' => $_POST['content'],
                    'active' => isset($_POST['published_article']) ? 1 : 0,
                ];

                // Perform the update operation in the database
                $updateResult = updateLivreDB($conn, $updateData);

                // Check the result of the update operation
                if ($updateResult === true) {
                    // Redirect to manager.php after successful update
                    header('Location: manager.php');
                    exit;
                } else {
                    $msg = getMessage('Erreur lors de la modification de l\'article. Veuillez réessayer.', 'error');
                }
            }
        }
    } else {
        // If article ID is not provided, redirect to manager.php
        header('Location: manager.php');
        exit; // Add exit after redirection
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Editer un article');
    displayJSSection($tinyMCE);
    ?>
</head>

<body>
    <header>
        <?php displayNavigation(); ?>
    </header>

    <div class="container">
        <h2 class="title">Editer un article</h2>
        <div id="content-edit">
            <?php echo $msg; ?>

            <form action="edit.php?id=<?php echo $article['idLivre']; ?>" method="post">
                <input type="hidden" name="idLivre" value="<?php echo $article['idLivre']; ?>">
                <div class="form-ctrl">
                    <label for="titleLivre" class="form-ctrl">Titre</label>
                    <input type="text" class="form-ctrl" id="titleLivre" name="titleLivre" value="<?php echo $article['titleLivre']; ?>" required>
                </div>
                <div class="form-ctrl">
                    <label for="published_article" class="form-ctrl">Status de l'article <small>(publication)</small></label>
                    <?php displayFormRadioBtnArticlePublished($article['active'], 'EDIT'); ?>
                </div>
                <div class="form-ctrl">
                    <label for="content" class="form-ctrl">Contenu</label>
                    <textarea class="content" id="content" name="content" rows="5"><?php echo $article['content']; ?></textarea>
                </div>
                <input type="hidden" id="form" name="form" value="update">
                <button type="submit" class="btn-primary">Sauvegarder</button>
                <button type="submit" name="submit_and_afficher" class="btn-primary">Afficher</button>
            </form>
        </div>
    </div>

    <?php
    displayJSSection($tinyMCE);
    ?>
    <footer>
        <div data-include="footer"></div>
    </footer>

    <script src="https://kit.fontawesome.com/3546d47201.js" crossorigin="anonymous"></script>
    <script src="../js/functions.js"></script>
</body>

</html>
