<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Start output buffering

include 'db.php'; // Include your database connection

// Set the correct time zone
date_default_timezone_set('Your/Timezone'); // Replace 'Your/Timezone' with your actual time zone

// Check for database connection error
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    ob_end_flush();
    exit();
}

// Fetch sales data for the last 7 days including today
$sql = "SELECT DATE(CREATED_AT) as date, SUM(TOTAL_PAYABLE) as total_sales
        FROM sales_tbl
        WHERE CREATED_AT >= CURDATE() - INTERVAL 6 DAY
        GROUP BY DATE(CREATED_AT)
        ORDER BY DATE(CREATED_AT) ASC";

$result = $conn->query($sql);

// Check for query execution error
if (!$result) {
    echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    ob_end_flush();
    exit();
}

// Initialize sales data for the last 7 days
$sales_data = [];
$today = new DateTime();
for ($i = 6; $i >= 0; $i--) {
    $date = (clone $today)->modify("-$i day")->format('Y-m-d');
    $sales_data[$date] = 0; // Initialize sales to 0
}

// Populate sales data with query results
while ($row = $result->fetch_assoc()) {
    $sales_data[$row['date']] = (float)$row['total_sales'];
}

// Reverse the order so the latest date appears first
krsort($sales_data);

// Prepare the final JSON response
$final_data = [];
foreach ($sales_data as $date => $total_sales) {
    $final_data[] = [
        'date' => $date,
        'total_sales' => $total_sales
    ];
}

// Output the JSON
ob_end_clean(); // Clear any accidental output
header('Content-Type: application/json');
echo json_encode($final_data);
?>
