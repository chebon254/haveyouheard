<?php
include 'database.php';

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT name, email, message FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Contact details not found']);
    }

    $stmt->close();
}
?>