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
    if (isset($_POST['action']) && isset($_POST['productId'])) {
        $action = $_POST['action'];
        $productId = $_POST['productId'];
        
        // Ensure the product exists in the cart and has a quantity
        if (!isset($cart[$productId])) {
            $cart[$productId] = ['quantity' => 0]; // Initialize with default values
        }
        if (!isset($cart[$productId]['quantity'])) {
            $cart[$productId]['quantity'] = 1;
        }
        
        switch ($action) {
            case 'increase':
                $cart[$productId]['quantity']++;
                break;
            case 'decrease':
                if ($cart[$productId]['quantity'] > 1) {
                    $cart[$productId]['quantity']--;
                }
                break;
            case 'remove':
                unset($cart[$productId]);
                break;
        }
    }
    // Update the cart in the session
    $_SESSION['cart'] = $cart;

    // Redirect to avoid form resubmission
    header('Location: cart-view.php');
    exit();
}
