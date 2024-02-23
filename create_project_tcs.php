<?php
    include('connection.php');
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['selectedClient1']) && isset($_POST['selectedProject'])) {

        $projID =mysqli_real_escape_string($conn, $_POST["selectedProject"]);
        $clintId = mysqli_real_escape_string($conn, $_POST['selectedClient1']);
        $_SESSION['projid']=$projID;
        // echo $projID;
        // echo $clintId;
        $Q1 = "SELECT prdata.ClientId, prdata.`NameOfProject`, cl.ClientName, cl.CityId
            FROM `otasprojectdata` prdata 
            JOIN client cl ON prdata.ClientId = cl.ClientId  
            WHERE prdata.ClientId = '$clintId' And prdata.projid='$projID'";

        $q12=mysqli_query($conn,$Q1);
        
        if( $q1=mysqli_fetch_assoc($q12)){
            $projectname=$q1['NameOfProject'];
            // echo $projectname;
            // $_SESSION['projectname']=$projectname;
            if($q1['CityId'] >= 0){
                $sql = "SELECT c.name AS city_name, 
                s.name AS state_name
                FROM city c
                INNER JOIN state_uts s ON c.state_id = s.id
                WHERE c.id = '$q1[CityId]'";
                $d2=mysqli_query($conn,$sql);
                $r2=mysqli_fetch_assoc($d2);
                $cityname = $r2['city_name'] . ', ' . $r2['state_name'];     
            }
            if ($projID) {
                $countQuery = "SELECT * FROM `otasprcandcount` WHERE `projid`=?";
             
                $stmt = mysqli_prepare($conn, $countQuery);
            
                mysqli_stmt_bind_param($stmt, 's', $projID);
                mysqli_stmt_execute($stmt);
            
                $res3 = mysqli_stmt_get_result($stmt);
                $res = mysqli_fetch_assoc($res3);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/project.css">
        <title>Create | Project</title>
    </head>
    <body >
        <section class="home">
            <div class="project-container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" autocomplete="off" enctype="application/x-www-form-urlencoded" >
                    <h2>Create Project</h2>
                    <div class="project-details">
                        <div class="inputbox">
                            <span for="clientname" class='details'>Client Name</span>
                            <input type="text" name="clientName" id="clientname" class="input" disabled value="<?php echo $q1['ClientName'];?>" required>
                        </div>
                        <div class="inputbox">
                            <span for="clientid" class="details">Client ID</span>
                            <input type="text" name="clientId" id="clientid" class="input" disabled value="<?php echo $q1['ClientId']?>"required>
                            <input type="hidden" name="clientId" id="clientid" value="<?php echo $q1['ClientId']?>" required>
                        </div>
                        <div class="inputbox">
                            <span for="clientcity" class="details">Client City</span>
                            <input type="text" name="clientCity" id="clientcity" class="input" disabled value="<?php echo $cityname;?>" required>
                        </div>
                        <div class="inputbox projname">
                            <span for="projectname" class="details">Name Of Project<sup>*</sup></span>
                            <input type="text" name="projectName" id="projectname" class="input" placeholder="Enter Project Name Here" required value="<?php echo  $projectname  ?>" disabled>
                            <input type="hidden" name="projectName" value="<?php echo  $projectname  ?>" >
                        </div>
                        <div class="inputbox">
                            <span for="year" class="details">Year<sup>*</sup></span>
                            <input type="number" name="Year" maxlength="4" id="year" class="input" placeholder="Select year Of Project" required>
                        </div>
                        <div class="inputbox">
                            <span for="startDate" class="details">Work Order Date (mm/dd/yy)<sup>*</sup></span>
                            <input type="date" name="orderDate" id="startDate" class="input"
                            required >
                        </div>
                        <div class="inputbox">
                            <span for="duration" class="details">Duration (In Days)<sup>*</sup></span>
                            <input name="Duration" class="input" type="number" id="duration" min="1" max="365"  placeholder="Enter Duration Of Project" required>
                        </div>
                        <div class="inputbox">
                            <span for="endDate" class='details'>Sched. Compl. Date(mm/dd/yy)</span>
                            <input type="date" name="schedCompl" id="endDate" class="input" readonly required>
                        </div>
                        <div class="inputbox">
                            <span for="services" class="details">Services</span>
                            <div id="servicesContainer" class="input" style="position: relative;">
                                <input type="text" id="selectedServices" class="input" readonly placeholder="Select services">
                                <i class='bx bx-chevron-down dropdown-select'></i>
                            </div>
                            <div class="select-box">
                                <div class="select-dropdown">
                                    <div class="select-header">
                                        <input type="checkbox" id="selectAll"> &nbsp;Select All
                                    </div>
                                    <hr style="color:#eae8e4  ;">
                                    <div class="select-options">
                                        <input type="checkbox" id="option2" name="services[]"  value="CCTV Recording"> CCTV Recording<br>
                                        <!-- <pre class="servicesPrice"  id="cctv recordingPrice">CCTV Recording Price<br><input type="number" name="CCTVRecordPrice" id="cctv_recordingPrice" class="servicepriceinput"></pre> -->

                                        <input type="checkbox" id="option3"  name="services[]" value="CCTV Live Streaming"> CCTV Live Streaming<br>
                                        <!-- <pre class="servicesPrice"  id="cctv live streamingPrice">CCTV Live Streaming Price<br><input type="number" name="CCTVLiveStreamPrice" id="cctv_live_streamingPrice" class="servicepriceinput"></pre> -->
                                        
                                        <input type="checkbox" id="option4"  name="services[]" value="Iris Scanning"> Iris Scanning<br>
                                        <!-- <pre class="servicesPrice"   id="iris scanningPrice">Iris Scanning Price<br><input type="number" name="IrisPrice"  id="iris_scanningPrice" class="servicepriceinput"></pre> -->

                                        <input type="checkbox" id="option5" name="services[]"  value="Biometric Capturing"> Biometric Capturing<br>
                                        <!-- <pre class="servicesPrice"  id="biometric capturingPrice">Biometric Capturing Price<br><input type="number" name="BioPrice" id="biometric_capturingPrice" class="servicepriceinput"></pre> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="inputbox">
                            <span for="percandrate" class="details">Per Candidate Rate</span>
                            <input type="text" name="perCandRate" id="percandrate" class="input" required >
                        </div>
                        <div class="inputbox">
                            <span for="expcandcount" class="details">Expected Candidate Count</span>
                            <input type="text" name="expCandCount" id="expcandcount" class="input" required  placeholder="Enter candidate count" value="<?php echo $res['ExpectCandCount'] ?>" readonly>
                        </div>
                        <div class="inputbox">
                            <span for="estprojval" class="details">Estimated Project Value(In Rs.)</span>
                            <input type="text" name="estProjVal" id="estprojval" class="input" required readonly >
                        </div>
                        <div class="inputbox">
                            <span for="actualcandcount" class="details">Actual Candidate Count</span>
                            <input type="text" name="actualcandCount" id="actualcandcount" class="input"  placeholder="Enter candidate count" value="<?php echo $res['ActualCandCount']?>" readonly>
                        </div>
                        <div class="inputbox">
                            <span for="actprojval" class="details">Actual Project Value(In Rs.)</span>
                            <input type="text" name="actProjVal" id="actprojval" class="input" readonly>
                        </div>
                        <div class="inputbox " >
                            <span for="prjctstts" class="details">Project Status<sup>*</sup></span>
                            <select name="prjctstts" id="prjctstts" class="input" required autocomplete="off">
                                <option value disabled>--Select--</option>
                                <option value="Ongoing" >Ongoing</option>
                                <option value="Amount Pending">Amount Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <span style=" color:red; font-size:1.4rem;"><sup>*</sup>All fields are mandatory</span>
                    <span class="">
                        <input type="submit" value="Create" name="save&next" class="button  input" >
                    </span>
                </form>
            </div>
            <script defer src="js/create_project_tcs.js"></script>
            <script defer src='js/services.js'></script>
        </section>
    </body>
</html>
<?php 
    if(isset($_POST['save&next'])){
        $id= mysqli_real_escape_string($conn,$_POST['clientId']);
        $Year= mysqli_real_escape_string($conn,$_POST['Year']);
        $ProjName= mysqli_real_escape_string($conn,$_POST['projectName']);
        $Orderdate= mysqli_real_escape_string($conn,$_POST['orderDate']);
        $Duration= mysqli_real_escape_string($conn,$_POST['Duration']);
        $SchedDateofCompl=date('Y-m-d', strtotime($Orderdate . ' + ' . $Duration . ' days'));

        if (isset($_POST['services']) && is_array($_POST['services'])) {
            $selectedServices = implode(', ', $_POST['services']);
        } else {
            $selectedServices = ''; 
        }

        $PerCandRate = mysqli_real_escape_string($conn, str_replace(',', '', $_POST['perCandRate']));
        $ExpProjVal = mysqli_real_escape_string($conn, str_replace(',', '', $_POST['estProjVal']));
        $ActProjVal = mysqli_real_escape_string($conn, str_replace(',', '', $_POST['actProjVal']));

        $Prjctstts=mysqli_real_escape_string($conn,$_POST['prjctstts']);

        $projID=$_SESSION['projid'];

        $tocheckprojectcreated = "SELECT * FROM `tcsprojectdata` WHERE projid='$projID'";
        $yes = mysqli_query($conn, $tocheckprojectcreated);
        $resultyes = mysqli_fetch_row($yes);
        if (!$resultyes) {
            $query3="INSERT INTO `tcsprojectdata`(`projid`, `ClientId`, `NameOfProject`, `Year`, `WorkOrderDate`, `Duration`, `SchedDateCompl`, `PerCanRate`, `ExpectedVal`, `ActualVal`, `Service`, `Status`) VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )";
            $stmt = mysqli_prepare($conn, $query3);
            if ($stmt) 
            {
                mysqli_stmt_bind_param($stmt, "sssisisdddss", $projID, $id, $ProjName, $Year, $Orderdate, $Duration,$SchedDateofCompl, $PerCandRate,$ExpProjVal,  $ActProjVal,$selectedServices, $Prjctstts);    
                if (mysqli_stmt_execute($stmt)) {
                    // Prepare the first query
                    $q1 = mysqli_prepare($conn, "INSERT INTO `tcscbtdata`(`projid`, `cbtPcnt`, `cbtPymntAmt`, `cbtInvNum`, `cbtInvAmt`, `cbtInvDate`, `cbtPDAmt1`, `cbtPDDate1`, `cbtPDAmt2`, `cbtPDDate2`, `cbtPDAmt3`, `cbtPDDate3`, `cbtPymntDone`) VALUES (?, '', '', '', '', '', '', '', '', '', '', '', '')");
                    // Prepare the second query
                    $q2 = mysqli_prepare($conn, "INSERT INTO `tcsresultdata`(`projid`, `resPcnt`, `resPymntAmt`, `resInvNum`, `resInvAmt`, `resInvDate`, `resPDAmt1`, `resPDDate1`, `resPDAmt2`, `resPDDate2`, `resPDAmt3`, `resPDDate3`, `resPymntDone`) VALUES (?, '', '', '', '', '', '', '', '', '', '', '', '')");

                    mysqli_stmt_bind_param($q1, "s", $projID);
                    mysqli_stmt_bind_param($q2, "s", $projID);

                    $q11=mysqli_stmt_execute($q1);
                    $q21=mysqli_stmt_execute($q2);

                    if ($q11 && $q21  ){
                        echo"<script>alert('Data inserted.');</script>";
                        ?><meta http-equiv="refresh" content="0; url=project_data_tcs.php"><?php
                    } 
                    else 
                    {
                        echo "<script>alert('Record not inserted.');</script>";
                    }
                }
            }
            else {
                echo "<script>alert('Record not inserted.');</script>";
            }
            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt_projval);
            unset($_SESSION['projid']);
        }
        else{
            echo "<script>alert('Project Already Created.');</script>";
            ?><meta http-equiv="refresh" content="0; url=choose_client_tcs.php"><?php
        }
    }
?>
<?php }?>