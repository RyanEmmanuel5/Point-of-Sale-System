<?php
header('Content-Type: application/json'); // Set header for JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php'; // Replace with your actual connection file

    $id = $_POST['id'];
    $name = $_POST['name'];

    $query = "UPDATE users_tbl SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('si', $name, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
