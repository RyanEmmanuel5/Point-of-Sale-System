<?php
include 'db.php'; // Database connection file


// Fetch top 5 selling products based on quantity and calculate revenue
$sql = "
    SELECT 
        JSON_EXTRACT(ITEM_DETAILS, '$[0].product_name') AS product_name,
        SUM(JSON_EXTRACT(ITEM_DETAILS, '$[0].quantity')) AS quantity_sold,
        SUM(JSON_EXTRACT(ITEM_DETAILS, '$[0].quantity') * JSON_EXTRACT(ITEM_DETAILS, '$[0].unit_price')) AS total_revenue
    FROM sales_tbl
    GROUP BY product_name
    ORDER BY quantity_sold DESC
    LIMIT 5
";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'product' => $row['product_name'],
            'quantity' => (int)$row['quantity_sold'],
            'revenue' => (float)$row['total_revenue']
        ];
    }
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
