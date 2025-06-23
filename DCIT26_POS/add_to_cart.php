<?php
session_start();
include('db.php');

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $username = $_SESSION['username']; // Assuming user is logged in
    $quantity = 1; // Default quantity is 1, unless specified

    // Check if the product is already in the cart
    $query = "SELECT * FROM cart_tbl WHERE username = ? AND PRODUCT_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $username, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If product is already in the cart, update quantity
        $query = "UPDATE cart_tbl SET QUANTITY = QUANTITY + 1 WHERE username = ? AND PRODUCT_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $username, $product_id);
        $stmt->execute();
    } else {
        // If product is not in the cart, insert a new entry
        $query = "INSERT INTO cart_tbl (username, PRODUCT_ID, QUANTITY) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $username, $product_id, $quantity);
        $stmt->execute();
    }

    // Send a success message back
    echo "Item added to cart!";
}
?>
