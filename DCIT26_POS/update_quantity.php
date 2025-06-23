<?php
session_start();
include('db.php'); // Include your database connection

if (isset($_SESSION['username']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $username = $_SESSION['username'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Update the cart quantity in the database
    $stmt = $conn->prepare("UPDATE cart_tbl SET QUANTITY = ? WHERE username = ? AND PRODUCT_ID = ?");
    $stmt->bind_param("isi", $quantity, $username, $product_id);
    $stmt->execute();

    // Recalculate the total price for the updated product
    $stmt = $conn->prepare("SELECT p.PRICE FROM product_tbl p WHERE p.PRODUCT_ID = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $price = $row['PRICE'];
    $productTotal = $price * $quantity;

    // Recalculate the total payable for all items in the cart
    $total_payable = 0;
    $query = "SELECT p.PRICE, c.QUANTITY FROM cart_tbl c JOIN product_tbl p ON c.PRODUCT_ID = p.PRODUCT_ID WHERE c.username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $total_payable += $row['PRICE'] * $row['QUANTITY'];
    }

    // Ensure total values are valid numbers
    if (is_numeric($productTotal) && is_numeric($total_payable)) {
        // Return both the updated product total and the overall total payable
        echo json_encode([
            'productTotal' => $productTotal,
            'totalPayable' => $total_payable
        ]);
    } else {
        echo json_encode(['error' => 'Invalid numbers returned from the database']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
