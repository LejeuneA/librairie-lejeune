<?php
require_once('C:\xampp\htdocs\librairie-lejeune\admin\settings.php');

// Check if user is not identified, redirect to login page
// if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
// 	header('Location: login.php');
// 	exit();
// }

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
	<?php displayHeadSection('Livres'); ?>
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
					<form class="search" role="search" action="../admin/search.php" method="GET">
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

					<!-- Shopping cart -->
					<a href="<?php echo DOMAIN; ?>/public/cart-view.php" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i></a>
					<!-- Shopping cart end -->

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
			<form class="search" role="search" action="../admin/search.php" method="GET">
				<div class="search-group">
					<input class="form-control" type="search" name="query" placeholder="Que cherchez-vous?" aria-label="Search">
					<button class="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
				</div>
			</form>
			<!-- Search end -->

			<!-- Shopping cart -->
			<a href="<?php echo DOMAIN; ?>/public/cart-view.php" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i></a>
			<!-- Shopping cart end -->


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

		<div class="header-image--books">
			<h1>Lire, rêver, s’évader</h1>
			<p>
				Ouvrez un livre, explorez un univers infini.
			</p>
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

			<h1>Livres</h1>
			<p>
				Explorez notre collection exceptionnelle de livres allant des best-sellers incontournables aux perles
				littéraires cachées. Plongez-vous dans des mondes imaginaires, découvrez des histoires captivantes et
				trouvez le livre parfait pour chaque passion.
			</p>
		</section>
		<div class="square-left">
			<img src="../assets/components/square-left.png" alt="square">
		</div>
		<!-----------------------------------------------------------------
                               Introduction end
        ------------------------------------------------------------------>
		<!-----------------------------------------------------------------
                                Livres
        ------------------------------------------------------------------>
		<section class="books-container container">
			<!-- Articles -->
			<?php
			// Check if there are livres to display
			if ($execute) {
				// Loop through each livre and generate HTML markup
				foreach ($result as $livre) {
					echo generateLivreHTML($livre);
				}
			} else {
				// Display a message if there are no livres to display
				echo '<p>Il n\'y a pas de livre à afficher actuellement</p>';
			}
			?>
			<!-- Articles end -->


		</section>
		<!-----------------------------------------------------------------
                             Livres end
        ------------------------------------------------------------------>

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