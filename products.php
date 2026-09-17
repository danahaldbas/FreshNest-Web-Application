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


$query = "SELECT * FROM products";
$selected_category = "";

if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
    $selected_category = trim($_GET['category_id']);

    if (is_numeric($selected_category)) {
        $query = "SELECT * FROM products WHERE category_id = $selected_category";
    }
}

$result = mysqli_query($conn, $query);

$favorites = array();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $fav_query = "SELECT product_id FROM favorites WHERE user_id = $user_id";
    $fav_result = mysqli_query($conn, $fav_query);

    if ($fav_result) {
        while ($fav = mysqli_fetch_row($fav_result)) {
            $favorites[] = $fav[0];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FreshNest - Products</title>
<link rel="stylesheet" href="css/style.css"/>

<style>
.product-img-box{
    position:relative;
}

.product-img-box img{
    display:block;
}

.sold-card{
    background:#dddddd;
    opacity:0.75;
}

.sold-overlay{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    color:#ffffff;
    font-size:28px;
    font-weight:bold;
    letter-spacing:2px;
    text-align:center;
    line-height:190px;
    border-radius:14px;
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
            <h1 class="page-title">All Products</h1>

            <form action="products.php" method="get">
                <select name="category_id" class="filter" onchange="this.form.submit()">
                    <option value="">Filter by Category</option>

                    <?php
                    $cat_query = "SELECT * FROM category";
                    $cat_result = mysqli_query($conn, $cat_query);

                    while ($cat = mysqli_fetch_row($cat_result)) {
                    ?>
                        <option value="<?php echo $cat[0]; ?>"
                            <?php
                            if ($selected_category == $cat[0]) {
                                echo "selected";
                            }
                            ?>>
                            <?php echo $cat[1]; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </form>
        </div>

        <div class="product-grid">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_row($result)) {
            ?>

                    <div class="card product-card-pro <?php if ($row[6] == 0) { echo 'sold-card'; } ?>">

                        <div class="product-img-box">
                            <img src="<?php echo $row[3]; ?>" alt="<?php echo $row[1]; ?>"/>

                            <button type="button"
                                    class="product-fav-btn <?php if (in_array($row[0], $favorites)) { echo 'active'; } ?>"
                                    onclick="toggleProductFavorite(<?php echo $row[0]; ?>, this)">
                                <span class="heart-empty">♡</span>
                                <span class="heart-full">♥</span>
                            </button>

                            <?php
                            if ($row[6] == 0) {
                                echo "<div class='sold-overlay'>SOLD OUT</div>";
                            }
                            ?>
                        </div>

                        <h3><?php echo $row[1]; ?></h3>

                        <div class="meta">
                            <span class="price">$<?php echo $row[2]; ?></span><br/>
                            <span class="badge"><?php echo $row[4]; ?></span>
                        </div>

                        <a class="btn product-view-btn" href="product-details.php?product_id=<?php echo $row[0]; ?>">View Details</a>
                    </div>

            <?php
                }
            } else {
                echo "<p>No products found.</p>";
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

<script>
function toggleProductFavorite(productId, button) {
    fetch('add_to_favorites.php?product_id=' + productId)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.status == 'login') {
            window.location.href = 'login.php';
        } else if (data.status == 'added') {
            button.classList.add('active');
            button.classList.add('pop');
        } else if (data.status == 'removed') {
            button.classList.remove('active');
            button.classList.add('pop');
        }

        setTimeout(function() {
            button.classList.remove('pop');
        }, 350);
    });
}
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>