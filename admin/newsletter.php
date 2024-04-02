<?php
include 'database.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo "Email subscribed to the newsletter successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>