<?php

require_once('settings.php');

// Check if user is not identified, redirect to login page
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit; // Add exit after redirection
}

$msg = null;
$tinyMCE = true;
$livre = null; // Change $article to $livre

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Check if article ID is provided in the URL
    if (isset($_GET['id'])) {

        // Get the article ID from the URL
        $idLivre = $_GET['id']; // Change $articleId to $livreId

        // Retrieve article details from the database
        $livre = getLivreByIDDB($conn, $idLivre); // Change $article to $livre

        // Check if the form is submitted and the form type
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the form was submitted for update
            if (isset($_POST['update_form'])) {
                // Update the article in the database
                $updateData = [
                    'idLivre' => $idLivre, 
                    'titleLivre' => isset($_POST['titleLivre']) ? $_POST['titleLivre'] : '', // Check if the key exists before accessing
                    'content' => $_POST['content'],
                    'published_article' => isset($_POST['published_article']) ? 1 : 0,
                ];

                // Perform the update operation in the database
                $updateResult = updateLivreDB($conn, $updateData);

                // Check the result of the update operation
                if ($updateResult === true) {
                    $msg = getMessage('Les modifications ont été enregistrées sur la page.', 'success');
                    $_SESSION['form_submitted'] = true; // Set session variable to indicate form submission
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

// Check if form was submitted and unset the session variable
if (isset($_SESSION['form_submitted'])) {
    unset($_SESSION['form_submitted']);
    // Refresh the page after form submission
    header("Refresh: 1; URL=edit.php?id=$idLivre");
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

            <form action="edit.php?id=<?php echo $livre['idLivre']; ?>" method="post">
                <input type="hidden" name="idLivre" value="<?php echo $livre['idLivre']; ?>">
                <div class="form-ctrl">
                    <label for="titleLivre" class="form-ctrl">Titre</label>
                    <input type="text" class="form-ctrl" id="titleLivre" name="titleLivre" value="<?php echo isset($livre['titleLivre']) ? $livre['titleLivre'] : ''; ?>" required>
                </div>
                <div class="form-ctrl">
                    <label for="published_article" class="form-ctrl">Status de l'article <small>(publication)</small></label>
                    <?php displayFormRadioBtnArticlePublished(isset($livre['active']) ? $livre['active'] : 0, 'EDIT'); ?>
                </div>
                <div class="form-ctrl">
                    <label for="content" class="form-ctrl">Contenu</label>
                    <textarea class="content" id="content" name="content" rows="5"><?php echo isset($livre['content']) ? $livre['content'] : ''; ?></textarea>
                </div>
                <input type="hidden" name="update_form" value="1"> <!-- Hidden input to identify form submission -->
                <button type="submit" class="btn-primary">Sauvegarder</button>
                <button type="submit" class="btn-primary" formaction="article.php?id=<?php echo $livre['idLivre']; ?>">Afficher</button>
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
