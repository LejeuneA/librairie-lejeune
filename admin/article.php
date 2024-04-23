<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the item is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the item ID from the URL

    // Define the category based on the item type (livres, papeteries, or cadeaux)
    $category = 1; // Default category for livres
    if (isset($_GET['category']) && in_array($_GET['category'], [1, 2, 3])) {
        $category = $_GET['category'];
    }

    // Ensure that the database connection object is valid
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error'); // Display an error message if the connection is not valid
    } else {
        // Fetch the item from the database based on the ID and category
        $result = getItemByID($conn, $id, $category);

        // Check if the result is a valid array and not empty
        if (isset($result) && is_array($result) && !empty($result)) {
            $execute = true; // Set execute flag to true if a valid item is found
        } else {
            $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no item is found
        }
    }
} else {
    $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no item ID is provided
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
                echo "<h3>" . $result['title'] . "</h3>";
                echo "<p>" . $result['content'] . "</p>";
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
