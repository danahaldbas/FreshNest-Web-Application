<?php
session_start();
include("config.php");
$fav_count = 0;
if (isset($_SESSION['user_id'])) {
    $fav_user_id = $_SESSION['user_id'];
    $fav_count_query = "SELECT COUNT(*) AS total FROM favorites WHERE user_id = $fav_user_id";
    $fav_count_result = mysqli_query($conn, $fav_count_query);
    if ($fav_count_result) {
        $fav_count_row = mysqli_fetch_assoc($fav_count_result);
        $fav_count = $fav_count_row['total'];
    }
}


if (!isset($_SESSION['order_id'])) {
    die("No order found");
}

$order_id = $_SESSION['order_id'];
$total = 0;

$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($conn, $order_query);

if ($order_result && mysqli_num_rows($order_result) > 0) {
    $order_row = mysqli_fetch_row($order_result);
} else {
    die("Order not found");
}

$items_query = "SELECT products.*, order_items.quantity, order_items.price
                FROM order_items
                JOIN products ON order_items.product_id = products.product_id
                WHERE order_items.order_id = $order_id";

$items_result = mysqli_query($conn, $items_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Confirmation</title>
<link href="css/style.css" rel="stylesheet"/>
</head>
<body>

<div class="header">
<div class="container row">
<a class="brand" href="index.php">
<img alt="FreshNest Logo" src="images/logo.png"/>
<span class="name"><span class="fresh">Frsh</span><span class="nest">Nest</span></span>
</a>
<div class="nav">
<a href="index.php">Home</a>
<a href="products.php">Products</a>
<a href="contact.php">Contact</a>
<a href="orders.php">My Orders</a>
</div>
<div class="header-right">
<a class="header-fav" href="favorites.php">♥<?php if ($fav_count > 0) { ?><span class="fav-count"><?php echo $fav_count; ?></span><?php } ?></a>
<a class="icon-btn" href="cart.php"><img alt="Cart" class="cart-icon" src="images/icon-cart.png"/></a>
<a class="login-link" href="login.php">login</a>
</div>
</div>
</div>

<div class="section">
<div class="container confirm-page">

<div class="receipt">

<div class="receipt-top">
<div class="receipt-left">
<div class="receipt-brand">FreshNest</div>
<div class="receipt-sub">Invoice / Receipt</div>
</div>

<div class="receipt-right">
<div class="receipt-code">FN-<?php echo $order_id; ?></div>
<div class="receipt-date"><?php echo $order_row[2]; ?></div>
</div>
</div>

<div class="receipt-mid">
<h1 class="receipt-thanks">Thank You!</h1>
<p class="receipt-msg">Your order has been successfully completed.</p>
</div>

<table class="receipt-table">
<tr>
<th class="receipt-item-head">ITEM</th>
<th class="tc">QTY</th>
<th class="tc">PRICE</th>
<th class="tc">SUBTOTAL</th>
</tr>

<?php
if ($items_result && mysqli_num_rows($items_result) > 0) {
    while ($row = mysqli_fetch_row($items_result)) {
        $qty = $row[8];
        $price = $row[2];
        $subtotal = $qty * $price;
        $total = $total + $subtotal;
?>
<tr>
<td>
<div class="receipt-item">
<div class="receipt-img-box">
<img alt="<?php echo $row[1]; ?>" class="receipt-img" src="<?php echo $row[3]; ?>"/>
</div>
<span class="receipt-item-name"><?php echo $row[1]; ?></span>
</div>
</td>
<td class="tc"><?php echo $qty; ?></td>
<td class="tc">$<?php echo $price; ?></td>
<td class="tc receipt-subtotal">$<?php echo $subtotal; ?></td>
</tr>
<?php
    }
}
?>

</table>

<div class="receipt-total-row">
<span class="receipt-total-label">Total</span>
<span class="receipt-total-value">$<?php echo $total; ?></span>
</div>

<div class="receipt-bottom">
<div class="receipt-order-label">Order Number</div>
<div class="receipt-order-number">FN-<?php echo $order_id; ?></div>
</div>

</div>

<div class="confirm-actions">
<a class="return-btn" href="index.php"> Return to Home</a>
</div>

</div>
</div>

<div class="footer">
<div class="container footer-grid">
<div>
<a class="brand" href="index.php.html">
<img alt="FreshNest Logo" src="images/logo.png"/>
<span class="name"><span class="fresh">Frsh</span><span class="nest">Nest</span></span>
</a>
<p class="muted">Giving furniture a second life since 2026.<br/>Sustainable, affordable, beautiful.</p>
</div>
<div>
<h4>Quick links</h4>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="contact.php">Contact</a></li>
</ul>
</div>
<div>
<h4>Category</h4>
<ul>
<li><a href="products.php?category_id=1">Living Room</a></li>
<li><a href="products.php?category_id=2">Bedroom</a></li>
<li><a href="products.php?category_id=4">Kitchen</a></li>
<li><a href="products.php?category_id=3">Kids</a></li>
</ul>
</div>
<div>
<h4>Contact</h4>
<ul>
<li><a href="mailto:support@freshnest.com">support@freshnest.com</a></li>
<li>+1 (555) 123-4567</li>
<li>123 Green Street, Eco City</li>
</ul>
</div>
</div>
<div class="container footer-bottom">© 2026 FreshNest. All rights reserved.</div>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>