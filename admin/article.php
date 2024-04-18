<?php
require_once('settings.php');

$msg = null;
$result = null;
$execute = false;

// On vérifie si l'ID de l'article est passé en paramètre dans l'url ($_GET)
if (isset($_GET['idLivre']) && !empty($_GET['idLivre'])) {

    // On récupère l'ID de l'article passé en paramètre
    $id = $_GET['idLivre'];

    // On vérifie l'objet de connexion $conn
    if (!is_object($conn)) {
        $msg = getMessage($conn, 'error');
    } else {

        // Récupérer l'article spécifié par l'ID
        $result = getLivreByIDDB($conn, $id);

        // On vérifie le retour de la fonction : si c'est un tableau, on continue, sinon on affiche un message d'erreur
        (isset($result) && is_array($result) && !empty($result)) ? $execute = true : $msg = getMessage('Il n\'y a pas d\'article à afficher', 'error');
    }
} else {
    $msg = getMessage('Il n\'y a pas d\'article à afficher', 'success');
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection((isset($result['title']) ? $result['title'] : APP_NAME)); ?>
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
    <div class="container">
        <div id="message">
            <?php if (isset($msg)) echo $msg; ?>
        </div>
        <div id="content">

            <?php
            // Peut-on exécuter l'affichage de l'article
            if ($execute)
                displayLivreByID($result);
            ?>

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

    <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/3546d47201.js" crossorigin="anonymous"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>