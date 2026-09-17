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

$message_status = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
        $name = mysqli_real_escape_string($conn, trim($_POST['name']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $message = mysqli_real_escape_string($conn, trim($_POST['message']));

        $query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $query)) {
            $message_status = "✅ Message sent successfully!";
        } else {
            $message_status = "❌ Error: " . mysqli_error($conn);
        }
    } else {
        $message_status = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact Us - FreshNest</title>
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
            <a href="index.php">Home</a><a href="products.php">Products</a><a href="contact.php">Contacts</a><a href="orders.php">My Orders</a>
        </div>
        <div class="header-right">
            <a class="header-fav" href="favorites.php">♥<?php if ($fav_count > 0) { ?><span class="fav-count"><?php echo $fav_count; ?></span><?php } ?></a>
            <a class="icon-btn" href="cart.php"><img alt="Cart" class="cart-icon" src="images/icon-cart.png"/></a>
            <a class="login-link" href="login.php">login</a>
        </div>
    </div>
</div>

<div class="section container">
    <h1 class="page-title" style="text-align: center;">Contact Us</h1>
    <?php if ($message_status) echo "<p style='text-align:center; font-weight:bold;'>$message_status</p>"; ?>
    
    <div class="contact-wrap" style="background: #fff; padding: 40px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); display: flex; gap: 40px; flex-wrap: wrap; margin-bottom: 50px;">
        <div style="flex: 1; min-width: 300px; border-radius: 20px; overflow: hidden;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3625.549235069274!2d49.98801947525301!3d26.41724217696417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e4905d41f71a069%3A0xc489d2c1e7a57a0!2sImam%20Abdulrahman%20Bin%20Faisal%20University!5e0!3m2!1sen!2ssa!4v1683284950123!5m2!1sen!2ssa3" 
width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <form id="contactForm" action="contact.php" method="post" style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
            <input name="name" id="name" placeholder="Your Name" type="text" style="padding: 15px; border-radius: 12px; border: 1px solid #eee;" required/>
            <input name="email" id="email" placeholder="Email address" type="email" style="padding: 15px; border-radius: 12px; border: 1px solid #eee;" required/>
            <div id="emailError" style="color: red; font-size: 12px; display: none;">Invalid email format!</div>
            <textarea name="message" id="message" placeholder="Write something..." style="padding: 15px; border-radius: 12px; border: 1px solid #eee; height: 120px;" required></textarea>
            <div id="msgError" style="color: red; font-size: 12px; display: none;">Message must contain letters!</div>
            <input class="btn" type="submit" value="Send Message" style="background: #8fa589; color: #fff; padding: 15px; border-radius: 12px; border: none; cursor: pointer;"/>
        </form>
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
<li><a href="products.php">Kitchen</a></li>
<li><a href="products.php">Office</a></li>
</ul>
</div>

<div>
<h4>Contact</h4>
<ul>
<li><a href="mailto:support@freshnest.com">support@freshnest.com</a></li>
<li>+1 (555) 123-4567</li>
<li> Green Street, Dammam City</li>
</ul>
</div>

</div>

<div class="container footer-bottom">© 2026 FreshNest. All rights reserved.</div>
</div>

<script>
document.getElementById("contactForm").addEventListener("submit", function(event) {
    var email = document.getElementById("email").value;
    var msg = document.getElementById("message").value;
    var emailError = document.getElementById("emailError");
    var msgError = document.getElementById("msgError");
    
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        emailError.style.display = "block";
        event.preventDefault();
    } else {
        emailError.style.display = "none";
    }

    var isOnlyNumbers = /^\d+$/;
    if (isOnlyNumbers.test(msg)) {
        msgError.style.display = "block";
        event.preventDefault();
    } else {
        msgError.style.display = "none";
    }
});
</script>

</body>
</html>
<?php mysqli_close($conn); ?>