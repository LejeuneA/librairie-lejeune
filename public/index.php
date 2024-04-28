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
	<?php displayHeadSection('Librarie Lejeune'); ?>
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
					<a href="../public/livres.php" class="btn-primary">Découvrir nos produit</a>
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
			<a href="../public/livres.php" class="btn-secondary">Découvrir le top</a>
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
					<img src="../assets/icons/e-commerce-icons-01.png" alt="Paiements sécurisés">
					<h3>Paiements sécurisés</h3>
					<p><span> Vos transactions en toute confiance.</span></p>
				</article>

				<article>
					<img src="../assets/icons/e-commerce-icons-02.png" alt="Le meilleur prix">
					<h3>Le meilleur prix</h3>
					<p><span>Le meilleur prix, tout simplement.</span></p>
				</article>

				<article>
					<img src="../assets/icons/e-commerce-icons-03.png" alt="Livraison gratuite">
					<h3>Livraison gratuite</h3>
					<p><span>Profitez de la livraison gratuite sur toutes vos
							commandes.</span></p>
				</article>

				<article>
					<img src="../assets/icons/e-commerce-icons-04.png" alt="Retours faciles">
					<h3>Retours faciles</h3>
					<p><span>Retours faciles pour simplifier votre expérience d'achat.</span></p>
				</article>

				<article>
					<img src="../assets/icons/e-commerce-icons-05.png" alt="Qualité première">
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