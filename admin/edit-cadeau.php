<?php
require_once('settings.php');

// Check if user is not identified, redirect to login page
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit; // Add exit after redirection
}

$msg = null;
$tinyMCE = true;
$cadeau= null; // Change $article to $cadeau

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Check if article ID is provided in the URL
    if (isset($_GET['idCadeau'])) {
        // Get the article ID from the URL
        $idCadeau = $_GET['idCadeau']; // Change $articleId to $livreId

        // Retrieve article details from the database
        $cadeau = getCadeauByIDDB($conn, $idCadeau); // Change $article to $cadeau

        // Fetch category names from the database
        $categories = getCategoryNamesFromDB($conn);

        // Check if the form is submitted and the form type
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the form was submitted for update
            if (isset($_POST['update_form'])) {
                // Update the article in the database
                $updateData = [
                    'idCadeau' => $idCadeau,
                    'image_url' => $_POST['image_url'], // Add image URL to update data
                    'title' => isset($_POST['title']) ? $_POST['title'] : '', // Check if the key exists before accessing
                    'writer' => isset($_POST['writer']) ? $_POST['writer'] : '', // Check if the key exists before accessing
                    'feature' => isset($_POST['feature']) ? $_POST['feature'] : '', // Check if the key exists before accessing
                    'price' => isset($_POST['price']) ? $_POST['price'] : '', // Check if the key exists before accessing
                    'content' => $_POST['content'],
                    'published_article' => isset($_POST['published_article']) ? 1 : 0,
                    'idCategory' => $_POST['idCategory']
                ];

                // Perform the update operation in the database
                $updateResult = updatePapeterieDB($conn, $updateData);

                // Check the result of the update operation
                if ($updateResult === true) {
                    $msg = getMessage('Les modifications ont été enregistrées sur la page.', 'success');
                    $_SESSION['form_submitted'] = true; // Set session variable to indicate form submission
                } else {
                    $msg = getMessage('Erreur lors de la modification de l\'article. Veuillez réessayer.', 'error');
                }
            }

            // Check if file is uploaded
            if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
                $target_dir = "assets/images/uploads/";
                $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);

                // Check if the directory exists, if not, create it
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true); // Create directory recursively with full permissions
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
                    // File upload successful, update the image URL in the database
                    $updateData['image_url'] = $target_file;
                    updatePapeterieDB($conn, $updateData); // Update the database with the new image URL
                } else {
                    $msg = getMessage('Erreur lors de l\'enregistrement de l\'image. Veuillez réessayer.', 'error');
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
    header("Refresh: 1; URL=edit-cadeau.php?idCadeau=$idCadeau");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Editer un cadeau');
    displayJSSection($tinyMCE);
    ?>
</head>

<body>
    <header>
        <?php displayNavigation(); ?>
    </header>

    <div class="edit-content">
        <div class="edit-title">
            <h1>Editer un cadeau</h1>
            <div class="message">
                <?php if (isset($msg)) echo $msg; ?>
            </div>
        </div>

        <div class="edit-form container">
            <form action="edit-cadeau.php?idCadeau=<?php echo $cadeau['idCadeau']; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idCadeau" value="<?php echo $cadeau['idCadeau']; ?>">

                <!-- Form top -->
                <div class="form-top">

                    <!-- Form left -->
                    <div class="form-left">
                        <!-- Statue of the article -->
                        <div class=" form-ctrl">
                            <label for="published_article" class="published_article">Status du produit <span>(publication)</span></label>
                            <?php displayFormRadioBtnArticlePublished(isset($cadeau['active']) ? $cadeau['active'] : 0, 'EDIT'); ?>
                        </div>

                        <!-- Category -->
                        <div class="form-ctrl">
                            <label for="idCategory" class="form-ctrl">Catégorie</label>
                            <select id="idCategory" name="idCategory" class="form-ctrl" required>
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['idCategory']; ?>" <?php echo ($category['idCategory'] == $cadeau['idCategory']) ? 'selected' : ''; ?>><?php echo $category['nameOfCategory']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="form-ctrl">
                            <label for="title" class="form-ctrl">Titre</label>
                            <input type="text" class="form-ctrl" id="title" name="title" value="<?php echo isset($cadeau['title']) ? $cadeau['title'] : ''; ?>" required>
                        </div>

                        <!-- Writer -->
                        <div class="form-ctrl">
                            <label for="writer" class="form-ctrl">Auteur</label>
                            <input type="text" class="form-ctrl" id="writer" name="writer" value="<?php echo isset($cadeau['writer']) ? $cadeau['writer'] : ''; ?>">
                        </div>

                        <!-- Feature -->
                        <div class="form-ctrl">
                            <label for="feature" class="form-ctrl">Caractèriques</label>
                            <input type="text" class="form-ctrl" id="feature" name="feature" value="<?php echo isset($cadeau['feature']) ? $cadeau['feature'] : ''; ?>">
                        </div>
                        
                        <!-- Price -->
                        <div class="form-ctrl">
                            <label for="price" class="form-ctrl">Prix</label>
                            <input type="text" class="form-ctrl" id="price" name="price" value="<?php echo isset($cadeau['price']) ? $cadeau['price'] : ''; ?>">
                        </div>

                    </div>

                    <!-- Form right -->
                    <div class="form-right">
                        <!-- URL of the image -->
                        <div class="form-ctrl">
                            <label for="image_url" class="form-ctrl">URL de l'image</label>
                            <input type="text" class="form-ctrl" id="image_url" name="image_url" value="<?php echo isset($cadeau['image_url']) ? $cadeau['image_url'] : ''; ?>" readonly>
                        </div>

                        <!-- File upload field -->
                        <div class="form-ctrl">
                            <label for="image_upload" class="form-ctrl">Uploader l'image</label>
                            <input type="file" class="form-ctrl" id="image_upload" name="image_upload">
                        </div>
                        <!-- Preview of the image -->
                        <div class="form-ctrl">
                            <label for="image_preview" class="form-ctrl">Aperçu de l'image</label>
                            <div>
                                <img id="image_preview" class="image_preview" src="<?php echo isset($cadeau['image_url']) ? $cadeau['image_url'] : ''; ?>" alt="Aperçu de l'image"">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form bottom -->
                <div class=" form-bottom">
                                <div class="form-ctrl">
                                    <label for="content" class="form-ctrl">Contenu</label>
                                    <textarea class="content" id="content" name="content" rows="5"><?php echo isset($cadeau['content']) ? $cadeau['content'] : ''; ?></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="update_form" value="1"> 
                            <button type="submit" class="btn-primary">Sauvegarder</button>
                            <button type="submit" class="btn-primary" formaction="article-cadeau.php?idCadeau=<?php echo $cadeau['idCadeau']; ?>">Afficher</button>
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