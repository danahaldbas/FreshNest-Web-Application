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
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        if (!empty($email) && !empty($password)) {
            $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $_SESSION['user_id'] = $row[0];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid email or password";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FreshNest - Login</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

  <header class="header">
    <div class="container row">
      <a class="brand" href="index.php">
        <img src="images/logo.png" alt="FreshNest Logo">
        	<span class="name">
  		<span class="fresh">Frsh</span><span class="nest">Nest</span>
		</span>
      </a>

      <nav class="nav" aria-label="Main Navigation">
        <a href="index.php">Home</a>
        <a href="products.php">Procdet</a>
        <a href="contact.php">Contact</a>
        <a href="orders.php">My Orders</a>
      </nav>

      <div class="header-right">
<a class="header-fav" href="favorites.php">♥<?php if ($fav_count > 0) { ?><span class="fav-count"><?php echo $fav_count; ?></span><?php } ?></a>
<a class="icon-btn" href="cart.php"><img alt="Cart" class="cart-icon" src="images/icon-cart.png"/></a>
<a class="login-link" href="login.php">login</a>
</div>
    </div>
  </header>

<main class="section container">
    <div class="feature" style="max-width: 1000px; width: 100%; margin: 40px auto; padding: 0; display: flex; overflow: hidden; border-radius: 30px; background: #fff; box-shadow: 0 20px 50px rgba(0,0,0,0.05); min-height: 600px;">
      
      <div style="flex: 1.2; background: #f4f1ee; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 60px; border-right: 1px solid rgba(0,0,0,0.03);">
    <img src="images/logo.png" alt="FreshNest" style="width: 200px; margin-bottom: 25px; border-radius: 20px;"> 
    
    <h2 style="font-family: 'Playfair Display', serif; color: #2d4a36; font-size: 32px; margin-bottom: 15px;">FreshNest</h2> 
    
    <p class="muted" style="text-align: center; max-width: 300px; font-size: 18px; line-height: 1.6;">Giving furniture a second life with sustainable beauty.</p> 
</div>

      <div style="flex: 1.2; padding: 60px; display: flex; flex-direction: column; justify-content: center; text-align: left;">
        <div style="margin-bottom: 35px;">
          <h1 style="font-size: 48px; margin-bottom: 16px;">Hello Again!</h1>
          <p class="muted">Welcome back, you've been missed!</p>
        </div>
		
		<?php if (!empty($error)) { ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #f5c6cb; text-align: center; font-weight: bold;">
        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
    </div>
<?php } ?>

        <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
          
<div style="display: flex; flex-direction: column; gap: 8px;">
    <label style="font-weight: 500; font-size: 14px;">Email</label>
    <div style="position: relative; width: 100%;">
        <i class="fa-solid fa-envelope" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); opacity: 0.5; color: #444;"></i>
        <input type="text" name="email" placeholder="Enter your email" style="width: 100%; padding: 15px 15px 15px 45px; border-radius: 12px; border: 1px solid #eee; background: #f9f9f9; font-family: inherit; display: block;" required>
    </div>
    <div id="emailError" style="color: red; font-size: 12px; display: none;">Please enter a valid email address</div>
</div>

    <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="font-weight: 500; font-size: 14px;">Password</label>
        <div style="position: relative; width: 100%;">
            <i class="fa-solid fa-lock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); opacity: 0.5; color: #444;"></i>
            <input type="password" name="password" id="passwordField" placeholder="••••••••••••" style="width: 100%; padding: 15px 45px 15px 45px; border-radius: 12px; border: 1px solid #eee; background: #f9f9f9; font-family: inherit; display: block;" required>
            <i class="fa-solid fa-eye-slash" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; color: #444;"></i>
        </div>
        <a href="#" onclick="alert('A recovery link has been sent to your email!')" style="text-align: right; font-size: 12px; color: var(--nav); text-decoration: none; margin-top: 5px;">Forgot Password?</a>
    </div>

    <button type="submit" class="btn" style="width: 100%; border: none; cursor: pointer; padding: 18px; font-size: 16px; margin-top: 10px; border-radius: 12px; display: block; background: #8fa589;">Sign In</button>
</form>

        <p class="muted" style="text-align: center; font-size: 14px; margin-top: 30px;">
          Dont have an account? <a href="signup.php" style="color: var(--nav); font-weight: 700; text-decoration: none;">Sign up</a>
        </p>
      </div>

    </div>

    <script>
      const togglePassword = document.querySelector('#togglePassword');
      const password = document.querySelector('#passwordField');

      togglePassword.addEventListener('click', function () {
          const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
          password.setAttribute('type', type);
          
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
      });
	  document.getElementsByName("email")[0].addEventListener("blur", function() {
    var email = this.value;
    var errorDiv = document.getElementById("emailError");
    if (email.length > 0 && (!email.includes("@") || !email.includes("."))) {
        errorDiv.style.display = "block";
    } else {
        errorDiv.style.display = "none";
    }
});

	  
    </script>
</main>

 

</body>
</html>