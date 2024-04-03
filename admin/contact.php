<?php
include 'database.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = isset($_POST['email']) ? $_POST['email'] : ''; // Check if email is set, otherwise set it to an empty string
    $message = $_POST['message'];

    // Check if the email is not empty
    if (!empty($email)) {
        // Prepare and execute the SQL query
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "Success! Thank you!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Email is required.";
    }
}
?>