<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php'; // database connection file

    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    $query = "DELETE FROM users_tbl WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $id);
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
