<?php
session_start();
include("config.php");

$fav_count = 0;
$error = "";

if (isset($_SESSION['user_id'])) {
    $fav_user_id = $_SESSION['user_id'];
    $fav_count_query = "SELECT COUNT(*) AS total FROM favorites WHERE user_id = $fav_user_id";
    $fav_count_result = mysqli_query($conn, $fav_count_query);
    if ($fav_count_result) {
        $fav_count_row = mysqli_fetch_assoc($fav_count_result);
        $fav_count = $fav_count_row['total'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['first_name']) . " " . trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);

    if (!empty($full_name) && !empty($email) && !empty($password) && !empty($phone)) {
        $sql = "INSERT INTO users (full_name, email, password, phone)
                VALUES ('$full_name', '$email', '$password', '$phone')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FreshNest | Create New Account</title>
<link href="css/style.css" rel="stylesheet">
<style>
.signup-section{
    padding:50px 0;
}

.main-container{
    width:100%;
    max-width:1000px;
    min-height:750px;
    margin:0 auto;
    background:#ffffff;
    border-radius:30px;
    overflow:hidden;
    border:1px solid #eeeeee;
}

.side-info{
    float:left;
    width:38%;
    min-height:750px;
    background:#f4f1ee;
    text-align:center;
    padding-top:180px;
    padding-left:20px;
    padding-right:20px;
    border-right:1px solid #eeeeee;
}

.side-info img{
    width:150px;
    margin-bottom:20px;
    border-radius:20px;
}

.side-info h2{
    font-family:'Playfair Display', Georgia, serif;
    color:#2d4a36;
    font-size:32px;
    margin-bottom:10px;
}

.side-info p{
    text-align:center;
    color:#666666;
    font-size:16px;
    line-height:1.6;
    width:280px;
    margin:0 auto;
}

.form-section{
    float:left;
    width:62%;
    min-height:750px;
    padding:80px 60px;
}

.form-title{
    margin-bottom:20px;
}

.form-title h1{
    font-family:'Playfair Display', Georgia, serif;
    font-size:32px;
    color:#5C4338;
    margin-bottom:5px;
}

.form-title p{
    color:#666666;
    font-size:14px;
}

.signup-form{
    width:100%;
}

.name-row{
    overflow:hidden;
    margin-bottom:12px;
}

.name-box{
    float:left;
    width:48%;
}

.name-box:first-child{
    margin-right:4%;
}

.form-group{
    margin-bottom:12px;
}

.form-group label{
    display:block;
    font-weight:bold;
    font-size:13px;
    margin-bottom:5px;
}

.filter-input{
    width:100%;
    padding:14px 15px;
    border-radius:12px;
    border:1px solid #dddddd;
    background:#f9f9f9;
    font-family:'Poppins', Arial, sans-serif;
    font-size:14px;
}

.btn-submit{
    width:100%;
    background-color:#BFC9B3;
    color:#2b2b2b;
    padding:18px;
    border-radius:12px;
    border:none;
    font-weight:bold;
    font-size:16px;
    margin-top:15px;
    cursor:pointer;
}

.signin-text{
    text-align:center;
    font-size:14px;
    margin-top:15px;
}

.signin-text a{
    color:#8B6A5B;
    font-weight:bold;
    text-decoration:none;
}

.error-msg{
    background:#fff1f1;
    color:#8B3A3A;
    border:1px solid #e5b8b8;
    border-radius:12px;
    padding:12px;
    margin-bottom:15px;
    font-size:14px;
}

@media (max-width:850px){
    .side-info,
    .form-section{
        float:none;
        width:100%;
        min-height:auto;
    }

    .side-info{
        padding:50px 20px;
        border-right:none;
        border-bottom:1px solid #eeeeee;
    }

    .form-section{
        padding:50px 30px;
    }

    .name-box,
    .name-box:first-child{
        float:none;
        width:100%;
        margin-right:0;
    }
}
</style>
</head>
<body>

<div class="header">
<div class="container row">

<a class="brand" href="index.php">
<img src="images/logo.png" alt="FreshNest Logo">
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
<a class="icon-btn" href="cart.php"><img src="images/icon-cart.png" class="cart-icon" alt="Cart"></a>
<a class="login-link" href="login.php">login</a>
</div>

</div>
</div>

<div class="signup-section">
<div class="main-container">

<div class="side-info">
<img src="images/logo.png" alt="FreshNest">
<h2>FreshNest</h2>
<p>Giving furniture a second life with sustainable beauty.</p>
</div>

<div class="form-section">
<div class="form-title">
<h1>Create New Account</h1>
<p>Join the FreshNest community today</p>
</div>

<?php if (!empty($error)) { ?>
<div class="error-msg"><?php echo $error; ?></div>
<?php } ?>

<form class="signup-form" action="signup.php" method="POST">
<div class="name-row">
<div class="name-box">
<div class="form-group">
<label>First Name</label>
<input type="text" name="first_name" class="filter-input" placeholder="First name" required>
</div>
</div>

<div class="name-box">
<div class="form-group">
<label>Last Name</label>
<input type="text" name="last_name" class="filter-input" placeholder="Last name" required>
</div>
</div>
</div>

<div class="form-group">
<label>Mobile Number</label>
<input type="tel" name="phone" class="filter-input" placeholder="5xxxxxxxx" required>
</div>

<div class="form-group">
<label>Email Address</label>
<input type="email" name="email" class="filter-input" placeholder="example@mail.com" required>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="password" class="filter-input" placeholder="Create password" required>
</div>

<input type="submit" name="signup_btn" value="Sign Up" class="btn-submit">

<p class="signin-text">
Already have an account? <a href="login.php">Sign in</a>
</p>
</form>
</div>

</div>
</div>

<div class="footer">
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

<div class="container footer-bottom">© 2026 FreshNest. All rights reserved.</div>
</div>

</body>
</html>
