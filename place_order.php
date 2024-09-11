<?php
session_start();
require 'products.php';

// Check if there are items in the cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='index.php'>Go back to products</a>";
    exit;
}

// Generate a unique order code
$order_code = uniqid();

// Get the order from the cart (Session variable)
$cart_items = [];
$total = 0;

foreach ($_SESSION['cart'] as $product_id) {
    foreach ($products as $product) {
        if ($product['id'] == $product_id) {
            $cart_items[] = $product;
            $total += $product['price'];
        }
    }
}

// Save order details to a text file
$order_details = "Order Code: $order_code\n";
$order_details .= "Products:\n";
foreach ($cart_items as $item) {
    $order_details .= "- {$item['name']} ({$item['price']} PHP)\n";
}
$order_details .= "Total: $total PHP\n";

file_put_contents("orders-$order_code.txt", $order_details);

// Clear the cart after placing the order
$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <p>Order Code: <?php echo $order_code; ?></p>
    <p>Total: <?php echo $total; ?> PHP</p>
    <a href="index.php">Go back to products</a>
</body>
</html>
