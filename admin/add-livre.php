<?php

require_once('settings.php');

// Check if user is not identified, redirect to login page
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit(); // Make sure to exit after redirection
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
            'image_url' => $_POST['image_url'],
            'title' => isset($_POST['title']) ? $_POST['title'] : '',
            'writer' => isset($_POST['writer']) ? $_POST['writer'] : '',
            'feature' => isset($_POST['feature']) ? $_POST['feature'] : '',
            'price' => isset($_POST['price']) ? $_POST['price'] : '',
            'content' => $_POST['content'],
            'active' => isset($_POST['active']) ? 1 : 0,
            'idCategory' => isset($_POST['idCategory']) ? $_POST['idCategory'] : 0 // Make sure to handle if no category is selected
        ];

        // Add the livre to the database
        $addResult = addLivreDB($conn, $addData);

        // Check the result and display appropriate message
        if ($addResult === true) {
            $msg = getMessage('Le livre a été ajouté avec succès.', 'success');
        } else {
            $msg = getMessage('Erreur lors de l\'ajout du livre. Veuillez réessayer.', 'error');
        }
    }

    // Fetch categories for the form dropdown
    $categories = getAllCategoriesDB($conn);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Ajouter un produit');
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
    <div class="edit-content">
        <div class="edit-title">
            <h1>Ajouter un produit</h1>
            <div class="message">
                <?php if (isset($msg)) echo $msg; ?>
            </div>
        </div>

        <div class="edit-form container">
            <form action="add.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form" value="add">
                <!-- Add enctype="multipart/form-data" to enable file uploads -->

                <!-- Form top -->
                <div class="form-top">

                    <!-- Form left -->
                    <div class="form-left">
                        <!-- Statue of the article -->
                        <div class=" form-ctrl">
                            <label for="published_article" class="published_article">Status de l'article <span>(publication)</span></label>
                            <?php displayFormRadioBtnArticlePublished(isset($livre['active']) ? $livre['active'] : 0, 'EDIT'); ?>
                        </div>

                        <!-- Category -->
                        <div class="form-ctrl">
                            <label for="idCategory" class="form-ctrl">Catégorie</label>
                            <select id="idCategory" name="idCategory" class="form-ctrl" required>
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['idCategory']; ?>"><?php echo $category['nameOfCategory']; ?></option>
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
                            <label for="writer" class="form-ctrl">Author</label>
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
                            <input type="file" class="form-ctrl" id="image_upload" name="image_upload">
                        </div>
                        <!-- Preview of the image -->
                        <div class="form-ctrl">
                            <label for="image_preview" class="form-ctrl">Aperçu de l'image</label>
                            <div>
                                <img id="image_preview" class="image_preview" src="<?php echo isset($livre['image_url']) ? $livre['image_url'] : ''; ?>" alt="Aperçu de l'image"">
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
                            <button type="submit" class="btn-primary">Ajouter</button>
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