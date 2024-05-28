<?php
require_once('C:\xampp\htdocs\librairie-lejeune\admin\settings.php');

$msg = null;
$result = null;
$execute = false;

// Check if the ID of the papeterie is passed in the URL
if (isset($_GET['idPapeterie']) && !empty($_GET['idPapeterie'])) {
    $idPapeterie = $_GET['idPapeterie'];
    // Ensure that the database connection object is valid
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error');
    } else {
        // Fetch the papeterie from the database based on the ID
        $result = getPapeterieByIDDB($conn, $idPapeterie);
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
    <?php displayHeadSection('Papeterie'); ?>
</head>

<body>
    <header>
        <!-----------------------------------------------------------------
                               Navigation
        ------------------------------------------------------------------>
        <div data-include="navigation"></div>
        <!-----------------------------------------------------------------
                            Navigation end
        ------------------------------------------------------------------>
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
                    displayPapeterieByID($result);
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