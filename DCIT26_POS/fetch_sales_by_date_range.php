<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos_dcit26";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get date range from query parameters
$fromDate = $_GET['from'] ?? null;
$toDate = $_GET['to'] ?? null;

if ($fromDate && $toDate) {
    // Prepare the SQL query to select data between the two dates
    $query = $conn->prepare("SELECT * FROM sales_tbl WHERE DATE(CREATED_AT) BETWEEN ? AND ?");
    $query->bind_param("ss", $fromDate, $toDate);
    $query->execute();
    $result = $query->get_result();

    // Fetch all results as an associative array
    $sales = $result->fetch_all(MYSQLI_ASSOC);

    // Return the results as a JSON response
    echo json_encode($sales);
} else {
    // If date range is incomplete, return an error message
    echo json_encode(['error' => 'Date range is incomplete.']);
}

// Close the connection
$conn->close();
?>
