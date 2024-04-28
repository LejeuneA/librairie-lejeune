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
							echo '<img src="http://localhost/librairie-lejeune/admin/' . $livre['image_url'] . '" alt="' . $livre['title'] . '" style="width:100%">';
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
		<!-- Papeterie -->
		<section class="article-preview">
			<!-- Container -->
			<div class="container">
				<h2>Meilleures ventes <span>Papeterie</span></h2>
				<!-- Article-preview-container -->
				<div class="article-preview-container">
					<!-- Articles -->
					<article>
						<img src="../assets/images/stationeries/paint-on-bloc.jpg" alt="Paint'ON bloc">
						<h3>Paint'ON bloc</h3>
						<p>Clairefontaine
							<span>Multi-technique | A4</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/stationeries/memo-notes.jpg" alt="Memo Notes">
						<h3>Memo Notes</h3>
						<p>Paperstore
							<span>Exotic | NL</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/stationeries/bullet-journal.jpg" alt="Bullet Journal">
						<h3>Bullet Journal</h3>
						<p>Minj
							<span>Livre broché | NL</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/stationeries/cahier-cercles.jpg" alt="Cahier cercles">
						<h3>Cahier cercles</h3>
						<p>Paperstore
							<span>Carnet d'adresses | NL</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/stationeries/crayons-couleurs.jpg" alt="Crayons couleurs">
						<h3>Crayons couleurs</h3>
						<p>BIC Kids
							<span>Tropicolors | x18</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/stationeries/bloc-papier.jpg" alt="Aurora bloc papier">
						<h3>Aurora bloc papier</h3>
						<p>Aurora
							<span>Millimetré A4 beige | A3</span>
						</p>
					</article>
					<!-- Articles end -->
				</div>
				<!-- Article-preview-container end -->
			</div>
			<!-- Container end -->
		</section>
		<!-- Article-preview end -->
		<!-- Papeterie end -->

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
		<!-- Cadeaux -->
		<section class="article-preview">
			<!-- Container -->
			<div class="container">
				<h2>Meilleures ventes <span>Cadeaux</span></h2>
				<!-- Article-preview-container -->
				<div class="article-preview-container">
					<!-- Articles -->
					<article>
						<img src="../assets/images/gifts/cinema.jpg" alt="Cinéma & Pop-corn">
						<h3>Cinéma & Pop-corn</h3>
						<p>Bongo
							<span>Giftbox | Deux personnes</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/gifts/tables-romantiques.jpg" alt="Tables Romantiques">
						<h3>Tables Romantiques</h3>
						<p>Bongo
							<span>Giftbox | Deux personnes</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/gifts/tentations.jpg" alt="Tentations a Deux">
						<h3>Tentations a Deux</h3>
						<p>Bongo
							<span>Giftbox | Deux personnes</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/gifts/evasion-a-deux.jpg" alt="Evasion a Deux">
						<h3>Evasion a Deux</h3>
						<p>Bongo
							<span>Giftbox | Deux personnes</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/gifts/week-end-insolite.jpg" alt="Séjour Insolite">
						<h3>Séjour Insolite</h3>
						<p>Bongo
							<span>Giftbox | Deux personnes</span>
						</p>
					</article>

					<article>
						<img src="../assets/images/gifts/aventure-en-duo.jpg" alt="Aventure en Duo">
						<h3>Aventure en Duo</h3>
						<p>Bongo
							<span>Giftbox | Deux personnes</span>
						</p>
					</article>
					<!-- Articles end -->
				</div>
				<!-- Article-preview-container end -->
			</div>
			<!-- Container end -->
		</section>
		<!-- Article-preview end -->
		<!-- Cadeaux end -->
		<!-----------------------------------------------------------------
							Article preview - Cadeaux end
		------------------------------------------------------------------>
		<!-----------------------------------------------------------------
								Advantage icons
		------------------------------------------------------------------>
		<!-- Advantage icons -->
		<section class="article-preview advantage-icons">
			<!-- Container -->
			<div class="container">
				<!-- Article-preview-container -->
				<div class="article-preview-container">
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
			</div>
			<!-- Container end -->
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