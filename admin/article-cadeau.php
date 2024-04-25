<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the cadeau is passed in the URL
if (isset($_GET['idCadeau']) && !empty($_GET['idCadeau'])) {
    $idCadeau = $_GET['idCadeau']; // Retrieve the cadeau ID from the URL
    // Ensure that the database connection object is valid
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error'); // Display an error message if the connection is not valid
    } else {
        // Fetch the cadeau from the database based on the ID
        $result = getCadeauByIDDB($conn, $idCadeau);
        // Check if the result is a valid array and not empty
        if (isset($result) && is_array($result) && !empty($result)) {
            $execute = true; // Set execute flag to true if a valid cadeau is found
        } else {
            $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no cadeau is found
        }
    }
} else {
    $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no cadeau ID is provided
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
            // Peut-on exécuter l'affichage de l'article
            if ($execute) {
                displayCadeauByID($result);
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