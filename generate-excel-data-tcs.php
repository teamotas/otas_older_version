<?php 
include "connection.php";
include "js/format.php";
require 'vendor/autoload.php';

error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

$usercheck = null; 
$adminType = null; 
$data = null;

if (isset($_GET['userIdtcs'])) {
    // Sanitize the input to prevent SQL injection
    $Id = mysqli_real_escape_string($conn, $_GET['userIdtcs']);
    $checkuser = "SELECT * FROM roles WHERE EmployeeId='$Id'";
    $result = mysqli_query($conn, $checkuser);
    $usercheck = mysqli_fetch_assoc($result);
    $adminType = $usercheck['UserRole'];
}

if ($usercheck['UserRole'] === 'User') {
    $sql = "SELECT *
    FROM tcsprojectdata prdata
    JOIN otasprcandcount count ON prdata.projid = count.projid
    JOIN tcscbtdata cbt ON count.projid=cbt.projid
    JOIN tcsresultdata res ON cbt.projid=res.projid
    Join client cl On prdata.ClientId=cl.ClientId
    LEFT JOIN userotasproject up ON prdata.projid = up.projid
    LEFT JOIN roles ro ON up.EmployeeId = ro.EmployeeId
    WHERE 
        (up.EmployeeId = $Id AND ro.UserRole = 'User')
    ORDER BY prdata.projid ASC";
    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);
} elseif ($usercheck['UserRole'] === 'Admin') {
    $sql = "SELECT *
    FROM tcsprojectdata prdata
    JOIN otasprcandcount count ON prdata.projid = count.projid
    JOIN tcscbtdata cbt ON count.projid=cbt.projid
    JOIN tcsresultdata res ON cbt.projid=res.projid
    JOIN client cl ON prdata.ClientId = cl.ClientId
    LEFT JOIN userotasproject up ON prdata.projid = up.projid
    LEFT JOIN employee em ON up.EmployeeId = em.EmployeeId
    ORDER BY `prdata`.`projid` ASC"; 
    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);
}

// Create a new spreadsheet instance
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the headers for the Excel file
$sheet->mergeCells('A1:Z3'); 
$sheet->setCellValue('A1', 'TCS PROJECT DATA');

// Apply styling
$style = [
    'font' => [
        'bold' => true,
        'size' => 18,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '336699',
        ],
    ],
];

$style2 = [
    'font' => [
        'bold' => true,
        'size' => 13,
        'color' => ['rgb' => '000000'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '80bfff',
        ],
    ],
];
$style3=[
    'font' => [
        'bold' => true,
        'size' => 11,
        'color' => ['rgb' => '000000'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'b3d9ff',
        ],
    ],
];

// Apply the styles to the desired range
$sheet->getStyle('A1:Z3')->applyFromArray($style);
$sheet->getStyle('A4:Z5')->applyFromArray($style2); // Apply style to line 4
$sheet->getStyle('N5:U5')->applyFromArray($style3); // Apply style to line 5

// Add bold border between lines 4 and 5
$borderStyle = [
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
            'color' => ['rgb' => '000000'],
        ],
    ],
];

$sheet->getStyle('A4:Z5')->applyFromArray($borderStyle); // Apply border to line 4
$sheet->getStyle('M5:T5')->applyFromArray($borderStyle); // Apply border to line 5
// Apply the bold border to all cells between lines 4 and 5
$sheet->getStyle('A1:Z5')->applyFromArray($borderStyle);

$sheet->setCellValue('A4', 'Sr. No.');
$sheet->setCellValue('B4', 'Client Name');
$sheet->setCellValue('C4', 'Project Name');
$sheet->setCellValue('D4', 'Year');
$sheet->setCellValue('E4', 'Work Order Date');
$sheet->setCellValue('F4', 'Duration(Days)');
$sheet->setCellValue('G4', 'Sched. Date Of Compl.');
$sheet->setCellValue('H4', 'Services');
$sheet->setCellValue('I4', 'Per Cand. Rate');
$sheet->setCellValue('J4', 'Exp. Cand. Count');
$sheet->setCellValue('K4', 'Est. Project Val.');
$sheet->setCellValue('L4', 'Actual Cand. Count');
$sheet->setCellValue('M4', 'Actual Project Val');

$sheet->mergeCells('N4:O4'); 
$sheet->setCellValue('N4', 'Payment Stage(%)');
$sheet->setCellValue('N5', 'CBT %');
$sheet->setCellValue('O5', 'Result %');

$sheet->mergeCells('P4:Q4'); 
$sheet->setCellValue('P4', 'Payment Stage(Amt.)');
$sheet->setCellValue('P5', 'CBT');
$sheet->setCellValue('Q5', 'Result');

$sheet->mergeCells('R4:S4'); 
$sheet->setCellValue('R4', 'Invoice Amount ');
$sheet->setCellValue('R5', 'CBT');
$sheet->setCellValue('S5', 'Result');

$sheet->mergeCells('T4:U4'); 
$sheet->setCellValue('T4', 'Payment Done ');
$sheet->setCellValue('T5', 'CBT');
$sheet->setCellValue('U5', 'Result');

$sheet->setCellValue('V4', 'Invoice Raised');
$sheet->setCellValue('W4', 'Total Payment Done');
$sheet->setCellValue('X4', 'Ouststanding Balance');

$sheet->setCellValue('Y4', 'Status');
if($adminType==='Admin'){
    $sheet->setCellValue('Z4','Project Manager');
}
// $sheet->setCellValue('AB4', 'Delay Reason');

// Set row index
$row = 6;
$sNo = 1;

$evenRowStyle = [
        'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'e6f3ff',
        ],
    ],
];

$oddRowStyle = [ 
    'alignment' => [
    'horizontal' => Alignment::HORIZONTAL_CENTER,
    'vertical' => Alignment::VERTICAL_CENTER,
],]; 

while (($res = mysqli_fetch_assoc($data))) {
    // Check if the serial number is even or odd
    $currentRowStyle = ($sNo % 2 == 0) ? $evenRowStyle : $oddRowStyle;

    // Apply the style to each cell in the row based on even or odd
    for ($col = 'A'; $col <= 'Y'; $col++) {
        $sheet->getStyle($col . $row)->applyFromArray($currentRowStyle);
        // Apply text wrapping for all columns
        $sheet->getStyle($col . '4:' . $col . $row)->getAlignment()->setWrapText(true);
    }

    $sheet->setCellValue('A'. $row, $sNo);
    $sheet->setCellValue('B'. $row, $res['ClientName']);
    $sheet->setCellValue('C'. $row, $res['NameOfProject']);
    $sheet->setCellValue('D'. $row, $res['Year']);
    setFormattedDateCellValue($sheet, 'E'. $row, $res['WorkOrderDate']);
    $sheet->setCellValue('F'. $row, $res['Duration'] !== null ? $res['Duration']. ' day'  : '');
    setFormattedDateCellValue($sheet, 'G'. $row, $res['SchedDateCompl']);  
    $sheet->setCellValue('H'. $row, $res['Service']);
    $sheet->setCellValue('I'. $row, $res['PerCanRate'] !== null ? $res['PerCanRate'] : '');
    $sheet->setCellValue('J' . $row, formatNumberIndianStyle($res['ExpectCandCount']));
    $sheet->setCellValue('K' . $row, formatNumberIndianStyle($res['ExpectedVal']));

    $sheet->setCellValue('L' . $row, formatNumberIndianStyle($res['ActualCandCount']));
    $sheet->setCellValue('M' . $row, formatNumberIndianStyle($res['ActualVal']));

    $sheet->setCellValue('N'. $row, $res['cbtPcnt'] !== null ? $res['cbtPcnt'] : '');
    $sheet->setCellValue('O'. $row, $res['resPcnt'] !== null ? $res['resPcnt'] : '');

    $sheet->setCellValue('P' . $row, formatNumberIndianStyle($res['cbtPymntAmt']));
    $sheet->setCellValue('Q' . $row, formatNumberIndianStyle($res['resPymntAmt']));

    $sheet->setCellValue('R' . $row, formatNumberIndianStyle($res['cbtInvAmt']));
    $sheet->setCellValue('S' . $row, formatNumberIndianStyle($res['resInvAmt']));

    $sheet->setCellValue('T' . $row, formatNumberIndianStyle($res['cbtPymntDone']));
    $sheet->setCellValue('U' . $row, formatNumberIndianStyle($res['resPymntDone']));

    $sheet->setCellValue('V' . $row, formatNumberIndianStyle($res['tcsInvRaised']));
    $sheet->setCellValue('W' . $row, formatNumberIndianStyle($res['TotPymntDone']));
    $sheet->setCellValue('X' . $row, formatNumberIndianStyle($res['OutstndBal'])); 
    $sheet->setCellValue('Y' . $row, ($res['Status']));

    if($adminType==='Admin'){
        $sheet->setCellValue('Z'.$row, $res['Name'] );
    }
    // $sheet->setCellValue('AB'. 'Delay Reason');

    $row++;
    $sNo++;
}
  
    // Create a new Xlsx writer
$writer = new Xlsx($spreadsheet);

// Save the Excel file to a temporary location
$tempFilePathtcs = tempnam(sys_get_temp_dir(), 'Project_data_TCS_');
$writer->save($tempFilePathtcs);

// Close the database connection
mysqli_close($conn);

// Prompt the user to download the file and choose the directory
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="Project_data_TCS.Xlsx"');
header('Content-Length: ' . filesize($tempFilePathtcs));
readfile($tempFilePathtcs);

// Delete the temporary file
unlink($tempFilePathtcs);
exit;
?>
<script>
    // Perform client-side redirection
    window.location.href = 'project-data-tcs.php';
</script>