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
$cart = &$_SESSION['cart']; // Use reference to directly modify session cart

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $productId = $_POST['productId'] ?? null;
        $productType = $_POST['productType'] ?? null;

        if ($productId && $productType) {
            switch ($action) {
                case 'add':
                    $product = getProductById($productId, $productType, $conn);
                    if ($product) {
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
                    break;
                case 'increase':
                    if (isset($cart[$productId])) {
                        $cart[$productId]['quantity']++;
                    }
                    break;
                case 'decrease':
                    if (isset($cart[$productId])) {
                        if ($cart[$productId]['quantity'] > 1) {
                            $cart[$productId]['quantity']--;
                        } else {
                            unset($cart[$productId]);
                        }
                    }
                    break;
                case 'delete':
                    if (isset($cart[$productId])) {
                        unset($cart[$productId]);
                    }
                    break;
            }
        }

        // Update the cart in the session
        $_SESSION['cart'] = $cart;

        // Redirect to avoid form resubmission
        header('Location: cart-view.php');
        exit();
    }
}
