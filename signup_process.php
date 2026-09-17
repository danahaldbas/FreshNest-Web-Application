<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_data1";
$port = 3307;

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['signup_btn'])) {
    $full_name = $_POST['first_name'] . " " . $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];

    $sql = "INSERT INTO users (full_name, email, password, phone) 
            VALUES ('$full_name', '$email', '$pass', '$phone')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Account created successfully!');
        window.location.href='login.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>