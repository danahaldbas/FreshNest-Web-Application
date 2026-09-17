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
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT products.*
          FROM products
          INNER JOIN favorites
          ON products.product_id = favorites.product_id
          WHERE favorites.user_id = $user_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Favorites</title>
<link rel="stylesheet" href="css/style.css"/>

<style>
.product-img-box{
    position:relative;
}

.product-img-box img{
    display:block;
}

.remove-fav{
    display:inline-block;
    margin-top:10px;
    padding:10px 16px;
    background:#E8DCCB;
    color:#8B6A5B;
    border-radius:30px;
    text-decoration:none;
    font-weight:bold;
    border:1px solid #8B6A5B;
}

.remove-fav:hover{
    background:#8B6A5B;
    color:#ffffff;
}

.empty-box{
    background:#F6EEE8;
    padding:30px;
    border-radius:20px;
    text-align:center;
    color:#8B6A5B;
}
</style>
</head>

<body>

<div class="header">
    <div class="container row">
        <a class="brand" href="index.php">
            <img src="images/logo.png" alt="FreshNest Logo"/>
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
            <a class="icon-btn" href="cart.php"><img src="images/icon-cart.png" class="cart-icon" alt="Cart"/></a>
            <a class="login-link" href="login.php">login</a>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">

        <div class="page-head">
            <h1 class="page-title">My Favorites</h1>
        </div>

        <div class="product-grid">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_row($result)) {
            ?>
                    <div class="card">
                        <div class="product-img-box">
                            <img src="<?php echo $row[3]; ?>" alt="<?php echo $row[1]; ?>"/>
                        </div>

                        <h3><?php echo $row[1]; ?></h3>

                        <div class="meta">
                            <span class="price">$<?php echo $row[2]; ?></span><br/>
                            <span class="badge"><?php echo $row[4]; ?></span>
                        </div>

                        <a class="btn" href="product-details.php?product_id=<?php echo $row[0]; ?>">View Details</a>
                        <a class="remove-fav" href="remove_favorite.php?product_id=<?php echo $row[0]; ?>">Remove</a>
                    </div>
            <?php
                }
            } else {
                echo "<div class='empty-box'><h3>No favorite products yet.</h3><p>Go to Products and press the heart button to add items here.</p><a class='btn' href='products.php'>Browse Products</a></div>";
            }
            ?>
        </div>

    </div>
</div>

<div class="footer">
    <div class="container footer-grid">

        <div>
            <a class="brand" href="index.php">
                <img src="images/logo.png" alt="FreshNest Logo"/>
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
