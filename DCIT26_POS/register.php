<?php
// Include the database connection
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'register') {
    // Get form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username already exists
    $sql = "SELECT * FROM users_tbl WHERE USERNAME = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username is already taken. Please choose another one.";
        exit; // Stop further execution
    }

    // Check if the email already exists
    $sql = "SELECT * FROM users_tbl WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email is already registered. Please choose another one.";
        exit; // Stop further execution
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $sql = "INSERT INTO users_tbl (NAME, USERNAME, EMAIL, PASSWORD) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $name, $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "success";  // Registration successful
    } else {
        echo "An error occurred during registration. Please try again.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
