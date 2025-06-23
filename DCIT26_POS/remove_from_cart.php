<?php
session_start();
include 'db.php'; // Include your database connection

if (isset($_POST['product_id']) && isset($_SESSION['username'])) {
    $product_id = $_POST['product_id'];
    $username = $_SESSION['username'];

    // Remove the product from the cart
    $query = "DELETE FROM cart_tbl WHERE PRODUCT_ID = ? AND username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $product_id, $username); // 'i' for int, 's' for string
    $stmt->execute();

    // Check if the product was removed
    if ($stmt->affected_rows > 0) {
        // Calculate the total payable after removal
        $total_query = "SELECT SUM(p.PRICE * c.QUANTITY) AS total_payable
                        FROM cart_tbl c
                        JOIN product_tbl p ON c.PRODUCT_ID = p.PRODUCT_ID
                        WHERE c.username = ?";
        $total_stmt = $conn->prepare($total_query);
        $total_stmt->bind_param('s', $username);
        $total_stmt->execute();
        $total_result = $total_stmt->get_result();

        if ($total_row = $total_result->fetch_assoc()) {
            $total_payable = $total_row['total_payable'];
            echo json_encode(['totalPayable' => $total_payable]);
        } else {
            echo json_encode(['totalPayable' => 0]);
        }
    } else {
        echo json_encode(['error' => 'Failed to remove item']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
?>
