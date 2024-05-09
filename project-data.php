<?php
    include "connection.php";
    include "js/format.php";
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    if($userType==='User'){
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
            (up.EmployeeId = $userId AND ro.UserRole = 'User')
        ORDER BY prdata.projid ASC";
    }
    elseif($adminType==='Admin')
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
        ORDER BY `prdata`.`projid` ASC";       
    }
    
    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Project|Data</title>
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" href="css/popup.css">
        <script>
        function showPopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'block';
        }

        function download(Id) {
            location.replace('generate-excel-data.php?Id=' +Id);
        }

        function closePopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'none';
            location.replace('project-data.php');
        }
        </script>
    </head>
    <body>
        <section class="home" >
            <div id="popup" style="display: none;">
                <div class="popup-content">
                <p>Your file is ready for download!</p><br>
                <p>And it wil save in D:\ drive </p>
                <button onclick="download('<?php if($adminId){echo $adminId;} else{echo $userId;}?>')">Download</button>
                <button onclick="closePopup()">Close</button>
                </div>
            </div>
            <div class="card1">
            <?php if ($total != 0) {?>
                <table border="4">
                    <thead > 
                        <tr>
                            <td colspan="100%"  class="thtr">Project Data</td>
                        </tr>
                        <tr class="thead">
                            <th rowspan="2" class="thstyle">Sr. No.</th>
                            <th rowspan="2" class="thstyle">Client Name</th>
                            <th rowspan="2" class="thstyle">Name Of Project</th>
                            <th rowspan="2" class="thstyle">Work Order Date</th>
                            <th rowspan="2" class="thstyle">Project Duration</th>
                            <th rowspan="2" class="thstyle">Sched. Compl. Date</th>
                            <th rowspan="2" class="thstyle">Services</th>
                            <th rowspan="2" class="thstyle">Per Cand. Rate(In Rs.)</th>
                            <th rowspan="2" class="thstyle">Exp. Cand. Count</th>
                            <th rowspan="2" class="thstyle">Exp. Project Val.</th>
                            <th rowspan="2" class="thstyle">Actual Cand. Count</th>
                            <th rowspan="2" class="thstyle">Actual Project Val.</th>
                            <th rowspan="2" class="thstyle">Application Start Date</th>
                            <th rowspan="2" class="thstyle">Application End Date</th>
                            <th rowspan="2" class="thstyle">Admit Card Live Date</th>
                            <th rowspan="2" class="thstyle">CBT Date</th>   
                            <th rowspan="2" class="thstyle">Obj. Mngmt. Date(Start/End)</th>
                            <th rowspan="2" class="thstyle">Result Submission</th>
                            <th colspan="5" class="thstyle ">Payment Stage(%)</th>
                            <th colspan="5" class="thstyle ">Payment Stage (Amount)</th>
                            <th colspan="5" class="thstyle ">Invoice Amount</th>
                            <th colspan="5" class="thstyle  ">Payment Received</th>
                            <th rowspan="2" class="thstyle">Outstanding Balance</th>
                            <!-- <th class="thstyle">Delay Reason</th> -->
                            <th class="thstyle" rowspan="2">Actions</th>
                        </tr>
                        <tr class="thead2" >
                            <th class="thstyle even">Stage 1</th>
                            <th class="thstyle even">Stage 2</th>
                            <th class="thstyle even">Stage 3</th>
                            <th class="thstyle even">Stage 4</th>
                            <th class="thstyle even">Stage 5</th>
                            <th class="thstyle odd">Stage 1</th>
                            <th class="thstyle odd">Stage 2</th>
                            <th class="thstyle odd">Stage 3</th>
                            <th class="thstyle odd">Stage 4</th>
                            <th class="thstyle odd">Stage 5</th>
                            <th class="thstyle even">Stage 1</th>
                            <th class="thstyle even">Stage 2</th>
                            <th class="thstyle even">Stage 3</th>
                            <th class="thstyle even">Stage 4</th>
                            <th class="thstyle even">Stage 5</th>
                            <th class="thstyle odd">Stage 1</th>
                            <th class="thstyle odd">Stage 2</th>
                            <th class="thstyle odd">Stage 3</th>
                            <th class="thstyle odd">Stage 4</th>
                            <th class="thstyle odd">Stage 5</th>
                        </tr>
                    </thead>
                    <?php
                        $srNo = 1;
                        mysqli_data_seek($data, 0); // Reset data pointer to the beginning
                        while (($res = mysqli_fetch_assoc($data))) {
                            $services = $res["Service"];
                            $serviceschosen = explode(" ,", $services);
                            echo '
                            <tr class="tr" >
                                <td class="tdstyle" >' . $srNo . '</td>
                                <td class="tdstyle" >' . $res["ClientName"] . '</td>
                                <td class="tdstyle" >' . $res["NameOfProject"] . '</td>
                                <td class="tdstyle">' ; 
                                    if ( ($WorkOrderDate = $res["WorkOrderDate"])!== '0000-00-00') {
                                        $formattedDate = date('d-m-Y', strtotime($WorkOrderDate));
                                        echo $formattedDate;} else { echo '';} echo '</td>
                                <td class="tdstyle">' . ($res["Duration"] !== null ? $res["Duration"].' <span   class="days-text">Days</span>' : '') . '</td>
                                <td class="tdstyle">' ; 
                                if ( ($SchedDate = $res["SchedDateCompl"])!== '0000-00-00') {
                                    $formattedDate = date('d-m-Y', strtotime($SchedDate));
                                    echo $formattedDate;
                                } else {echo '';} echo '</td>
                                <td class="tdstyle">';
                                    if (count($serviceschosen) <= 1) { echo $res["Service"];} 
                                    else {foreach ($serviceschosen as $service) { echo $service . ', ';}}
                                    echo '</td>
                                <td class="tdstyle">' . formatNumberIndianStyle($res["PerCandRate"]) . '</td>
                                <td class="tdstyle">' . formatNumberIndianStyle($res["ExpectCandCount"]) . '</td>
                                <td class="tdstyle">' . formatNumberIndianStyle($res["ExpectProjVal"]) . '</td>
                                <td class="tdstyle">' . formatNumberIndianStyle($res["ActualCandCount"]) . '</td>
                                <td class="tdstyle">' . formatNumberIndianStyle($res["ActualProjVal"]) . '</td>

                                <td class="tdstyle">' ; 
                                    if ( ($AplicLivDate = $res["AplicLivDate"])!== '0000-00-00') {
                                        $formattedDate = date('d-m-Y', strtotime($AplicLivDate));
                                        echo $formattedDate;
                                    } else {echo '';} echo '</td>
                                <td class="tdstyle">' ; 
                                    if ( ($AplicLivEndDate = $res["AplicLiveEndDate"])!== '0000-00-00') {
                                        $formattedDate = date('d-m-Y', strtotime($AplicLivEndDate));
                                        echo $formattedDate;
                                    } else {echo '';} echo '</td>
                                
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
                                    $formattedDate = ($res["ObjMngLiveDate"] !== '0000-00-00') ? date('d-m-Y', strtotime($res["ObjMngLiveDate"])) : '';
                                    $formattedDate2 = ($res["ObjMngEndDate"] !== '0000-00-00') ? date('d-m-Y', strtotime($res["ObjMngEndDate"])) : '';
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
                                <td class="tdstyle">' ; 
                                    if ( $res["ResultSubmitDate"]!== '0000-00-00') {                
                                        $formattedDate2 = ($res["ResultSubmitDate"] !== '0000-00-00') ? date('d-m-Y', strtotime($res["ResultSubmitDate"])) : '';
                                        echo $formattedDate2;
                                    } else { echo '';
                                    } echo '</td>
                                <td class="tdstyle" >' . $res['stg1pcnt']  .'%'. '</td>
                                <td class="tdstyle" >' . $res['stg2pcnt']  .'%'. '</td>
                                <td class="tdstyle" >' . $res['stg3pcnt']  .'%'. '</td>
                                <td class="tdstyle" >' . $res['stg4pcnt']  .'%'. '</td>
                                <td class="tdstyle" >' . $res['stg5pcnt']  .'%'. '</td>

                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg1amt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg2amt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg3amt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg4amt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg5amt']) . '</td>

                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg1InvAmt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg2InvAmt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg3InvAmt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg4InvAmt']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg5InvAmt']) . '</td>
                                
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg1pymntRcvd']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg2pymntRcvd']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg3pymntRcvd']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg4pymntRcvd']) . '</td>
                                <td class="tdstyle" >' . formatNumberIndianStyle($res['stg5pymntRcvd']) . '</td>

                                <td class="tdstyle">' . ($res["TotOutstndBal"] !== null ? $res["TotOutstndBal"] : '') . '</td>
                                <td>
                                    <form action="update-project-data.php" method="post">
                                        <input type="hidden" name="updateprojectdata" value="true">
                                        <input type="hidden" name="project_id" value="' . $res["projid"] . '">
                                        <input type="submit" class="updatebtn" value="Update Data">
                                    </form>

                                    <form action="payment-status.php" method="post">
                                        <input type="hidden" name="payment_status" value="true">
                                        <input type="hidden" name="project_id" value="' . $res["projid"] . '">
                                        <input type="submit" class="pymntbtn" value="Payment Status">
                                    </form>
                                    

                        
                                </td> 
                            </tr>';
                            $srNo++;
                        }?>
                    <tr>
                        <td colspan="100%" class="tdxl" >
                            <button onclick="showPopup()" class="exclbtngen">Generate and Download Excel File</button>
                        </td>
                    </tr>
                </table>
                <?php
            }
            else {?>
                <div class="no_data">
                    <div><h3> No Project Available </h3></div>&nbsp;&nbsp;
                    <div>
                        <p>Want to create project <a href='choose-client.php'>Click here</a></p>
                    </div>
                </div>
            <?php }?>
            </div>
        </section>
    </body>
</html>
<!-- <form action="delete.php" method="post" onclick="return checkdelete()" >
                                        <input type="hidden" name="delProject" value="true">
                                        <input type="hidden" name="project_id" value="' . $res["projid"] . '">
                                        <input type="submit" class="deletebtn" value="Delete" delete.php >
                                    </form> -->
<?php }?>