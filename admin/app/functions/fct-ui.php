<?php
/* ********************************************************************** */
/* *                          TOOLS FUNCTIONS                           * */
/* *                          ---------------                           * */
/* *        FONCTIONS D'AFFICHAGE DE L'INTERFACE UTILISATEUR            * */
/* ********************************************************************** */

/**
 * Retourne le code html des boutons radios indiquant 
 * le status de publication de l'article
 * 
 * @param boolean     $published
 * @param string      $typeForm  (ADD ou EDIT)
 * @return void
 */
function displayFormRadioBtnArticlePublished($published, $typeForm = 'ADD')
{
    $html = '';

    if ($typeForm == 'ADD') {
        $html .= '
        <div class="checkbox-wrapper-22">
            <label class="switch" for="checkbox">
            <input type="checkbox" id="checkbox" value="1" name="published_article" />
            <div class="slider round"></div>
            </label>
        </div>
        ';
    } elseif ($typeForm == 'EDIT') {
        if ($published) {
            $html .= '
                <div class="checkbox-wrapper-22">
                    <label class="switch" for="checkbox"> 
                    <input type="checkbox" id="checkbox" value="1" name="published_article" checked>    
                    <span class="slider round"></span> 
                    </label>
                </div>
            ';
        } else {
            $html .= '
                <div class="checkbox-wrapper-22">
                    <label class="switch" for="checkbox">
                    <input type="checkbox" id="checkbox" value="1" name="published_article">  
                    <span class="slider round"></span> 
                    </label>   
                </div>
            ';
        }
    }

    echo $html;
}


/**-----------------------------------------------------------------
                    Affichage de la section JS
 *------------------------------------------------------------------**/
/**
 * Affichage de la section JS
 * 
 * @param bool $tinyMCE 
 * @return void 
 */
function displayJSSection($tinyMCE = false)
{
    $js = '';

    // Chargement de TinyMCE si nécessaire (paramètre $tinyMCE = true)
    $js .= ($tinyMCE) ? '
    <script src="vendors/tinymce/tinymce.min.js" referrerpolicy="origin"></script>  
    <script src="assets/js/conf-tinymce.js"> </script>
    ' : null;

    // Affichage de la chaîne des scripts JS
    echo $js;
}


/**-----------------------------------------------------------------
                Affichage de la section head d'une page
 *------------------------------------------------------------------**/
/**
 * Affichage de la section head d'une page
 * 
 * @param string $title 
 * @return void 
 */
function displayHeadSection($title = APP_NAME)
{
    $head = '
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez Librairie Lejeune pour des livres, fournitures de papeterie et cadeaux uniques. Parcourez notre sélection dès aujourd\'hui!">

    <!-- Custom Sass file -->
    <link rel="stylesheet" href="'.DOMAIN.'/css/styles.css">

    <!-- Favicon -->
	<link rel="icon" type="image/png" href="../assets/icons/favicon.png">

    <!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/icons/favicon.png">

    <!-- Google Fonts Preconnect and Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
    <title>' . $title . '</title>
    ';

    echo $head;
}


/**-----------------------------------------------------------------
                    Navigation admin
*------------------------------------------------------------------**/

/**
 * Affichage de la navigation
 * 
 * @return void 
 */
function displayNavigation()
{

    $navigation = '';

    if ($_SESSION['IDENTIFY']) {
        $navigation .= '
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
                        <a class="social-link" href="https://www.facebook.com/">
                            <i class="fa-brands fa-square-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://twitter.com/">
                            <i class="fa-brands fa-x-twitter fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://www.instagram.com">
                            <i class="fa-brands fa-instagram fa-lg"></i>
                        </a>
                    </li>
                </ul>
                <!-- Social icons end -->

                <!-- Search -->
					<form class="search" role="search" action="search.php" method="GET">
						<div class="search-group">
							<input class="form-control" type="search" name="query" placeholder="Que cherchez-vous?" aria-label="Search">
							<button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
						</div>
					</form>
				<!-- Search end -->

                <!-- Login button -->
                <a href="logoff.php" class="btn-primary">Déconnexion</a>
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
                <a class="nav-link" href="../admin/manager.php">Catégories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/manager-livre.php">Livres</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="../admin/manager-papeterie.php">Papeteries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/manager-cadeau.php">Cadeaux</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/manager.php">Ajouter</a>
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
            <form class="search" role="search" action="search.php" method="GET">
                <div class="search-group">
                 <input class="form-control" type="search" name="query" placeholder="Que cherchez-vous?" aria-label="Search">
                 <button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        <!-- Search end -->

        <!-- Menu -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a class="nav-link" href="../index.php">Accueil</a>
        <a class="nav-link" href="../admin/manager.php">Catégories</a>
        <a class="nav-link" href="../admin/manager-livre.php">Livres</a>
        <a class="nav-link" href="../admin/manager-papeterie.php">Papeteries</a>
        <a class="nav-link" href="../admin/manager-cadeau.php">Cadeaux</a>
        <a class="nav-link" href="../admin/manager.php">Ajouter</a>
        <!-- Menu end -->
 
        <!-- Login button -->
        <a href="logoff.php" class="btn-login">Déconnexion</a>
        <!-- Login button end -->

        <!-- Social icons -->
        <ul class="social-nav">
            <!-- Icons -->
            <li class="social-item">
                <a class="social-link" href="https://www.facebook.com/">
                    <i class="fa-brands fa-square-facebook fa-lg"></i>
                </a>
            </li>
            <li class="social-item">
                <a class="social-link" href="https://twitter.com/">
                    <i class="fa-brands fa-x-twitter fa-lg"></i>
                </a>
            </li>
            <li class="social-item">
                <a class="social-link" href="https://www.instagram.com">
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
        ';
    } else {
        $navigation .= '
        <nav class="navbar">
        <div class="navbar-container container">
            <!-- Logo -->
            <a href="login.php">
                <img src="../assets/logo/librairie-lejeune.png" class="navbar-brand-img" alt="Librairie Lejeune Logo">
            </a>
            <!-- Logo end -->

            <!-- Right-side content -->
            <div class="d-flex">
                <!-- Social icons -->
                <ul class="social-nav">
                    <!-- Icons -->
                    <li class="social-item">
                        <a class="social-link" href="https://www.facebook.com/">
                            <i class="fa-brands fa-square-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://twitter.com/">
                            <i class="fa-brands fa-x-twitter fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://www.instagram.com">
                            <i class="fa-brands fa-instagram fa-lg"></i>
                        </a>
                    </li>
                </ul>
                <!-- Social icons end -->

                <!-- Search -->
                <form class="search" role="search">
                    <div class="search-group">
                        <input class="form-control" type="search" placeholder="Que cherhez-vous?" aria-label="Search">
                        <button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <!-- Search end -->

                <!-- Login button -->
                <a href="login.php" class="btn-primary">Se connecter</a>
                <!-- Login button end -->
            </div>
            <!-- Right-side content end -->
        </div>
    </nav>';
    }

    echo $navigation;
}


/**-----------------------------------------------------------------
                    Navigation customer
*------------------------------------------------------------------**/

/**
 * Affichage de la navigation
 * 
 * @return void 
 */
function displayNavigationCustomer()
{

    $navigation = '';

    if ($_SESSION['IDENTIFY']) {
        $navigation .= '
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
                        <a class="social-link" href="https://www.facebook.com/">
                            <i class="fa-brands fa-square-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://twitter.com/">
                            <i class="fa-brands fa-x-twitter fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://www.instagram.com">
                            <i class="fa-brands fa-instagram fa-lg"></i>
                        </a>
                    </li>
                </ul>
                <!-- Social icons end -->

                <!-- Search -->
					<form class="search" role="search" action="search.php" method="GET">
						<div class="search-group">
							<input class="form-control" type="search" name="query" placeholder="Que cherchez-vous?" aria-label="Search">
							<button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
						</div>
					</form>
				<!-- Search end -->

                <!-- Login button -->
                <a href="logoff.php" class="btn-primary">Déconnexion</a>
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
            <form class="search" role="search" action="search.php" method="GET">
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

        <!-- Login button -->
        <a href="logoff.php" class="btn-login">Déconnexion</a>
        <!-- Login button end -->

        <!-- Social icons -->
        <ul class="social-nav">
            <!-- Icons -->
            <li class="social-item">
                <a class="social-link" href="https://www.facebook.com/">
                    <i class="fa-brands fa-square-facebook fa-lg"></i>
                </a>
            </li>
            <li class="social-item">
                <a class="social-link" href="https://twitter.com/">
                    <i class="fa-brands fa-x-twitter fa-lg"></i>
                </a>
            </li>
            <li class="social-item">
                <a class="social-link" href="https://www.instagram.com">
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
        ';
    } else {
        $navigation .= '
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
                        <a class="social-link" href="https://www.facebook.com/">
                            <i class="fa-brands fa-square-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://twitter.com/">
                            <i class="fa-brands fa-x-twitter fa-lg"></i>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="https://www.instagram.com">
                            <i class="fa-brands fa-instagram fa-lg"></i>
                        </a>
                    </li>
                </ul>
                <!-- Social icons end -->

                <!-- Search -->
                <form class="search" role="search">
                    <div class="search-group">
                        <input class="form-control" type="search" placeholder="Que cherhez-vous?" aria-label="Search">
                        <button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <!-- Search end -->

                <!-- Login button -->
                <a href="login.php" class="btn-primary">Se connecter</a>
                <!-- Login button end -->
            </div>
            <!-- Right-side content end -->
        </div>
    </nav>';
    }

    echo $navigation;
}


/**-----------------------------------------------------------------
                    Affichage du footer
*------------------------------------------------------------------**/

/**
 * Affichage du footer
 * 
 * @return void 
 */
function displayFooter()
{

    $footer = '';

    if ($_SESSION['IDENTIFY']) {
        $footer .= '
        <!-----------------------------------------------------------------
                            Footer upper section
        ------------------------------------------------------------------>
        <div class="upper-footer-container">
            <!-- Upper footer -->
            <div class="upper-footer container">
                <!-- Logo column -->
                <div class="footer-brand">
                    <a href="../index.php">
                        <img src="../assets/logo/librairie-lejeune-white.png" alt="Librarie Lejeune Logo" />
                    </a>
                </div>
                <!-- Logo column end-->

                <!-- Contact us column -->
                <div class="footer-contact">
                    <h3>CONTACTEZ-NOUS</h3>
                    <ul>
                        <li>
                            <a href="../public/contact.php" class="">Contact</a>
                        </li>
                        <li>
                            <i class="fa-regular fa-envelope"></i>
                            <a href="mailto:contact@acelyalejeune.be">Envoyez-nous un message</a>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            Téléphonez-nous au <br>0493 38 77 29
                        </li>
                        <li>
                            <b>Permanence téléphonique:</b><br>
                            Lundi au vendredi 09:00 - 18:00 <br>
                            Samedi 09:00 - 16:00
                        </li>
                    </ul>
                </div>
                <!-- Contact us column end -->

                <!-- About us column -->
                <div class="footer-about-us">
                    <h3>À PROPOS DE NOUS<h3>
                            <ul>
                                <li>
                                    <a href="../public/about-us.php">Qui sommes-nous?</a>
                                </li>
                                <li>
                                    <a href="../public/work-with-us.php">Travailler chez nous</a>
                                </li>
                                <li>
                                    <a href="../public/conditions.php">Conditions générales</a>
                                </li>
                            </ul>
                </div>
                <!-- About us column end -->

                <!-- Follow us column -->
                <div class="footer-follow-us">
                    <h3>SUVEZ-NOUS SUR</h3>
                    <div class="footer-social-icons">
                        <p>
                            Rejoignez-nous sur Facebook, Twitter et <br>
                            Instagram pour être tenus au courant de <br>
                            notre actualité.
                        </p>
                        <div class="social-icons">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            <!-- Twitter -->
                            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            <!-- Instagram -->
                            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>

                        <p>343 Rue Saint-Gilles <br> 4000 Liége - Belgique</p>
                    </div>
                </div>
                <!-- Follow us column end -->
            </div>
        </div>
    <!-----------------------------------------------------------------
                        Footer upper section
    ------------------------------------------------------------------>
    <!-----------------------------------------------------------------
                        Footer bottom section
    ------------------------------------------------------------------>
        <div class="bottom-footer-container">
            <!-- Section: Copyright -->
            <div class="bottom-footer container">
                <!-- Copyright column -->
                <div>
                    © 2024 Copyright tous droits réservés
                </div>
                <!-- Copyright column end -->

                <!-- Conception and development column -->
                <div>
                    Conception et développement par
                    <a href="https://github.com/lejeunea" class="github text-decoration-none">
                        <i class="fa-brands fa-github"></i>
                    </a>
                    <a href="https://github.com/lejeunea" class="text-decoration-none">Açelya Lejeune</a>.
                </div>
                <!-- Conception and development column end -->
            </div>
            <!-- Section: Copyright -->
        </div>
        <!-----------------------------------------------------------------
                        Footer bottom section end
        ------------------------------------------------------------------>
        ';
    } 
    echo $footer;
}


/**-----------------------------------------------------------------
                  Retour d'un message au format HTML
 *------------------------------------------------------------------**/

/**
 * Retour d'un message au format HTML
 * 
 * @param string $message 
 * @param string $type 
 * @return string 
 */
function getMessage($message, $type = 'success')
{
    $html = '<div class="msg-' . $type . '">' . $message . '</div>';
    return $html;
}
/**-----------------------------------------------------------------
        Generate HTML markup for displaying articles information
 *------------------------------------------------------------------**/
/**
 * Generate HTML markup for displaying livre information
 * 
 * @param array $livre 
 * @return string 
 */
function generateLivreHTML($livre)
{
    // Start building the HTML markup
    $html = '<article class="article-container">';
    $html .= '<div class="product-img">';
    $html .= '<a href="'.DOMAIN.'/public/product-livre.php?idLivre=' . $livre['idLivre'] . '">';
    $html .= '<img src="'.DOMAIN.'/'.$livre['image_url'] . '" alt="' . $livre['title'] . '">';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="product-info">';
    // Check if 'title', 'writer', and 'feature' keys are set before accessing them
    $title = isset($livre['title']) ? $livre['title'] : 'Titre non disponible';
    $writer = isset($livre['writer']) ? $livre['writer'] : 'Auteur non disponible';
    $feature = isset($livre['feature']) ? $livre['feature'] : 'Feature non disponible';

    $html .= '<a href="'.DOMAIN.'/public/product-livre.php?idLivre=' . $livre['idLivre'] . '">';
    $html .= '<h2>' . $title . '</h2>';
    $html .= '</a>';
    $html .= '<p>' . $writer . ' <span>' . $feature . '</span></p>';

    // Check if 'content' key is set before accessing it
    if (isset($livre['content'])) {

        $truncatedContent = strlen($livre['content']) > 350 ? substr($livre['content'], 0, 350) . '...' : $livre['content'];
        $html .= '<div class="product-description">';
        $html .= '<p>' . htmlspecialchars_decode($truncatedContent) . '</p>';
        $html .= '</div>';
    }

    $html .= '<div class="more-info">';
    // Check if 'idLivre' key is set before creating the link
    $link = isset($livre['idLivre']) ? ''.DOMAIN. '/public/product-livre.php?idLivre=' . $livre['idLivre'] : '#';
    $html .= '<a href="' . $link . '">Savoir plus</a>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="product-price">';
    // Check if 'price' key is set before accessing it
    $price = isset($livre['price']) ? $livre['price'] . ' €' : 'Prix non disponible';
    $html .= '<p>' . $price . ' <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    $html .= '<form action="'.DOMAIN. '/public/cart.php" method="POST">';
    $html .= '<input type="hidden" name="productId" value="' . $livre['idLivre'] . '">';
    $html .= '<input type="hidden" name="productType" value="livre">';
    $html .= '<input type="hidden" name="action" value="add">';
    $html .='<button type="submit" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</button>';
    $html .= '</form>';
    $html .= '</div>';

    $html .= '</article>';

    return $html;
}

/**
 * Generate HTML markup for displaying papeterie information
 * 
 * @param array $papeterie
 * @return string 
 */
function generatePapeterieHTML($papeterie)
{
    // Start building the HTML markup
    $html = '<article class="article-container">';
    $html .= '<div class="product-img">';
    $html .= '<a href="'.DOMAIN.'/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] . '">';
    $html .= '<img src="'.DOMAIN. '/'. $papeterie['image_url'] . '" alt="' . $papeterie['title'] . '">';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="product-info">';
    // Check if 'title', 'writer', and 'feature' keys are set before accessing them
    $title = isset($papeterie['title']) ? $papeterie['title'] : 'Titre non disponible';
    $feature = isset($papeterie['feature']) ? $papeterie['feature'] : 'Feature non disponible';

    $html .= '<a href="'.DOMAIN.'/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] . '">';
    $html .= '<h2>' . $title . '</h2>';
    $html .= '</a>';
    $html .= '<p><span>' . $feature . '</span></p>';

    // Check if 'content' key is set before accessing it
    if (isset($papeterie['content'])) {

        $truncatedContent = strlen($papeterie['content']) > 350 ? substr($papeterie['content'], 0, 350) . '...' : $papeterie['content'];
        $html .= '<div class="product-description">';
        $html .= '<p>' . htmlspecialchars_decode($truncatedContent) . '</p>';
        $html .= '</div>';
    }

    $html .= '<div class="more-info">';
    // Check if 'idPapeterie' key is set before creating the link
    $link = isset($papeterie['idPapeterie']) ? ''.DOMAIN.'/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] : '#';
    $html .= '<a href="' . $link . '">Savoir plus</a>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="product-price">';
    // Check if 'price' key is set before accessing it
    $price = isset($papeterie['price']) ? $papeterie['price'] . ' €' : 'Prix non disponible';
    $html .= '<p>' . $price . ' <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    $html .= '<form action="'.DOMAIN. '/public/cart.php" method="POST">';
    $html .= '<input type="hidden" name="productId" value="' . $papeterie['idPapeterie'] . '">';
    $html .= '<input type="hidden" name="productType" value="papeterie">';
    $html .= '<input type="hidden" name="action" value="add">';
    $html .='<button type="submit" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</button>';
    $html .= '</form>';
    $html .= '</div>';

    $html .= '</article>';

    return $html;
}

/**
 * Generate HTML markup for displaying cadeau information
 * 
 * @param array $cadeau
 * @return string 
 */
function generateCadeauHTML($cadeau)
{
    // Start building the HTML markup
    $html = '<article class="article-container">';
    $html .= '<div class="product-img">';
    $html .= '<a href="'.DOMAIN.'/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] . '">';
    $html .= '<img src="'.DOMAIN. '/'. $cadeau['image_url'] . '" alt="' . $cadeau['title'] . '">';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="product-info">';
    // Check if 'title', 'writer', and 'feature' keys are set before accessing them
    $title = isset($cadeau['title']) ? $cadeau['title'] : 'Titre non disponible';
    $feature = isset($cadeau['feature']) ? $cadeau['feature'] : 'Feature non disponible';

    $html .= '<a href="'.DOMAIN.'/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] . '">';
    $html .= '<h2>' . $title . '</h2>';
    $html .= '</a>';
    $html .= '<p><span>' . $feature . '</span></p>';

    // Check if 'content' key is set before accessing it
    if (isset($cadeau['content'])) {

        $truncatedContent = strlen($cadeau['content']) > 350 ? substr($cadeau['content'], 0, 350) . '...' : $cadeau['content'];
        $html .= '<div class="product-description">';
        $html .= '<p>' . htmlspecialchars_decode($truncatedContent) . '</p>';
        $html .= '</div>';
    }

    $html .= '<div class="more-info">';
    // Check if 'idCadeau' key is set before creating the link
    $link = isset($cadeau['idCadeau']) ? ''.DOMAIN.'/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] : '#';
    $html .= '<a href="' . $link . '">Savoir plus</a>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="product-price">';
    // Check if 'price' key is set before accessing it
    $price = isset($cadeau['price']) ? $cadeau['price'] . ' €' : 'Prix non disponible';
    $html .= '<p>' . $price . ' <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    $html .= '<form action="'.DOMAIN. '/public/cart.php" method="POST">';
    $html .= '<input type="hidden" name="productId" value="' . $cadeau['idCadeau'] . '">';
    $html .= '<input type="hidden" name="productType" value="cadeau">';
    $html .= '<input type="hidden" name="action" value="add">';
    $html .='<button type="submit" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</button>';
    $html .= '</form>';
    $html .= '</div>';

    $html .= '</article>';

    return $html;
}



/**-----------------------------------------------------------------
             Affiche le livre reçu en paramètre
 *------------------------------------------------------------------**/
/**
 * Affiche le livre reçu en paramètre
 * 
 * @param mixed $livre 
 * @return void 
 */
 function displayLivreByID($livre)
{
    echo '<section class="product-container container">';
    echo '<div class="product-info-container">';
    echo '<div class="product-img">';
    echo '<img src="'.DOMAIN. '/'. $livre['image_url'] . '" alt="' . $livre['title'] . '">';
    echo '</div>';
    echo '<div class="product-info">';
    echo '<div>';
    echo '<h2>' . $livre['title'] . '</h2>';
    echo '<p>' . $livre['writer'] . ' <span>' . $livre['feature'] . '</span></p>';
    echo '</div>';
    echo '<div class="product-price">';
    echo '<p>' . $livre['price'] . ' € <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    echo '<form action="'.DOMAIN. '/public/cart.php" method="POST">';
    echo '<input type="hidden" name="productId" value="' . $livre['idLivre'] . '">';
    echo '<input type="hidden" name="productType" value="livre">';
    echo '<input type="hidden" name="action" value="add">';
    echo '<button type="submit" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</button>';
    echo '</form>';
    echo '</div>';
    echo '<div class="product-advantages">';
    echo '<ul>';
    echo '<li><i class="fa fa-shopping-cart"></i> Passer une commande en un clic</li>';
    echo '<li><i class="fa fa-lock"></i> Payer en toute sécurité</li>';
    echo '<li><i class="fa fa-home"></i> Livraison en Belgique: 3,99 €</li>';
    echo '<li><i class="fa fa-gift"></i> Livraison en magasin gratuite</li>';
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="product-description">';
    echo '<h2>Description</h2>';
    echo '<p>' . htmlspecialchars_decode($livre['content']) . '</p>';
    echo '</div>';
    echo '</section>';
}


/**
 * Affiche le papeterie reçu en paramètre
 * 
 * @param mixed $papeterie
 * @return void 
 */
function displayPapeterieByID($papeterie)
{

    echo '<section class="product-container container">';
    echo '<div class="product-info-container">';
    echo '<div class="product-img">';
    echo '<img src="'.DOMAIN. '/'. $papeterie['image_url'] . '" alt="' . $papeterie['title'] . '">';
    echo '</div>';
    echo '<div class="product-info">';
    echo '<div>';
    echo '<h2>' . $papeterie['title'] . '</h2>';
    echo '<p>'  . $papeterie['feature'] . '</p>';
    echo '</div>';
    echo '<div class="product-price">';
    echo '<p>' . $papeterie['price'] . ' € <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    echo '<form action="'.DOMAIN. '/public/cart.php" method="POST">';
    echo '<input type="hidden" name="productId" value="' . $papeterie['idPapeterie'] . '">';
    echo '<input type="hidden" name="productType" value="papeterie">';
    echo '<input type="hidden" name="action" value="add">';
    echo '<button type="submit" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</button>';
    echo '</form>';
    echo '</div>';
    echo '<div class="product-advantages">';
    echo '<ul>';
    echo '<li><i class="fa fa-shopping-cart"></i> Passer une commande en un clic</li>';
    echo '<li><i class="fa fa-lock"></i> Payer en toute sécurité</li>';
    echo '<li><i class="fa fa-home"></i> Livraison en Belgique: 3,99 €</li>';
    echo '<li><i class="fa fa-gift"></i> Livraison en magasin gratuite</li>';
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="product-description">';
    echo '<h2>Description</h2>';
    echo '<p>' . htmlspecialchars_decode($papeterie['content']) . '</p>';
    echo '</div>';
    echo '</section>';
}


/**
 * Affiche le cadeau reçu en paramètre
 * 
 * @param mixed $cadeau
 * @return void 
 */
function displayCadeauByID($cadeau)
{
    echo '<section class="product-container container">';
    echo '<div class="product-info-container">';
    echo '<div class="product-img">';
    echo '<img src="'.DOMAIN. '/'. $cadeau['image_url'] . '" alt="' . $cadeau['title'] . '">';
    echo '</div>';
    echo '<div class="product-info">';
    echo '<div>';
    echo '<h2>' . $cadeau['title'] . '</h2>';
    echo '</div>';
    echo '<div class="product-price">';
    echo '<p>' . $cadeau['price'] . ' € <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    echo '<form action="'.DOMAIN. '/public/cart.php" method="POST">';
    echo '<input type="hidden" name="productId" value="' . $cadeau['idCadeau'] . '">';
    echo '<input type="hidden" name="productType" value="cadeau">';
    echo '<input type="hidden" name="action" value="add">';
    echo '<button type="submit" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</button>';
    echo '</form>';
    echo '</div>';
    echo '<div class="product-advantages">';
    echo '<ul>';
    echo '<li><i class="fa fa-shopping-cart"></i> Passer une commande en un clic</li>';
    echo '<li><i class="fa fa-lock"></i> Payer en toute sécurité</li>';
    echo '<li><i class="fa fa-home"></i> Livraison en Belgique: 3,99 €</li>';
    echo '<li><i class="fa fa-gift"></i> Livraison en magasin gratuite</li>';
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="product-description">';
    echo '<h2>Description</h2>';
    echo '<p>' . htmlspecialchars_decode($cadeau['content']) . '</p>';
    echo '</div>';
    echo '</section>';
}


/**-----------------------------------------------------------------
            Affiche les articles pour la page du manager
 *------------------------------------------------------------------**/

/**
 * Affiche les articles pour la page du manager
 * 
 * @param array $articles 
 * @return void
 */

function displayArticlesWithButtons($articles)
{
    foreach ($articles as $article) {
        // Display Article Content
        echo '<div class="article">';

        // Display circle based on article status
        $circleClass = ($article['active']) ? 'circle-published' : 'circle-not-published';
        echo '<div class="circle ' . $circleClass . '"></div>';

        echo '<h3>' . htmlspecialchars_decode($article['title']) . '</h3>';
        echo '</div>';

        // Display buttons
        echo '<div class="buttons">';
        echo '<button class="btn-manager" onclick="modifierArticle(' . $article['id'] . ')">Modifier</button>';
        echo '<button class="btn-manager" onclick="afficherArticle(' . $article['id'] . ')">Afficher</button>';
        echo '<button class="btn-manager-delete" onclick="supprimerArticle(' . $article['id'] . ')">Supprimer</button>';
        echo '</div>';

        echo '<hr>';
    }
}


/**
 * Affiche les livres pour la page du manager
 * 
 * @param array $livres
 * @return void
 */

function displayLivresWithButtons($livres)
{
    foreach ($livres as $livre) {
        // Display Article Content
        echo '<div class="article">';

        // Display circle based on article status
        $circleClass = ($livre['active']) ? 'circle-published' : 'circle-not-published';
        echo '<div class="circle ' . $circleClass . '"></div>';

        echo '<h3>' . htmlspecialchars_decode($livre['title']) . '</h3>';
        echo '</div>';

        // Display buttons
        echo '<div class="buttons">';
        echo '<button class="btn-primary" onclick="modifierLivre(' . $livre['idLivre'] . ')">Modifier</button>';
        echo '<button class="btn-primary" onclick="afficherLivre(' . $livre['idLivre'] . ')">Afficher</button>';
        echo '<button class="btn-secondary" onclick="supprimerLivre(' . $livre['idLivre'] . ')">Supprimer</button>';
        echo '</div>';

        echo '<hr>';
    }
}

/**
 * Affiche les papeteries pour la page du manager
 * 
 * @param array $papeteries
 * @return void
 */

function displayPapeteriesWithButtons($papeteries)
{
    foreach ($papeteries as $papeterie) {
        // Display Article Content
        echo '<div class="article">';

        // Display circle based on article status
        $circleClass = ($papeterie['active']) ? 'circle-published' : 'circle-not-published';
        echo '<div class="circle ' . $circleClass . '"></div>';

        echo '<h3>' . htmlspecialchars_decode($papeterie['title']) . '</h3>';
        echo '</div>';

        // Display buttons
        echo '<div class="buttons">';
        echo '<button class="btn-primary" onclick="modifierPapeterie(' . $papeterie['idPapeterie'] . ')">Modifier</button>';
        echo '<button class="btn-primary" onclick="afficherPapeterie(' . $papeterie['idPapeterie'] . ')">Afficher</button>';
        echo '<button class="btn-secondary" onclick="supprimerPapeterie(' . $papeterie['idPapeterie'] . ')">Supprimer</button>';
        echo '</div>';

        echo '<hr>';
    }
}

/**
 * Affiche les cadeaux pour la page du manager
 * 
 * @param array $cadeaux
 * @return void
 */

function displayCadeauxWithButtons($cadeaux)
{
    foreach ($cadeaux as $cadeau) {
        // Display Article Content
        echo '<div class="article">';

        // Display circle based on article status
        $circleClass = ($cadeau['active']) ? 'circle-published' : 'circle-not-published';
        echo '<div class="circle ' . $circleClass . '"></div>';

        echo '<h3>' . htmlspecialchars_decode($cadeau['title']) . '</h3>';
        echo '</div>';

        // Display buttons
        echo '<div class="buttons">';
        echo '<button class="btn-primary" onclick="modifierCadeau(' . $cadeau['idCadeau'] . ')">Modifier</button>';
        echo '<button class="btn-primary" onclick="afficherCadeau(' . $cadeau['idCadeau'] . ')">Afficher</button>';
        echo '<button class="btn-secondary" onclick="supprimerCadeau(' . $cadeau['idCadeau'] . ')">Supprimer</button>';
        echo '</div>';

        echo '<hr>';
    }
}

/**-----------------------------------------------------------------
    Affiche les articles pour la page du manager sous forme de table
 *------------------------------------------------------------------**/
/**
 * Affiche les livres pour la page du manager sous forme de table
 * 
 * @param array $livres
 * @return void
 */
function displayLivresAsTable($livres)
{
    // Start the table
    echo '<table>';

    // Table headers
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Titre</th>';
    echo '<th>Auteur</th>';
    echo '<th>Fonctionnalité</th>';
    echo '<th>Prix</th>';
    echo '<th>Statut</th>';
    echo '<th>Actions</th>';
    echo '</tr>';

    // Table data
    foreach ($livres as $livre) {
        echo '<tr>';
        echo '<td data-cell="id">' . $livre['idLivre'] . '</td>';
        echo '<td data-cell="titre">' . html_entity_decode($livre['title']) . '</td>';
        echo '<td data-cell="auteur">' . html_entity_decode($livre['writer']) . '</td>';
        echo '<td data-cell="fonctionnalité">' . html_entity_decode($livre['feature']) . '</td>';
        echo '<td data-cell="prix">' . html_entity_decode($livre['price']) . '</td>';
        echo '<td data-cell="statut">' . ($livre['active'] ? 'Actif' : 'Inactif') . '</td>';
        echo '<td>';
        echo '<button class="btn-secondary" onclick="modifierLivre(' . $livre['idLivre'] . ')">Modifier</button>';
        echo '<button class="btn-secondary" onclick="afficherLivre(' . $livre['idLivre'] . ')">Afficher</button>';
        echo '<button class="btn-primary" onclick="supprimerLivre(' . $livre['idLivre'] . ')">Supprimer</button>';
        echo '</td>';
        echo '</tr>';
    }

    // End the table
    echo '</table>';
}



/**
 * Affiche les papeteries pour la page du manager sous forme de table
 * 
 * @param array $papeteries
 * @return void
 */
function displayPapeteriesAsTable($papeteries)
{
    // Start the table
    echo '<table>';

    // Table headers
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Titre</th>';
    echo '<th>Fonctionnalité</th>';
    echo '<th>Prix</th>';
    echo '<th>Statut</th>';
    echo '<th>Actions</th>';
    echo '</tr>';

    // Table data
    foreach ($papeteries as $papeterie) {
        echo '<tr>';
        echo '<td data-cell="id">' . $papeterie['idPapeterie'] . '</td>';
        echo '<td data-cell="titre">' . html_entity_decode($papeterie['title']) . '</td>';
        echo '<td data-cell="fonctionnalité">' . html_entity_decode($papeterie['feature']) . '</td>';
        echo '<td data-cell="prix">' . html_entity_decode($papeterie['price']) . '</td>';
        echo '<td data-cell="statut">' . ($papeterie['active'] ? 'Actif' : 'Inactif') . '</td>';
        echo '<td>';
        echo '<button class="btn-secondary" onclick="modifierPapeterie(' . $papeterie['idPapeterie'] . ')">Modifier</button>';
        echo '<button class="btn-secondary" onclick="afficherPapeterie(' . $papeterie['idPapeterie'] . ')">Afficher</button>';
        echo '<button class="btn-primary" onclick="supprimerPapeterie(' . $papeterie['idPapeterie'] . ')">Supprimer</button>';
        echo '</td>';
        echo '</tr>';
    }

    // End the table
    echo '</table>';
}



/**
 * Affiche les cadeaux pour la page du manager sous forme de table
 * 
 * @param array $cadeaux
 * @return void
 */
function displayCadeauxAsTable($cadeaux)
{
    // Start the table
    echo '<table>';

    // Table headers
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Titre</th>';
    echo '<th>Fonctionnalité</th>';
    echo '<th>Prix</th>';
    echo '<th>Statut</th>';
    echo '<th>Actions</th>';
    echo '</tr>';

    // Table data
    foreach ($cadeaux as $cadeau) {
        echo '<tr>';
        echo '<td data-cell="id">' . $cadeau['idCadeau'] . '</td>';
        echo '<td data-cell="titre">' . html_entity_decode($cadeau['title']) . '</td>';
        echo '<td data-cell="fonctionnalité">' . html_entity_decode($cadeau['feature']) . '</td>';
        echo '<td data-cell="prix">' . html_entity_decode($cadeau['price']) . '</td>';
        echo '<td data-cell="statut">' . ($cadeau['active'] ? 'Actif' : 'Inactif') . '</td>';
        echo '<td>';
        echo '<button class="btn-secondary" onclick="modifierCadeau(' . $cadeau['idCadeau'] . ')">Modifier</button>';
        echo '<button class="btn-secondary" onclick="afficherCadeau(' . $cadeau['idCadeau'] . ')">Afficher</button>';
        echo '<button class="btn-primary" onclick="supprimerCadeau(' . $cadeau['idCadeau'] . ')">Supprimer</button>';
        echo '</td>';
        echo '</tr>';
    }

    // End the table
    echo '</table>';
}
