<?php
/* ********************************************************************** */
/* *                          TOOLS FUNCTIONS                           * */
/* *                          ---------------                           * */
/* *        FONCTIONS D'AFFICHAGE DE L'INTERFACE UTILISATEUR            * */
/* ********************************************************************** */

/**-----------------------------------------------------------------
                le status de publication de l'article
*------------------------------------------------------------------**/
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
            <div class="form-check form-switch custom-checkbox">
                <input class="form-check-input" type="checkbox" value="1" id="published_article" name="published_article">          
                <label class="form-check-label" for="published_article"></label>
            </div>
        ';
    } elseif ($typeForm == 'EDIT') {
        // Si c'est le formulaire de modification d'article
        if ($published) {
            $html .= '
                <div class="form-check form-switch custom-checkbox">
                    <input class="form-check-input" value="1" type="checkbox" id="published_article" name="published_article" checked>          
                    <label class="form-check-label" for="published_article">Publié</label>
                </div>
            ';
        } else {
            $html .= '
                <div class="form-check form-switch custom-checkbox">
                    <input class="form-check-input" value="1" type="checkbox" id="published_article" name="published_article">        
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
        <meta name="description"
		content="Découvrez Librairie Lejeune pour des livres, fournitures de papeterie et cadeaux uniques. Parcourez notre sélection dès aujourd\'hui!">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">  

        <link rel="stylesheet" href="../../../css/styles.css">
        
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
            <a href="../public/index.html">
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
                <a class="nav-link" href="../admin/index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/edit.php">Modefiér</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/add.php">Ajouter</a>
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
        <a class="nav-link" href="../admin/index.php">Accueil</a>
        <a class="nav-link" href="../admin/manager.php">Modifiér</a>
        <a class="nav-link" href="../admin/add.php">Ajouter</a>
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
        <div class="welcome"> Bienvenue <span>' . $_SESSION['user_email'] . '</span></div>
        ';
    } else {
        $navigation .= '
        <nav class="navbar">
        <div class="navbar-container container">
            <!-- Logo -->
            <a href="../public/index.html">
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
                        Affichage des articles 
*------------------------------------------------------------------**/
/**
 * Affichage des articles 
 * 
 * @param mixed $livres 
 * @return void 
 */
function displayLivres($livres)
{
    foreach ($livres as $livre) {
        echo '<article><a href="article.php?id=' . $livre['idLivre'] . '" titleLivre="Lire l\'article"><h2">' . $livre['titleLivre'] . '</h2></a></article>';
        echo '<hr>';
    }
}

/**-----------------------------------------------------------------
                 Affiche l'article reçu en paramètre
*------------------------------------------------------------------**/
/**
 * Affiche l'article reçu en paramètre
 * 
 * @param mixed $livre 
 * @return void 
 */
function displayLivreByID($livre)
{
    echo '<article>';
    echo '<h2 class="article-title">' . $livre['titleLivre'] . '</h2>';
    echo '<hr>';
    echo '<p>' . html_entity_decode($livre['content']) . '</p>';
    echo '</article>';
}

/**-----------------------------------------------------------------
            Affiche les articles pour la page du manager
*------------------------------------------------------------------**/

/**
 * Affiche les articles pour la page du manager
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

        echo '<h3>' . htmlspecialchars_decode($livre['titleLivre']) . '</h3>';
        echo '</div>';

        // Display buttons
        echo '<div class="buttons">';
        echo '<button class="btn-primary" onclick="modifierArticle(' . $livre['idLivre'] . ')">Modifier</button>';
        echo '<button class="btn-primary" onclick="afficherArticle(' . $livre['idLivre'] . ')">Afficher</button>';
        echo '<button class="btn-secondary" onclick="supprimerArticle(' . $livre['idLivre'] . ')">Supprimer</button>';
        echo '</div>';

        echo '<hr>';
    }
}
