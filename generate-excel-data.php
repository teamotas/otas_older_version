<?php

    include "connection.php";
    include "js/format.php";
    require 'vendor/autoload.php';
    // require_once "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Font;
    use PhpOffice\PhpSpreadsheet\Writer\Ods\WriterPart;
    $usercheck = null; 
    $adminType = null; 
    $data = null;

    if (isset($_GET['Id'])) {
        // Sanitize the input to prevent SQL injection
        $Id = mysqli_real_escape_string($conn, $_GET['Id']);
        $checkuser = "SELECT * FROM roles WHERE EmployeeId='$Id'";
        $result = mysqli_query($conn, $checkuser);
        $usercheck = mysqli_fetch_assoc($result);
        $adminType=$usercheck['UserRole'];
    }
    if ($usercheck['UserRole'] === 'User'){
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
        LEFT JOIN roles ro ON up.EmployeeId = ro.EmployeeId
        WHERE 
            (up.EmployeeId = $Id AND ro.UserRole = 'User')
        ORDER BY prdata.projid ASC";
            $data = mysqli_query($conn, $sql);
            $total = mysqli_num_rows($data);
    }
    else if($usercheck['UserRole'] === 'Admin')
    {
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
        $total = mysqli_num_rows($data);
    }




    
    // Create a new spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the headers for the Excel file
    $sheet->mergeCells('A1:AP3'); 
    $sheet->setCellValue('A1', 'PROJECT DATA');

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
    $sheet->getStyle('A1:AP3')->applyFromArray($style);
    $sheet->getStyle('A4:AP5')->applyFromArray($style2); // Apply style to line 4
    $sheet->getStyle('N5:AG5')->applyFromArray($style3); // Apply style to line 5

    // Add bold border between lines 4 and 5
    $borderStyle = [
        'borders' => [
            'bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    $sheet->getStyle('A4:AP5')->applyFromArray($borderStyle); // Apply border to line 4
    $sheet->getStyle('N5:AG5')->applyFromArray($borderStyle); // Apply border to line 5

    // Apply the bold border to all cells between lines 4 and 5
    $sheet->getStyle('A1:AJ5')->applyFromArray($borderStyle);

    $sheet->setCellValue('A4', 'Sr. No.');
    $sheet->setCellValue('B4', 'Client Name');
    $sheet->setCellValue('C4', 'Project Name');
    $sheet->setCellValue('D4', 'Year');
    $sheet->setCellValue('E4', 'Work Order Date');
    $sheet->setCellValue('F4', 'Duration(Days)');
    $sheet->setCellValue('G4', 'Sched. Date Of Completion');
    $sheet->setCellValue('H4', 'Services');
    $sheet->setCellValue('I4', 'Per Candidate Rate');
    $sheet->setCellValue('J4', 'Expected Candidate Count');
    $sheet->setCellValue('K4', 'Estimated Project Value');
    $sheet->setCellValue('L4', 'Actual Candidate Count');
    $sheet->setCellValue('M4', 'Actual Project Value');
    $sheet->mergeCells('N4:R4'); 
    $sheet->setCellValue('N4', 'Payment Stage(%)');
    $sheet->setCellValue('N5', 'Stage 1%');
    $sheet->setCellValue('O5', 'Stage 2%');
    $sheet->setCellValue('P5', 'Stage 3%');
    $sheet->setCellValue('Q5', 'Stage 4%');
    $sheet->setCellValue('R5', 'Stage 5%');
    $sheet->mergeCells('S4:W4'); 
    $sheet->setCellValue('S4', 'Payment Stage Amt.');
    $sheet->setCellValue('S5', 'Stage 1');
    $sheet->setCellValue('T5', 'Stage 2');
    $sheet->setCellValue('U5', 'Stage 3');
    $sheet->setCellValue('V5', 'Stage 4');
    $sheet->setCellValue('W5', 'Stage 5');
    $sheet->mergeCells('X4:AB4'); 
    $sheet->setCellValue('X4', 'Invoice Amount');
    $sheet->setCellValue('X5', 'Stage 1');
    $sheet->setCellValue('Y5', 'Stage 2');
    $sheet->setCellValue('Z5', 'Stage 3');
    $sheet->setCellValue('AA5', 'Stage 4');
    $sheet->setCellValue('AB5', 'Stage 5');
    $sheet->mergeCells('AC4:AG4'); 
    $sheet->setCellValue('AC4', 'Payment Recieved');
    $sheet->setCellValue('AC5', 'Stage 1');
    $sheet->setCellValue('AD5', 'Stage 2');
    $sheet->setCellValue('AE5', 'Stage 3');
    $sheet->setCellValue('AF5', 'Stage 4');
    $sheet->setCellValue('AG5', 'Stage 5');

    $sheet->setCellValue('AH4', 'Total Invoice Raised');
    $sheet->setCellValue('AI4', 'Amount Recieved By Client');
    $sheet->setCellValue('AJ4', 'Outstanding Balance');

    $sheet->setCellValue('AK4','Application Start/End Date');
    // $sheet->setCellValue('AL4','Application End Date');
    $sheet->setCellValue('AL4','Admit Card Live Date');
    $sheet->setCellValue('AM4','Objection Mgmt. Start/End Date');
    // $sheet->setCellValue('AO4','Objection Management End Date');
    $sheet->setCellValue('AN4','CBT Date');
    $sheet->setCellValue('AO4','Result Submission Date');
    // $sheet->setCellValue('AJ3', 'Delay Reason');
    if($adminType==='Admin'){
        $sheet->setCellValue('AP4','Project Manager');
    }

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
        ],
    ]; 

    while (($res = mysqli_fetch_assoc($data))) {
        // Check if the serial number is even or odd
        $currentRowStyle = ($sNo % 2 == 0) ? $evenRowStyle : $oddRowStyle;

        // Apply the style to each cell in the row based on even or odd
        for ($col = 'A'; $col <= 'Z'; $col++) {
            $sheet->getStyle($col . $row)->applyFromArray($currentRowStyle);
            // Apply text wrapping for all columns
            $sheet->getStyle($col . '4:' . $col . $row)->getAlignment()->setWrapText(true);
        }
        $sheet->setCellValue('A'. $row, $sNo);
        $sheet->setCellValue('B'. $row, $res['ClientName']);
        $sheet->setCellValue('C'. $row, $res['NameOfProject']);
        $sheet->setCellValue('D'. $row, $res['Year']);
        setFormattedDateCellValue($sheet, 'E'. $row, $res['WorkOrderDate']);
        $sheet->setCellValue('F' . $row, ($res['Duration'] !== null ? $res['Duration'] . ' day' : ''));
        setFormattedDateCellValue($sheet, 'G'. $row, $res['SchedDateCompl']);
        $sheet->setCellValue('H'. $row, $res['Service']);
        $sheet->setCellValue('I'. $row, $res['PerCandRate'] !== null ? $res['PerCandRate'] : '');
        $sheet->setCellValue('J' . $row, formatNumberIndianStyle($res['ExpectCandCount']));
        $sheet->setCellValue('K' . $row, formatNumberIndianStyle($res['ExpectProjVal']));
        $sheet->setCellValue('L' . $row, formatNumberIndianStyle($res['ActualCandCount']));
        $sheet->setCellValue('M' . $row, formatNumberIndianStyle($res['ActualProjVal']));

        $sheet->setCellValue('N' . $row, isset($res['stg1pcnt']) ? $res['stg1pcnt'] : '');
        $sheet->setCellValue('O' . $row, isset($res['stg2pcnt']) ? $res['stg2pcnt'] : '');
        $sheet->setCellValue('P' . $row, isset($res['stg3pcnt']) ? $res['stg3pcnt'] : '');
        $sheet->setCellValue('Q' . $row, isset($res['stg4pcnt']) ? $res['stg4pcnt'] : '');
        $sheet->setCellValue('R' . $row, isset($res['stg5pcnt']) ? $res['stg5pcnt'] : '');

        $sheet->setCellValue('S' . $row, formatNumberIndianStyle(isset($res['stg1amt']) ? $res['stg1amt'] : ''));
        $sheet->setCellValue('T' . $row, formatNumberIndianStyle(isset($res['stg2amt']) ? $res['stg2amt'] : ''));
        $sheet->setCellValue('U' . $row, formatNumberIndianStyle(isset($res['stg3amt']) ? $res['stg3amt'] : ''));
        $sheet->setCellValue('V' . $row, formatNumberIndianStyle(isset($res['stg4amt']) ? $res['stg4amt'] : ''));
        $sheet->setCellValue('W' . $row, formatNumberIndianStyle(isset($res['stg5amt']) ? $res['stg5amt'] : ''));

        $sheet->setCellValue('X' . $row, formatNumberIndianStyle(isset($res['stg1InvAmt']) ? $res['stg1InvAmt'] : ''));
        $sheet->setCellValue('Y' . $row, formatNumberIndianStyle(isset($res['stg2InvAmt']) ? $res['stg2InvAmt'] : ''));
        $sheet->setCellValue('Z' . $row, formatNumberIndianStyle(isset($res['stg3InvAmt']) ? $res['stg3InvAmt'] : ''));
        $sheet->setCellValue('AA' . $row, formatNumberIndianStyle(isset($res['stg4InvAmt']) ? $res['stg4InvAmt'] : ''));
        $sheet->setCellValue('AB' . $row, formatNumberIndianStyle(isset($res['stg5InvAmt']) ? $res['stg5InvAmt'] : ''));
        
        $sheet->setCellValue('AC' . $row, formatNumberIndianStyle(isset($res['stg1pymntRcvd']) ? $res['stg1pymntRcvd'] : ''));
        $sheet->setCellValue('AD' . $row, formatNumberIndianStyle(isset($res['stg2pymntRcvd']) ? $res['stg2pymntRcvd'] : ''));
        $sheet->setCellValue('AE' . $row, formatNumberIndianStyle(isset($res['stg3pymntRcvd']) ? $res['stg3pymntRcvd'] : ''));
        $sheet->setCellValue('AF' . $row, formatNumberIndianStyle(isset($res['stg4pymntRcvd']) ? $res['stg4pymntRcvd'] : ''));
        $sheet->setCellValue('AG' . $row, formatNumberIndianStyle(isset($res['stg5pymntRcvd']) ? $res['stg5pymntRcvd'] : ''));
        
        $sheet->setCellValue('AH'. $row, formatNumberIndianStyle($res['InvAmtRaised']));
        $sheet->setCellValue('AI'. $row, formatNumberIndianStyle($res['AmntRcvdByClient']));
        $sheet->setCellValue('AJ'. $row, formatNumberIndianStyle($res['TotOutstndBal']));
       
        $sheet->setCellValue('AK'. $row, formatDualDate($res['AplicLivDate'], $res['AplicLiveEndDate']));
        // $sheet->setCellValue('AL'. $row, $res['AplicLiveEndDate']);
        $sheet->setCellValue('AL'. $row, formatMultipleDates($res['AdmitLivDate']));
        $sheet->setCellValue('AM'. $row, formatDualDate($res['ObjMngLiveDate'], $res['ObjMngEndDate']));
        // $sheet->setCellValue('AO'. $row, $res['ObjMngEndDate']);
        $sheet->setCellValue('AN'. $row, formatMultipleDates($res['CBTDate']));
        setFormattedDateCellValue($sheet, 'AO'. $row, $res['ResultSubmitDate']);
        // $sheet->setCellValue('AJ'. 'Delay Reason');
        if($adminType==='Admin'){
            $sheet->setCellValue('AP'.$row, $res['Name'] );
        }

        $row++;
        $sNo++;
    }

     // Create a new Xlsx writer
     $writer = new Xlsx($spreadsheet);

     // Save the Excel file to a temporary location
     $tempFilePath = tempnam(sys_get_temp_dir(), 'Project_data_');
     $writer->save($tempFilePath);
 
     // Close the database connection
     mysqli_close($conn);
 
     // Prompt the user to download the file and choose the directory
     header('Content-Type: application/octet-stream');
     
     header('Content-Disposition: attachment; filename="Project_data.xlsx"');
     header('Content-Length: ' . filesize($tempFilePath));
     readfile($tempFilePath);
 
     // Delete the temporary file
     unlink($tempFilePath);
    //  exit;

?>
<script>
    // Perform client-side redirection
    window.location.href = 'project_data.php';
</script>
<?php //}?>