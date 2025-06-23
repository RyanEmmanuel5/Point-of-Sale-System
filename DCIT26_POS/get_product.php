<?php
require 'db.php'; // Include your database connection

if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);

    $query = "SELECT * FROM product_tbl WHERE PRODUCT_ID = '$product_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $product = mysqli_fetch_assoc($query_run);
        $res = [
            'status' => 200,
            'message' => 'Product fetched successfully',
            'data' => $product
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'message' => 'Product ID not found'
        ];
        echo json_encode($res);
    }
} else {
    $res = [
        'status' => 400,
        'message' => 'Product ID is required'
    ];
    echo json_encode($res);
}
?>
