<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the livre is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the livre ID from the URL
    // Ensure that the database connection object is valid
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error'); // Display an error message if the connection is not valid
    } else {
        // Fetch the livre from the database based on the ID
        $result = getLivreByIDDB($conn, $id);
        // Check if the result is a valid array and not empty
        if (isset($result) && is_array($result) && !empty($result)) {
            $execute = true; // Set execute flag to true if a valid livre is found
        } else {
            $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no livre is found
        }
    }
} else {
    $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no livre ID is provided
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection((isset($result['titleLivre']) ? $result['titleLivre'] : APP_NAME)); ?>
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
                displayLivreByID($result);
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