<?php
// Include database connection
include 'database.php';

// Include PhpSpreadsheet library
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch all data from the newsletter table
$sql = "SELECT * FROM newsletter";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create a new spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Email');
    $sheet->setCellValue('C1', 'Campaign Sent');

    // Populate data in the spreadsheet
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);
        $sheet->setCellValue('B' . $row, $data['email']);
        $sheet->setCellValue('C' . $row, $data['campaign_sent'] ? 'Yes' : 'No');
        $row++;
    }

    // Set headers for Excel download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="newsletter_data.xlsx"');

    // Create and output the Excel file
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
} else {
    echo "No data available for download.";
}

// Close database connection
$conn->close();
?>