<?php
include 'db.php'; // Database connection file

header('Content-Type: application/json');

try {
    // Fetch all columns
    $sql = "SELECT * FROM sales_tbl";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sales = [];
        while ($row = $result->fetch_assoc()) {
            $sales[] = $row;
        }
        echo json_encode($sales);
    } else {
        echo json_encode([]);
    }
} catch (Exception $e) {
    // Handle any errors
    echo json_encode(["error" => $e->getMessage()]);
}

$conn->close();
?>
