<?php
include 'database.php';

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the SQL query to fetch contact details
    $stmt = $conn->prepare("SELECT name, email, message, message_sent FROM contacts WHERE id = ?");
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
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['messageSent'])) {
    $id = $_POST['id'];
    $messageSent = $_POST['messageSent'] === 'true';

    // Prepare and execute the SQL query to update the message sent status
    $stmt = $conn->prepare("UPDATE contacts SET message_sent = ? WHERE id = ?");
    $stmt->bind_param("ii", $messageSent, $id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
}
?>