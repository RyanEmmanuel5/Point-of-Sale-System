<?php
require 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
    
    // Check if a new image is uploaded
    if (!empty($_FILES['productImage']['name'])) {
        $image = $_FILES['productImage']['name'];
        $targetDir = "uploads/"; // Directory for uploaded images
        $targetFile = $targetDir . basename($image);
        move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile);

        // Update query with image
        $query = "UPDATE product_tbl 
                  SET PRODUCT_NAME = '$productName', CATEGORY = '$productCategory', PRICE = '$productPrice', IMAGE = '$targetFile'
                  WHERE PRODUCT_ID = '$productId'";
    } else {
        // Update query without image
        $query = "UPDATE product_tbl 
                  SET PRODUCT_NAME = '$productName', CATEGORY = '$productCategory', PRICE = '$productPrice'
                  WHERE PRODUCT_ID = '$productId'";
    }

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Failed to update product']);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Invalid request method']);
}
?>
