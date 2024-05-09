<?php
require 'connection.php';
require 'js/format.php';
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

// Your SQL query
$sql = "SELECT *
        FROM otasprojectdata prdata
        JOIN otasservicesprice serprice ON prdata.projid=serprice.projid
        JOIN otasprojval prval ON  serprice.projid= prval.projid
        JOIN otasprcandcount count ON prval.projid = count.projid
        JOIN otasprojdates dates ON count.projid = dates.projid
        JOIN stg1pymntdetail stg1 ON dates.projid=stg1.projid
        JOIN stg2pymntdetail stg2 ON stg1.projid=stg2.projid
        JOIN stg3pymntdetail stg3 ON stg2.projid=stg3.projid
        JOIN stg4pymntdetail stg4 ON stg3.projid=stg4.projid
        JOIN stg5pymntdetail stg5 ON stg4.projid=stg5.projid
        JOIN client cl ON prdata.ClientId = cl.ClientId
        LEFT JOIN userotasproject up ON prdata.projid = up.projid
        LEFT JOIN employee em ON up.EmployeeId = em.EmployeeId
        ORDER BY `prdata`.`projid` ASC";       

$data = mysqli_query($conn, $sql);

// Create a new PhpWord instance
$phpWord = new PhpWord();

// Set page orientation to landscape
$section = $phpWord->addSection(['orientation' => 'landscape']);

// Define header cell style
$headerCellStyle = [
    'bold' => true,
    'size' => 11,
    'color' => '000000', // Black text color
    'alignment' => Jc::CENTER, // Center alignment
];

// Define header row style
$headerRowStyle = [
    'bgColor' => 'F2F2F2', // Grey background color
    'borderTopSize' => 6,
    'borderBottomSize' => 6,
    'borderLeftSize' => 6,
    'borderRightSize' => 6,
    'borderColor' => '000000', // Black border color
];

// Add a table to the section
$table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000']); // Border for the entire table

// Add header row
$headerCells = ['No.', 'Project Name', 'Client Name', 'Contract Value (Excluding GST)(Rs in Crore)', 'Date of LOA', 'Date of Exam/CBT', 'Scheduled Date of Completion', 'Expected / Actual Date of Completion', 'Reasons for delay in completion', 'Amount Received from Client(Rs. In crores)', 'Reasons for Non-Realization'];
$headerRow = $table->addRow();
foreach ($headerCells as $headerCell) {
    // Calculate cell width based on content length
    $cellWidth = max(500, strlen($headerCell) * 50); // Minimum width 500, adjust as needed
    $cell = $headerRow->addCell($cellWidth, $headerRowStyle);
    $cell->addText($headerCell, $headerCellStyle);
}

$sNo = 1;

// Fetch data and loop through each row
while ($res = mysqli_fetch_assoc($data)) {
    $rowData = [
        $sNo,
        $res['NameOfProject'],
        $res['ClientName'],
        $res['ActualProjVal'] ? formatNumberIndianStyle($res['ActualProjVal']) : formatNumberIndianStyle($res['ExpectProjVal']),
        setFormattedDateValue($res['WorkOrderDate']),
        formatMultipleDates($res['CBTDate']),
        setFormattedDateValue($res['SchedDateCompl']),
        setFormattedDateValue($res['ResultSubmitDate']),
        $res['DelayReason'], // Placeholder for "Reasons for delay in completion" (update as needed)
        formatNumberIndianStyle($res['AmntRcvdByClient']),
        '', // Placeholder for "Reasons for Non-Realization" (update as needed)
    ];

    // Add a new row to the table
    $row = $table->addRow();
    foreach ($rowData as $cellData) {
        // Add cell with calculated width
        $cellWidth = max(500, strlen($cellData) * 50); // Minimum width 500, adjust as needed
        $cell = $row->addCell($cellWidth);
        $cell->addText($cellData);
    }

    $sNo++;
}

// Save the document
$filename = 'your_document.docx';
$phpWord->save($filename);

// Download the document
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Delete the temporary file
unlink($filename);
?>
<!-- 
// // Dummy data for the table
// $dummyData = [
//     ['1', 'Project A', 'Client X', '100', '2024-01-01', '2024-02-01', '2024-03-01', '2024-04-01', 'Delay due to weather', '80', 'Client payment pending'],
//     ['2', 'Project B', 'Client Y', '150', '2024-02-01', '2024-03-01', '2024-04-01', '2024-05-01', 'Material shortage', '120', 'Client dispute'],
// ];

// // Add dummy data to the table
// foreach ($dummyData as $rowData) {
//     $row = $table->addRow();
//     foreach ($rowData as $cellData) {
//         // Calculate cell width based on content length
//         $cellWidth = max(500, strlen($cellData) * 50); // Minimum width 500, adjust as needed
//         $cell = $row->addCell($cellWidth);
//         $cell->addText($cellData);
//     }
// }

// Save the document
$filename = 'sample_table_with_dynamic_width.docx';
$phpWord->save($filename);

// Download the document
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Delete the temporary file
unlink($filename); -->

