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


if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT orders.order_id, orders.order_date, orders.total_price,
                 products.product_id, products.name, products.image, products.product_condition,
                 order_items.quantity, order_items.price
          FROM orders
          JOIN order_items ON orders.order_id = order_items.order_id
          JOIN products ON order_items.product_id = products.product_id
          WHERE orders.user_id = $user_id
          ORDER BY orders.order_id DESC";

$result = mysqli_query($conn, $query);
?>

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>FreshNest - My Orders</title>
<link rel="stylesheet" href="css/style.css" />

<style>
.orders-wrapper { padding: 60px 0; background-color: #f9f7f4; min-height: 80vh; }
.page-title-section { margin-bottom: 40px; }
.page-title-section h1 { font-size: 32px; color: #333; }

.order-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 15px rgba(0,0,0,0.03);
}

.item-box { display: flex; align-items: center; gap: 25px; }
.item-box img { width: 120px; height: 120px; border-radius: 15px; object-fit: cover; }

.item-details h3 { font-size: 20px; color: #2b2b2b; margin-bottom: 4px; }
.order-id-text { color: #999; font-size: 13px; margin-bottom: 8px; display: block; }

.status-badge {
    display: inline-block;
    padding: 5px 15px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: bold;
}

.proc { background: #fff4e5; color: #d48806; }

.action-section { text-align: right; }
.item-price { font-size: 22px; font-weight: bold; color: #333; }

.order-details {
    margin-top: 10px;
    font-size: 14px;
    color: #555;
    line-height: 1.6;
}

.btn-action {
    background-color: #b5c0a9;
    color: #333 !important;
    border: none;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    font-size: 13px;
    display: inline-block;
    margin-top: 10px;
}

@media (max-width: 768px) {
    .order-card { flex-direction: column; text-align: center; gap: 15px; }
    .item-box { flex-direction: column; }
}
</style>
</head>

<body>

<header class="header">
<div class="container row">
<a class="brand" href="index.php">
<img src="images/logo.png" alt="FreshNest Logo">
<span class="name"><span class="fresh">Frsh</span><span class="nest">Nest</span></span>
</a>

<nav class="nav">
<a href="index.php">Home</a>
<a href="products.php">Products</a>
<a href="contact.php">Contact</a>
<a href="orders.php">My Orders</a>
</nav>

<div class="header-right">
<a class="header-fav" href="favorites.php">♥<?php if ($fav_count > 0) { ?><span class="fav-count"><?php echo $fav_count; ?></span><?php } ?></a>
<a class="icon-btn" href="cart.php">🛒</a>
<a class="login-link" href="login.php">login</a>
</div>
</div>
</header>

<main class="orders-wrapper">
<div class="container">

<div class="page-title-section">
<h1>My Orders</h1>
</div>

<?php
if ($result && mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_row($result)) {

        $order_id = $row[0];
        $order_date = $row[1];
        $product_id = $row[3];
        $product_name = $row[4];
        $image = $row[5];
        $condition = $row[6];
        $quantity = $row[7];
        $price = $row[8];
        $subtotal = $quantity * $price;
?>

<div class="order-card">

<div class="item-box">
<img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>">

<div class="item-details">
<h3><?php echo $product_name; ?></h3>
<span class="order-id-text">Order ID: #FN-<?php echo $order_id; ?></span>
<span class="order-id-text">Date: <?php echo $order_date; ?></span>
<span class="status-badge proc">Processing</span>

<div class="order-details">
<p><strong>Quantity Purchased:</strong> <?php echo $quantity; ?></p>
<p><strong>Condition:</strong> <?php echo $condition; ?></p>
</div>
</div>
</div>

<div class="action-section">
<span class="item-price">$<?php echo $subtotal; ?></span><br>
<a href="product-details.php?product_id=<?php echo $product_id; ?>" class="btn-action">Buy Again</a>
</div>

</div>

<?php
    }

} else {
    echo "<p>No orders found.</p>";
}
?>

</div>
</main>

<footer class="footer">
<div class="container footer-grid">

<div>
<a class="brand" href="index.php">
<img src="images/logo.png" alt="FreshNest Logo">
<span class="name"><span class="fresh">Frsh</span><span class="nest">Nest</span></span>
</a>
<p class="muted">Giving furniture a second life since 2026. Sustainable, affordable, beautiful.</p>
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

<div class="container footer-bottom">
<p>© 2026 FreshNest. All rights reserved.</p>
</div>
</footer>

</body>
</html>

<?php
mysqli_close($conn);
?>