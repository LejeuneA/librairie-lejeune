<?php
require_once('settings.php');

// Redirection vers la page de gestion si l'utilisateur est connecté
if ($_SESSION['IDENTIFY']) {
    header('Location: manager.php');
}

$user = null;
$connexionSuccessfull = null;
$msg = null;

// On vérifie l'objet de connexion $conn
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {

    // Vérifie si on reçoit le formumaire d'identification
    if (isset($_POST['form']) && $_POST['form'] == 'login') {

        // Vérifie si les champs sont vides
        if ($_POST['login'] == '' || $_POST['pwd'] == '') {
            $msg = getMessage('Veuillez remplir tous les champs', 'error');
        } else {

            // On récupère les données du formulaire
            $datas = $_POST;

            // Appel de la fonction d'identification
            // Utiliser cette fonction si les mots de passe sont en clair dans la DB
            $user = userIdentificationDB($conn, $datas);

            // Utiliser cette fonction si les mots de passe sont hashés dans la DB
            // $user = userIdentificationWithHashPwdDB($conn, $datas);            

            // On vérifie si on a une adresse email dans le tableau $user, si c'est le cas on est connecté
            (!empty($user['email'])) ? $connexionSuccessfull = true : $connexionSuccessfull = false;
        }
    }

    // Si on est connecté, on initialise les variables de session et on redirige vers la page de gestion
    if ($connexionSuccessfull === true) {
        $_SESSION['IDENTIFY'] = true;
        $_SESSION['user_email'] = $user['email'];
        header('Location: manager.php');
        // Dans le cas contraire on affiche un message d'erreur, il y a eu une erreur d'identification
    } elseif ($connexionSuccessfull === false) {
        $msg = getMessage('Votre email et/ou votre mot de passe sont erronés', 'error');
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection('S\'identifier'); ?>
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
    <div class="login-container">
        <div class="login-title">
            <h1>Se connecter</h1>
            <p>Connectez-vous et gérer votre page</p>
            <div class="message">
                <?php if (isset($msg)) echo $msg; ?>
            </div>
        </div>
        <div class="login-content container">
            <form class="login-form" action="login.php" method="post">
                <div class="form-ctrl">
                    <label for="login" class="form-ctrl">E-mail</label>
                    <input type="email" class="form-ctrl" id="login" name="login" value="<?php echo (!empty($_POST['login'])) ? $_POST['login'] : null; ?>" required>
                </div>
                <div class="form-ctrl">
                    <label for="pwd" class="form-ctrl">Mot de passe</label>
                    <input type="password" class="form-ctrl" id="pwd" name="pwd" value="" required>
                </div>
                <p>Oublié le mot de passe ?</p>
                <input type="hidden" id="form" name="form" value="login">
                <button type="submit" class="btn-primary">Se connecter</button>
            </form>
            <div class="background-vector">
                <img src="../assets/components/background-vector.png" alt="background-vector">
            </div>
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

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>