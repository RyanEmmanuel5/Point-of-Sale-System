<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "pos_dcit26";         

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get the date from the query parameter (or set to null if not provided)
$date = $_GET['date'] ?? null;

if ($date) {
    // Prepare SQL query to select all columns from sales_tbl where the created_at date matches the provided date
    $query = $conn->prepare("SELECT * FROM sales_tbl WHERE DATE(CREATED_AT) = ?");
    
    // Bind the date parameter to the query (use "s" for string type)
    $query->bind_param("s", $date);
    
    // Execute the query
    if ($query->execute()) {
        // Get the result of the query execution
        $result = $query->get_result();

        // Fetch all results as an associative array
        $sales = $result->fetch_all(MYSQLI_ASSOC);

        // Return the fetched data as a JSON response
        echo json_encode($sales);
    } else {
        // If the query execution fails, return an error message
        echo json_encode(['error' => 'Query execution failed: ' . $query->error]);
    }
} else {
    // If the date parameter is missing, return an error message
    echo json_encode(['error' => 'Date parameter is missing.']);
}

// Close the database connection
$conn->close();
?>
