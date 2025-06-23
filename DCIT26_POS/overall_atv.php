<?php
include 'db.php'; // Database connection file


// Query to calculate overall ATV
$sql = "
    SELECT 
        SUM(TOTAL_PAYABLE) AS total_payable,
        COUNT(SALE_ID) AS total_transactions,
        (SUM(TOTAL_PAYABLE) / COUNT(SALE_ID)) AS overall_atv
    FROM sales_tbl
";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data = [
        'total_payable' => (float)$row['total_payable'],
        'total_transactions' => (int)$row['total_transactions'],
        'overall_atv' => (float)$row['overall_atv']
    ];
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
