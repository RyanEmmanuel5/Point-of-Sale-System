<?php
// Include your database connection
include 'db.php';

$response = array(); // Initialize response array

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Prepare and execute the delete query using mysqli
    $stmt = $conn->prepare("DELETE FROM product_tbl WHERE PRODUCT_ID = ?");
    $stmt->bind_param("i", $productId); // "i" for integer type
    $stmt->execute();

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        $response['status'] = 'success';
        $response['message'] = "Product deleted successfully.";
    } else {
        $response['status'] = 'error';
        $response['message'] = "Product not found.";
    }
} else {
    $response['status'] = 'error';
    $response['message'] = "Invalid request.";
}

// Send the response back to JavaScript as a JSON object
echo json_encode($response);
?>
