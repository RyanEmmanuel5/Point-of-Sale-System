<?php
session_start();
require 'db.php'; // Include the database connection

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT password FROM users_tbl WHERE USERNAME = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username; // Store the username in the session
            echo "success"; // Login successful
        } else {
            echo "Invalid credentials"; // Incorrect password
        }
    } else {
        echo "Username not found"; // Username doesn't exist
    }

    $stmt->close();
    $conn->close();
}
?>
