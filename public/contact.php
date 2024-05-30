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
	<title>Contactez-nous</title>
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
	<div class="header-image--contact">
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

			<h1>Contactez-nous</h1>
			<p>
				Pour toute question relative au service clientèle, aux commandes en magasin et en ligne, aux
				remboursements et aux retours, veuillez contacter notre équipe du service clientèle.
			</p>
		</section>
		<div class="square-left">
			<img src="../assets/components/square-left.png" alt="square">
		</div>
		<!-----------------------------------------------------------------
                               Introduction end
        ------------------------------------------------------------------>

		<!-----------------------------------------------------------------
                               Contact icons
        ------------------------------------------------------------------>
		<section class="contact-icons-container">
			<div class="contact-icons container">
				<article>
					<img src="../assets/icons/contact-icons-02.png" alt="Livraison gratuite">
					<p>Téléphonez-nous au<span>0493 38 77 29</span></p>
				</article>

				<article>
					<img src="../assets/icons/contact-icons-03.png" alt="Retours faciles">
					<p>Contactez-nous sur<span>Via le formulaire de contact</span></p>
				</article>

				<article>
					<img src="../assets/icons/contact-icons-04.png" alt="Qualité première">
					<p>Envoyer-nous un message<span>support@librairie.com</span></p>
				</article>
			</div>
		</section>
		<!-----------------------------------------------------------------
                               Contact icons end
        ------------------------------------------------------------------>

		<!-----------------------------------------------------------------
                                Contact form
        ------------------------------------------------------------------>
		<!-- Contact section -->
		<section class="contact-section container">
			<div class="contact-title">
				<h1>Contactez-nous</h1>
			</div>
			<!-- Contact form -->
			<form action="/action_page.php">
				<label for="fname">Prénom</label>
				<input type="text" id="fname" name="firstname" placeholder="Votre prénom...">

				<label for="lname">Nom</label>
				<input type="text" id="lname" name="lastname" placeholder="Votre nom...">

				<label for="country">Pay</label>
				<select id="country" name="country">
					<option value="australia">Belgique</option>
					<option value="canada">France</option>
					<option value="usa">Angleterre</option>
				</select>

				<label for="subject">Message</label>
				<textarea id="subject" name="subject" placeholder="Rédiger votre message..." style="height:200px"></textarea>
				<!-- Checkbox -->
				<div class="checkbox">
					<input type="checkbox" id="cgu" name="cgu" required>
					<label for="cgu">J'accepte les condition générales d'utilisation</label>
				</div>
				<!-- Checkbox end -->
				<!-- Button -->
				<input type="reset" value="Réinitialiser">
				<input type="submit" value="Envoyer">
				<!-- Button end -->
			</form>

			<!-- Contact form end -->
		</section>
		<!-- Contact section end -->
		<!-------------------------------------------------------- 
                          Contact form end
        ---------------------------------------------------------->


	</main>

	<!-- Footer -->
	<footer>
		<div data-include="footer"></div>
	</footer>


	<!-- Font Awesome -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- Include functions.js -->
	<script src="../js/functions.js"></script>

</body>

</html>