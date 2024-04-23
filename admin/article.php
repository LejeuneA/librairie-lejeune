<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the item is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the item ID from the URL

    // Define the category based on the item type (livres, papeteries, or cadeaux)
    $category = null; // Default value
    if (isset($_GET['idCategory']) && ($_GET['idCategory'] === '1' || $_GET['idCategory'] === '2' || $_GET['idCategory'] === '3')) {
        $category = $_GET['idCategory'];
    } elseif ($_GET['idCategory'] === 'livres') {
        $category = 1; // Assign the correct category ID for papeteries
    } elseif ($_GET['idCategory'] === 'papeteries') {
        $category = 2; // Assign the correct category ID for papeteries
    } elseif ($_GET['idCategory'] === 'cadeaux') {
        $category = 3; // Assign the correct category ID for cadeaux
    }

    // Ensure that the database connection object is valid
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error');
    } else {
        // Fetch the item from the database based on the ID and category
        switch ($category) {
            case 1:
                $result = getItemByIDLivres($conn, $id);
                break;
            case 2:
                $result = getItemByIDPapeteries($conn, $id);
                break;
            case 3:
                $result = getItemByIDCadeaux($conn, $id);
                break;
            default:
                $result = null;
        }

        // Check if the result is a valid array and not empty
        if (isset($result) && is_array($result) && !empty($result)) {
            $execute = true;
        } else {
            $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error');
        }
    }
} else {
    $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection((isset($result['title']) ? $result['title'] : APP_NAME)); ?>
</head>

<body>
    <header>
        <?php displayNavigation(); ?>
    </header>
    <div class="container">
        <div id="message">
            <?php if (isset($msg)) echo $msg; ?>
        </div>
        <div id="content">
            <?php
            // Check if execution is successful
            if ($execute) {
                // Display the item content
                echo "<h3>" . html_entity_decode($result['title']) . "</h3>";
                echo "<p>" . html_entity_decode($result['content']) . "</p>";
            }
            ?>
        </div>
    </div>
    <footer>
        <div data-include="footer"></div>
    </footer>
    <script src="https://kit.fontawesome.com/3546d47201.js" crossorigin="anonymous"></script>
    <script src="../js/functions.js"></script>
</body>

</html>