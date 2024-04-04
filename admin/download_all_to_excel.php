<?php
// Include database connection
include 'database.php';

// Fetch all data from the newsletter table
$sql = "SELECT * FROM newsletter";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generate CSV file content
    $csv_content = "ID,Email,Campaign Sent\n";
    while ($row = $result->fetch_assoc()) {
        // Escape special characters and enclose values in double quotes
        $csv_content .= '"' . $row['id'] . '","' . $row['email'] . '","' . ($row['campaign_sent'] ? 'Yes' : 'No') . '"' . "\n";
    }

    // Set headers for CSV download
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="newsletter_data.csv"');

    // Output CSV content
    echo $csv_content;
} else {
    // No data found
    echo "No data available for download.";
}

// Close database connection
$conn->close();
?>
