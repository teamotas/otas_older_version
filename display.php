<?php
include "connection.php";
include "js/format.php";

error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
session_start();

$sql =  "SELECT *
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
ORDER BY `prdata`.`projid` ASC";
// where `Status`='Ongoing'
$data = mysqli_query($conn, $sql);
$total = mysqli_num_rows($data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="photos\images.png"/>
    <title>Project Status</title>
    <link rel="stylesheet" href="css/display-table.css">
    <style></style>
</head>
<body>
<div class="slider">
    <div class="list">
        <div class="item">
            <main class="table">
                <section class="table__header">
                    <h1 style="color: white; font-size: 25px;">Online Application Status</h1>
                </section>
                <section class="table__body">
                    <table>
                        <thead>
                            <tr >
                                <th> Sr. No. </th>
                                <th> Client Name </th>
                                <th> Project Name </th>
                                <th> Application Start Date </th>
                                <th> Application End Date </th>
                                <th> Candidate Count </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $srNo = 1;
                            mysqli_data_seek($data, 0); 
                            while (($res = mysqli_fetch_assoc($data))) {
                        
                                $formattedExpectCandCount = formatNumberIndianStyle($res["ExpectCandCount"]);
                                $formattedActualCanCount = formatNumberIndianStyle($res["ActualCandCount"]);
                                
                                echo '
                                <tr >
                                    <td >' . $srNo . '</td>
                                    <td >' . $res["ClientName"] . '</td>
                                    <td >' . $res["NameOfProject"] . '</td>
                                    <td >' ; 
                                        if ( ($AplicLivDate = $res["AplicLivDate"])!== '0000-00-00') {
                                            $formattedDate =formatDate($res["AplicLivDate"]);
                                            echo $formattedDate;
                                        } else {
                                            echo '';
                                        } 
                                        echo'</td>
                                    <td >' ; 
                                        if ( ($AplicLiveEndDate = $res["AplicLiveEndDate"])!== '0000-00-00') {
                                            $formattedDate =formatDate($res["AplicLiveEndDate"]);
                                            echo $formattedDate;
                                        } else {
                                            echo '';
                                        } 
                                        echo'</td>    
                                    <td >' . $formattedActualCanCount . '</td>
                                ';
                                $srNo++;
                            }
                            ?>
                            
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
        <div class="item">
            <main class="table">
                <section class="table__header">
                    <h1 style="color: white; font-size: 25px;">Admit Card Live  & CBT Live Status</h1>
                </section>
                <section class="table__body">
                    <table>
                        <thead>
                            <tr >
                                <th> Sr. No. </th>
                                <th> Client Name </th>
                                <th> Project Name </th>
                                <th> Admit Card Live Date </th> 
                                <th> CBT Dates </th>
                                <!-- <th> CBT End Date </th> -->
                                <th> Objection Mgmt. Sched.(Start/End)</th>
                                <!-- <th> Tcs Developer </th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $srNo = 1;
                                mysqli_data_seek($data, 0); // Reset data pointer to the beginning
                                while (($res = mysqli_fetch_assoc($data))) {
 
                                    echo '
                                    <tr >
                                    <td >' . $srNo . '</td>
                                    <td >' . $res["ClientName"] . '</td>
                                    <td >' . $res["NameOfProject"] . '</td>
                                    <td class="tdstyle">' ; 
                                    if (($AdmitLivDate = $res["AdmitLivDate"])!== '0000-00-00') {
                                        $cleaned_dates = stripslashes($res['AdmitLivDate']);
                                        $cleaned_dates = trim($cleaned_dates, '"');
                                        $dates = explode(', ', $cleaned_dates);
                                        if (!empty($dates)) {
                                            $formatted_dates = implode(", ", $dates);
                                            echo $formatted_dates;
                                        }}
                                        else {
                                            echo '';
                                        } 
                                        echo '</td>
                                    <td class="tdstyle">' ; 
                                    if (($CBTDate = $res["CBTDate"])!== '0000-00-00') {
                                        $cleaned_dates = stripslashes($res['CBTDate']);
                                        $cleaned_dates = trim($cleaned_dates, '"');
                                        $dates = explode(', ', $cleaned_dates);
                                        if (!empty($dates)) {
                                            $formatted_dates = implode(", ", $dates);
                                            echo $formatted_dates;
                                        }}
                                    else {
                                        echo '';
                                    }   echo '</td>

                                    <td class="tdstyle">' ; 
                                    if ($res["ObjMngLiveDate"] !== '0000-00-00' || $res["ObjMngEndDate"] !== '0000-00-00') {
                                        $formattedDate = ($res["ObjMngLiveDate"] !== '0000-00-00') ? formatDate($res["ObjMngLiveDate"]) : '';
                                        $formattedDate2 = ($res["ObjMngEndDate"] !== '0000-00-00') ? formatDate($res["ObjMngEndDate"]) : '';
                                        
                                        if ($formattedDate && $formattedDate2) {
                                            echo $formattedDate . "/" . $formattedDate2;
                                        } elseif ($formattedDate) {
                                            echo $formattedDate . "/";
                                        } elseif ($formattedDate2) {
                                            echo "/" . $formattedDate2;
                                        } else {
                                            echo '';
                                        }
                                    } else {
                                        echo '';
                                    } echo '</td>
                                    ';
                                    $srNo++;
                                } 
                            ?>
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>
    <div class="buttons">
        <button id="prev"><</button>
        <button id="next">></button>
    </div>
    <ul class="dots">
        <li class="active"></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<script defer src="js/display.js"></script>
</body>
</html>

 