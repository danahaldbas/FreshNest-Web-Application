<?php
session_start();
include("config.php");

$fav_count = 0;
$favorites = array();

if (isset($_SESSION['user_id'])) {
    $fav_user_id = $_SESSION['user_id'];

    $fav_count_query = "SELECT COUNT(*) AS total FROM favorites WHERE user_id = $fav_user_id";
    $fav_count_result = mysqli_query($conn, $fav_count_query);
    if ($fav_count_result) {
        $fav_count_row = mysqli_fetch_assoc($fav_count_result);
        $fav_count = $fav_count_row['total'];
    }

    $fav_query = "SELECT product_id FROM favorites WHERE user_id = $fav_user_id";
    $fav_result = mysqli_query($conn, $fav_query);
    if ($fav_result) {
        while ($fav = mysqli_fetch_row($fav_result)) {
            $favorites[] = $fav[0];
        }
    }
}

$living_query = "SELECT * FROM products WHERE category_id = 1 LIMIT 8";
$living_result = mysqli_query($conn, $living_query);

$bedroom_query = "SELECT * FROM products WHERE category_id = 2 LIMIT 8";
$bedroom_result = mysqli_query($conn, $bedroom_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Home</title>
<link href="css/style.css" rel="stylesheet"/>
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

<div class="hero">
<img src="images/hero-banner.jpeg" alt="FreshNest furniture"/>
<div class="overlay">
<div>
<h1>Give Furniture a Second Life</h1>
<p>
Beautiful refurbished & pre-loved furniture at sustainable prices.<br/>
Quality pieces with stories to tell.
</p>
<a class="btn hero-btn" href="products.php">Shop Now</a>
</div>
</div>
</div>

<div class="section">
<div class="container">

<h2 class="section-title">About FreshNest</h2>

<p class="section-text">
FreshNest is your go-to destination for sustainable living. We carefully select, restore,
and offer pre-loved furniture that deserves a second chance — saving you money and helping the planet.
</p>

<div class="features">
<div class="feature">
<h3>Eco-Friendly</h3>
<p>Every piece we sell reduces waste and supports a circular economy.</p>
</div>

<div class="feature">
<h3>Free Delivery</h3>
<p>Enjoy free delivery on all orders over $200 within city limits.</p>
</div>

<div class="feature">
<h3>Quality Checked</h3>
<p>Each item is inspected and restored by our expert craftspeople.</p>
</div>
</div>

</div>
</div>

<div class="featured-category soft-category">
<div class="container">
<div class="category-head">
<h2>Living Room</h2>
<a href="products.php?category_id=1">View All</a>
</div>

<div class="carousel-wrap">
<button class="carousel-arrow left-arrow" type="button" onclick="scrollCarousel('livingCarousel', -1)">‹</button>
<div class="product-carousel" id="livingCarousel">
<?php
if ($living_result && mysqli_num_rows($living_result) > 0) {
    while ($row = mysqli_fetch_row($living_result)) {
?>
<div class="card carousel-card <?php if ($row[6] == 0) { echo 'sold-out-card'; } ?>">
<div class="card-img-wrap">
<img src="<?php echo $row[3]; ?>" alt="<?php echo $row[1]; ?>"/>
<button type="button" class="card-fav-btn <?php if (in_array($row[0], $favorites)) { echo 'saved'; } ?>" onclick="toggleHomeFavorite(<?php echo $row[0]; ?>, this)">♥</button>
<?php if ($row[6] == 0) { echo "<div class='sold-out-ribbon'>SOLD OUT</div>"; } ?>
</div>
<h3><?php echo $row[1]; ?></h3>
<div class="meta">
<span class="price">$<?php echo $row[2]; ?></span>
<span class="badge"><?php echo $row[4]; ?></span>
</div>
<a class="btn card-view-btn" href="product-details.php?product_id=<?php echo $row[0]; ?>">View Details</a>
</div>
<?php
    }
}
?>
</div>
<button class="carousel-arrow right-arrow" type="button" onclick="scrollCarousel('livingCarousel', 1)">›</button>
</div>
</div>
</div>

<div class="featured-category">
<div class="container">
<div class="category-head">
<h2>Bedroom</h2>
<a href="products.php?category_id=2">View All</a>
</div>

<div class="carousel-wrap">
<button class="carousel-arrow left-arrow" type="button" onclick="scrollCarousel('bedroomCarousel', -1)">‹</button>
<div class="product-carousel" id="bedroomCarousel">
<?php
if ($bedroom_result && mysqli_num_rows($bedroom_result) > 0) {
    while ($row = mysqli_fetch_row($bedroom_result)) {
?>
<div class="card carousel-card <?php if ($row[6] == 0) { echo 'sold-out-card'; } ?>">
<div class="card-img-wrap">
<img src="<?php echo $row[3]; ?>" alt="<?php echo $row[1]; ?>"/>
<button type="button" class="card-fav-btn <?php if (in_array($row[0], $favorites)) { echo 'saved'; } ?>" onclick="toggleHomeFavorite(<?php echo $row[0]; ?>, this)">♥</button>
<?php if ($row[6] == 0) { echo "<div class='sold-out-ribbon'>SOLD OUT</div>"; } ?>
</div>
<h3><?php echo $row[1]; ?></h3>
<div class="meta">
<span class="price">$<?php echo $row[2]; ?></span>
<span class="badge"><?php echo $row[4]; ?></span>
</div>
<a class="btn card-view-btn" href="product-details.php?product_id=<?php echo $row[0]; ?>">View Details</a>
</div>
<?php
    }
}
?>
</div>
<button class="carousel-arrow right-arrow" type="button" onclick="scrollCarousel('bedroomCarousel', 1)">›</button>
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

<script>
function scrollCarousel(id, direction) {
    var carousel = document.getElementById(id);
    if (carousel) {
        carousel.scrollLeft += direction * 300;
    }
}

function toggleHomeFavorite(productId, button) {
    fetch('add_to_favorites.php?product_id=' + productId)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.status == 'login') {
            window.location.href = 'login.php';
        } else if (data.status == 'added') {
            button.classList.add('saved');
        } else if (data.status == 'removed') {
            button.classList.remove('saved');
        }
    });
}
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>
