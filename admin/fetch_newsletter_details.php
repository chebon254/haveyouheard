<?php
include 'database.php';

// Check if the request is a POST request and required parameters are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['campaignSent'])) {
    $id = $_POST['id'];
    $campaignSent = $_POST['campaignSent'] === 'true';

    // Prepare and execute the SQL query to update the campaign sent status
    $stmt = $conn->prepare("UPDATE newsletter SET campaign_sent = ? WHERE id = ?");
    $stmt->bind_param("ii", $campaignSent, $id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
