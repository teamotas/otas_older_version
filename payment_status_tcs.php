<?php
    include "connection.php";
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    if(isset($_POST['payment_status1']) && isset($_POST['project_id1'])) 
    {
        $prID = $_POST['project_id1']; 
        $_SESSION['update_pymnt_status1']=$prID;
        // echo "update_payment_direct ".$_SESSION['update_pymnt_status1'];
    }
    $prID=$_SESSION['update_pymnt_status1'];

    $q2 = "SELECT *
    FROM tcsprojectdata prdata
    JOIN otasprcandcount count ON prdata.projid = count.projid
    JOIN tcscbtdata cbt ON count.projid=cbt.projid
    JOIN tcsresultdata res ON cbt.projid=res.projid
    where prdata.projid='$prID'";
    $q21=mysqli_query($conn,$q2);
    $q22=mysqli_fetch_assoc($q21);
    $projectValue=$q22['ActualVal'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create | Project</title>
        <link rel="stylesheet" href="css/project.css">
    </head>
    <body>
        <section class="home">
            <div class="project-container " >
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" enctype="multipart/form-data"><h2>Payment Status</h2>
                    <?php
                    if(isset($_SESSION['update_pymnt_status1'])){
                        $prID=$_SESSION['update_pymnt_status1'];
                        // echo 'update_payment_direct'.$prID.$projectValue;
                        echo "Project Name"."  ->   ".$q22['NameOfProject'];
                    }
                    ?>
                    <input type="hidden" name="prID1" value="<?php echo $prID ?>">
                    <!-- <div>Project Name</div> -->
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Payment Stage(%)</span>
                        </div>
                        <div class="stage ">
                            <div class="pymnt1">
                            
                                <label for="cbtper" class='details'>CBT(%)</label>
                                <input type="number" name="cbtper" id="cbtper" class="input" style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                $cbtperValue = $q22['cbtPcnt'];
                                    echo ($cbtperValue !== null  || $cbtperValue !== 0) ? $cbtperValue : '';}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="resper" class='details'>Result(%)</label>
                                <input type="number" name="resper" id="resper" class="input" style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                echo $q22['resPcnt'];
                                }?>">
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Payment Stage (Amount)(In Rs.)</span>
                        </div>
                        <div class="stage ">
                            <div class="pymnt1">
                                <label for="cbtpymnt" class='details'>CBT</label>
                                <input type="text" name="cbtpymnt" id="cbtpymnt" class="input" readonly style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                    echo $q22['cbtPymntAmt'];
                                }?>">
                            </div>
                            <div class="pymnt1">
                                <label for="respymnt" class='details'>Result</label>
                                <input type="text" name="respymnt" id="respymnt" class="input" readonly style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                echo $q22['resPymntAmt'];
                                }?>">
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Invoice Stage</span>
                        </div>
                        <div>
                            <span class=' heading1 center'>CBT</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="stage ">
                                <div class="pymnt1">
                                    <label for="invnumcbt" class='details1'>Invoice Number</label>
                                    <input type="text" name="invnumcbt" id="invnumcbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtInvNum'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="invdatecbt" class='details1'>Invoice Date</label>
                                    <input type="date" name="invdatecbt" id="invdatecbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtInvDate'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="invamtcbt" class='details1'>Amount (In Rs.)</label>
                                    <input type="text" name="invamtcbt" id="invamtcbt" class="input" value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtInvAmt'];
                                    }?>">
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class=' heading1 center'>Result</span>
                            <div class="stage ">
                                <div class="pymnt1">
                                    <label for="invnumres" class='details1'>Invoice Number</label>
                                    <input type="text" name="invnumres" id="invnumres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){echo $q22['resInvNum'];}?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="invdateres" class='details1'>Invoice Date</label>
                                    <input type="date" name="invdateres" id="invdateres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){echo $q22['resInvDate'];}?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="invamtres" class='details1'>Amount (In Rs.)</label>
                                    <input type="text" name="invamtres" id="invamtres" class="input" value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){echo $q22['resInvAmt'];}?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="" class='details1' id="dark">Total Invoice Raised(In Rs.)</label>
                                    <input type="text" name="tcsinvraise" id="tcsinvraise" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){echo $q22['tcsInvRaised'];}?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>CBT Gross Payment Done</span>
                        </div>
                        <div>
                            <div class="stage ">
                                <div class="pymnt1">
                                    <label for="cbtPymnt1Done" class='details1'>Payment 1 Amt(In Rs.)</label>
                                    <input type="text" name="cbtPymnt1Done" id="cbtPymnt1Done" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtPDAmt1'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="CBTPymnt1Date" class='details1'>Payment 1 Date</label>
                                    <input type="date" name="CBTPymnt1Date" id="CBTPymnt1Date" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtPDDate1'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="cbtPymnt2Done" class='details1'>Payment 2 Amt(In Rs.)</label>
                                    <input type="text" name="cbtPymnt2Done" id="cbtPymnt2Done" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtPDAmt2'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="CBTPymnt2Date" class='details1'>Payment 2 Date</label>
                                    <input type="date" name="CBTPymnt2Date" id="CBTPymnt2Date" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtPDDate2'];
                                    }?>">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="stage ">
                                <div class="pymnt1">
                                    <label for="cbtPymnt3Done" class='details1'>Payment 3 Amt(In Rs.)</label>
                                    <input type="text" name="cbtPymnt3Done" id="cbtPymnt3Done" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtPDAmt3'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="CBTPymnt3Date" class='details1'>Payment 3 Date</label>
                                    <input type="date" name="CBTPymnt3Date" id="CBTPymnt3Date" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtPDDate3'];
                                    }?>">
                                </div>
                                <div class="pymnt1 input-container  ">
                                    <label for="cbtpymntdone" class='details ' id="dark">Total CBT Payment Done  (In Rs.)</label>
                                    <input type="text" name="cbtpymntdone" id="TotCBTPymtDone" class="input inputcon"  readonly  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['cbtPymntDone'];
                                    }?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Result Gross Payment Done </span>
                        </div>
                        <div>
                            <div class="stage ">
                                <div class="pymnt1">
                                    <label for="resPymnt1Done" class='details1'>Payment 1 Amt(In Rs.)</label>
                                    <input type="text" name="resPymnt1Done" id="resPymnt1Done" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['resPDAmt1'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="Respymnt1Date" class='details1'>Payment 1 Date</label>
                                    <input type="date" name="Respymnt1Date" id="Respymnt1Date" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['resPDDate1'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="resPymnt2Done" class='details1'>Payment 2 Amt(In Rs.)</label>
                                    <input type="text" name="resPymnt2Done" id="resPymnt2Done" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['resPDAmt2'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="Respymnt2Date" class='details1'>Payment 2 Date</label>
                                    <input type="date" name="Respymnt2Date" id="Respymnt2Date" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['resPDDate2'];
                                    }?>">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="stage ">
                                <div class="pymnt1">
                                    <label for="resPymnt3Done" class='details1'>Payment 3 Amt(In Rs.)</label>
                                    <input type="text" name="resPymnt3Done" id="resPymnt3Done" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['resPDAmt3'];
                                    }?>">
                                </div>
                                <div class="pymnt1">
                                    <label for="Respymnt3Date" class='details1'>Payment 3 Date</label>
                                    <input type="date" name="Respymnt3Date" id="Respymnt3Date" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['resPDDate3'];
                                    }?>">
                                </div>
                                <div class="pymnt1 input-container  ">
                                    <label for="respymntdone" class='details ' id="dark">Total Result Payment Done (In Rs.)</label>
                                    <input type="text" name="respymntdone" id="TotResPymtDone" class="input inputcon"  readonly  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                        echo $q22['resPymntDone'];
                                    }?>">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="stage  heading">
                            <div class="pymnt1 input-container  ">
                                <label for="totpymntdone" class='details ' id="dark">Total Payment Done(In Rs.)</label>
                                <input type="text" name="totpymntdone" id="totpymntdone" class="input inputcon"   readonly value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                    echo $q22['TotPymntDone'];
                                }?>">
                            </div>
                            <div class="pymnt1 input-container ">
                                <label for="OutstndBal" class='details ' id="dark">Outstanding Balance(In Rs.)</label>
                                <input type="text" name="OutstndBal" id="OutstndBal" readonly class="input inputcon"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) ){
                                    echo $q22['OutstndBal'];
                                }?>">
                            </div>
                        </div>
                    </div>
                    <span >
                        <input type="submit" value="Submit" name="submitpymnt" class="button  input">
                    </span>
                </form>
            </div>
            <script>var projectValue = <?php echo json_encode($projectValue); ?>;</script>
            <script defer src="js/payment_status_tcs.js"></script>
        </section>
    </body>
</html>
<?php
    if(isset($_POST['submitpymnt']))
    {  
        $prID=mysqli_real_escape_string($conn,$_POST['prID1']);
        // Payment Stage(%)
        $cbtper= mysqli_real_escape_string($conn,$_POST['cbtper']);
        $resper= mysqli_real_escape_string($conn,$_POST['resper']);
        // Payment Amount
        $cbtpymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['cbtpymnt']));
        $respymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['respymnt']));

        //cbt invoice data  = number  .date  .amount  .file
        $cbtinvnum= mysqli_real_escape_string($conn,$_POST['invnumcbt']);
        $cbtinvdate=mysqli_real_escape_string($conn,$_POST['invdatecbt']);
        $cbtinvamt=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['invamtcbt']));

        //result invoice data  = number  .date  .amount  .file
        $resinvnum= mysqli_real_escape_string($conn,$_POST['invnumres']);
        $resinvdate=mysqli_real_escape_string($conn,$_POST['invdateres']);
        $resinvamt=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['invamtres']));

        $cbtPymnt1Done=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['cbtPymnt1Done']));
        $cbtPymnt2Done=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['cbtPymnt2Done']));
        $cbtPymnt3Done=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['cbtPymnt3Done']));
       
        $CBTPymnt1Date=mysqli_real_escape_string($conn,$_POST['CBTPymnt1Date']);
        $CBTPymnt2Date=mysqli_real_escape_string($conn,$_POST['CBTPymnt2Date']);
        $CBTPymnt3Date=mysqli_real_escape_string($conn,$_POST['CBTPymnt3Date']);

        $resPymnt1Done=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['resPymnt1Done']));
        $resPymnt2Done=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['resPymnt2Done']));
        $resPymnt3Done=mysqli_real_escape_string($conn, str_replace(',', '',$_POST['resPymnt3Done']));
        
        $Respymnt1Date=mysqli_real_escape_string($conn,$_POST['Respymnt1Date']);
        $Respymnt2Date=mysqli_real_escape_string($conn,$_POST['Respymnt2Date']);
        $Respymnt3Date=mysqli_real_escape_string($conn,$_POST['Respymnt3Date']);

        $cbtpymntdone= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['cbtpymntdone']));
        $respymntdone= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['respymntdone']));

        //invoice raised->  total amount
        $tcsinvraise=mysqli_real_escape_string($conn, str_replace(',', '',$_POST["tcsinvraise"])) ;

        //Total Payment Done
        $totpymntdone= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['totpymntdone']));
        //Outstanding balance
        $OutstndBal=mysqli_real_escape_string($conn, str_replace(',', '',$_POST["OutstndBal"])) ;

        //------------------------------query start--------------------------------

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        // Query for updating tcscbtdata table
        $stmt = mysqli_prepare($conn, "UPDATE `tcscbtdata` SET `cbtPcnt`=?, `cbtPymntAmt`=?, `cbtInvNum`=?, `cbtInvAmt`=?, `cbtInvDate`=? ,`cbtPDAmt1`=?,`cbtPDDate1`=?,`cbtPDAmt2`=?,`cbtPDDate2`=?,`cbtPDAmt3`=?,`cbtPDDate3`=?, `cbtPymntDone`=? WHERE `projid`=?");
    
        // Check for prepared statement
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ddsdsdsdsdsds", $cbtper, $cbtpymnt, $cbtinvnum, $cbtinvamt, $cbtinvdate, $cbtPymnt1Done, $CBTPymnt1Date,  $cbtPymnt2Done, $CBTPymnt2Date,  $cbtPymnt3Done, $CBTPymnt3Date, $cbtpymntdone, $prID);
    
            // Execute the statement and check for success
            if (mysqli_stmt_execute($stmt)) {
                // Query for updating tcsresultdata table
                $stmt2 = mysqli_prepare($conn, "UPDATE `tcsresultdata` SET `resPcnt`=?, `resPymntAmt`=?, `resInvNum`=?, `resInvAmt`=?, `resInvDate`=? ,`resPDAmt1`=?,`resPDDate1`=?,`resPDAmt2`=?,`resPDDate2`=?,`resPDAmt3`=?,`resPDDate3`=?, `resPymntDone`=? WHERE `projid`=?");
    
                // Check for prepared statement
                if ($stmt2) {
                    mysqli_stmt_bind_param($stmt2, "ddsdsdsdsdsds", $resper, $respymnt, $resinvnum, $resinvamt, $resinvdate, $resPymnt1Done, $Respymnt1Date,  $resPymnt2Done, $Respymnt2Date,  $resPymnt3Done, $Respymnt3Date,  $respymntdone, $prID);
    
                    // Execute the statement and check for success
                    if (mysqli_stmt_execute($stmt2)) {
                        // Query for updating tcsprojectdata table
                        // Query for updating tcsprojectdata table
                        $stmt3 = mysqli_prepare($conn, "UPDATE `tcsprojectdata` SET `tcsInvRaised`=?, `TotPymntDone`=?, `OutstndBal`=? WHERE `projid`=?");

                        // Check for prepared statement
                        if ($stmt3) {
                            mysqli_stmt_bind_param($stmt3, "ddds", $tcsinvraise, $totpymntdone, $OutstndBal, $prID);

                            // Execute the statement and check for success
                            if (mysqli_stmt_execute($stmt3)) {
                                echo "<script>alert('Data Updated successfully.');</script>";
                                ?><meta http-equiv="refresh" content="0; url=project_data_tcs.php"><?php
                                exit();
                            } else {
                                echo "Error updating tcsprojectdata table: " . mysqli_error($conn);
                            }
                            mysqli_stmt_close($stmt3);
                        } else {
                            echo "Error preparing tcsprojectdata update statement: " . mysqli_error($conn);
                        }

                    } else {
                        echo "Error updating tcsresultdata table: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt2);
                } else {
                    echo "Error preparing tcsresultdata update statement: " . mysqli_error($conn);
                }
            } else {
                echo "Error updating tcscbtdata table: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing tcscbtdata update statement: " . mysqli_error($conn);
        }
    
        // Close the database connection
        mysqli_close($conn);
    }
    ?>
    <?php }?>