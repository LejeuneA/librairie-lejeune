<?php
require_once('settings.php');

// Check if user is not identified, redirect to login page
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit; 
}

$msg = null;
$tinyMCE = true;
$livre = null; 

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Check if article ID is provided in the URL
    if (isset($_GET['idLivre'])) {
        // Get the article ID from the URL
        $idLivre = $_GET['idLivre']; 

        // Retrieve article details from the database
        $livre = getLivreByIDDB($conn, $idLivre); 

        // Fetch category names from the database
        $categories = getCategoryNamesFromDB($conn);

        // Check if the form is submitted and the form type
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the form was submitted for update
            if (isset($_POST['update_form'])) {
                // Update the article in the database
                $updateData = [
                    'idLivre' => $idLivre,
                    'image_url' => $_POST['image_url'], 
                    'title' => isset($_POST['title']) ? $_POST['title'] : '', 
                    'writer' => isset($_POST['writer']) ? $_POST['writer'] : '',
                    'feature' => isset($_POST['feature']) ? $_POST['feature'] : '', 
                    'price' => isset($_POST['price']) ? $_POST['price'] : '',
                    'content' => $_POST['content'],
                    'published_article' => isset($_POST['published_article']) ? 1 : 0,
                    'idCategory' => $_POST['idCategory']
                ];

                // Perform the update operation in the database
                $updateResult = updateLivreDB($conn, $updateData);

                // Check the result of the update operation
                if ($updateResult === true) {
                    $msg = getMessage('Les modifications ont été enregistrées sur la page.', 'success');
                    $_SESSION['form_submitted'] = true; 
                } else {
                    $msg = getMessage('Erreur lors de la modification du produit. Veuillez réessayer.', 'error');
                }
            }

            // Check if file is uploaded
            if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);

                // Check if the directory exists, if not, create it
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true); 
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
                    // File upload successful, update the image URL in the database
                    $updateData['image_url'] = $target_file;
                    updateLivreDB($conn, $updateData); 
                } else {
                    $msg = getMessage('Erreur lors de l\'enregistrement de l\'image. Veuillez réessayer.', 'error');
                }
            }
        }
    } else {
        // If article ID is not provided, redirect to manager.php
        header('Location: manager.php');
        exit; 
    }
}

// Check if form was submitted and unset the session variable
if (isset($_SESSION['form_submitted'])) {
    unset($_SESSION['form_submitted']);
    // Refresh the page after form submission
    header("Refresh: 1; URL=edit-livre.php?idLivre=$idLivre");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Editer un livre');
    displayJSSection($tinyMCE);
    ?>
</head>

<body>
    <header>
        <?php displayNavigation(); ?>
    </header>

    <div class="edit-content">
        <div class="edit-title">
            <h1>Editer un livre</h1>
            <div class="message">
                <?php if (isset($msg)) echo $msg; ?>
            </div>
        </div>

        <div class="edit-form container">
            <form action="edit-livre.php?idLivre=<?php echo $livre['idLivre']; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idLivre" value="<?php echo $livre['idLivre']; ?>">

                <!-- Form top -->
                <div class="form-top">

                    <!-- Form left -->
                    <div class="form-left">
                        
                        <!-- Statue of the article -->
                        <div class=" checkbox-ctrl">
                            <label for="published_article" class="published_article">Status du produit <span>(publication)</span></label>
                            <?php displayFormRadioBtnArticlePublished(isset($livre['active']) ? $livre['active'] : 0, 'EDIT'); ?>
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
                            <input type="text" class="form-ctrl" id="title" name="title" value="<?php echo isset($livre['title']) ? $livre['title'] : ''; ?>" required>
                        </div>

                        <!-- Writer -->
                        <div class="form-ctrl">
                            <label for="writer" class="form-ctrl">Auteur</label>
                            <input type="text" class="form-ctrl" id="writer" name="writer" value="<?php echo isset($livre['writer']) ? $livre['writer'] : ''; ?>">
                        </div>

                        <!-- Feature -->
                        <div class="form-ctrl">
                            <label for="feature" class="form-ctrl">Caractèriques</label>
                            <input type="text" class="form-ctrl" id="feature" name="feature" value="<?php echo isset($livre['feature']) ? $livre['feature'] : ''; ?>">
                        </div>
                        
                        <!-- Price -->
                        <div class="form-ctrl">
                            <label for="price" class="form-ctrl">Prix</label>
                            <input type="text" class="form-ctrl" id="price" name="price" value="<?php echo isset($livre['price']) ? $livre['price'] : ''; ?>">
                        </div>

                    </div>

                    <!-- Form right -->
                    <div class="form-right">
                        <!-- URL of the image -->
                        <div class="form-ctrl">
                            <label for="image_url" class="form-ctrl">URL de l'image</label>
                            <input type="text" class="form-ctrl" id="image_url" name="image_url" value="<?php echo isset($livre['image_url']) ? $livre['image_url'] : ''; ?>" readonly>
                        </div>

                        <!-- File upload field -->
                        <div class="form-ctrl">
                            <label for="image_upload" class="form-ctrl">Uploader l'image</label>
                            <input type="file" class="form-ctrl" id="image_upload" name="image_upload" onchange="previewImage(this)">
                        </div>
                        <!-- Preview of the image -->
                        <div class="form-ctrl">
                            <label for="image_preview" class="form-ctrl">Aperçu de l'image</label>
                            <div>
                                <img id="image_preview" class="image_preview" src="<?php echo isset($livre['image_url']) ? $livre['image_url'] : ''; ?>" alt="Aperçu de l'image">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form bottom -->
                <div class=" form-bottom">
                    <div class="form-ctrl">
                        <label for="content" class="form-ctrl">Contenu</label>
                        <textarea class="content" id="content" name="content" rows="5"><?php echo isset($livre['content']) ? $livre['content'] : ''; ?></textarea>
                    </div>
                </div>

                <input type="hidden" name="update_form" value="1"> 
                <button type="submit" class="btn-primary">Sauvegarder</button>
                <button type="submit" class="btn-primary" formaction="article-livre.php?idLivre=<?php echo $livre['idLivre']; ?>">Afficher</button>
            </form>
        </div>
    </div>

    <?php
    displayJSSection($tinyMCE);
    ?>
    <!-- Footer -->
    <footer>
        <div data-include="footer"></div>
    </footer>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Functions -->
    <script src="../js/functions.js"></script>

    <script>
        function previewImage(input) {
            var preview = document.getElementById('image_preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
