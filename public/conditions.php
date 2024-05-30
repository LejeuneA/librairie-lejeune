<?php
require_once('../admin/settings.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez Librairie Lejeune pour des livres, fournitures de papeterie et cadeaux uniques. Parcourez notre sélection dès aujourd'hui!">


    <!-- Custom Sass file -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Favicon -->
	<link rel="icon" type="image/png" href="../assets/icons/favicon.png">

    <!-- Google Fonts Preconnect and Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Favicon -->

    <!-- Title -->
    <title>Conditions générales</title>
</head>

<body>
    <!-----------------------------------------------------------------
                               Header
    ------------------------------------------------------------------>
    <header>
        <!-----------------------------------------------------------------
                               Navigation
    	------------------------------------------------------------------>
        <nav class="navbar">
            <div class="navbar-container container">
                <!-- Logo -->
                <a href="../index.php">
                    <img src="../assets/logo/librairie-lejeune.png" class="navbar-brand-img" alt="Librairie Lejeune Logo">
                </a>
                <!-- Logo end -->

                <!-- Right-side content -->
                <div class="d-flex">
                    <!-- Social icons -->
                    <ul class="social-nav">
                        <!-- Icons -->
                        <li class="social-item">
                            <a class="social-link" href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-square-facebook fa-lg"></i>
                            </a>
                        </li>
                        <li class="social-item">
                            <a class="social-link" href="https://twitter.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-x-twitter fa-lg"></i>
                            </a>
                        </li>
                        <li class="social-item">
                            <a class="social-link" href="https://www.instagram.com" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-instagram fa-lg"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Social icons end -->

                    <!-- Search -->
                    <form class="search" role="search" action="./admin/search.php" method="GET">
                        <div class="search-group">
                            <input class="form-control" type="search" name="query" placeholder="Que cherchez-vous?" aria-label="Search">
                            <button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <!-- Search end -->

                    <!-- Customer button -->
                    <?php
                    if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
                        echo '<a href="http://localhost/librairie-lejeune/admin/login.php" class="btn-primary">Se connecter</a>';
                    } elseif (isset($_SESSION['user_permission'])) {
                        if ($_SESSION['user_permission'] == 1) {
                            echo '<a href="http://localhost/librairie-lejeune/admin/manager.php" class="btn-customer"><i class="fa-solid fa-user"></i> Mon compte</a>';
                        } elseif ($_SESSION['user_permission'] == 2) {
                            echo '<a href="http://localhost/librairie-lejeune/admin/customer.php" class="btn-customer"><i class="fa-solid fa-user"></i> Mon compte</a>';
                        }
                    }
                    ?>
                    <!-- Customer button end -->

                    <!-- Login button -->
                    <?php if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) : ?>
                        <a href="http://localhost/librairie-lejeune/admin/login.php" class="btn-primary">Se connecter</a>
                    <?php else : ?>
                        <a href="http://localhost/librairie-lejeune/admin/logoff.php" class="btn-primary">Déconnexion</a>
                    <?php endif; ?>
                    <!-- Login button end -->


                </div>
                <!-- Right-side content end -->
            </div>
        </nav>

        <!---------------------------------------------------------------
                                Menu
    	----------------------------------------------------------------->
        <div class="navbar-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/livres.php">Livres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/papeteries.php">Papeterie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/cadeaux.php">Cadeaux</a>
                </li>
            </ul>
        </div>
        <!---------------------------------------------------------------
                         Menu end
    	---------------------------------------------------------------->

        <!---------------------------------------------------------------
                             Offcanvas menu
    	----------------------------------------------------------------->
        <div id="mySidenav" class="sidenav">

            <!-- Search -->
            <form class="search" role="search" action="./admin/search.php" method="GET">
                <div class="search-group">
                    <input class="form-control" type="search" name="query" placeholder="Que cherchez-vous?" aria-label="Search">
                    <button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <!-- Search end -->

            <!-- Menu -->
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a class="nav-link" href="../index.php">Accueil</a>
            <a class="nav-link" href="../public/livres.php">Livres</a>
            <a class="nav-link" href="../public/papeteries.php">Papeterie</a>
            <a class="nav-link" href="../public/cadeaux.php">Cadeaux</a>
            <!-- Menu end -->

            <!-- Customer button -->
            <?php
            if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
                echo '<a href="http://localhost/librairie-lejeune/admin/login.php" class="btn-primary">Se connecter</a>';
            } elseif (isset($_SESSION['user_permission'])) {
                if ($_SESSION['user_permission'] == 1) {
                    echo '<a href="http://localhost/librairie-lejeune/admin/manager.php" class="btn-customer"><i class="fa-solid fa-user"></i> Mon compte</a>';
                } elseif ($_SESSION['user_permission'] == 2) {
                    echo '<a href="http://localhost/librairie-lejeune/admin/customer.php" class="btn-customer"><i class="fa-solid fa-user"></i> Mon compte</a>';
                }
            }
            ?>
            <!-- Customer button end -->

            <!-- Login button -->
            <?php if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) : ?>
                <a href="http://localhost/librairie-lejeune/admin/login.php" class="btn-login">Se connecter</a>
            <?php else : ?>
                <a href="http://localhost/librairie-lejeune/admin/logoff.php" class="btn-login">Déconnexion</a>
            <?php endif; ?>
            <!-- Login button end -->

            <!-- Social icons -->
            <ul class="social-nav">
                <!-- Icons -->
                <li class="social-item">
                    <a class="social-link" href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-square-facebook fa-lg"></i>
                    </a>
                </li>
                <li class="social-item">
                    <a class="social-link" href="https://twitter.com/" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-x-twitter fa-lg"></i>
                    </a>
                </li>
                <li class="social-item">
                    <a class="social-link" href="https://www.instagram.com" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-instagram fa-lg"></i>
                    </a>
                </li>
            </ul>
            <!-- Social icons end -->

        </div>

        <!-- Hamburger icon for smaller screens -->
        <div class="navbar-hamburger">
            <div id="hamburger" onclick="openNav()"><i class="fa-solid fa-bars"></i></div>
        </div>
        <!------------------------------------------------------------- 
                          Offcanvas menu end
    	--------------------------------------------------------------->
    </header>
    <!-----------------------------------------------------------------
                               Header end
    ------------------------------------------------------------------>
    <div class="header-image--conditions">
    </div>
    </header>
    <!-----------------------------------------------------------------
                            Header end
    ------------------------------------------------------------------>
    <!-- Main -->
    <main>

        <!-----------------------------------------------------------------
                               Introduction
    ------------------------------------------------------------------>
        <div class="square-right">
            <img src="../assets/components/square-right.png" alt="square">
        </div>

        <section class="introduction">

            <h1>Conditions générales</h1>
            <p>
                Lorsque vous vous inscrivez sur le site Librairie Lejeune, il vous sera demandé de choisir une adresse
                électronique de contact et un mot de passe. Vous êtes responsable de toutes les sessions et transactions
                effectuées à l'aide de ces données. Vous devez conserver votre mot de passe en toute sécurité et ne le
                divulguer à personne. Vous devez le modifier immédiatement si vous pensez qu'il a été compromis.
                Si l'une de vos données change, comme l'adresse de facturation de votre carte de crédit, vous devez en
                informer Waterstones dès que possible. Vous pouvez mettre à jour vos données en vous connectant à votre
                compte sur le site Web de Librairie Lejeune et en mettant à jour la section correspondante.
            </p>
        </section>
        <div class="square-left">
            <img src="../assets/components/square-left.png" alt="square">
        </div>
        <!-----------------------------------------------------------------
                               Introduction end
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                               Information
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                               Information top
        ------------------------------------------------------------------>
        <section class="information-top">

            <!-- Container -->
            <div class="container">

                <h2>
                    Le contrat entre nous
                </h2>
                <p>
                    Librairie Lejeune doit recevoir le paiement de la totalité du prix des marchandises que vous
                    commandez avant que votre commande ne soit acceptée et que le contrat ne soit formé. Le paiement
                    n'est effectué qu'au moment de l'expédition des marchandises depuis notre centre de distribution.
                    Une fois le paiement reçu, Waterstones confirmera que votre commande a été reçue en vous envoyant un
                    courriel à l'adresse électronique que vous avez fournie dans votre formulaire d'inscription.
                    L'e-mail d'expédition comprendra votre nom, le numéro de commande et le prix total. L'acceptation de
                    votre commande par Waterstones donne naissance à un contrat juridiquement contraignant entre nous
                    selon ces conditions. Toute condition que vous cherchez à imposer dans votre commande ne fera pas
                    partie du contrat.
                    Librairie Lejeune a le droit de se retirer de tout contrat en cas d'erreurs ou d'inexactitudes
                    évidentes concernant les marchandises apparaissant sur notre site web. Si une erreur ou une
                    inexactitude est découverte en ce qui concerne le prix annoncé des marchandises que vous avez
                    commandées, nous vous contacterons dès que possible par courrier électronique. Nous vous informerons
                    du prix correct des marchandises et vous demanderons si vous souhaitez poursuivre la commande au
                    prix modifié ou si vous souhaitez l'annuler.
                </p>
            </div>
        </section>
        <!-- Information-top end -->

        <!-- Container end -->
        <!-----------------------------------------------------------------
                               Information top end
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                               Information bottom
        ------------------------------------------------------------------>
        <section class="information-bottom container">

            <!-- Information-bottom-left -->
            <div class="information-bottom-left">
                <h2>
                    Ventes en ligne
                </h2>
                <p>
                    Une commande en ligne suppose l'acceptation par l'utilisateur des conditions générales telles
                    qu'elles sont applicables au moment de la commande.
                    Club SA se réserve le droit de refuser une commande. La simple volonté d’un utilisateur d’acquérir
                    un produit ne suffit donc pas à la conclusion d’un contrat.
                    Une commande en ligne ne sera acceptée par Club SA que si l’utilisateur s’est identifié suffisamment
                    clairement.
                    Si, du fait de circonstances indépendantes de notre volonté, des articles ne peuvent finalement pas
                    être livrés par Club SA sous un maximum de 30 jours calendaires après la commande, Club SA tiendra
                    l’utilisateur informé par e-mail sur l’adresse indiquée par lui. Dans ce cas, l’utilisateur peut
                    choisir d’annuler la commande. Club SA remboursera alors à l’utilisateur le montant déjà payé pour
                    ce ou ces article(s) et, de cette manière, le contrat de vente sera automatiquement résilié pour ce
                    qui le ou les concerne.
                </p>
            </div>
            <!-- Information-bottom-left end -->

        </section>
        <!-- Information-top end -->

        <!-----------------------------------------------------------------
                            Information bottom end
        ------------------------------------------------------------------>
    </main>
    <!-- Main end -->


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