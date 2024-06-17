<?php
require_once('C:\xampp\htdocs\librairie-lejeune\admin\settings.php');

// Check if user is not identified, redirect to login page
if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get the cart from the session
$cart = $_SESSION['cart'];

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productId']) && isset($_POST['productType'])) {
        $productId = $_POST['productId'];
        $productType = $_POST['productType'];

        // Fetch product details from the database
        $product = getProductById($productId, $productType, $conn);

        if ($product) {
            // If product already in cart, increase quantity, otherwise add to cart
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'quantity' => 1,
                    'type' => $productType
                ];
            }
        }
    }
    // Update the cart in the session
    $_SESSION['cart'] = $cart;

    // Redirect to avoid form resubmission
    header('Location: cart-view.php');
    exit();
}

