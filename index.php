<?php
require_once('C:\xampp\htdocs\librairie-lejeune\admin\settings.php');

// Check if user is not identified, redirect to login page
if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
	header('Location: login.php');
	exit();
}

$msg = null;
$result = null;
$execute = false;

// Check the database connection
if (!is_object($conn)) {
	$msg = getMessage($conn, 'error');
} else {
	// Fetch all livres from the database
	$result = getAllLivresDB($conn);

	// Check if livres exist
	if (is_array($result) && !empty($result)) {
		$execute = true;
	} else {
		$msg = getMessage('Il n\'y a pas de livre à afficher actuellement', 'error');
	}
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Découvrez Librairie Lejeune pour des livres, fournitures de papeterie et cadeaux uniques. Parcourez notre sélection dès aujourd'hui!">

	<!-- Custom Sass file -->
	<link rel="stylesheet" href="./css/styles.css">


	<!-- Google Fonts Preconnect and Link -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<!-- Favicon -->

	<!-- Title -->
	<title>Librairie Lejeune</title>
</head>

<body>
	<header>

		<!-----------------------------------------------------------------
                               Navigation
    ------------------------------------------------------------------>
		<nav class="navbar">
			<div class="navbar-container container">
				<!-- Logo -->
				<a href="./index.php">
					<img src="./assets/logo/librairie-lejeune.png" class="navbar-brand-img" alt="Librairie Lejeune Logo">
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
					<form class="search" role="search">
						<div class="search-group">
							<input class="form-control" type="search" placeholder="Que cherhez-vous?" aria-label="Search">
							<button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
						</div>
					</form>
					<!-- Search end -->

					<!-- Login button -->
					<a href="http://localhost/librairie-lejeune/admin/login.php" class="btn-primary">Se connecter</a>
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
					<a class="nav-link" href="./index.php">Accueil</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="./public/livres.php">Livres</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="./public/papeteries.php">Papeterie</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="./public/cadeaux.php">Cadeaux</a>
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
			<a class="nav-link" href="./index.php">Accueil</a>
			<a class="nav-link" href="./public/livres.php">Livres</a>
			<a class="nav-link" href="./public/papeteries.php">Papeterie</a>
			<a class="nav-link" href="./public/cadeaux.php">Cadeaux</a>
			<!-- Menu end -->

			<!-- Login button -->
			<a href="http://localhost/librairie-lejeune/admin/login.php" class="btn-login">Se connecter</a>
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

		<!-- Navigation end -->
		<div class="header-image--home">
			<h1>
				Explorez, découvrez, lisez.
			</h1>

			<p>
				Notre librairie en ligne propose une variété de genres pour satisfaire tous les goûts. Naviguez,
				choisissez,
				et laissez-vous emporter par des histoires captivantes.
			</p>
			<a href="../public/livres.php" class="btn-primary">Découvrir nos produit</a>
		</div>
	</header>
	<!-----------------------------------------------------------------
							Header end
	------------------------------------------------------------------>
	<!-- Main -->
	<main>


		<!-----------------------------------------------------------------
							Article preview - Livres
		------------------------------------------------------------------>

		<!-- Article preview - Livres -->
		<section class="article-preview">
			<div class="container slideshow-container">
				<h2>Meilleures ventes <span>Livres</span></h2>
				<div class="article-preview-container">
					<!-- Articles -->
					<?php
					// Check if livres exist
					if ($execute) {
						// Iterate over livres
						foreach ($result as $livre) {
							echo '<div class="mySlides fade">';
							echo '<div class="article">';
							echo '<a href="http://localhost/librairie-lejeune/public/product-livre.php?idLivre=' . $livre['idLivre'] . '">';
							echo '<img src="http://localhost/librairie-lejeune/admin/' . $livre['image_url'] . '" alt="' . $livre['title'] . '>';
							echo '</a>';
							echo '<a href="http://localhost/librairie-lejeune/public/product-livre.php?idLivre=' . $livre['idLivre'] . '">';
							echo '<div class="article-title">' . $livre['title'] . '</div>';
							echo '</a>';
							echo '<div class="article-writer">' . $livre['writer'] . '</div>';
							echo '<div class="article-feature">' . $livre['feature'] . '</div>';
							echo '</div>';
							echo '</div>';
						}
					}
					?>
					<!-- Articles end -->
				</div>
			</div>
		</section>
		<!-- Article preview - Livres end -->
		<!-----------------------------------------------------------------
							Article preview - Livres end
		------------------------------------------------------------------>

		<!-----------------------------------------------------------------
							Best-sellers paragraph
		------------------------------------------------------------------>
		<!-- Best-sellers -->
		<section class="best-sellers">
			<!-- Container -->
			<div class="container">

				<!-- Best-sellers-left -->
				<div class="best-sellers-left"></div>
				<!-- Best-sellers-left end -->

				<!-- Best-sellers-right -->
				<div class="best-sellers-right">
					<h2>Recevez les derniers best-sellers</h2>
					<p>Plongez dans l'air du temps littéraire avec notre collection, qui propose les derniers
						best-sellers qui promettent de captiver et d'inspirer à la pointe de la narration contemporaine.
					</p>
					<a href="./public/livres.php" class="btn-primary">Découvrir nos produit</a>
				</div>
				<!-- Best-sellers-right end -->

			</div>
			<!-- Container end -->
		</section>
		<!-- Best-sellers end -->
		<!-----------------------------------------------------------------
							 Best-sellers paragraph end
		------------------------------------------------------------------>

		<!-----------------------------------------------------------------
							  Article preview - Papeterie
		------------------------------------------------------------------>
		<!-- Article preview - Papeterie -->
		<section class="article-preview">
			<div class="container slideshow-container">
				<h2>Meilleures ventes <span>Papeteries</span></h2>
				<div class="article-preview-container">
					<!-- Articles -->
					<?php
					// Fetch papeteries from the database
					$papeteries = getAllPapeteriesDB($conn, 6);

					// Check if papeteries exist
					if (is_array($papeteries) && !empty($papeteries)) {
						// Iterate over papeteries
						foreach ($papeteries as $papeterie) {
							echo '<div class="article">';
							echo '<a href="http://localhost/librairie-lejeune/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] . '">';
							echo '<img src="http://localhost/librairie-lejeune/admin/' . $papeterie['image_url'] . '" alt="' . $papeterie['title'] . '>';
							echo '</a>';
							echo '<a href="http://localhost/librairie-lejeune/public/product-papeterie.php?idPapeterie=' . $papeterie['idPapeterie'] . '">';
							echo '<div class="article-title">' . $papeterie['title'] . '</div>';
							echo '</a>';
							echo '<div class="article-feature">' . $papeterie['feature'] . '</div>';
							echo '</div>';
						}
					} else {
						// No papeteries found
						echo '<p>Aucune papeterie disponible actuellement.</p>';
					}
					?>
				</div>
				<!-- Article-preview-container end -->
			</div>
			<!-- Container end -->
		</section>
		<!-- Article preview - Papeterie end -->

		<!-----------------------------------------------------------------
							Article preview - Papeterie end
		------------------------------------------------------------------>

		<!-----------------------------------------------------------------
								Édition special paragraph
		------------------------------------------------------------------>
		<!-- Edition-special -->
		<section class="edition-special">
			<!-- Container -->
			<div class="container">
				<p>Des éditions de collection qui ont l'air parfaites sur une étagère</p>
			</div>
			<a href="./public/livres.php" class="btn-secondary">Découvrir le top</a>
			<!-- Container end -->
		</section>
		<!-- Edition-special end -->
		<!-----------------------------------------------------------------
								Édition special paragraph end
		------------------------------------------------------------------>
		<!-----------------------------------------------------------------
								Article preview - Cadeaux
		------------------------------------------------------------------>
		<!-- Article preview - Cadeaux -->
		<section class="article-preview">
			<div class="container slideshow-container">
				<h2>Meilleures ventes <span>Cadeaux</span></h2>
				<div class="article-preview-container">
					<!-- Articles -->
					<?php
					// Fetch cadeaux from the database
					$cadeaux = getAllCadeauxDB($conn, 6);

					// Check if cadeaux exist
					if (is_array($cadeaux) && !empty($cadeaux)) {
						// Iterate over papeteries
						foreach ($cadeaux as $cadeau) {
							echo '<div class="article">';
							echo '<a href="http://localhost/librairie-lejeune/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] . '">';
							echo '<img src="http://localhost/librairie-lejeune/admin/' . $cadeau['image_url'] . '" alt="' . $cadeau['title'] . '>';
							echo '</a>';
							echo '<a href="http://localhost/librairie-lejeune/public/product-cadeau.php?idCadeau=' . $cadeau['idCadeau'] . '">';
							echo '<div class="article-title">' . $cadeau['title'] . '</div>';
							echo '</a>';
							echo '<div class="article-feature">' . $cadeau['feature'] . '</div>';
							echo '</div>';
						}
					} else {
						// No papeteries found
						echo '<p>Aucune cadeau disponible actuellement.</p>';
					}
					?>
				</div>
				<!-- Article-preview-container end -->
			</div>
			<!-- Container end -->
		</section>
		<!-- Article preview - Papeterie end -->
		<!-----------------------------------------------------------------
							Article preview - Cadeaux end
		------------------------------------------------------------------>
		<!-----------------------------------------------------------------
								Advantage icons
		------------------------------------------------------------------>
		<!-- Advantage icons -->
		<section class="article-preview advantage-icons">
			<!-- Article-preview-container -->
			<div class="article-preview-container container">
				<!-- Articles -->
				<article>
					<img src="./assets/icons/e-commerce-icons-01.png" alt="Paiements sécurisés">
					<h3>Paiements sécurisés</h3>
					<p><span> Vos transactions en toute confiance.</span></p>
				</article>

				<article>
					<img src="./assets/icons/e-commerce-icons-02.png" alt="Le meilleur prix">
					<h3>Le meilleur prix</h3>
					<p><span>Le meilleur prix, tout simplement.</span></p>
				</article>

				<article>
					<img src="./assets/icons/e-commerce-icons-03.png" alt="Livraison gratuite">
					<h3>Livraison gratuite</h3>
					<p><span>Profitez de la livraison gratuite sur toutes vos
							commandes.</span></p>
				</article>

				<article>
					<img src="./assets/icons/e-commerce-icons-04.png" alt="Retours faciles">
					<h3>Retours faciles</h3>
					<p><span>Retours faciles pour simplifier votre expérience d'achat.</span></p>
				</article>

				<article>
					<img src="./assets/icons/e-commerce-icons-05.png" alt="Qualité première">
					<h3>Qualité première</h3>
					<p><span>Exigez l'excellence, optez pour la première qualité.</span></p>
				</article>
				<!-- Articles end -->
			</div>
			<!-- Article-preview-container end -->
		</section>
		<!-- Article-preview end -->
		<!-- Advantage icons end -->
		<!-----------------------------------------------------------------
							  Advantage icons end
		------------------------------------------------------------------>
	</main>

	<footer>
    <!-----------------------------------------------------------------
                        Footer upper section
    ------------------------------------------------------------------>
        <div class="upper-footer-container">
            <!-- Upper footer -->
            <div class="upper-footer container">
                <!-- Logo column -->
                <div class="footer-brand">
                    <a href="./index.php">
                        <img src="./assets/logo/librairie-lejeune-white.png" alt="Librarie Lejeune Logo" />
                    </a>
                </div>
                <!-- Logo column end-->

                <!-- Contact us column -->
                <div class="footer-contact">
                    <h3>CONTACTEZ-NOUS</h3>
                    <ul>
                        <li>
                            <a href="./public/contact.html" class="">Contact</a>
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
                                    <a href="./public/about-us.html">Qui sommes-nous?</a>
                                </li>
                                <li>
                                    <a href="./public/work-with-us.html">Travailler chez nous</a>
                                </li>
                                <li>
                                    <a href="./public/conditions.html">Conditions générales</a>
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
    </footer>
    <!-----------------------------------------------------------------
                               Footer
    ------------------------------------------------------------------>

	<!-- Font Awesome -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- Include functions.js -->
	<script src="./js/functions.js"></script>

	<!-----------------------------------------------------------------
				JavaScript for slideshow effect
	------------------------------------------------------------------>
	<script>
		let currentIndex = 0;
		const articles = document.querySelectorAll('.mySlides');
		const totalArticles = articles.length;
		const articlesPerPage = 6;
		const totalPages = Math.ceil(totalArticles / articlesPerPage);

		function showSlides() {
			const start = currentIndex * articlesPerPage;
			const end = Math.min(start + articlesPerPage, totalArticles);

			// Hide all articles
			articles.forEach(article => {
				article.style.display = 'none';
			});

			// Show the current set of articles
			for (let i = start; i < end; i++) {
				articles[i].style.display = 'block';
			}

			// Increment index for next set of articles
			currentIndex = (currentIndex + 1) % totalPages;
		}

		// Initially show the first set of articles
		showSlides();

		// Automatically switch to the next set of articles every 3 seconds
		setInterval(showSlides, 3000);
	</script>

</body>

</html>