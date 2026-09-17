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
$total = 0;
$cart_id = 0;

$cart_query = "SELECT * FROM cart WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    $cart_row = mysqli_fetch_row($cart_result);
    $cart_id = $cart_row[0];
}

if ($cart_id > 0) {
    $items_query = "SELECT products.*, cart_items.quantity
                    FROM cart_items
                    JOIN products ON cart_items.product_id = products.product_id
                    WHERE cart_items.cart_id = $cart_id";
    $items_result = mysqli_query($conn, $items_query);
} else {
    $items_result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Checkout</title>
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
<div class="container checkout-page">
<h1 class="checkout-title">Checkout</h1>

<div class="checkout-grid2">

<div class="checkout-card">
<div class="card-head">
<h2>Order Summary</h2>
</div>

<div class="card-body">
<table class="checkout-table">
<tr>
<th>Product</th>
<th class="tc">Price</th>
<th class="tc">Qty</th>
<th class="tc">Subtotal</th>
</tr>

<?php
if ($items_result && mysqli_num_rows($items_result) > 0) {
    while ($row = mysqli_fetch_row($items_result)) {
        $price = $row[2];
        $qty = $row[8];
        $subtotal = $price * $qty;
        $total = $total + $subtotal;
?>
<tr>
<td>
<div class="checkout-product">
<div class="checkout-img-box">
<img class="checkout-img" src="<?php echo $row[3]; ?>"/>
</div>
<span class="checkout-name"><?php echo $row[1]; ?></span>
</div>
</td>
<td class="tc">$<?php echo $price; ?></td>
<td class="tc"><?php echo $qty; ?></td>
<td class="tc checkout-sub">$<?php echo $subtotal; ?></td>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
}
?>

</table>
</div>

<div class="card-foot">
<span class="total-label">Total Price</span>
<span class="total-price2">$<?php echo $total; ?></span>
</div>
</div>

<div class="checkout-card">
<div class="card-head">
<h2>Shipping Details</h2>
</div>

<div class="card-body form-body">
<form action="save_order.php" method="post">

<input type="hidden" name="total_price" value="<?php echo $total; ?>"/>

<div class="field2">
<label>Delivery Time</label>
<p class="delivery-time">3-5 Business Days</p>
</div>

<div class="field2">
<label for="address">Delivery Address</label>
<input id="address" name="address" placeholder="Enter your address" required type="text"/>
</div>

<div class="field2">
<label>Payment Method</label>

<label class="pay-option">
<input name="pay" required type="radio" value="cash"/>
Cash on Delivery
</label>

<label class="pay-option">
<input name="pay" type="radio" value="card"/>
Credit / Debit Card
</label>

<label class="pay-option">
<input name="pay" type="radio" value="wallet"/>
Digital Wallet
</label>
</div>

<input class="confirm-btn" type="submit" value="Confirm Order"/>

</form>
</div>
</div>

</div>
</div>
</div>

<div class="footer">
<div class="container footer-grid">
<div>
<a class="brand" href="index.php">
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