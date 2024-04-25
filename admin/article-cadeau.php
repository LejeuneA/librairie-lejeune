<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the cadeau is passed in the URL
if (isset($_GET['idCadeau']) && !empty($_GET['idCadeau'])) {
    $idCadeau = $_GET['idCadeau']; 
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
            $msg = getMessage('Il n\'y a pas du produit à afficher', 'error'); // Display an error message if no cadeau is found
        }
    }
} else {
    $msg = getMessage('Il n\'y a pas du produit à afficher', 'error'); // Display an error message if no cadeau ID is provided
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
    <!-- Footer -->
    <footer>
        <div data-include="footer"></div>
    </footer>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>