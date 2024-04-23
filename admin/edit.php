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
        $id = $_GET['id'];

        // Retrieve article details from the database
        $livre = getLivreByIDDB($conn, $id);
        $papeterie = getPapeterieByIDDB($conn, $id);
        $cadeau = getCadeauByIDDB($conn, $id);

        // Fetch category names from the database
        $categories = getCategoryNamesFromDB($conn);

        // Check if the form is submitted and the form type
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the form was submitted for update
            if (isset($_POST['update_form'])) {
                // Update the article in the database
                $updateData = [
                    'id' => $id,
                    'image_url' => $_POST['image_url'],
                    'title' => isset($_POST['title']) ? $_POST['title'] : '',
                    'writer' => isset($_POST['writer']) ? $_POST['writer'] : '',
                    'feature' => isset($_POST['feature']) ? $_POST['feature'] : '',
                    'price' => isset($_POST['price']) ? $_POST['price'] : '',
                    'content' => $_POST['content'],
                    'active' => isset($_POST['active']) ? 1 : 0,
                    'idCategory' => $_POST['idCategory']
                ];

                // Perform the update operation in the database
                $updateResult = updateLivreDB($conn, $updateData) || updatePapeterieDB($conn, $updateData) || updateCadeauDB($conn, $updateData);

                // Check the result of the update operation
                if ($updateResult === true) {
                    $msg = getMessage('Les modifications ont été enregistrées sur la page.', 'success');
                    $_SESSION['form_submitted'] = true;
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
                    mkdir($target_dir, 0777, true);
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
                    // File upload successful, update the image URL in the database
                    $updateData['image_url'] = $target_file;
                    updateLivreDB($conn, $updateData); // Update the database with the new image URL
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
    header("Refresh: 1; URL=edit.php?id=$id");
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
        <div class="edit-title">
            <h1>Editer un article</h1>
            <div class="message">
                <?php if (isset($msg)) echo $msg; ?>
            </div>
        </div>

        <div class="edit-form container">
            <form action="edit.php?id=<?php echo $livre['id'];
                                        $papeterie['id'];
                                        $cadeau['id']; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $livre['id']; ?>">
                <!-- Add enctype="multipart/form-data" to enable file uploads -->

                <!-- Form top -->
                <div class="form-top">

                    <!-- Form left -->
                    <div class="form-left">
                        <!-- Statue of the article -->
                        <div class=" form-ctrl">
                            <label for="published_article" class="published_article">Status de l'article <span>(publication)</span></label>
                            <?php $active = isset($livre['active']) ? $livre['active'] : (isset($papeterie['active']) ? $papeterie['active'] : (isset($cadeau['active']) ? $cadeau['active'] : 0));
                            displayFormRadioBtnArticlePublished($active, 'EDIT');  ?>
                        </div>

                        <!-- Category -->
                        <div class="form-ctrl">
                            <label for="idCategory" class="form-ctrl">Catégorie</label>
                            <select id="idCategory" name="idCategory" class="form-ctrl" required>
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['idCategory']; ?>" <?php echo ($category['idCategory'] == $livre['idCategory']) ? 'selected' : ''; ?>><?php echo $category['nameOfCategory']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="form-ctrl">
                            <label for="title" class="form-ctrl">Titre</label>
                            <input type="text" class="form-ctrl" id="title" name="title" value="<?php
                                                                                                $title = isset($livre['title']) ? $livre['title'] : (isset($papeterie['title']) ? $papeterie['title'] : (isset($cadeau['title']) ? $cadeau['title'] : ''));
                                                                                                echo $title;
                                                                                                ?>
" required>
                        </div>

                        <!-- Writer -->
                        <div class="form-ctrl">
                            <label for="writer" class="form-ctrl">Author</label>
                            <input type="text" class="form-ctrl" id="writer" name="writer" value="<?php
                                                                                                    $writer = isset($livre['writer']) ? $livre['writer'] : (isset($papeterie['writer']) ? $papeterie['writer'] : (isset($cadeau['writer']) ? $cadeau['writer'] : ''));
                                                                                                    echo $writer;
                                                                                                    ?>
">
                        </div>

                        <!-- Feature -->
                        <div class="form-ctrl">
                            <label for="feature" class="form-ctrl">Caractèriques</label>
                            <input type="text" class="form-ctrl" id="feature" name="feature" value="<?php
                                                                                                    $feature = isset($livre['feature']) ? $livre['feature'] : (isset($papeterie['feature']) ? $papeterie['feature'] : (isset($cadeau['feature']) ? $cadeau['feature'] : ''));
                                                                                                    echo $feature;
                                                                                                    ?>
">
                        </div>

                        <!-- Price -->
                        <div class="form-ctrl">
                            <label for="price" class="form-ctrl">Prix</label>
                            <input type="text" class="form-ctrl" id="price" name="price" value="<?php
                                                                                                $price = isset($livre['price']) ? $livre['price'] : (isset($papeterie['price']) ? $papeterie['price'] : (isset($cadeau['price']) ? $cadeau['price'] : ''));
                                                                                                echo $price;
                                                                                                ?>
">
                        </div>

                    </div>

                    <!-- Form right -->
                    <div class="form-right">
                        <!-- URL of the image -->
                        <div class="form-ctrl">
                            <label for="image_url" class="form-ctrl">URL de l'image</label>
                            <input type="text" class="form-ctrl" id="image_url" name="image_url" value="<?php
                                                                                                        $image_url = isset($livre['image_url']) ? $livre['image_url'] : (isset($papeterie['image_url']) ? $papeterie['image_url'] : (isset($cadeau['image_url']) ? $cadeau['image_url'] : ''));
                                                                                                        echo $image_url;
                                                                                                        ?>
" readonly>
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
                                <img id="image_preview" class="image_preview" src="<?php
                                                                                    $image_url = isset($livre['image_url']) ? $livre['image_url'] : (isset($papeterie['image_url']) ? $papeterie['image_url'] : (isset($cadeau['image_url']) ? $cadeau['image_url'] : ''));
                                                                                    echo $image_url;
                                                                                    ?>
" alt="Aperçu de l'image"">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form bottom -->
                <div class=" form-bottom">
                                <div class="form-ctrl">
                                    <label for="content" class="form-ctrl">Contenu</label>
                                    <textarea class="content" id="content" name="content" rows="5"><?php
                                                                                                    $content = isset($livre['content']) ? $livre['content'] : (isset($papeterie['content']) ? $papeterie['content'] : (isset($cadeau['content']) ? $cadeau['content'] : ''));
                                                                                                    echo $content;
                                                                                                    ?>
</textarea>
                                </div>
                            </div>

                            <input type="hidden" name="update_form" value="1"> <!-- Hidden input to identify form submission -->
                            <button type="submit" class="btn-primary">Sauvegarder</button>
                            <button type="submit" class="btn-primary" formaction="article.php?id=<?php echo $livre['id']; ?>">Afficher</button>
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