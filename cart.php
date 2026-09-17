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


// user id (مؤقت)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}
$user_id = $_SESSION['user_id'];

$total = 0;

// جلب cart
$cart_query = "SELECT * FROM cart WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

$cart_id = 0;

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    $cart_row = mysqli_fetch_row($cart_result);
    $cart_id = $cart_row[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Cart</title>
<link href="css/style.css" rel="stylesheet"/>
</head>
<body>

<div class="header">
<div class="container row">
<a class="brand" href="index.php">
<img src="images/logo.png"/>
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
<a class="icon-btn" href="cart.php"><img src="images/icon-cart.png" class="cart-icon"/></a>
<a class="login-link" href="login.php">login</a>
</div>
</div>
</div>

<div class="section">
<div class="container cart-page">
<h1 class="cart-title">Shopping Cart</h1>

<div class="cart-grid">

<div class="cart-card">
<div class="cart-table-wrap">

<table class="cart-table">
<tr>
<th>Product Image</th>
<th>Product Name</th>
<th class="tc">Price</th>
<th class="tc">Quantity</th>
<th class="tc">Subtotal</th>
<th class="tc delete-col">Delete</th>
</tr>

<?php
if ($cart_id > 0) {

$query = "SELECT products.*, cart_items.quantity
          FROM cart_items
          JOIN products ON cart_items.product_id = products.product_id
          WHERE cart_items.cart_id = $cart_id";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {

while ($row = mysqli_fetch_row($result)) {

$price = $row[2];
$qty = $row[8]; // quantity
$subtotal = $price * $qty;
$total += $subtotal;
?>

<tr>
<td>
<div class="cart-img-box">
<img class="cart-img" src="<?php echo $row[3]; ?>"/>
</div>
</td>

<td>$qty = $row[7];
<div class="cart-name"><?php echo $row[1]; ?></div>
<div class="cart-cond"><?php echo $row[4]; ?></div>
</td>

<td class="tc">$<?php echo $price; ?></td>

<td class="tc">
<?php echo $qty; ?>
</td>

<td class="tc cart-sub">$<?php echo $subtotal; ?></td>

<td class="tc delete-col">
<a href="remove.php?product_id=<?php echo $row[0]; ?>">🗑</a>
</td>
</tr>

<?php
}
} else {
echo "<tr><td colspan='6'>Cart is empty</td></tr>";
}

} else {
echo "<tr><td colspan='6'>Cart is empty</td></tr>";
}
?>

</table>
</div>

<a class="empty-btn" href="empty_cart.php">Empty Cart</a>
</div>

<div class="summary-card">

<div class="sum-row">
<span class="muted">Subtotal</span>
<span class="sum-strong">$<?php echo $total; ?></span>
</div>

<div class="sum-row">
<span class="muted">Delivery</span>
<span class="sum-free">Free</span>
</div>

<div class="sum-divider"></div>

<div class="sum-total">
<span>Total Price</span>
<span>$<?php echo $total; ?></span>
</div>

<a class="sum-btn" href="checkout.php">Proceed to Checkout</a>

</div>

</div>
</div>
</div>

<div class="footer">
<div class="container footer-grid">

<div>
<a class="brand" href="index.php">
<img src="images/logo.png"/>
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
