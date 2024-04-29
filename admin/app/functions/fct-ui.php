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
 * @return string
 */
function displayFormRadioBtnArticlePublished($published, $typeForm = 'ADD')
{
    $html = '';

    // Si c'est le formulaire d'ajout d'article
    if ($typeForm == 'ADD') {
        $html .= '
            <div class="form-check switch custom-checkbox">
                <input class="form-check-input checkbox" type="checkbox" value="1" name="published_article">  
                <span class="slider round"></span>        
                <label class="form-check-label" for="published_article"></label>
            </div>
        ';
    } elseif ($typeForm == 'EDIT') {
        // Si c'est le formulaire de modification d'article
        if ($published) {
            $html .= '
                <div class="form-check switch custom-checkbox">
                    <input class="form-check-input checkbox" value="1" type="checkbox" name="published_article" checked>    
                    <span class="slider round"></span>      
                    <label class="form-check-label" for="published_article">Publié</label>
                </div>
            ';
        } else {
            $html .= '
                <div class="form-check switch custom-checkbox">
                    <input class="form-check-input checkbox" value="1" type="checkbox" name="published_article">  
                    <span class="slider round"></span>      
                    <label class="form-check-label" for="published_article">Non publié</label>
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
    <link rel="stylesheet" href="/css/styles.css">

    <!-- Google Fonts Preconnect and Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
    <title>' . $title . '</title>
    ';

    echo $head;
}


/**-----------------------------------------------------------------
                            Navigation
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
                <form class="search" role="search">
                    <div class="search-group">
                        <input class="form-control" type="search" placeholder="Que cherhez-vous?" aria-label="Search">
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

        <!-- Search bar -->
        <form class="search" role="search">
            <div class="search-group">
                <input class="form-control" type="search" placeholder="Que cherhez-vous?" aria-label="Search">
                <button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <!-- Search bar end -->

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
    $html .= '<a href="http://localhost/librairie-lejeune/public/product-livre.php?idLivre=' . $livre['idLivre'] . '">';
    $html .= '<img src="http://localhost/librairie-lejeune/admin/' . $livre['image_url'] . '" alt="' . $livre['title'] . '">';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="product-info">';
    // Check if 'title', 'writer', and 'feature' keys are set before accessing them
    $title = isset($livre['title']) ? $livre['title'] : 'Titre non disponible';
    $writer = isset($livre['writer']) ? $livre['writer'] : 'Auteur non disponible';
    $feature = isset($livre['feature']) ? $livre['feature'] : 'Feature non disponible';

    $html .= '<a href="http://localhost/librairie-lejeune/public/product-livre.php?idLivre=' . $livre['idLivre'] . '">';
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
    $link = isset($livre['idLivre']) ? 'http://localhost/librairie-lejeune/public/product-livre.php?idLivre=' . $livre['idLivre'] : '#';
    $html .= '<a href="' . $link . '">Savoir plus</a>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="product-price">';
    // Check if 'price' key is set before accessing it
    $price = isset($livre['price']) ? $livre['price'] . ' €' : 'Prix non disponible';
    $html .= '<p>' . $price . ' <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    $html .= '<a href="#" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</a>';
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
    $html .= '<a href="http://localhost/librairie-lejeune/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] . '">';
    $html .= '<img src="http://localhost/librairie-lejeune/admin/' . $papeterie['image_url'] . '" alt="' . $papeterie['title'] . '">';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="product-info">';
    // Check if 'title', 'writer', and 'feature' keys are set before accessing them
    $title = isset($papeterie['title']) ? $papeterie['title'] : 'Titre non disponible';
    $feature = isset($papeterie['feature']) ? $papeterie['feature'] : 'Feature non disponible';

    $html .= '<a href="http://localhost/librairie-lejeune/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] . '">';
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
    $link = isset($papeterie['idPapeterie']) ? 'http://localhost/librairie-lejeune/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] : '#';
    $html .= '<a href="' . $link . '">Savoir plus</a>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="product-price">';
    // Check if 'price' key is set before accessing it
    $price = isset($papeterie['price']) ? $papeterie['price'] . ' €' : 'Prix non disponible';
    $html .= '<p>' . $price . ' <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    $html .= '<a href="#" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</a>';
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
    $html .= '<a href="http://localhost/librairie-lejeune/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] . '">';
    $html .= '<img src="http://localhost/librairie-lejeune/admin/' . $cadeau['image_url'] . '" alt="' . $cadeau['title'] . '">';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="product-info">';
    // Check if 'title', 'writer', and 'feature' keys are set before accessing them
    $title = isset($cadeau['title']) ? $cadeau['title'] : 'Titre non disponible';
    $feature = isset($cadeau['feature']) ? $cadeau['feature'] : 'Feature non disponible';

    $html .= '<a href="http://localhost/librairie-lejeune/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] . '">';
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
    $link = isset($cadeau['idCadeau']) ? 'http://localhost/librairie-lejeune/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] : '#';
    $html .= '<a href="' . $link . '">Savoir plus</a>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="product-price">';
    // Check if 'price' key is set before accessing it
    $price = isset($cadeau['price']) ? $cadeau['price'] . ' €' : 'Prix non disponible';
    $html .= '<p>' . $price . ' <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    $html .= '<a href="#" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</a>';
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
    echo '<main>';
    echo '<section class="product-container container">';
    echo '<div class="product-info-container">';
    echo '<div class="product-img">';
    echo '<img src="http://localhost/librairie-lejeune/admin/' . $livre['image_url'] . '" alt="' . $livre['title'] . '">';
    echo '</div>';
    echo '<div class="product-info">';
    echo '<div>';
    echo '<h2>' . $livre['title'] . '</h2>';
    echo '<p>' . $livre['writer'] . ' <span>' . $livre['feature'] . '</span></p>';
    echo '</div>';
    echo '<div class="product-price">';
    echo '<p>' . $livre['price'] . ' € <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    echo '<a href="#" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</a>';
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
    // echo '<div class="product-specification">';
    // echo '<h2>Spécifications</h2>';
    // echo '<div class="product-specification-container">';
    // echo '<div class="product-specification-left">';
    // echo '<h3>Parties prenantes</h3>';
    // echo '<ul>';
    // echo '<li>Auteur(s): <span>' . $livre['writer'] . '</span></li>';
    // echo '<li>Editeur: <span>' . $livre['feature'] . '</span></li>';
    // echo '</ul>';
    // echo '<h3>Contenu</h3>';
    // echo '<ul>';

    // echo '<li>Nombre de pages: <span>' . $livre['pages'] . '</span></li>';
    // echo '<li>Langue: <span>Français</span></li>';
    // echo '</ul>';
    // echo '</div>';
    // echo '<div class="product-specification-right">';
    // echo '<h3>Caractéristiques</h3>';
    // echo '<ul>';

    // echo '<li>EAN: <span>' . $livre['ean'] . '</span></li>';
    // echo '<li>Date de parution: <span>' . $livre['publication_date'] . '</span></li>';
    // echo '<li>Format: <span>' . $livre['feature'] . '</span></li>'; 
    // echo '<li>Dimensions: <span>' . $livre['dimensions'] . '</span></li>';
    // echo '<li>Poids: <span>' . $livre['weight'] . '</span></li>';
    // echo '</ul>';
    // echo '</div>';
    // echo '</div>';
    // echo '</div>';
    // echo '</section>';
    // echo '</main>';
}


/**
 * Affiche la papeterie reçu en paramètre
 * 
 * @param mixed $papeterie
 * @return void 
 */
function displayPapeterieByID($papeterie)
{
    echo '<main>';
    echo '<section class="product-container container">';
    echo '<div class="product-info-container">';
    echo '<div class="product-img">';
    echo '<img src="http://localhost/librairie-lejeune/admin/' . $papeterie['image_url'] . '" alt="' . $papeterie['title'] . '">';
    echo '</div>';
    echo '<div class="product-info">';
    echo '<div>';
    echo '<h2>' . $papeterie['title'] . '</h2>';
    echo '</div>';
    echo '<div class="product-price">';
    echo '<p>' . $papeterie['price'] . ' € <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    echo '<a href="#" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</a>';
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
}

/**
 * Affiche le cadeau reçu en paramètre
 * 
 * @param mixed $papeterie
 * @return void 
 */
function displayCadeauByID($cadeau)
{
    echo '<section class="product-container container">';
    echo '<div class="product-info-container">';
    echo '<div class="product-img">';
    echo '<img src="http://localhost/librairie-lejeune/admin/' . $cadeau['image_url'] . '" alt="' . $cadeau['title'] . '">';
    echo '</div>';
    echo '<div class="product-info">';
    echo '<div>';
    echo '<h2>' . $cadeau['title'] . '</h2>';
    echo '</div>';
    echo '<div class="product-price">';
    echo '<p>' . $cadeau['price'] . ' € <span><i class="fas fa-truck"></i> Livraison 1 à 2 semaines</span><span><i class="fas fa-receipt"></i> Retrait en magasin dans 2 h.</span></p>';
    echo '<a href="#" class="btn-primary"><i class="fas fa-shopping-cart"></i> Ajouter au panier</a>';
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
}



/**-----------------------------------------------------------------
            Affiche les articles pour la page du manager
 *------------------------------------------------------------------**/

/**
 * Affiche les articles pour la page du manager
 * 
 * @param array $articles 
 * @return string 
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
 * @return string 
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
 * @return string 
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
 * @return string 
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
 * @return string 
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
 * @return string 
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
 * @return string 
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
