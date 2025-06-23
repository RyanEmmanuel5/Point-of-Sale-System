<?php
session_start();
include 'db.php'; // Include your database connection

// Check if user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Get the updated quantity and product ID from the AJAX request
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        // Validate the input
        if (is_numeric($quantity) && $quantity > 0) {
            // Update the cart table with the new quantity
            $updateQuery = "UPDATE cart_tbl SET QUANTITY = ? WHERE username = ? AND PRODUCT_ID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("iss", $quantity, $username, $product_id);
            
            if ($stmt->execute()) {
                // Success: Optionally, send a success response back to the client
                echo "Cart updated successfully.";
            } else {
                // Error: Handle failure (optional)
                echo "Failed to update cart.";
            }
        } else {
            echo "Invalid quantity.";
        }
    } else {
        echo "Product ID or quantity not provided.";
    }
} else {
    echo "User not logged in.";
}
?>
