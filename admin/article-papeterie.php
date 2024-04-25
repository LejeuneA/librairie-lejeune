<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the papeterie is passed in the URL
if (isset($_GET['idPapeterie']) && !empty($_GET['idPapeterie'])) {
    $idPapeterie = $_GET['idPapeterie']; // Retrieve the papeterie ID from the URL
    // Ensure that the database connection object is valid
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error'); // Display an error message if the connection is not valid
    } else {
        // Fetch the papeterie from the database based on the ID
        $result = getPapeterieByIDDB($conn, $idPapeterie);
        // Check if the result is a valid array and not empty
        if (isset($result) && is_array($result) && !empty($result)) {
            $execute = true; // Set execute flag to true if a valid papeterie is found
        } else {
            $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no papeterie is found
        }
    }
} else {
    $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error'); // Display an error message if no papeterie ID is provided
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
                displayPapeterieByID($result);
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