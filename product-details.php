<?php
session_start();
include("config.php");

$product_id = "";
$row = "";

if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $product_id = trim($_GET['product_id']);

    if (is_numeric($product_id)) {
        $query = "SELECT * FROM products WHERE product_id = $product_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_row($result);
        } else {
            die("Product not found");
        }
    } else {
        die("Invalid product id");
    }
} else {
    die("No product selected");
}

$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $fav_check = "SELECT * FROM favorites WHERE user_id = $user_id AND product_id = $product_id";
    $fav_result = mysqli_query($conn, $fav_check);
    if ($fav_result && mysqli_num_rows($fav_result) > 0) {
        $is_favorite = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Product Details</title>
<link href="css/style.css" rel="stylesheet"/>

<style>
.help-box{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.3);
text-align:center;
}

.help-box:target{
display:block;
}

.help-content{
width:420px;
background:#ffffff;
margin:200px auto;
padding:30px;
border-radius:20px;
text-align:left;
}

.help-content h3{
font-size:24px;
margin-bottom:10px;
}

.close{
float:right;
text-decoration:none;
font-size:22px;
color:#333;
}

/* size fix */
.details-info .qty input{
width:120px;
height:15px;
font-size:20px;
padding:12px 14px;
border-radius:14px;
}

.details-info .btn{
font-size:18px;
padding:15px 22px;
border-radius:30px;
}

.details-info .help-btn{
font-size:18px;
padding:15px 22px;
border-radius:30px;
}

.notify-btn{
display:inline-block;
margin-top:15px;
padding:15px 22px;
background:#E8DCCB;
color:#8B6A5B;
border-radius:30px;
text-decoration:none;
font-weight:bold;
font-size:18px;
border:1px solid #8B6A5B;
}

.notify-btn:hover{
background:#8B6A5B;
color:#ffffff;
}

.product-img-box{
  position:relative;
}

.product-img-box img{
  width:100%;
  display:block;
}

.sold-card{
  filter: grayscale(100%);
  opacity:0.7;
}

.sold-overlay{
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.5);
  color:#fff;
  font-size:28px;
  font-weight:bold;
  text-align:center;
  display:flex;
  align-items:center;
  justify-content:center;
  border-radius:18px;
}


.favorite-btn{
display:inline-block;
margin-left:10px;
padding:13px 18px;
background:#ffffff;
color:#8B6A5B;
border:1px solid #8B6A5B;
border-radius:30px;
font-size:22px;
text-decoration:none;
cursor:pointer;
}

.favorite-btn.active{
background:#8B6A5B;
color:#ffffff;
}

.favorite-message{
margin-top:12px;
color:#8B6A5B;
font-weight:bold;
}

</style>
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
<a class="icon-btn" href="favorites.php">♥</a>
<a class="icon-btn" href="cart.php"><img alt="Cart" class="cart-icon" src="images/icon-cart.png"/></a>
<a class="login-link" href="login.php">login</a>
</div>
</div>
</div>

<div class="section">
<div class="container">
<div class="details-wrap">

<div class="details-img <?php if ($row[6] == 0) { echo 'sold-card'; } ?>">

<div class="product-img-box">

<img alt="<?php echo $row[1]; ?>" src="<?php echo $row[3]; ?>"/>

<?php
if ($row[6] == 0) {
    echo "<div class='sold-overlay'>SOLD OUT</div>";
}
?>

</div>
</div>

<div class="details-info">
<span class="badge"><?php echo $row[4]; ?></span>
<h1 class="details-title"><?php echo $row[1]; ?></h1>
<div class="details-price">$<?php echo $row[2]; ?></div>

<p class="muted">In Stock: <strong><?php echo $row[6]; ?></strong></p>

<p class="details-desc">
<?php echo $row[7]; ?>
</p>

<?php
if ($row[6] > 0) {
?>
<form action="added.php" class="details-actions" method="get">
<input type="hidden" name="product_id" value="<?php echo $row[0]; ?>"/>
<input type="hidden" name="name" value="<?php echo $row[1]; ?>"/>

<div class="qty">
<label>Quantity:</label><br/>
<input max="<?php echo $row[6]; ?>" min="1" name="qty" type="number" value="1"/>
</div>

<br/>

<input class="btn" type="submit" value="Add to Cart"/>
<a class="help-btn" href="#help">Help</a>
<button type="button" id="favoriteButton" class="favorite-btn <?php if ($is_favorite) { echo 'active'; } ?>" onclick="toggleFavorite(<?php echo $row[0]; ?>)">♥</button>
<div id="favoriteMessage" class="favorite-message"></div>
</form>
<?php
} else {
?>
<p class="muted"><strong>Out of Stock</strong></p>
<a class="notify-btn" href="#" id="notifyButton">🔔 Notify Me When Available</a>
<a class="help-btn" href="#help">Help</a>
<button type="button" id="favoriteButton" class="favorite-btn <?php if ($is_favorite) { echo 'active'; } ?>" onclick="toggleFavorite(<?php echo $row[0]; ?>)">♥</button>
<div id="favoriteMessage" class="favorite-message"></div>
<?php
}
?>

</div>
</div>
</div>
</div>

<div class="help-box" id="help">
<div class="help-content">
<a class="close" href="#">×</a>
<h3>Need Help?</h3>
<p class="muted">
If you need assistance regarding this product,
please contact our support team.
</p>
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

<script>
var notifyButton = document.getElementById("notifyButton");

if (notifyButton) {
    notifyButton.onclick = function() {
        alert("You will be notified when this product is available.");
        return false;
    };
}

function toggleFavorite(productId) {
    fetch('add_to_favorites.php?product_id=' + productId)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        var button = document.getElementById('favoriteButton');
        var message = document.getElementById('favoriteMessage');

        if (data.status == 'login') {
            window.location.href = 'login.php';
        } else if (data.status == 'added') {
            button.classList.add('active');
            message.innerHTML = 'Product added to favorites.';
        } else if (data.status == 'removed') {
            button.classList.remove('active');
            message.innerHTML = 'Product removed from favorites.';
        } else {
            message.innerHTML = 'Something went wrong.';
        }
    });
}
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>     