<?php
    include('connection.php');
    include "js/format.php";
    // session_start();
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Font;

    if(isset($_GET['AdminId'])){
        $id=$_GET['AdminId'];

        $sqlAdmin = "SELECT * FROM employee em
        Join department dp ON em.EmployeeId=dp.EmployeeId  
        Join roles ro ON dp.EmployeeId=ro.EmployeeId
        WHERE em.EmployeeId='$id'";
        $dataAdmin = mysqli_query($conn, $sqlAdmin);
        $totalAdmin = mysqli_fetch_assoc($dataAdmin);
        $adminType = $totalAdmin['UserRole'];
    }

    
    if($adminType==='Admin'){
    // Fetch data from the database
    $sql = "SELECT * FROM employee em, department dp, roles ro  WHERE em.EmployeeId=dp.EmployeeId AND dp.EmployeeId=ro.EmployeeId ";
    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);

    // Create a new spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->mergeCells('A1:J2'); 
    $sheet->setCellValue('A1', 'EMPLOYEE DATA');
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

    $style2=[
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
    // Apply the styles to the desired range
    $sheet->getStyle('A1:J2')->applyFromArray($style);
    $sheet->getStyle('A3:J3')->applyFromArray($style2);

    // Add bold border between lines 4 and 5
    $borderStyle = [
        'borders' => [
            'bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];

    // Set the headers for the Excel file
    $sheet->setCellValue('A3', 'Sr. No.');
    $sheet->setCellValue('B3', 'Name');
    $sheet->setCellValue('C3', 'Email Id');
    $sheet->setCellValue('D3', 'Employee Id');
    $sheet->setCellValue('E3', 'Designation');
    $sheet->setCellValue('F3', 'Department Id');
    $sheet->setCellValue('G3', 'Role');
    $sheet->setCellValue('H3', 'Gender');
    $sheet->setCellValue('I3', 'Date Of Birth');
    $sheet->setCellValue('J3', 'Mobile No.');

    // Set row index
    $row = 4;
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

    $oddRowStyle = [ 'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],]; 

    while (($res = mysqli_fetch_assoc($data))) {
        // Check if the serial number is even or odd
        $currentRowStyle = ($sNo % 2 == 0) ? $evenRowStyle : $oddRowStyle;

        // Apply the style to each cell in the row based on even or odd
        for ($col = 'A'; $col <= 'J'; $col++) {
            $sheet->getStyle($col . $row)->applyFromArray($currentRowStyle);
        }
        $dateOfBirth = $res['Date Of Birth'];
        if ($dateOfBirth === null || $dateOfBirth === '00-00-0000') {
            // Handle NULL or invalid dates
            $dateOfBirthFormatted = ''; // Or any default value you want to display
        } else {
            // Convert the date to the desired format
            $dateOfBirthFormatted = date('d-m-Y', strtotime($dateOfBirth));
        }
        
       
        
        $sheet->setCellValue('A' . $row, $sNo);
        $sheet->setCellValue('B' . $row, $res['Name']);
        $sheet->setCellValue('C' . $row, $res['EmailId']);
        $sheet->setCellValue('D' . $row, $res['EmployeeId']);
        $sheet->setCellValue('E' . $row, $res['Designation']);
        $sheet->setCellValue('F' . $row, $res['DepartmentId']);
        $sheet->setCellValue('G' . $row, $res['UserRole']);
        $sheet->setCellValue('H' . $row, $res['Gender']);
        // Set the formatted date value in the spreadsheet cell
        $sheet->setCellValue('I' . $row, $dateOfBirthFormatted);
        $sheet->setCellValue('J' . $row, $res['MobileNo']);

        $row++;
        $sNo++;
    }

    // Create a new Xlsx writer
    $writer = new Xlsx($spreadsheet);

    // Save the Excel file to a temporary location
    $tempFilePath = tempnam(sys_get_temp_dir(), 'employee_data_');
    $writer->save($tempFilePath);

    // Close the database connection
    mysqli_close($conn);
    unset($_SESSION['fileReady']);

    // Prompt the user to download the file and choose the directory
    header('Content-Type: application/octet-stream');
    
    header('Content-Disposition: attachment; filename="employee_data.xlsx"');
    header('Content-Length: ' . filesize($tempFilePath));
    readfile($tempFilePath);

    // Delete the temporary file
    unlink($tempFilePath);
    exit;
?>
<script>
    // Perform client-side redirection
    window.location.href = 'employee_data.php';
</script>


<?php }?>