<?php
include 'db.php'; // Database connection file

// Get the current date and calculate the first day of the month for the past 5 months
$currentMonth = date('Y-m-01');
$months = [];
for ($i = 4; $i >= 0; $i--) {
    $months[] = date('Y-m', strtotime("$currentMonth -$i month"));
}

// Prepare the query to fetch sales per month
$query = "
    SELECT 
        DATE_FORMAT(CREATED_AT, '%Y-%m') AS month, 
        SUM(TOTAL_PAYABLE) AS total_sales 
    FROM 
        sales_tbl 
    WHERE 
        CREATED_AT >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH) 
    GROUP BY 
        DATE_FORMAT(CREATED_AT, '%Y-%m')
";

$result = $conn->query($query);

// Initialize the monthly sales data
$salesData = array_fill_keys($months, 0);

// Populate the sales data from the query result
while ($row = $result->fetch_assoc()) {
    $salesData[$row['month']] = (float)$row['total_sales'];
}

// Send the data as JSON
echo json_encode($salesData);
?>
