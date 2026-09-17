<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['total_price']) && isset($_POST['address']) && isset($_POST['pay'])) {

        $total_price = trim($_POST['total_price']);
        $address = trim($_POST['address']);
        $pay = trim($_POST['pay']);

        if (empty($address) || empty($pay) || !is_numeric($total_price)) {
            die("Invalid order data");
        }

        // جلب cart
        $cart_query = "SELECT * FROM cart WHERE user_id = $user_id";
        $cart_result = mysqli_query($conn, $cart_query);

        if ($cart_result && mysqli_num_rows($cart_result) > 0) {

            $cart_row = mysqli_fetch_row($cart_result);
            $cart_id = $cart_row[0];

            // جلب العناصر
            $items_query = "SELECT products.*, cart_items.quantity
                            FROM cart_items
                            JOIN products ON cart_items.product_id = products.product_id
                            WHERE cart_items.cart_id = $cart_id";

            $items_result = mysqli_query($conn, $items_query);

            if ($items_result && mysqli_num_rows($items_result) > 0) {

                // إنشاء الطلب
                $order_query = "INSERT INTO orders (user_id, order_date, total_price)
                                VALUES ($user_id, NOW(), $total_price)";

                mysqli_query($conn, $order_query);

                $order_id = mysqli_insert_id($conn);

                // إضافة المنتجات
                while ($row = mysqli_fetch_row($items_result)) {

                    $product_id = $row[0];
                    $price = $row[2];
                    $stock = $row[6];
                    $qty = $row[8];

                    // حماية من زيادة الكمية
                    if ($qty > $stock) {
                        $qty = $stock;
                    }

                    // إضافة في order_items
                    $insert_item = "INSERT INTO order_items (order_id, product_id, quantity, price)
                                    VALUES ($order_id, $product_id, $qty, $price)";
                    mysqli_query($conn, $insert_item);

                    // تحديث المخزون
                    $update_stock = "UPDATE products 
                                     SET stock = stock - $qty 
                                     WHERE product_id = $product_id";
                    mysqli_query($conn, $update_stock);
                }

                // تفريغ السلة
                $empty_cart = "DELETE FROM cart_items WHERE cart_id = $cart_id";
                mysqli_query($conn, $empty_cart);

                // حفظ order_id
                $_SESSION['order_id'] = $order_id;

                mysqli_close($conn);

                header("Location: confirmation.php");
                exit();

            } else {
                die("Cart is empty");
            }

        } else {
            die("Cart not found");
        }

    } else {
        die("Missing order data");
    }

} else {
    die("Invalid request");
}
?>