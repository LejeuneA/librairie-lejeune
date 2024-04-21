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

        // Fetch category names from the database
        $categories = getCategoryNamesFromDB($conn);

        // Check if the form is submitted and the form type
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the form was submitted for update
            if (isset($_POST['update_form'])) {
                // Update the article in the database
                $updateData = [
                    'idLivre' => $idLivre,
                    'image_url' => $_POST['image_url'], // Add image URL to update data
                    'title' => isset($_POST['title']) ? $_POST['title'] : '', // Check if the key exists before accessing
                    'writer' => isset($_POST['writer']) ? $_POST['writer'] : '', // Check if the key exists before accessing
                    'feature' => isset($_POST['feature']) ? $_POST['feature'] : '', // Check if the key exists before accessing
                    'price' => isset($_POST['price']) ? $_POST['price'] : '', // Check if the key exists before accessing
                    'content' => $_POST['content'],
                    'active' => isset($_POST['active']) ? 1 : 0,
                    'idCategory' => $_POST['idCategory']
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

    <div class="edit-content">
        <h1>Editer un article</h1>
        <?php echo $msg; ?>
        
        <div class="edit-form container">
            <form action="edit.php?id=<?php echo $livre['idLivre']; ?>" method="post">
                <input type="hidden" name="idLivre" value="<?php echo $livre['idLivre']; ?>">
                <div class="form-ctrl">
                    <label for="title" class="form-ctrl">Titre</label>
                    <input type="text" class="form-ctrl" id="title" name="title" value="<?php echo isset($livre['title']) ? $livre['title'] : ''; ?>" required>
                </div>

                <div class="form-ctrl">
                    <label for="writer" class="form-ctrl">Author</label>
                    <input type="text" class="form-ctrl" id="writer" name="writer" value="<?php echo isset($livre['writer']) ? $livre['writer'] : ''; ?>">
                </div>

                <div class="form-ctrl">
                    <label for="feature" class="form-ctrl">Caractèriques</label>
                    <input type="text" class="form-ctrl" id="feature" name="feature" value="<?php echo isset($livre['feature']) ? $livre['feature'] : ''; ?>">
                </div>

                <div class="form-ctrl">
                    <label for="price" class="form-ctrl">Prix</label>
                    <input type="text" class="form-ctrl" id="price" name="price" value="<?php echo isset($livre['price']) ? $livre['price'] : ''; ?>">
                </div>

                <div class="form-ctrl">
                    <label for="idCategory" class="form-ctrl">Catégorie</label>
                    <select id="idCategory" name="idCategory" class="form-ctrl" required>
                        <option value="">Sélectionner une catégorie</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['idCategory']; ?>" <?php echo ($category['idCategory'] == $livre['idCategory']) ? 'selected' : ''; ?>><?php echo $category['nameOfCategory']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-ctrl">
                    <label for="image_url" class="form-ctrl">URL de l'image</label>
                    <input type="text" class="form-ctrl" id="image_url" name="image_url" value="<?php echo isset($livre['image_url']) ? $livre['image_url'] : ''; ?>" readonly>
                </div>
                <div class="form-ctrl">
                    <label for="image_preview" class="form-ctrl">Aperçu de l'image</label>
                    <img id="image_preview" src="<?php echo isset($livre['image_url']) ? $livre['image_url'] : ''; ?>" alt="Aperçu de l'image"">
                </div>

                <div class=" form-ctrl">
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