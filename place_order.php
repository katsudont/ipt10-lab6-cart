<?php
session_start();
require 'products.php';


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='index.php'>Go back to products</a>";
    exit;
}


$order_code = uniqid('ORDER_');

$order_date = date('Y-m-d H:i:s');

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


$order_details = "Order Code: $order_code\n";
$order_details .= "Date and Time Ordered: $order_date\n";
$order_details .= "Order Items:\n";
foreach ($cart_items as $item) {
    $order_details .= "Product ID: {$item['id']} | Product Name: {$item['name']} | Price: {$item['price']} PHP\n";
}
$order_details .= "Total Price: $total PHP\n";


file_put_contents("orders-$order_code.txt", $order_details);


$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <p><strong>Order Code:</strong> <?php echo $order_code; ?></p>
    <p><strong>Date and Time Ordered:</strong> <?php echo $order_date; ?></p>
    <h2>Order Summary</h2>
    <ul>
        <?php foreach ($cart_items as $item): ?>
            <li>Product ID: <?php echo $item['id']; ?> | Name: <?php echo $item['name']; ?> | Price: <?php echo $item['price']; ?> PHP</li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total Price:</strong> <?php echo $total; ?> PHP</p>
    <a href="index.php">Go back to products</a>
</body>
</html>
