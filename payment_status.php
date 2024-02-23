<?php
    include "connection.php";
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    if(isset($_POST['payment_status'])){
        if (isset($_POST['project_id'])){
            $prID = $_POST['project_id']; 
            $_SESSION['update_pymnt_status']=$prID;
            // echo $_SESSION['update_pymnt_status'];
        }
    }
    $sql="SELECT * 
        FROM otasprojectdata prdata
        JOIN otasprojval prval ON prdata.projid=prval.projid
        JOIN stg1pymntdetail stg1 ON prval.projid=stg1.projid
        JOIN stg2pymntdetail stg2 ON stg1.projid=stg2.projid
        JOIN stg3pymntdetail stg3 ON stg2.projid=stg3.projid
        JOIN stg4pymntdetail stg4 ON stg3.projid=stg4.projid
        JOIN stg5pymntdetail stg5 ON stg4.projid=stg5.projid
        where prdata.projid='$prID'";
    
    $data = mysqli_query($conn, $sql);
    // $total = mysqli_num_rows($data);
    $q22=mysqli_fetch_assoc($data);


    
    $ExpProjVal=$q22['ExpectProjVal'];
    $ActprojectValue=$q22['ActualProjVal'];
    
    if (!empty($ExpProjVal) && empty($ActprojectValue)) {
        // If ExpProjVal is present and ActprojectValue is not present
        $projectVal = $ExpProjVal;
    } elseif (empty($ExpProjVal) && !empty($ActprojectValue)) {
        // If ExpProjVal is not present and ActprojectValue is present
        $projectVal = $ActprojectValue;
    } elseif (!empty($ExpProjVal) && !empty($ActprojectValue)) {
        // If both ExpProjVal and ActprojectValue are present
        $projectVal = $ActprojectValue;
    } else {
        // If neither ExpProjVal nor ActprojectValue is present 
        $projectVal = null; 
    }
 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create | Project</title>
        <link rel="stylesheet" href="css/project.css">
        <link rel="stylesheet" href="css/stages.css">
        <!-- <script defer src="js/payment_status.js"></script> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <style>
           #InvAmtRaised{
                width: 27.5rem;
           }
           .xtra-margin{
            margin-top: 10rem;
           }
        </style>
    </head>
    <body >
        <section class="home">
            <div class="project-container project-container1 xtra-margin" >
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" enctype="multipart/form-data">
                 <h2>Payment Status</h2>
                    <?php
                        if(isset($_SESSION['update_pymnt_status'])){
                            $prID=$_SESSION['update_pymnt_status'];
                            // echo $projectVal;
                            // echo $q22['stg1name'];
                            echo "Project Name"."  ->   ".$q22['NameOfProject'];
                        }
                    ?>
                    <input type="hidden" name="prID" value="<?php echo $prID?>">
                    <!-- <div class="payment-details input-container">
                        <div class="">
                            <span class='heading'>Project ID</span>
                        </div>
                        <input type="text" name="" id="" class="input"  readonly value="<?php //if(isset($_SESSION['update_pymnt_status'])){echo $prID;}?>">
                    </div> -->
                    <div class="payment-details " >
                        <div class="">
                            <span class='heading'>Payment Stage(%)</span>
                        </div>
                        <div class="stage" >
                            <div class="pymnt1">
                                <label for="stage1" class='details'>Stage 1</label>
                                <div class="custom-dropdown " id="dropdown1">
                                    <div class="selected-items" >Select Stage</div>
                                    <div class="dropdown-content" >
                                        <input type="hidden" id="stageval1" name="stageval1" value="<?php echo $q22['stg1name']?>">
         
                                    </div>
                                </div>
                            </div>
                            <div class="pymnt1">
                                <label for="stage2" class='details'>Stage 2</label>
                                <div class="custom-dropdown " id="dropdown2">
                                    <div class="selected-items" >Select Stage</div>
                                    <div class="dropdown-content" >
                                    <input type="hidden" id="stageval2" name="stageval2">
                                    </div>
                                </div>
                            </div>
                            <div class="pymnt1">
                                <label for="stage3" class='details'>Stage 3</label>
                                <div class="custom-dropdown " id="dropdown3">
                                    <div class="selected-items" >Select Stage</div>
                                    <div class="dropdown-content" >
                                    <input type="hidden" id="stageval3" name="stageval3">
                                    </div>
                                </div>
                            </div>
                            <div class="pymnt1">
                                <label for="stage4" class='details'>Stage 4</label>
                                <div class="custom-dropdown " id="dropdown4">
                                    <div class="selected-items" >Select Stage</div>
                                    <div class="dropdown-content" >
                                    <input type="hidden" id="stageval4" name="stageval4">
                                    </div>
                                </div>
                            </div>
                            <div class="pymnt1">
                                <label for="stage5" class='details'>Stage 5</label>
                                <div class="custom-dropdown " id="dropdown5">
                                    <div class="selected-items" >Select Stage</div>
                                    <div class="dropdown-content" >
                                    <input type="hidden" id="stageval5" name="stageval5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="stage " id="stagechosen ">
                            <div class="pymnt1" id="stage1">
                                <label for="stage1pcnt" class='details  heading1'>Stage 1%</label>
                                <input type="number" class="input" name="stg1pcnt" id="stage1pcnt"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1pcnt'];}else{echo "";}?>">
                            </div>
                            <div class="pymnt1" id="stage2">
                                <label for="stage2pcnt" class='details  heading1'>Stage 2%</label>
                                <input type="number" class="input" name="stg2pcnt" id="stage2pcnt"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2pcnt'];}else{echo "";}?>">
                            </div>
                            <div class="pymnt1" id="stage3">
                                <label for="stage3pcnt" class='details  heading1'>Stage 3%</label>
                                <input type="number" class="input" name="stg3pcnt" id="stage3pcnt"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3pcnt'];}else{echo "";}?>">
                            </div>
                            <div class="pymnt1" id="stage4">
                                <label for="stage4pcnt" class='details  heading1'>Stage 4%</label>
                                <input type="number" class="input" name="stg4pcnt" id="stage4pcnt"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4pcnt'];}else{echo "";}?>">
                            </div>
                            <div class="pymnt1" id="stage5">
                                <label for="stage5pcnt" class='details  heading1'>Stage 5%</label>
                                <input type="number" class="input" name="stg5pcnt" id="stage5pcnt"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5pcnt'];}else{echo "";}?>">
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Payment Stage (Amount) (In Rs.)</span>
                        </div>
                        <div class="stage ">
                            <div class="pymnt1">
                                <label for="stg1amt" class='details'>Stage 1</label>
                                <input type="text" name="stg1amt" id="stg1amt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1amt'];}else{echo "";}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg2amt" class='details '>Stage 2</label>
                                <input type="text" name="stg2amt" id="stg2amt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2amt'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg3amt" class='details'>Stage 3</label>
                                <input type="text" name="stg3amt" id="stg3amt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3amt'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg4amt" class='details'>Stage 4</label>
                                <input type="text" name="stg4amt" id="stg4amt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4amt'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg5amt" class='details'>Stage 5</label>
                                <input type="text" name="stg5amt" id="stg5amt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5amt'];}?>">
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Invoice Amount </span>
                        </div>
<!-- Stage 1 -->
                        <div class="stage ">
                            <span class=' heading1'>Stage 1</span>
                            <div class="pymnt1">
                                <label for="stg1InvNum" class='details1'>Invoice Number</label>
                                <input type="text" name="stg1InvNum" id="stg1InvNum" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1InvNum'];}?>" >
                            </div>
                            <div class="pymnt1">
                                <label for="stg1InvDate" class='details1'>Invoice Date</label>
                                <input type="date" name="stg1InvDate" id="stg1InvDate" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1InvDate'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg1InvAmt" class='details1'>Amount (In Rs.)</label>
                                <input type="text" name="stg1InvAmt" id="stg1InvAmt" class="input" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1InvAmt'];}?>" >
                            </div>
                        </div>
<!-- Stage 2 -->
                        <div class="stage ">
                            <span class=' heading1'>Stage 2</span>
                            <div class="pymnt1">
                                <label for="stg2InvNum" class='details1'>Invoice Number</label>
                                <input type="text" name="stg2InvNum" id="stg2InvNum" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2InvNum'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg2InvDate" class='details1'>Invoice Date</label>
                                <input type="date" name="stg2InvDate" id="stg2InvDate" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2InvDate'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg2InvAmt" class='details1'>Amount (In Rs.)</label>
                                <input type="text" name="stg2InvAmt" id="stg2InvAmt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2InvAmt'];}?>" >
                            </div>
                        </div>
<!-- Stage 3 -->
                        <div class="stage ">
                            <span class=' heading1'>Stage 3</span>
                            <div class="pymnt1">
                                <label for="stg3InvNum" class='details1'>Invoice Number</label>
                                <input type="text" name="stg3InvNum" id="stg3InvNum" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3InvNum'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg3InvDate" class='details1'>Invoice Date</label>
                                <input type="date" name="stg3InvDate" id="stg3InvDate" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3InvDate'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg3InvAmt" class='details1'>Amount (In Rs.)</label>
                                <input type="text" name="stg3InvAmt" id="stg3InvAmt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3InvAmt'];}?>" >
                            </div>
                            <div class="pymnt1" >
                            <label for="InvAmtRaised" class='details '>Total Raised Invoice Amount (In Rs.)</label>
                                <input type="text" name="InvAmtRaised" id="InvAmtRaised" class="input "   value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['InvAmtRaised'];}?>" >
                            </div>
                        </div>
<!-- Stage 4 -->
                        <div class="stage ">
                            <span class=' heading1'>Stage 4</span>
                            <div class="pymnt1">
                                <label for="stg4InvNum" class='details1'>Invoice Number</label>
                                <input type="text" name="stg4InvNum" id="stg4InvNum" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4InvNum'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg4InvDate" class='details1'>Invoice Date</label>
                                <input type="date" name="stg4InvDate" id="stg4InvDate" class="input" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4InvDate'];}?>" >
                            </div>
                            <div class="pymnt1">
                                <label for="stg4InvAmt" class='details1'>Amount (In Rs.)</label>
                                <input type="text" name="stg4InvAmt" id="stg4InvAmt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4InvAmt'];}?>" >
                            </div>
                        </div>
<!-- Stage 5 -->
                        <div class="stage ">
                            <span class=' heading1'>Stage 5</span>
                            <div class="pymnt1">
                                <label for="stg5InvNum" class='details1'>Invoice Number</label>
                                <input type="text" name="stg5InvNum" id="stg5InvNum" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5InvNum'];}?>">
                            </div>
                            <div class="pymnt1">
                                <label for="stg5InvDate" class='details1'>Invoice Date</label>
                                <input type="date" name="stg5InvDate" id="stg5InvDate" class="input" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5InvDate'];}?>" >
                            </div>
                            <div class="pymnt1">
                                <label for="stg5InvAmt" class='details1'>Amount (In Rs.)</label>
                                <input type="text" name="stg5InvAmt" id="stg5InvAmt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5InvAmt'];}?>" >
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Payment Recieved (In Rs.)</span>
                        </div>
                        <div class="stage ">
                            <!-- <div class=""> -->
                                <span class='heading1'> Stage1</span>
                            <!-- </div> -->
                            <div class="pymnt1">
                                <label for="stg1pymntRcvd" class='details'>Payment Recieved</label>
                                <input type="text" class="input"  name="stg1pymntRcvd" id="stg1pymntRcvd" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1pymntRcvd'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg1NetPymnt" class='details '>Net Payment (A)</label>
                                <input type="number" class="input" name="stg1NetPymnt" id="stg1NetPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1NetPymnt'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg1TDS" class='details '>TDS (B)</label>
                                <input type="number" class="input" name="stg1TDS" id="stg1TDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1TDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg1GstTDS" class='details '>GST TDS (C)</label>
                                <input type="number" class="input" name="stg1GstTDS" id="stg1GstTDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1GstTDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg1GrossPymnt" class='details '>Gross Amt(A+B+C)</label>
                                <input type="number" class="input" name="stg1GrossPymnt" id="stg1GrossPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg1GrossPymnt'];}?>">
                            </div>
                        </div>
                        <div class="stage ">
                            <!-- <div class=""> -->
                                <span class='heading1'> Stage2</span>
                            <!-- </div> -->
                            <div class="pymnt1">
                                <label for="stg2pymntRcvd" class='details'>Payment Recieved</label>
                                <input type="text" name="stg2pymntRcvd" id="stg2pymntRcvd" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2pymntRcvd'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg2NetPymnt" class='details '>Net Payment (A)</label>
                                <input type="number" class="input" name="stg2NetPymnt" id="stg2NetPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2NetPymnt'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg2TDS" class='details '>TDS (B)</label>
                                <input type="number" class="input" name="stg2TDS" id="stg2TDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2TDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg2GstTDS" class='details '>GST TDS (C)</label>
                                <input type="number" class="input" name="stg2GstTDS" id="stg2GstTDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2GstTDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg2GrossPymnt" class='details '>Gross Amt(A+B+C)</label>
                                <input type="number" class="input" name="stg2GrossPymnt" id="stg2GrossPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg2GrossPymnt'];}?>">
                            </div>
                        </div>
                        <div class="stage ">
                            <!-- <div class=""> -->
                                <span class='heading1'> Stage3</span>
                            <!-- </div> -->
                            <div class="pymnt1">
                                <label for="stg3pymntRcvd" class='details'>Payment Recieved</label>
                                <input type="text" name="stg3pymntRcvd" id="stg3pymntRcvd" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3pymntRcvd'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg3NetPymnt" class='details '>Net Payment (A)</label>
                                <input type="number" class="input" name="stg3NetPymnt" id="stg3NetPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3NetPymnt'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg3TDS" class='details '>TDS (B)</label>
                                <input type="number" class="input" name="stg3TDS" id="stg3TDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3TDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg3GstTDS" class='details '>GST TDS (C)</label>
                                <input type="number" class="input" name="stg3GstTDS" id="stg3GstTDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3GstTDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg3GrossPymnt" class='details '>Gross Amt(A+B+C)</label>
                                <input type="number" class="input" name="stg3GrossPymnt" id="stg3GrossPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg3GrossPymnt'];}?>">
                            </div>
                        </div>
                        <div class="stage ">
                            <!-- <div class=""> -->
                                <span class='heading1'> Stage4</span>
                            <!-- </div> -->
                            <div class="pymnt1">
                                <label for="stg4pymntRcvd" class='details'>Payment Recieved</label>
                                <input type="text" name="stg4pymntRcvd" id="stg4pymntRcvd" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4pymntRcvd'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg4NetPymnt" class='details '>Net Payment (A)</label>
                                <input type="number" class="input" name="stg4NetPymnt" id="stg4NetPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4NetPymnt'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg4TDS" class='details '>TDS (B)</label>
                                <input type="number" class="input" name="stg4TDS" id="stg4TDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4TDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg4GstTDS" class='details '>GST TDS (C)</label>
                                <input type="number" class="input" name="stg4GstTDS" id="stg4GstTDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4GstTDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg4GrossPymnt" class='details '>Gross Amt(A+B+C)</label>
                                <input type="number" class="input" name="stg4GrossPymnt" id="stg4GrossPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg4GrossPymnt'];}?>">
                            </div>
                        </div>
                        <div class="stage ">
                            <!-- <div class=""> -->
                                <span class='heading1'> Stage5</span>
                            <!-- </div> -->
                            <div class="pymnt1">
                                <label for="stg5pymntRcvd" class='details'>Payment Recieved</label>
                                <input type="text" name="stg5pymntRcvd" id="stg5pymntRcvd" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5pymntRcvd'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg5NetPymnt" class='details '>Net Payment (A)</label>
                                <input type="number" class="input" name="stg5NetPymnt" id="stg5NetPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5NetPymnt'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg5TDS" class='details '>TDS (B)</label>
                                <input type="number" class="input" name="stg5TDS" id="stg5TDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5TDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg5GstTDS" class='details '>GST TDS (C)</label>
                                <input type="number" class="input" name="stg5GstTDS" id="stg5GstTDS" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5GstTDS'];}?>">
                            </div>
                            <div class="pymnt1" >
                                <label for="stg5GrossPymnt" class='details '>Gross Amt(A+B+C)</label>
                                <input type="number" class="input" name="stg5GrossPymnt" id="stg5GrossPymnt" value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['stg5GrossPymnt'];}?>">
                            </div>
                        </div>
                    </div>
                    <div class="payment-details ">
                        <div class="">
                            <span class='heading'>Total Payment Recieved</span>
                        </div>
                        <div class="stage" id="input1">
                            <div class="pymnt1 ">
                                <label for="Amountrcvd" class='details'>Amount Recieved from Client (In Rs.)</label>
                                <input type="text" name="AmntRcvdByClient" id="Amountrcvd" class="input input1"   readonly placeholder="Enter amount"   value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['AmntRcvdByClient'];}?>">
                            </div>
                            <div class="pymnt1 ">
                                <label for="TotOutstndBal" class='details'>Total Outstanding Balance (In Rs.)</label>
                                <input type="text" name="TotOutstndBal" id="TotOutstndBal" class="input input1" readonly    value="<?php  if(isset($_SESSION['update_pymnt_status'])){echo $q22['TotOutstndBal'];}?>">
                            </div>
                        </div>
                    </div>
                    <span >
                        <input type="submit" value="Submit" name="submitpymnt" class="button  input">
                    </span>
                </form>
            </div>
            <script>
                var projectValue = <?php echo json_encode($projectVal); ?>;
                var ExpectProjVal= <?php echo json_encode($ExpProjVal); ?>;
                var stg1name = "<?php echo $q22['stg1name']; ?>";
                var stg2name = "<?php echo $q22['stg2name']; ?>";
                var stg3name = "<?php echo $q22['stg3name']; ?>";
                var stg4name = "<?php echo $q22['stg4name']; ?>";
                var stg5name = "<?php echo $q22['stg5name']; ?>"; 
            </script>

            <script defer src="js/stages.js"></script>
            <script defer src="js/payment_status.js"></script>
            

        </section>
    </body>
</html>
<?php
    if(isset($_POST['submitpymnt'])){
        $prID=mysqli_real_escape_string($conn,$_POST['prID']);

        // echo $prID;
        // Stage Name
        $stg1name= mysqli_real_escape_string($conn,$_POST['stageval1']);
        $stg2name= mysqli_real_escape_string($conn,$_POST['stageval2']);
        $stg3name= mysqli_real_escape_string($conn,$_POST['stageval3']);
        $stg4name= mysqli_real_escape_string($conn,$_POST['stageval4']);
        $stg5name= mysqli_real_escape_string($conn,$_POST['stageval5']);

        // Payment Stage(%)
        $stg1pcnt= mysqli_real_escape_string($conn,$_POST['stg1pcnt']);
        $stg2pcnt= mysqli_real_escape_string($conn,$_POST['stg2pcnt']);
        $stg3pcnt= mysqli_real_escape_string($conn,$_POST['stg3pcnt']);
        $stg4pcnt= mysqli_real_escape_string($conn,$_POST['stg4pcnt']);
        $stg5pcnt= mysqli_real_escape_string($conn,$_POST['stg5pcnt']);

        // Payment Amount
        $stg1amt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg1amt']));
        $stg2amt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg2amt']));
        $stg3amt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg3amt']));
        $stg4amt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg4amt']));
        $stg5amt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg5amt'])); 

        //live invoice data  = number  .date  .amount  .file
        $stg1InvNum= mysqli_real_escape_string($conn,$_POST['stg1InvNum']);
        $stg1InvDate= mysqli_real_escape_string($conn,$_POST['stg1InvDate']);
        $stg1InvAmt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg1InvAmt']));
        
        $stg2InvNum= mysqli_real_escape_string($conn,$_POST['stg2InvNum']);
        $stg2InvDate= mysqli_real_escape_string($conn,$_POST['stg2InvDate']);
        $stg2InvAmt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg2InvAmt']));
        
        $stg3InvNum= mysqli_real_escape_string($conn,$_POST['stg3InvNum']);
        $stg3InvDate= mysqli_real_escape_string($conn,$_POST['stg3InvDate']);
        $stg3InvAmt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg3InvAmt']));
        
        $stg4InvNum= mysqli_real_escape_string($conn,$_POST['stg4InvNum']);
        $stg4InvDate= mysqli_real_escape_string($conn,$_POST['stg4InvDate']);
        $stg4InvAmt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg4InvAmt']));

        $stg5InvNum= mysqli_real_escape_string($conn,$_POST['stg5InvNum']);
        $stg5InvDate= mysqli_real_escape_string($conn,$_POST['stg5InvDate']);
        $stg5InvAmt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg5InvAmt']));
        
        //Payment Recieved By Client
        // stg 1
        $stg1pymntRcvd= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg1pymntRcvd']));
        $stg1NetPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg1NetPymnt']));
        $stg1TDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg1TDS']));
        $stg1GstTDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg1GstTDS']));
        $stg1GrossPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg1GrossPymnt']));

        $stg2pymntRcvd= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg2pymntRcvd']));
        $stg2NetPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg2NetPymnt']));
        $stg2TDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg2TDS']));
        $stg2GstTDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg2GstTDS']));
        $stg2GrossPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg2GrossPymnt']));

        $stg3pymntRcvd= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg3pymntRcvd']));
        $stg3NetPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg3NetPymnt']));
        $stg3TDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg3TDS']));
        $stg3GstTDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg3GstTDS']));
        $stg3GrossPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg3GrossPymnt']));

        $stg4pymntRcvd= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg4pymntRcvd']));
        $stg4NetPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg4NetPymnt']));
        $stg4TDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg4TDS']));
        $stg4GstTDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg4GstTDS']));
        $stg4GrossPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg4GrossPymnt']));

        $stg5pymntRcvd= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg5pymntRcvd']));
        $stg5NetPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg5NetPymnt']));
        $stg5TDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg5TDS']));
        $stg5GstTDS= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg5GstTDS']));
        $stg5GrossPymnt= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['stg5GrossPymnt']));

        //Total Payment Recieved by Client
        $InvAmtRaised= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['InvAmtRaised']));
        $AmntRcvdByClient= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['AmntRcvdByClient']));
        $TotOutstndBal= mysqli_real_escape_string($conn, str_replace(',', '',$_POST['TotOutstndBal']));

        //------------------------------query start--------------------------------
        // query1 for percentage
        $q1 = "UPDATE `stg1pymntdetail` SET `stg1name`=?,`stg1pcnt`=?,`stg1amt`=?,`stg1InvNum`=?,`stg1InvDate`=?,`stg1InvAmt`=?,`stg1pymntRcvd`=?,`stg1NetPymnt`=? , `stg1TDS`=?, `stg1GstTDS`=?, `stg1GrossPymnt`=? WHERE `projid`=?";
        $stmt1= mysqli_prepare($conn, $q1);
        if($stmt1){
            mysqli_stmt_bind_param($stmt1, "sddisdddddds", $stg1name, $stg1pcnt, $stg1amt, $stg1InvNum,$stg1InvDate,$stg1InvAmt,$stg1pymntRcvd,$stg1NetPymnt,$stg1TDS,$stg1GstTDS,$stg1GrossPymnt, $prID);
        
            if(mysqli_stmt_execute($stmt1)){
                $q2 = "UPDATE `stg2pymntdetail` SET `stg2name`=?,`stg2pcnt`=?,`stg2amt`=?,`stg2InvNum`=?,`stg2InvDate`=?,`stg2InvAmt`=?,`stg2pymntRcvd`=?,`stg2NetPymnt`=? , `stg2TDS`=?, `stg2GstTDS`=?, `stg2GrossPymnt`=? WHERE `projid`=?";
                $stmt2= mysqli_prepare($conn, $q2);
                if($stmt2){ 
                    mysqli_stmt_bind_param($stmt2, "sddisdddddds", $stg2name, $stg2pcnt, $stg2amt, $stg2InvNum,$stg2InvDate,$stg2InvAmt,$stg2pymntRcvd,$stg2NetPymnt,$stg2TDS,$stg2GstTDS,$stg2GrossPymnt, $prID);
                
                    if(mysqli_stmt_execute($stmt2)){
                        $q3 = "UPDATE `stg3pymntdetail` SET `stg3name`=?,`stg3pcnt`=?,`stg3amt`=?,`stg3InvNum`=?,`stg3InvDate`=?,`stg3InvAmt`=?,`stg3pymntRcvd`=?,`stg3NetPymnt`=? , `stg3TDS`=?, `stg3GstTDS`=?, `stg3GrossPymnt`=? WHERE `projid`=?";
                        $stmt3= mysqli_prepare($conn, $q3);
                        if($stmt3){
                             mysqli_stmt_bind_param($stmt3, "sddisdddddds", $stg3name, $stg3pcnt, $stg3amt, $stg3InvNum,$stg3InvDate,$stg3InvAmt,$stg3pymntRcvd,$stg3NetPymnt,$stg3TDS,$stg3GstTDS,$stg3GrossPymnt, $prID);
                        
                            if(mysqli_stmt_execute($stmt3)){
                                $q4 = "UPDATE `stg4pymntdetail` SET `stg4name`=?,`stg4pcnt`=?,`stg4amt`=?,`stg4InvNum`=?,`stg4InvDate`=?,`stg4InvAmt`=?,`stg4pymntRcvd`=? ,`stg4NetPymnt`=? , `stg4TDS`=?, `stg4GstTDS`=?, `stg4GrossPymnt`=? WHERE `projid`=?";
                                $stmt4= mysqli_prepare($conn, $q4);
                                if($stmt4){
                                    mysqli_stmt_bind_param($stmt4, "sddisdddddds", $stg4name, $stg4pcnt, $stg4amt, $stg4InvNum,$stg4InvDate,$stg4InvAmt,$stg4pymntRcvd,$stg4NetPymnt,$stg4TDS,$stg4GstTDS,$stg4GrossPymnt, $prID);
                                
                                    if(mysqli_stmt_execute($stmt4)){
                                        $q5 = "UPDATE `stg5pymntdetail` SET `stg5name`=?,`stg5pcnt`=?,`stg5amt`=?,`stg5InvNum`=?,`stg5InvDate`=?,`stg5InvAmt`=?,`stg5pymntRcvd`=?,`stg5NetPymnt`=? , `stg5TDS`=?, `stg5GstTDS`=?, `stg5GrossPymnt`=? WHERE `projid`=?";
                                        $stmt5= mysqli_prepare($conn, $q5);
                                        if($stmt5){
                                            mysqli_stmt_bind_param($stmt5, "sddisdddddds", $stg5name, $stg5pcnt, $stg5amt, $stg5InvNum,$stg5InvDate,$stg5InvAmt,$stg5pymntRcvd,$stg5NetPymnt,$stg5TDS,$stg5GstTDS,$stg5GrossPymnt, $prID);
                                            if(mysqli_stmt_execute($stmt5)){
                                                $q8 = " UPDATE `otasprojectdata` SET `InvAmtRaised` = ? , `AmntRcvdByClient` = ?, `TotOutstndBal` = ? WHERE `otasprojectdata`.`projid` = ?";
                                                $stmt8 = mysqli_prepare($conn, $q8);
                                                if($stmt8){
                                                    mysqli_stmt_bind_param($stmt8, "ddds",$InvAmtRaised ,$AmntRcvdByClient,$TotOutstndBal, $prID);
                                                    
                                                    if(mysqli_stmt_execute($stmt8)){
                                                        if($stmt1 && $stmt2 && $stmt3 && $stmt4 && $stmt5 && $stmt8){
                                                            echo " <script>alert('Data Updated successfully.');</script> ";
                                                            mysqli_stmt_close($stmt1);
                                                            mysqli_stmt_close($stmt2);
                                                            mysqli_stmt_close($stmt3);
                                                            mysqli_stmt_close($stmt4);
                                                            mysqli_stmt_close($stmt5);
                                                            mysqli_stmt_close($stmt8);
                                                            unset($_SESSION['update_pymnt_status']);
                                                            ?>
                                                            <meta http-equiv="refresh" content="0; url=project_data.php">
                                                            <?php 
                                                        }
                                                        else{
                                                            echo"
                                                            <script>alert('Data not inserted');</script>";
                                                            ?><meta http-equiv="refresh" content="0; url=project_data.php"><?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // Close prepared statements
        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
        mysqli_stmt_close($stmt4);
        mysqli_stmt_close($stmt5);
        mysqli_stmt_close($stmt8);
        unset($_SESSION['update_pymnt_status']);
    }
?>
<?php }?>