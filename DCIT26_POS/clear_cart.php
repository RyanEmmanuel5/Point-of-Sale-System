<?php
session_start();
include('db.php'); // Include your database connection file

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Query to delete all items from the user's cart
    $query = "DELETE FROM cart_tbl WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        // Redirect to sale_transaction.php after successfully clearing the cart
        header("Location: sale_transaction.php?message=Cart cleared successfully");
        exit;
    } else {
        echo "Error clearing the cart.";
    }
} else {
    echo "User not logged in.";
}
?>
