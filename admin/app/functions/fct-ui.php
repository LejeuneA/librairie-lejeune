<?php

/*
|--------------------------------------------------------------------------
| Internal UI helpers
|--------------------------------------------------------------------------
*/

function uiUrl(string $path = ''): string
{
    return rtrim(
        DOMAIN,
        '/'
    ) . '/' . ltrim(
        $path,
        '/'
    );
}

function uiUserIsAuthenticated(): bool
{
    return (
        isset($_SESSION['IDENTIFY'])
        && $_SESSION['IDENTIFY'] === true
    );
}

function uiSocialNavigation(): string
{
    return '
        <ul class="social-nav">
            <li class="social-item">
                <a
                    class="social-link"
                    href="https://www.facebook.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Facebook"
                >
                    <i class="fa-brands fa-square-facebook fa-lg"></i>
                </a>
            </li>

            <li class="social-item">
                <a
                    class="social-link"
                    href="https://twitter.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="X"
                >
                    <i class="fa-brands fa-x-twitter fa-lg"></i>
                </a>
            </li>

            <li class="social-item">
                <a
                    class="social-link"
                    href="https://www.instagram.com/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Instagram"
                >
                    <i class="fa-brands fa-instagram fa-lg"></i>
                </a>
            </li>
        </ul>
    ';
}

function uiSearchForm(): string
{
    $action = uiEscape(
        uiUrl('admin/search.php')
    );

    return '
        <form
            class="search"
            role="search"
            action="' . $action . '"
            method="get"
        >
            <div class="search-group">
                <input
                    class="form-control"
                    type="search"
                    name="query"
                    placeholder="Que cherchez-vous ?"
                    aria-label="Rechercher"
                    maxlength="100"
                    required
                >

                <button
                    class="btn-search"
                    type="submit"
                    aria-label="Lancer la recherche"
                >
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    ';
}

/*
|--------------------------------------------------------------------------
| Publication checkbox
|--------------------------------------------------------------------------
*/

function displayFormRadioBtnArticlePublished(
    $published,
    $typeForm = 'ADD'
): void {
    $isPublished =
        strtoupper(
            (string) $typeForm
        ) === 'EDIT'
        && (bool) $published;

    echo '
        <div class="checkbox-wrapper-22">
            <label
                class="switch"
                for="published_article"
            >
                <input
                    type="checkbox"
                    id="published_article"
                    value="1"
                    name="published_article"
                    ' . (
        $isPublished
        ? 'checked'
        : ''
    ) . '
                >

                <span class="slider round"></span>
            </label>
        </div>
    ';
}

/*
|--------------------------------------------------------------------------
| JavaScript section
|--------------------------------------------------------------------------
*/

function displayJSSection(
    $tinyMCE = false
): void {
    if (!$tinyMCE) {
        return;
    }

    $tinyMceUrl = uiEscape(
        uiUrl(
            'admin/vendors/tinymce/tinymce.min.js'
        )
    );

    $configUrl = uiEscape(
        uiUrl(
            'admin/assets/js/conf-tinymce.js'
        )
    );

    echo '
        <script
            src="' . $tinyMceUrl . '"
            referrerpolicy="origin"
        ></script>

        <script src="' . $configUrl . '"></script>
    ';
}

/*
|--------------------------------------------------------------------------
| Head section
|--------------------------------------------------------------------------
*/

function displayHeadSection(
    $title = APP_NAME
): void {
    $safeTitle = uiEscape(
        (string) $title
    );

    $styleUrl = uiEscape(
        uiUrl('css/styles.css')
    );

    $faviconUrl = uiEscape(
        uiUrl(
            'assets/icons/favicon.png'
        )
    );

    echo '
        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <meta
            name="description"
            content="Découvrez Librairie Lejeune, ses livres, articles de papeterie et idées cadeaux."
        >

        <link
            rel="stylesheet"
            href="' . $styleUrl . '"
        >

        <link
            rel="icon"
            type="image/png"
            href="' . $faviconUrl . '"
        >

        <link
            rel="preconnect"
            href="https://fonts.googleapis.com"
        >

        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin
        >

        <link
            href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet"
        >

        <title>' . $safeTitle . '</title>
    ';
}

/*
|--------------------------------------------------------------------------
| Navigation
|--------------------------------------------------------------------------
*/

function displayNavigation(): void
{
    $homeUrl = uiEscape(
        uiUrl('index.php')
    );

    $logoUrl = uiEscape(
        uiUrl(
            'assets/logo/librairie-lejeune.png'
        )
    );

    $loginUrl = uiEscape(
        uiUrl('admin/login.php')
    );

    $logoutUrl = uiEscape(
        uiUrl(
            'admin/admin-logoff.php'
        )
    );

    $managerUrl = uiEscape(
        uiUrl('admin/manager.php')
    );

    $livresUrl = uiEscape(
        uiUrl(
            'admin/manager-livre.php'
        )
    );

    $papeteriesUrl = uiEscape(
        uiUrl(
            'admin/manager-papeterie.php'
        )
    );

    $cadeauxUrl = uiEscape(
        uiUrl(
            'admin/manager-cadeau.php'
        )
    );

    $messagesUrl = uiEscape(
        uiUrl(
            'admin/manager-messages.php'
        )
    );

    if (!uiUserIsAuthenticated()) {
        echo '
            <nav class="navbar">
                <div class="navbar-container container">

                    <a href="' . $homeUrl . '">
                        <img
                            src="' . $logoUrl . '"
                            class="navbar-brand-img"
                            alt="Librairie Lejeune"
                        >
                    </a>

                    <div class="d-flex">
                        ' . uiSocialNavigation() . '

                        ' . uiSearchForm() . '

                        <a
                            href="' . $loginUrl . '"
                            class="btn-primary"
                        >
                            Se connecter
                        </a>
                    </div>

                </div>
            </nav>
        ';

        return;
    }

    echo '
        <nav class="navbar">
            <div class="navbar-container container">

                <a href="' . $homeUrl . '">
                    <img
                        src="' . $logoUrl . '"
                        class="navbar-brand-img"
                        alt="Librairie Lejeune"
                    >
                </a>

                <div class="d-flex">
                    ' . uiSocialNavigation() . '

                    ' . uiSearchForm() . '

                    <a
                        class="nav-message"
                        href="' . $messagesUrl . '"
                    >
                        <i class="fa-solid fa-envelope"></i>
                        <span>Mes messages</span>
                    </a>

                    <a
                        href="' . $logoutUrl . '"
                        class="btn-primary"
                    >
                        Déconnexion
                    </a>
                </div>

            </div>
        </nav>

        <div class="navbar-menu">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="' . $homeUrl . '"
                    >
                        Accueil
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="' . $managerUrl . '"
                    >
                        Catégories
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="' . $livresUrl . '"
                    >
                        Livres
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="' . $papeteriesUrl . '"
                    >
                        Papeteries
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="' . $cadeauxUrl . '"
                    >
                        Cadeaux
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="' . $managerUrl . '"
                    >
                        Ajouter
                    </a>
                </li>

            </ul>
        </div>

        <div
            id="mySidenav"
            class="sidenav"
        >
            ' . uiSearchForm() . '

            <a
                class="nav-message"
                href="' . $messagesUrl . '"
            >
                <i class="fa-solid fa-envelope"></i>
                <span>Mes messages</span>
            </a>

            <a
                href="javascript:void(0)"
                class="closebtn"
                onclick="closeNav()"
                aria-label="Fermer le menu"
            >
                &times;
            </a>

            <a
                class="nav-link"
                href="' . $homeUrl . '"
            >
                Accueil
            </a>

            <a
                class="nav-link"
                href="' . $managerUrl . '"
            >
                Catégories
            </a>

            <a
                class="nav-link"
                href="' . $livresUrl . '"
            >
                Livres
            </a>

            <a
                class="nav-link"
                href="' . $papeteriesUrl . '"
            >
                Papeteries
            </a>

            <a
                class="nav-link"
                href="' . $cadeauxUrl . '"
            >
                Cadeaux
            </a>

            <a
                class="nav-link"
                href="' . $managerUrl . '"
            >
                Ajouter
            </a>

            <a
                href="' . $logoutUrl . '"
                class="btn-login"
            >
                Déconnexion
            </a>

            ' . uiSocialNavigation() . '
        </div>

        <div class="navbar-hamburger">
            <button
                id="hamburger"
                type="button"
                onclick="openNav()"
                aria-label="Ouvrir le menu"
            >
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    ';
}

function displayNavigationCustomer(): void
{
    displayNavigation();
}

/*
|--------------------------------------------------------------------------
| Footer
|--------------------------------------------------------------------------
*/

function displayFooter(): void
{
    $homeUrl = uiEscape(
        uiUrl('index.php')
    );

    $footerLogoUrl = uiEscape(
        uiUrl(
            'assets/logo/librairie-lejeune-white.png'
        )
    );

    $contactUrl = uiEscape(
        uiUrl('public/contact.php')
    );

    $aboutUrl = uiEscape(
        uiUrl('public/about-us.php')
    );

    $workUrl = uiEscape(
        uiUrl('public/work-with-us.php')
    );

    $conditionsUrl = uiEscape(
        uiUrl('public/conditions.php')
    );

    echo '
        <div class="upper-footer-container">
            <div class="upper-footer container">

                <div class="footer-brand">
                    <a href="' . $homeUrl . '">
                        <img
                            src="' . $footerLogoUrl . '"
                            alt="Librairie Lejeune"
                        >
                    </a>
                </div>

                <div class="footer-contact">
                    <h3>CONTACTEZ-NOUS</h3>

                    <ul>
                        <li>
                            <a href="' . $contactUrl . '">
                                Contact
                            </a>
                        </li>

                        <li>
                            <i class="fa-regular fa-envelope"></i>

                            <a href="mailto:contact@acelyalejeune.be">
                                Envoyez-nous un message
                            </a>
                        </li>

                        <li>
                            <i class="fa fa-phone"></i>

                            Téléphonez-nous au
                            <br>
                            0493 38 77 29
                        </li>

                        <li>
                            <strong>
                                Permanence téléphonique :
                            </strong>

                            <br>
                            Lundi au vendredi 09:00 - 18:00
                            <br>
                            Samedi 09:00 - 16:00
                        </li>
                    </ul>
                </div>

                <div class="footer-about-us">
                    <h3>À PROPOS DE NOUS</h3>

                    <ul>
                        <li>
                            <a href="' . $aboutUrl . '">
                                Qui sommes-nous ?
                            </a>
                        </li>

                        <li>
                            <a href="' . $workUrl . '">
                                Travailler chez nous
                            </a>
                        </li>

                        <li>
                            <a href="' . $conditionsUrl . '">
                                Conditions générales
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="footer-follow-us">
                    <h3>SUIVEZ-NOUS SUR</h3>

                    <div class="footer-social-icons">
                        <p>
                            Rejoignez-nous sur Facebook,
                            X et Instagram pour suivre
                            notre actualité.
                        </p>

                        <div class="social-icons">
                            <a
                                href="https://www.facebook.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Facebook"
                            >
                                <i class="fa-brands fa-facebook"></i>
                            </a>

                            <a
                                href="https://twitter.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="X"
                            >
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>

                            <a
                                href="https://instagram.com/"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Instagram"
                            >
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>

                        <p>
                            343 Rue Saint-Gilles
                            <br>
                            4000 Liège - Belgique
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="bottom-footer-container">
            <div class="bottom-footer container">

                <div>
                    © ' . date('Y') . '
                    Copyright tous droits réservés
                </div>

                <div>
                    Conception et développement par

                    <a
                        href="https://github.com/lejeunea"
                        class="github text-decoration-none"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="GitHub"
                    >
                        <i class="fa-brands fa-github"></i>
                    </a>

                    <a
                        href="https://github.com/lejeunea"
                        class="text-decoration-none"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Açelya Lejeune
                    </a>.
                </div>

            </div>
        </div>
    ';
}

/*
|--------------------------------------------------------------------------
| Messages
|--------------------------------------------------------------------------
*/

function getMessage(
    $message,
    $type = 'success'
): string {
    $allowedTypes = [
        'success',
        'error',
        'info',
        'warning',
    ];

    if (
        !in_array(
            $type,
            $allowedTypes,
            true
        )
    ) {
        $type = 'info';
    }

    if (
        !is_scalar($message)
        && !(
            is_object($message)
            && method_exists(
                $message,
                '__toString'
            )
        )
    ) {
        $message =
            'Une erreur est survenue.';
    }

    return '<div class="msg-'
        . uiEscape($type)
        . '">'
        . uiEscape($message)
        . '</div>';
}

/*
|--------------------------------------------------------------------------
| Public product cards
|--------------------------------------------------------------------------
*/

function generateLivreHTML($livre): string
{
    $idLivre = (int) (
        $livre['idLivre'] ?? 0
    );

    $title = (string) (
        $livre['title']
        ?? 'Titre non disponible'
    );

    $writer = (string) (
        $livre['writer'] ?? ''
    );

    $feature = (string) (
        $livre['feature'] ?? ''
    );

    $price = (string) (
        $livre['price'] ?? ''
    );

    $imageUrl = safeAssetUrl(
        $livre['image_url'] ?? ''
    );

    $productUrl = uiUrl(
        'public/product-livre.php?idLivre='
            . $idLivre
    );

    $excerpt = createTextExcerpt(
        $livre['content'] ?? ''
    );

    return renderUiProductCardHTML(
        $idLivre,
        'livre',
        $title,
        $writer,
        $feature,
        $price,
        $imageUrl,
        $productUrl,
        $excerpt
    );
}

function generatePapeterieHTML(
    $papeterie
): string {
    $idPapeterie = (int) (
        $papeterie['idPapeterie'] ?? 0
    );

    $title = (string) (
        $papeterie['title']
        ?? 'Titre non disponible'
    );

    $feature = (string) (
        $papeterie['feature'] ?? ''
    );

    $price = (string) (
        $papeterie['price'] ?? ''
    );

    $imageUrl = safeAssetUrl(
        $papeterie['image_url'] ?? ''
    );

    $productUrl = uiUrl(
        'public/product-papeterie.php?idPapeterie='
            . $idPapeterie
    );

    $excerpt = createTextExcerpt(
        $papeterie['content'] ?? ''
    );

    return renderUiProductCardHTML(
        $idPapeterie,
        'papeterie',
        $title,
        '',
        $feature,
        $price,
        $imageUrl,
        $productUrl,
        $excerpt
    );
}

function generateCadeauHTML(
    $cadeau
): string {
    $idCadeau = (int) (
        $cadeau['idCadeau'] ?? 0
    );

    $title = (string) (
        $cadeau['title']
        ?? 'Titre non disponible'
    );

    $feature = (string) (
        $cadeau['feature'] ?? ''
    );

    $price = (string) (
        $cadeau['price'] ?? ''
    );

    $imageUrl = safeAssetUrl(
        $cadeau['image_url'] ?? ''
    );

    $productUrl = uiUrl(
        'public/product-cadeau.php?idCadeau='
            . $idCadeau
    );

    $excerpt = createTextExcerpt(
        $cadeau['content'] ?? ''
    );

    return renderUiProductCardHTML(
        $idCadeau,
        'cadeau',
        $title,
        '',
        $feature,
        $price,
        $imageUrl,
        $productUrl,
        $excerpt
    );
}

function renderUiProductCardHTML(
    int $productId,
    string $productType,
    string $title,
    string $writer,
    string $feature,
    string $price,
    string $imageUrl,
    string $productUrl,
    string $excerpt
): string {
    $html = '
        <article class="article-container">

            <div class="product-img">
                <a href="' . uiEscape($productUrl) . '">
    ';

    if ($imageUrl !== '') {
        $html .= '
            <img
                src="' . uiEscape($imageUrl) . '"
                alt="' . uiEscape($title) . '"
            >
        ';
    }

    $html .= '
                </a>
            </div>

            <div class="product-info">
                <a href="' . uiEscape($productUrl) . '">
                    <h2>' . uiEscape($title) . '</h2>
                </a>

                <p>
    ';

    if ($writer !== '') {
        $html .= uiEscape($writer);
    }

    if ($feature !== '') {
        $html .= '
            <span>' . uiEscape($feature) . '</span>
        ';
    }

    $html .= '
                </p>
    ';

    if ($excerpt !== '') {
        $html .= '
            <div class="product-description">
                <p>' . uiEscape($excerpt) . '</p>
            </div>
        ';
    }

    $html .= '
                <div class="more-info">
                    <a href="' . uiEscape($productUrl) . '">
                        Savoir plus
                    </a>
                </div>
            </div>

            <div class="product-price">
                <p>
                    ' . (
        $price !== ''
        ? uiEscape($price) . ' €'
        : 'Prix non disponible'
    ) . '

                    <span>
                        <i class="fas fa-truck"></i>
                        Livraison 1 à 2 semaines
                    </span>

                    <span>
                        <i class="fas fa-receipt"></i>
                        Retrait en magasin dans 2 h.
                    </span>
                </p>

                <form
                    action="' . uiEscape(
        uiUrl('public/cart.php')
    ) . '"
                    method="post"
                >
                    <input
                        type="hidden"
                        name="productId"
                        value="' . $productId . '"
                    >

                    <input
                        type="hidden"
                        name="productType"
                        value="' . uiEscape(
        $productType
    ) . '"
                    >

                    <input
                        type="hidden"
                        name="action"
                        value="add"
                    >
                    
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="' . uiEscape(
        $_SESSION['csrf_token'] ?? ''
    ) . '"
                    >
                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        <i class="fas fa-shopping-cart"></i>
                        Ajouter au panier
                    </button>
                </form>
            </div>

        </article>
    ';

    return $html;
}

/*
|--------------------------------------------------------------------------
| Product details
|--------------------------------------------------------------------------
*/

function displayLivreByID($livre): void
{
    renderUiProductByID(
        $livre,
        'idLivre',
        'livre',
        true
    );
}

function displayPapeterieByID(
    $papeterie
): void {
    renderUiProductByID(
        $papeterie,
        'idPapeterie',
        'papeterie',
        false
    );
}

function displayCadeauByID(
    $cadeau
): void {
    renderUiProductByID(
        $cadeau,
        'idCadeau',
        'cadeau',
        false
    );
}

function renderUiProductByID(
    array $product,
    string $idKey,
    string $productType,
    bool $showWriter
): void {
    $productId = (int) (
        $product[$idKey] ?? 0
    );

    $title = (string) (
        $product['title']
        ?? 'Produit'
    );

    $writer = (string) (
        $product['writer'] ?? ''
    );

    $feature = (string) (
        $product['feature'] ?? ''
    );

    $price = (string) (
        $product['price'] ?? ''
    );

    $imageUrl = safeAssetUrl(
        $product['image_url'] ?? ''
    );

    $content = sanitizeRichText(
        $product['content'] ?? ''
    );

    echo '
        <section class="product-container container">

            <div class="product-info-container">

                <div class="product-img">
    ';

    if ($imageUrl !== '') {
        echo '
            <img
                src="' . uiEscape($imageUrl) . '"
                alt="' . uiEscape($title) . '"
            >
        ';
    }

    echo '
                </div>

                <div class="product-info">

                    <div>
                        <h2>' . uiEscape($title) . '</h2>

                        <p>
    ';

    if (
        $showWriter
        && $writer !== ''
    ) {
        echo uiEscape($writer);
    }

    if ($feature !== '') {
        echo '
            <span>' . uiEscape($feature) . '</span>
        ';
    }

    echo '
                        </p>
                    </div>

                    <div class="product-price">
                        <p>
                            ' . (
        $price !== ''
        ? uiEscape($price) . ' €'
        : 'Prix non disponible'
    ) . '

                            <span>
                                <i class="fas fa-truck"></i>
                                Livraison 1 à 2 semaines
                            </span>

                            <span>
                                <i class="fas fa-receipt"></i>
                                Retrait en magasin dans 2 h.
                            </span>
                        </p>

                        <form
                            action="' . uiEscape(
        uiUrl('public/cart.php')
    ) . '"
                            method="post"
                        >
                            <input
                                type="hidden"
                                name="productId"
                                value="' . $productId . '"
                            >

                            <input
                                type="hidden"
                                name="productType"
                                value="' . uiEscape(
        $productType
    ) . '"
                            >

                            <input
                                type="hidden"
                                name="action"
                                value="add"
                            >
                            
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="' . uiEscape(
        $_SESSION['csrf_token'] ?? ''
    ) . '"
                            >

                            <button
                                type="submit"
                                class="btn-primary"
                            >
                                <i class="fas fa-shopping-cart"></i>
                                Ajouter au panier
                            </button>
                        </form>
                    </div>

                    <div class="product-advantages">
                        <ul>
                            <li>
                                <i class="fa fa-shopping-cart"></i>
                                Passer une commande en un clic
                            </li>

                            <li>
                                <i class="fa fa-lock"></i>
                                Payer en toute sécurité
                            </li>

                            <li>
                                <i class="fa fa-home"></i>
                                Livraison en Belgique : 3,99 €
                            </li>

                            <li>
                                <i class="fa fa-gift"></i>
                                Livraison en magasin gratuite
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="product-description">
                <h2>Description</h2>

                <div>
                    ' . $content . '
                </div>
            </div>

        </section>
    ';
}

/*
|--------------------------------------------------------------------------
| Legacy manager card functions
|--------------------------------------------------------------------------
*/

function displayArticlesWithButtons(
    $articles
): void {
    foreach ($articles as $article) {
        $id = (int) (
            $article['id'] ?? 0
        );

        $title = uiEscape(
            $article['title'] ?? ''
        );

        $circleClass =
            !empty($article['active'])
            ? 'circle-published'
            : 'circle-not-published';

        echo '
            <div class="article">
                <div class="circle '
            . $circleClass
            . '"></div>

                <h3>' . $title . '</h3>
            </div>

            <div class="buttons">
                <button
                    class="btn-manager"
                    onclick="modifierArticle('
            . $id
            . ')"
                >
                    Modifier
                </button>

                <button
                    class="btn-manager"
                    onclick="afficherArticle('
            . $id
            . ')"
                >
                    Afficher
                </button>

                <button
                    class="btn-manager-delete"
                    onclick="supprimerArticle('
            . $id
            . ')"
                >
                    Supprimer
                </button>
            </div>

            <hr>
        ';
    }
}

function displayLivresWithButtons(
    $livres
): void {
    displayProductButtons(
        $livres,
        'idLivre',
        'Livre'
    );
}

function displayPapeteriesWithButtons(
    $papeteries
): void {
    displayProductButtons(
        $papeteries,
        'idPapeterie',
        'Papeterie'
    );
}

function displayCadeauxWithButtons(
    $cadeaux
): void {
    displayProductButtons(
        $cadeaux,
        'idCadeau',
        'Cadeau'
    );
}

function displayProductButtons(
    array $products,
    string $idKey,
    string $javascriptName
): void {
    foreach ($products as $product) {
        $productId = (int) (
            $product[$idKey] ?? 0
        );

        $title = uiEscape(
            $product['title'] ?? ''
        );

        $circleClass =
            !empty($product['active'])
            ? 'circle-published'
            : 'circle-not-published';

        echo '
            <div class="article">
                <div class="circle '
            . $circleClass
            . '"></div>

                <h3>' . $title . '</h3>
            </div>

            <div class="buttons">
                <button
                    class="btn-primary"
                    onclick="modifier'
            . $javascriptName
            . '('
            . $productId
            . ')"
                >
                    Modifier
                </button>

                <button
                    class="btn-primary"
                    onclick="afficher'
            . $javascriptName
            . '('
            . $productId
            . ')"
                >
                    Afficher
                </button>

                <button
                    class="btn-secondary"
                    onclick="supprimer'
            . $javascriptName
            . '('
            . $productId
            . ')"
                >
                    Supprimer
                </button>
            </div>

            <hr>
        ';
    }
}

/*
|--------------------------------------------------------------------------
| Manager tables
|--------------------------------------------------------------------------
*/

function displayLivresAsTable(
    $livres
): void {
    displayManagerProductTable(
        $livres,
        'idLivre',
        'Livre',
        [
            'writer' => [
                'label' => 'Auteur',
                'cell' => 'auteur',
            ],
            'feature' => [
                'label' => 'Fonctionnalité',
                'cell' => 'fonctionnalité',
            ],
            'price' => [
                'label' => 'Prix',
                'cell' => 'prix',
            ],
        ]
    );
}

function displayPapeteriesAsTable(
    $papeteries
): void {
    displayManagerProductTable(
        $papeteries,
        'idPapeterie',
        'Papeterie',
        [
            'feature' => [
                'label' => 'Fonctionnalité',
                'cell' => 'fonctionnalité',
            ],
            'price' => [
                'label' => 'Prix',
                'cell' => 'prix',
            ],
        ]
    );
}

function displayCadeauxAsTable(
    $cadeaux
): void {
    displayManagerProductTable(
        $cadeaux,
        'idCadeau',
        'Cadeau',
        [
            'feature' => [
                'label' => 'Fonctionnalité',
                'cell' => 'fonctionnalité',
            ],
            'price' => [
                'label' => 'Prix',
                'cell' => 'prix',
            ],
        ]
    );
}

function displayManagerProductTable(
    array $products,
    string $idKey,
    string $javascriptName,
    array $extraColumns
): void {
    echo '<table>';

    echo '<thead><tr>';

    echo '<th>ID</th>';
    echo '<th>Titre</th>';

    foreach ($extraColumns as $column) {
        echo '<th>'
            . uiEscape($column['label'])
            . '</th>';
    }

    echo '<th>Statut</th>';
    echo '<th>Actions</th>';

    echo '</tr></thead>';

    echo '<tbody>';

    foreach ($products as $product) {
        $productId = (int) (
            $product[$idKey] ?? 0
        );

        echo '<tr>';

        echo '<td data-cell="id">'
            . $productId
            . '</td>';

        echo '<td data-cell="titre">'
            . uiEscape(
                $product['title'] ?? ''
            )
            . '</td>';

        foreach (
            $extraColumns
            as $columnKey => $column
        ) {
            echo '<td data-cell="'
                . uiEscape($column['cell'])
                . '">'
                . uiEscape(
                    $product[$columnKey] ?? ''
                )
                . '</td>';
        }

        echo '<td data-cell="statut">'
            . (
                !empty($product['active'])
                ? 'Actif'
                : 'Inactif'
            )
            . '</td>';

        echo '<td>';

        echo '
            <button
                class="btn-secondary"
                onclick="modifier'
            . $javascriptName
            . '('
            . $productId
            . ')"
            >
                Modifier
            </button>
        ';

        echo '
            <button
                class="btn-secondary"
                onclick="afficher'
            . $javascriptName
            . '('
            . $productId
            . ')"
            >
                Afficher
            </button>
        ';

        echo '
            <button
                class="btn-primary"
                onclick="supprimer'
            . $javascriptName
            . '('
            . $productId
            . ')"
            >
                Supprimer
            </button>
        ';

        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}

/*
|--------------------------------------------------------------------------
| Messages table
|--------------------------------------------------------------------------
*/

function displayMessagesAsTable(
    $messages
): void {
    echo '
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>E-mail</th>
                    <th>Téléphone</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
    ';

    foreach ($messages as $message) {
        $messageId = (int) (
            $message['idContact'] ?? 0
        );

        echo '
            <tr>
                <td data-cell="nom">'
            . uiEscape(
                $message['lastname'] ?? ''
            )
            . '
                </td>

                <td data-cell="prenom">'
            . uiEscape(
                $message['firstname'] ?? ''
            )
            . '
                </td>

                <td data-cell="email">'
            . uiEscape(
                $message['email'] ?? ''
            )
            . '
                </td>

                <td data-cell="phone">'
            . uiEscape(
                $message['phone'] ?? ''
            )
            . '
                </td>

                <td data-cell="message">'
            . nl2br(
                uiEscape(
                    $message['message'] ?? ''
                )
            )
            . '
                </td>

                <td>
                    <button
                        class="btn-primary"
                        onclick="deleteMessage('
            . $messageId
            . ')"
                    >
                        Supprimer
                    </button>
                </td>
            </tr>
        ';
    }

    echo '
            </tbody>
        </table>
    ';
}
