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
        FROM tcsprojectdata prdata
        JOIN otasprcandcount count ON prdata.projid = count.projid
        JOIN tcscbtdata cbt ON count.projid=cbt.projid
        JOIN tcsresultdata res ON cbt.projid=res.projid
        Join client cl On prdata.ClientId=cl.ClientId
        LEFT JOIN userotasproject up ON prdata.projid = up.projid
        LEFT JOIN roles ro ON up.EmployeeId = ro.EmployeeId
        WHERE 
            (up.EmployeeId = $userId AND ro.UserRole = 'User')
            ORDER BY prdata.projid ASC";
    }
    elseif($adminType==='Admin')
    {
        $sql = "SELECT *
        FROM tcsprojectdata prdata
        JOIN otasprcandcount count ON prdata.projid = count.projid
        JOIN tcscbtdata cbt ON count.projid=cbt.projid
        JOIN tcsresultdata res ON cbt.projid=res.projid
        Join client cl On prdata.ClientId=cl.ClientId 
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

            function download(userId) {
                location.replace('generate-excel-data-tcs.php?userIdtcs=' + userId);
            }

            function closePopup() {
                var popup = document.getElementById('popup');
                popup.style.display = 'none';
                location.replace('project-data-tcs.php');
            }
        </script>

    </head>
    <body >
    <section class="home" >
            <div class="text" >
                <div id="popup" style="display: none;">
                    <div class="popup-content">
                        <p>Your file is ready for download!</p><br>
                        <!-- <p>And it wil save in D:\ drive </p> -->
                        <button onclick="download('<?php if($adminId){echo $adminId;} else{echo $userId;}?>')">Download</button>
                        <button onclick="closePopup()">Close</button>
                    </div>
                </div>
                <?php
                if ($total != 0) {
                    ?>
              
                    <table border="4">
                  
                    <thead style="background:scroll ;"> 
                        <tr>
                            <td colspan="100%"  class="thtr">TCS Project Data</td>
                            </tr>
                            <tr class="thead">
                                <th rowspan="2" class="thstyle">Sr. No.</th>
                                <th rowspan="2" class="thstyle">Client</th>
                                <th rowspan="2" class="thstyle">Name Of Project</th>
                                <th rowspan="2" class="thstyle">Year</th>
                                <th rowspan="2" class="thstyle">Work Order Date</th>
                                <th rowspan="2" class="thstyle">Project Duration</th>
                                <th rowspan="2" class="thstyle">Sched. Date Of Compl.</th>
                                <th rowspan="2" class="thstyle">Services</th>
                                <th rowspan="2" class="thstyle">Per Candidate Rate</th>
                                <th rowspan="2" class="thstyle">Expected Cand. Count</th>
                                <th rowspan="2" class="thstyle">Est. Project Val.</th>

                                <th rowspan="2" class="thstyle">Actual Candidate Count</th>
                                <th rowspan="2" class="thstyle" >Actual Project Value</th>

          

                                <th colspan="2" class="thstyle">Payment Stage(%)</th>
                                <th colspan="2" class="thstyle">Payment Stage (Amount)</th>
                                <th colspan="2" class="thstyle">Invoice Amount </th>
                                <th colspan="2" class="thstyle">Payment Done </th>
                                <!-- <th rowspan="2" class="thstyle"></th> -->
                                <th rowspan="2" class="thstyle">Total Payment Done</th>
                                <th rowspan="2" class="thstyle">Outstanding Balance</th>
                                <th rowspan="2" class="thstyle" colspan="2">Actions</th>
                            </tr>
                            <tr class="thead2" >
                                <th class="thstyle">CBT</th>
                                <th class="thstyle">Result</th>
                                <th class="thstyle">CBT</th>
                                <th class="thstyle">Result</th>
                                <th class="thstyle">CBT</th>
                                <th class="thstyle">Result</th>
                                <th class="thstyle">CBT</th>
                                <th class="thstyle">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $srNo = 1;
                                mysqli_data_seek($data, 0); 
                                while (($res = mysqli_fetch_assoc($data))) {
                                    $services = $res["Service"];
                                    $serviceschosen = explode(" ,", $services);
                                    $formattedExpectCandCount = formatNumberIndianStyle($res["ExpectCandCount"]);
                                    $formattedActualCanCount = formatNumberIndianStyle($res["ActualCandCount"]);
                                    $formattedExpectProjVal = formatNumberIndianStyle($res["ExpectedVal"]);
                                    $formattedActualProjVal = formatNumberIndianStyle($res["ActualVal"]);
                                    echo ' 
                                    <tr class="tr" >
                                        <td class="tdstyle">'. $srNo.'</td>
                                        <td class="tdstyle">'. $res["ClientName"].'</td>
                                        <td class="tdstyle">'. $res["NameOfProject"].'</td>
                                        <td class="tdstyle">'. $res["Year"].'</td>
                                        <td class="tdstyle">' ; 
                                            if ( ($WorkOrderDate = $res["WorkOrderDate"])!== '0000-00-00') {
                                                $formattedDate = date('d-m-Y', strtotime($WorkOrderDate));
                                                echo $formattedDate;
                                            } else {echo '';} echo '
                                        </td>
                                        <td class="tdstyle">'. ($res["Duration"] !== null ? $res["Duration"].' <span class="days-text">Days</span>' : '').'
                                        </td>
                                        <td class="tdstyle">' ; 
                                        if ( ($SchedDate = $res["SchedDateCompl"])!== '0000-00-00') {
                                            $formattedDate = date('d-m-Y', strtotime($SchedDate));
                                            echo $formattedDate;
                                        } else {echo '';} echo '
                                        </td>
                                        <td class="tdstyle">';
                                            if (count($serviceschosen) <= 1) {
                                                echo $res["Service"];
                                            } else {
                                                foreach ($serviceschosen as $service) {
                                                    echo $service.', ';
                                                }
                                            }echo '
                                        </td>
                                        <td class="tdstyle">'. ($res["PerCanRate"] !== null ? $res["PerCanRate"] : '').'</td>
                                        <td class="tdstyle">'. $formattedExpectCandCount.'</td>
                                        <td class="tdstyle">'.$formattedExpectProjVal.'</td>

                                        <td class="tdstyle">'. $formattedActualCanCount.'</td>
                                        <td class="tdstyle">'.$formattedActualProjVal.'</td>

                                        <td class="tdstyle">'.$res['cbtPcnt']."%".'</td>
                                        <td class="tdstyle">'.$res['resPcnt']."%".'</td>
                                        <td class="tdstyle">'.formatNumberIndianStyle($res['cbtPymntAmt']).'</td>
                                        <td class="tdstyle">'.formatNumberIndianStyle($res['resPymntAmt']).'</td>
                                        <td class="tdstyle">'.formatNumberIndianStyle($res['cbtInvAmt']).'</td>
                                        <td class="tdstyle">'.formatNumberIndianStyle($res['resInvAmt']).'</td>
                                        <td class="tdstyle">'.formatNumberIndianStyle($res['cbtPymntDone']).'</td>
                                        <td class="tdstyle">'.formatNumberIndianStyle($res['resPymntDone']).'</td>

                                        <td class="tdstyle">'. formatNumberIndianStyle(($res["TotPymntDone"] !== null ? $res["TotPymntDone"] : '')).'
                                        </td>
                                        <td class="tdstyle">'.formatNumberIndianStyle($res['OutstndBal']).'</td>
                                        <td >
                                            <form action="update-project-data-tcs.php" method="post">
                                                <input type="hidden" name="updateprojectdata" value="true">
                                                <input type="hidden" name="project_id1" value="'. $res["projid"].'">
                                                <input type="submit" class="updatebtn" value="Update Data">
                                            </form>

                                            <form action="payment-status-tcs.php" method="post">
                                                <input type="hidden" name="payment_status1" value="true">
                                                <input type="hidden" name="project_id1" value="'. $res["projid"].'">
                                                <input type="submit" class="pymntbtn" value="Payment Status">
                                            </form>
                                        
                                          
                                        </td> 
                                    </tr>';
                                    $srNo++;
                                }
                            ?>
                            <tr>
                                <td colspan="100%" class="tdxl" >
                                    <button onclick="showPopup()" class="exclbtngen">Generate and Download Excel File</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php }
                else{?>
                    <div class="no_data">
                        <div><h3> No Project Available </h3></div>&nbsp;&nbsp;
                        <div>
                            <p>Want to create project <a href='choose-client-tcs.php'>Click here</a></p>
                        </div>
                    </div>
                <?php }?>
            </div>
        </section>
    </body>
</html> 
  <!-- <form action="delete.php" method="post" onclick="return checkdelete()" >
                                                <input type="hidden" name="delTcsProject" value="true">
                                                <input type="hidden" name="project_id1" value="'. $res["projid"].'">
                                                <input type="submit" class="deletebtn" value="Delete" delete.php>
                                            </form> -->
<?php }?>