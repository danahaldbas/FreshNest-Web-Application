<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

$cart_query = "SELECT * FROM cart WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    $cart_row = mysqli_fetch_row($cart_result);
    $cart_id = $cart_row[0];

    $delete_query = "DELETE FROM cart_items WHERE cart_id = $cart_id";
    mysqli_query($conn, $delete_query);
}

mysqli_close($conn);

header("Location: cart.php");
exit();
?>