<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];

    $query = "DELETE FROM favorites WHERE user_id = $user_id AND product_id = $product_id";
    mysqli_query($conn, $query);
}

header("Location: favorites.php");
exit();
?>
