<?php
// Include database connection
include 'database.php';

// Delete all data from the newsletter table
$sql = "DELETE FROM newsletter";
if ($conn->query($sql) === TRUE) {
    echo "All data deleted successfully.";
} else {
    echo "Error deleting data: " . $conn->error;
}

// Close database connection
$conn->close();
?>
