<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the livre is passed in the URL
if (isset($_GET['idLivre']) && !empty($_GET['idLivre'])) {
    $idLivre = $_GET['idLivre'];
    // Ensure that the database connection object is valid
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error');
    } else {
        // Fetch the livre from the database based on the ID
        $result = getLivreByIDDB($conn, $idLivre);
        // Check if the result is a valid array and not empty
        if (isset($result) && is_array($result) && !empty($result)) {
            $execute = true;
        } else {
            $msg = getMessage('Il n\'y a pas du produit à afficher', 'error');
        }
    }
} else {
    $msg = getMessage('Il n\'y a pas du produit à afficher', 'error');
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection('Livre'); ?>
</head>

<body>
    <header>
        <?php displayNavigation(); ?>
    </header>
    <!-- Main -->
    <main>
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
    </main>
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