<?php
require_once('C:\xampp\htdocs\librairie-lejeune\admin\settings.php');

// Check if user is not identified, redirect to login page
if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
	header('Location: login.php');
	exit();
}

// Get the cart from the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$productId = $_POST['productId'];
	$action = $_POST['action'];

	if (isset($cart[$productId])) {
		switch ($action) {
			case 'increase':
				$cart[$productId]['quantity']++;
				break;
			case 'decrease':
				if ($cart[$productId]['quantity'] > 1) {
					$cart[$productId]['quantity']--;
				} else {
					unset($cart[$productId]);
				}
				break;
			case 'remove':
				unset($cart[$productId]);
				break;
		}
	}

	// Update the cart in the session
	$_SESSION['cart'] = $cart;

	// Redirect back to the cart view to avoid form resubmission
	header('Location: cart-view.php');
	exit();
}

// Ensure each cart item has a quantity
foreach ($cart as $productId => $item) {
	if (!isset($cart[$productId]['quantity'])) {
		$cart[$productId]['quantity'] = 1;
	}
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<?php displayHeadSection('Panier d\'achat'); ?>
</head>

<body>
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

	<main>
		<div class="table-cart container">
			<h1>Votre Panier</h1>
			<?php if (empty($cart)) : ?>
				<p>Votre panier est vide.</p>
			<?php else : ?>

				<table>
					<thead>
						<tr>
							<th>Produit</th>
							<th>Prix</th>
							<th>Quantité</th>
							<th>Total</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($cart as $productId => $item) : ?>
							<tr>
								<td data-cell="produit"><?= htmlspecialchars($item['title']) ?></td>
								<td data-cell="prix"><?= htmlspecialchars($item['price']) ?> €</td>
								<td data-cell="quantité"><?= htmlspecialchars($item['quantity']) ?></td>
								<td data-cell="total"><?= htmlspecialchars($item['price'] * $item['quantity']) ?> €</td>
								<td data-cell="actions">
									<form method="post" action="cart-view.php">
										<input type="hidden" name="productId" value="<?= htmlspecialchars($productId) ?>">
										<div class="btn-ctrl">
											<button class="btn-secondary" type="submit" name="action" value="increase">+</button>
											<button class="btn-secondary" type="submit" name="action" value="decrease">-</button>
										</div>
										<button class="btn-primary" type="submit" name="action" value="remove">Supprimer</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3">Total</td>
							<td>
								<?php
								$total = array_sum(array_map(function ($item) {
									return $item['price'] * $item['quantity'];
								}, $cart));
								echo htmlspecialchars($total) . ' €';
								?>
							</td>
							<td></td>
						</tr>
					</tfoot>
				</table>
		</div>
	<?php endif; ?>
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
</body>

</html>