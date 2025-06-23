<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php'; // Include your database connection

// Get the current date and calculate the last 5 weeks
$currentDate = new DateTime();
$weeks = [];
for ($i = 4; $i >= 0; $i--) { // Reverse the loop to ensure weeks are ordered from oldest to newest
    $weekDate = clone $currentDate;
    $weekDate->modify("-$i week");
    $weeks[] = [
        'week' => $weekDate->format('W'), // Week number (ISO 8601 format)
        'start_date' => $weekDate->format('Y-m-d'), // Start of the week
        'total_sales' => 0 // Default sales value for each week
    ];
}

// Query to get total sales per week for the last 5 weeks
$query = "
    SELECT 
    WEEK(DATE(CREATED_AT), 3) AS week, -- Use ISO 8601 week numbering
    SUM(TOTAL_PAYABLE) AS total_sales 
FROM 
    sales_tbl 
WHERE 
    CREATED_AT >= CURDATE() - INTERVAL 5 WEEK 
GROUP BY 
    WEEK(DATE(CREATED_AT), 3) 
ORDER BY 
    WEEK(DATE(CREATED_AT), 3) ASC";

// Execute the query and fetch the results
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    echo json_encode(['error' => 'Error fetching data']);
    exit;
}

// Update the default weeks array with actual sales data
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($weeks as &$week) {
        // If the week from the database matches one of the last 5 weeks, update its total_sales
        if ($week['week'] == $row['week']) {
            $week['total_sales'] = $row['total_sales'];
        }
    }
}

// Format the data for chart.js
$data = array_map(function ($week) {
    return [
        'week' => 'Week ' . $week['week'], // Label for each week
        'total_sales' => $week['total_sales'] // Sales for the week (or 0 if no sales)
    ];
}, $weeks);

// Return the data as JSON
echo json_encode($data);
?>
