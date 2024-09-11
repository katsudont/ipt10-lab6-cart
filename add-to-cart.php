<?php
session_start();

// Add to cart logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart
    // Here, we're adding the product ID. You can expand this to include quantity if needed.
    $_SESSION['cart'][] = $product_id;
}

// Redirect to the products browsing page
header("Location: index.php");
exit;
?>
