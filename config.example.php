<?php
$conn = mysqli_connect("localhost:3307", "root", "", "project_data1");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>