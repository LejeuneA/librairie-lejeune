<?php

require_once('settings.php');

// Check if user is not identified, redirect to login page
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit(); 
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
        // Initialize empty array for storing form data
        $addData = [];

        // Gather data from the form
        $addData['image_url'] = ''; 
        $addData['title'] = isset($_POST['title']) ? $_POST['title'] : '';
        $addData['writer'] = isset($_POST['writer']) ? $_POST['writer'] : '';
        $addData['feature'] = isset($_POST['feature']) ? $_POST['feature'] : '';
        $addData['price'] = isset($_POST['price']) ? $_POST['price'] : '';
        $addData['content'] = isset($_POST['content']) ? $_POST['content'] : '';
        $addData['published_article'] = isset($_POST['published_article']) ? 1 : 0;
        $addData['idCategory'] = isset($_POST['idCategory']) ? $_POST['idCategory'] : 0;

        // Handle image upload
        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/'; 
            $uploadFile = $uploadDir . basename($_FILES['image_upload']['name']);

            // Move uploaded file to designated directory
            if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $uploadFile)) {
                $addData['image_url'] = $uploadFile;
            }
        }

        // Add the livre to the database
        $addResult = addLivreDB($conn, $addData);

        // Check the result and display appropriate message
        if ($addResult === true) {
            // Set session variable to indicate success
            $_SESSION['livre_added'] = true;
            // Redirect to the same page to refresh and clear the form
            header('Location: add-livre.php');
            exit();
        } else {
            $msg = getMessage('Erreur lors de l\'ajout du livre. Veuillez réessayer.', 'error');
        }
    }

    // Fetch categories for the form dropdown
    $categories = getAllCategoriesDB($conn);
}

// At the beginning of the file, before any output
// Check if a livre has been successfully added
if (isset($_SESSION['livre_added']) && $_SESSION['livre_added'] === true) {
    // Display success message
    $msg = getMessage('Le livre a été ajouté avec succès.', 'success');
    // Clear the session variable
    unset($_SESSION['livre_added']);
}

// Initialize the $addData array with empty values
$addData = [
    'image_url' => '',
    'title' => '',
    'writer' => '',
    'feature' => '',
    'price' => '',
    'content' => '',
    'published_article' => 0,
    'idCategory' => 0
];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Ajouter un livre');
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
            <h1>Ajouter un livre</h1>
            <div class="message">
                <?php if (isset($msg)) echo $msg; ?>
            </div>
        </div>

        <div class="edit-form container">
            <form id="add-livre-form" action="add-livre.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form" value="add">

                <!-- Form top -->
                <div class="form-top">
                    <!-- Form left -->
                    <div class="form-left">
                        <!-- Statue of the article -->
                        <div class=" form-ctrl">
                            <label for="published_article" class="published_article">Status du produit <span>(publication)</span></label>
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
                            <input type="text" class="form-ctrl" id="title" name="title" value="<?php echo isset($addData['title']) ? $addData['title'] : ''; ?>" required>
                        </div>
                        <!-- Writer -->
                        <div class="form-ctrl">
                            <label for="writer" class="form-ctrl">Author</label>
                            <input type="text" class="form-ctrl" id="writer" name="writer" value="<?php echo isset($addData['writer']) ? $addData['writer'] : ''; ?>">
                        </div>
                        <!-- Feature -->
                        <div class="form-ctrl">
                            <label for="feature" class="form-ctrl">Caractèriques</label>
                            <input type="text" class="form-ctrl" id="feature" name="feature" value="<?php echo isset($addData['feature']) ? $addData['feature'] : ''; ?>">
                        </div>
                        <!-- Price -->
                        <div class="form-ctrl">
                            <label for="price" class="form-ctrl">Prix</label>
                            <input type="text" class="form-ctrl" id="price" name="price" value="<?php echo isset($addData['price']) ? $addData['price'] : ''; ?>">
                        </div>
                    </div>

                    <!-- Form right -->
                    <div class="form-right">
                        <!-- URL of the image -->
                        <div class="form-ctrl">
                            <label for="image_url" class="form-ctrl">URL de l'image</label>
                            <input type="text" class="form-ctrl" id="image_url" name="image_url" value="<?php echo isset($addData['image_url']) ? $addData['image_url'] : ''; ?>" readonly>
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
                                <img id="image_preview" class="image_preview" src="<?php echo isset($addData['image_url']) ? $addData['image_url'] : ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form bottom -->
                <div class="form-bottom">
                    <div class="form-ctrl">
                        <label for="content" class="form-ctrl">Contenu</label>
                        <textarea class="content" id="content" name="content" rows="5"><?php echo isset($addData['content']) ? $addData['content'] : ''; ?></textarea>
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

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
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
