<?php
session_start();
include("config.php");

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("status" => "login"));
    exit();
}

if (!isset($_GET['product_id']) || empty($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    echo json_encode(array("status" => "error"));
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

$check = "SELECT * FROM favorites WHERE user_id = $user_id AND product_id = $product_id";
$result = mysqli_query($conn, $check);

if ($result && mysqli_num_rows($result) > 0) {
    $delete = "DELETE FROM favorites WHERE user_id = $user_id AND product_id = $product_id";
    mysqli_query($conn, $delete);
    echo json_encode(array("status" => "removed"));
} else {
    $insert = "INSERT INTO favorites (user_id, product_id) VALUES ($user_id, $product_id)";
    mysqli_query($conn, $insert);
    echo json_encode(array("status" => "added"));
}

mysqli_close($conn);
?>
