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


$product_id = "";
$product_name = "";
$qty = 1;
$stock = 0;

// user id (مؤقت إذا ما فيه تسجيل دخول)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}
$user_id = $_SESSION['user_id'];

// التحقق من البيانات
if (isset($_GET['product_id']) && isset($_GET['qty'])) {

    $product_id = trim($_GET['product_id']);
    $qty = trim($_GET['qty']);

    if (!is_numeric($product_id) || !is_numeric($qty) || $qty < 1) {
        die("Invalid data");
    }

    // جلب المنتج من القاعدة
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_row($result);

        $product_name = $row[1];
        $stock = $row[6];

        // منع طلب أكثر من المتوفر
        if ($qty > $stock) {
            $qty = $stock;
        }

    } else {
        die("Product not found");
    }

    // ============================
    // إنشاء أو جلب cart
    // ============================

    $cart_query = "SELECT * FROM cart WHERE user_id = $user_id";
    $cart_result = mysqli_query($conn, $cart_query);

    if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        $cart_row = mysqli_fetch_row($cart_result);
        $cart_id = $cart_row[0];
    } else {
        $insert_cart = "INSERT INTO cart (user_id) VALUES ($user_id)";
        mysqli_query($conn, $insert_cart);
        $cart_id = mysqli_insert_id($conn);
    }

    // ============================
    // إضافة المنتج للسلة
    // ============================

    $check_item = "SELECT * FROM cart_items 
                   WHERE cart_id = $cart_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_item);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // تحديث الكمية
        $update = "UPDATE cart_items 
                   SET quantity = quantity + $qty 
                   WHERE cart_id = $cart_id AND product_id = $product_id";
        mysqli_query($conn, $update);
    } else {
        // إضافة جديد
        $insert_item = "INSERT INTO cart_items (cart_id, product_id, quantity)
                        VALUES ($cart_id, $product_id, $qty)";
        mysqli_query($conn, $insert_item);
    }

} else {
    die("Missing data");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Added to Cart</title>
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
<div class="container added-wrap">

<div class="success-box">
<h1 class="success-title">
Product Successfully Added to Your Cart!
</h1>

<p class="success-text">
<strong><?php echo $qty; ?>×</strong>
<strong><?php echo $product_name; ?></strong>
has been added to your shopping cart.
</p>

<p class="muted">
Available Stock: <?php echo $stock; ?>
</p>

<div class="success-actions">
<a class="btn outline-btn" href="products.php">
Continue Shopping
</a>

<a class="btn" href="cart.php">
View Cart
</a>
</div>
</div>

</div>
</div>

<div class="footer">
<div class="container footer-grid">

<div>
<a class="brand" href="index.php.html">
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
<li>Living Room</li>
<li>Bedroom</li>
<li>Kitchen</li>
<li>Office</li>
</ul>
</div>

<div>
<h4>Contact</h4>
<ul>
<li>support@freshnest.com</li>
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