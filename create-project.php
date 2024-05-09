<?php
    include('connection.php');   
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if (isset($_POST['selectedClient'])) {
        $id = $_POST['selectedClient'];
    }
    $Q1="SELECT * from client where `ClientId`='$id'";
    $q12=mysqli_query($conn,$Q1);
    $q1=mysqli_fetch_assoc($q12);

    //fetching city details from database   
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
    if(($adminType==='Admin')||($userType==='User')){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/multiple_date_picker.css">
        <link rel="stylesheet" href="/Otas/flatpickr-master/dist/flatpickr.min.css">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
        <title>Create | Project</title>
    </head>
<body >
    <section class="home" >  
        <div class="container" >
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" autocomplete="off" enctype="application/x-www-form-urlencoded" >
                <h2>Create Project</h2> 
                <div class="project-details">
                    <div class="inputbox">
                        <span for="clientname" class='details'>Client Name<sup>*</sup></span>
                        <input type="text" name="clientName" id="clientname" class="input" disabled value="<?php echo $q1['ClientName'];?>" required>
                    </div>
                    <div class="inputbox">
                        <span for="clientid" class="details">Client ID<sup>*</sup></span>
                        <input type="text" name="clientId" id="clientid" class="input" disabled value="<?php echo $q1['ClientId']?>" required>
                        <input type="hidden" name="clientId" id="clientid" value="<?php echo $q1['ClientId']?>" required>
                    </div>
                    <div class="inputbox">
                        <span for="clientcity" class="details">Client City<sup>*</sup></span>
                        <input type="text" name="clientCity" id="clientcity" class="input" disabled value="<?php echo $cityname;?>" required>
                    </div>
                    <div class="inputbox projname">
                        <span for="projectname" class="details">Name Of Project<sup>*</sup></span>
                        <input type="text" name="projectName" id="projectname" class="input" placeholder="Enter Project Name Here" required>
                    </div>
                    <div class="inputbox">
                        <span for="year" class="details">Year<sup>*</sup></span>
                        <input type="number" name="Year" maxlength="4"  id="year" class="input" placeholder="Select year Of Project" required>
                    </div>
                    <div class="inputbox">
                        <span for="startDate" class="details">Work Order Date(mm/dd/yyyy)<sup>*</sup></span>
                        <input type="date" name="orderDate" id="startDate" class="input" required  >
                    </div>
                    <div class="inputbox">
                        <span for="duration" class="details">Duration (In Days)<sup>*</sup></span>
                        <input name="Duration" class="input" type="number" id="duration" min="1" max="365" placeholder="Enter Duration Of Project" required  >
                    </div>
                    <div class="inputbox">
                        <span for="endDate" class='details'>Sched. Compl. Date(mm/dd/yyyy)</span>
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
                                    <input type="checkbox" id="option1" name="services[]" value="Jammer"> Jammer <br>
                                    <pre class="servicesPrice" id="jammerPrice">Jammer Price <br><input type="text" name="JammerPrice" id="jammer_Price" class="servicepriceinput" ><br>Jammer Vendor Name<br><select name="jammervendorname" id="" class="servicepriceinput"><option value="">-Select Vendor-</option><option value="BEL">BEL</option><option value="ECIL">ECIL</option></select></pre>
                                    
                                    <input type="checkbox" id="option2" name="services[]"  value="CCTV Recording"> CCTV Recording<br>
                                    <pre class="servicesPrice"  id="cctv recordingPrice">CCTV Recording Price<br><input type="text" name="CCTVRecordPrice" id="cctv_recordingPrice" class="servicepriceinput"></pre>

                                    <input type="checkbox" id="option3"  name="services[]" value="CCTV Live Streaming"> CCTV Live Streaming<br>
                                    <pre class="servicesPrice"  id="cctv live streamingPrice">CCTV Live Streaming Price<br><input type="text" name="CCTVLiveStreamPrice" id="cctv_live_streamingPrice" class="servicepriceinput"></pre>
                                    
                                    <input type="checkbox" id="option4"  name="services[]" value="Iris Scanning"> Iris Scanning<br>
                                    <pre class="servicesPrice"   id="iris scanningPrice">Iris Scanning Price<br><input type="text" name="IrisPrice"  id="iris_scanningPrice" class="servicepriceinput"></pre>

                                    <input type="checkbox" id="option5" name="services[]"  value="Biometric Capturing"> Biometric Capturing<br>
                                    <pre class="servicesPrice"  id="biometric capturingPrice">Biometric Capturing Price<br><input type="text" name="BioPrice" id="biometric_capturingPrice" class="servicepriceinput"></pre>

                                    <input type="checkbox" id="option6" name="services[]" value="HHMD"> HHMD <br>
                                    <pre class="servicesPrice" id="hhmdPrice">HHMDPrice <br><input type="text" name="HHMDPrice" id="HHMD_Price" class="servicepriceinput" ></pre>

                                    <input type="checkbox" id="option7" name="services[]" value="Gate Score"> Gate Score<br>
                                    <pre class="servicesPrice" id="gate scorePrice">Gate Score Price <br><input type="text" name="GatePrice" id="Gate_Price" class="servicepriceinput" ></pre>

                                    <input type="checkbox" id="option8" name="services[]" value="Skill Test"> Skill Test <br>
                                    <pre class="servicesPrice" id="skill testPrice">Skill Test Price <br><input type="text" name="Skill_TestPrice" id="skill_testPrice" class="servicepriceinput" ></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inputbox">
                        <span for="" class="details">Services Vendor(Excluding Jammer)</span>
                        <select name="excludingJammerServiceVendor" id="" class="input">
                            <option value="">-Select Vendor-</option>
                            <option value="TCS">TCS</option>
                            <option value="Innovatiview">Innovatiview</option>
                        </select>
                    </div>
                    <div class="inputbox">
                        <span for="qpcost" class="details">Question Paper Cost</span>
                        <input type="text" name="qpcost" id="qpcost" class="input"  value="200000" onchange="updateValue(this.value)">
                    </div>
                    <div class="inputbox">
                        <span for="percandrate" class="details">Per Candidate Rate </span>
                        <input type="text" name="perCandRate" id="percandrate" class="input" required   placeholder="Enter Per candidate rate">
                    </div>
                    <div class="inputbox">
                         <span for="expcandcount" class="details"> Exp Candidate Count</span> 
                        <input type="text" name="expCandCount" id="expcandcount" class="input" placeholder="Enter candidate count" oninput="formatIndianNumber(this)">
                    </div>
                    <div class="inputbox">
                        <span for="estprojval" class="details">Exp Project Val(Services + QP)(In Rs.)</span>
                        <input type="text" name="estProjVal" id="estprojval" class="input" readonly >
                    </div>
                    <div class="inputbox">
                        <span for="actualcandcount" class="details">Actual Candidate Count</span>
                        <input type="text" name="actualcandCount" id="actualcandcount" class="input"  placeholder="Enter candidate count">
                    </div>
                    <div class="inputbox">
                        <span for="actprojval" class="details">Act. Project Val.(Services + QP)(In Rs.)</span>
                        <input type="text" name="actProjVal" id="actprojval" class="input" readonly>
                    </div>
                    <div class="inputbox " >
                        <div class="project-details">
                            <div class="inputbox ">
                                <span for="AplLivDate" class="details">Application Start (mm/dd/yyyy)</span>
                                <input type="date" name="AplLivDate" id="AplLivDate" class="input" >
                            </div>
                            <div class="inputbox "> 
                                <span for="AplLivEndDate" class="details">Application End (mm/dd/yyyy)</span>
                                <input type="date" name="AplLivEndDate" id="AplLivEndDate" class="input" >
                            </div>
                        </div>
                    </div> 
                    <div class="inputbox " >
                        <span for="AdmitLivDate" class="details">Admit Card Live Date</span>
                        <input type="text" name="AdmitLivDate" id="AdmitLivDate" class="input" placeholder="Select multiple date">
                    </div>
                    <div class="inputbox " >
                        <span for="CBTDate" class="details">CBT Date</span>
                        <input type="text" name="CBTDate" id="CBTDate" class="input" placeholder="Select multiple date">
                    </div>
                    <div class="inputbox ">
                        <span for="" class="details">CBT Shifts </span>
                        <input type="number" name="NoOfCBTShifts" id="" class="input" placeholder="Enter No Of Shifts">
                    </div>
                    <div class="inputbox " id="objmng">
                        <div class="project-details">
                            <div class="inputbox ">
                                <span for="ObjMngDateStart" class="details">Obj. Start Date(mm/dd/yyyy)</span>
                                <input type="date" name="ObjMngDateStart" id="ObjMngDateStart" class="input" >
                            </div>
                            <div class="inputbox ">
                                <span for="ObjMngDateEnd" class="details">Obj. End Date(mm/dd/yyyy)</span> 
                                <input type="date" name="ObjMngDateEnd" id="ObjMngDateEnd" class="input" >
                            </div>
                        </div>
                    </div> 
                    <div class="inputbox" >
                        <span for="ResultSub" class="details">Result Subm. Date (mm/dd/yyyy)</span>
                        <input type="date" name="ResultSub" id="ResultSub" class="input" >
                    </div>
                    <div class="inputbox" >
                        <span for="prjctstts" class="details">Project Status<sup>*</sup></span>
                        <select name="prjctstts" id="prjctstts" class="input" required autocomplete="off">
                            <option value disabled >--Select--</option>
                            <option value="Ongoing" >Ongoing</option>
                            <option value="Amount Pending">Amount Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <span class="allfields"><sup>*</sup>Fields are mandatory</span>
                <span class="">
                    <input type="submit" value="Create" name="save&next"   class="button  input" >
                </span>
            </form>
        </div>
        <script src="/Otas/flatpickr-master/dist/flatpickr.min.js"></script>
        <script defer src="js/create-project.js"></script>
        <script defer src="js/services.js"></script>
    </section>
</body>
</html>
<?php 
    if(isset($_POST['save&next'])){
        $id= mysqli_real_escape_string($conn,$_POST['clientId']);
        $Year= mysqli_real_escape_string($conn,$_POST['Year']);
        $ProjName= mysqli_real_escape_string($conn,$_POST['projectName']);
        $Orderdate= mysqli_real_escape_string($conn,$_POST['orderDate']);
        if (isset($_POST['services']) && is_array($_POST['services'])) {
            $selectedServices = implode(', ', $_POST['services']);
        } else {
            $selectedServices = '';
        }
        $JammerPrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['JammerPrice']));
        $jammervendorname= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['jammervendorname']));
        $CCTVRecordPrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['CCTVRecordPrice']));
        $CCTVLiveStreamPrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['CCTVLiveStreamPrice']));
        $IrisPrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['IrisPrice']));
        $BioPrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['BioPrice']));
        $HHMDPrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['HHMDPrice']));
        $GatePrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['GatePrice']));
        $Skill_TestPrice= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['Skill_TestPrice']));
        $excludingJammerServiceVendor= mysqli_real_escape_string($conn,$_POST['excludingJammerServiceVendor']);        
        $qpcost= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['qpcost']));
        $Duration= mysqli_real_escape_string($conn,$_POST['Duration']);
        $PerCandRate= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['perCandRate']));
        $ExpCandCount= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['expCandCount']));
        $ActualCandCount= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['actualcandCount']));
        $ExpProjVal= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['estProjVal']));
        $ActProjVal=mysqli_real_escape_string($conn, str_replace(',', '', $_POST['actProjVal']));
        //scheduled date of completion
        $SchedDateofCompl=date('Y-m-d', strtotime($Orderdate . ' + ' . $Duration . ' days'));
        $AplLivDate=mysqli_real_escape_string($conn,$_POST['AplLivDate']);
        $AplLivEndDate=mysqli_real_escape_string($conn,$_POST['AplLivEndDate']);
        $AdmitLivDateArray = $_POST['AdmitLivDate'];
        $AdmitLivDateJSON = json_encode($AdmitLivDateArray);
        $AdmitLivDate = mysqli_real_escape_string($conn, $AdmitLivDateJSON);
        //cbt dates
        $CBTDateArray = $_POST['CBTDate'];
        $CBTDateJSON = json_encode($CBTDateArray);
        $CBTDateEscaped = mysqli_real_escape_string($conn, $CBTDateJSON);

        $ObjMngDateStart=mysqli_real_escape_string($conn,$_POST['ObjMngDateStart']);
        $ObjMngDateEnd=mysqli_real_escape_string($conn,$_POST['ObjMngDateEnd']);
        $ResultSub=mysqli_real_escape_string($conn,$_POST['ResultSub']);
        $NoOfCBTShifts=mysqli_real_escape_string($conn,$_POST['NoOfCBTShifts']);
        $Prjctstts=mysqli_real_escape_string($conn,$_POST['prjctstts']);

        $checkid = "SELECT * FROM `otasprojectdata` ORDER BY `projid` DESC LIMIT 1";
        $checkresultid = mysqli_query($conn, $checkid);
        
        if ($checkresultid) {
            if (mysqli_num_rows($checkresultid) > 0) {
                $row = mysqli_fetch_assoc($checkresultid);
                $lastProjID = $row['projid'];
                $get_numbers = (int) str_replace("PR", "", $lastProjID);
                $id_increase = $get_numbers + 1;
                $get_string = str_pad($id_increase, 10, 0, STR_PAD_LEFT);
                $projID = "PR" . $get_string;
            } else {
                $projID = "PR0000000001";
            }

            $query3 = "INSERT INTO `otasprojectdata` (`ClientId`, `projid`, `NameOfProject`, `Year`, `WorkOrderDate`, `Service`, `Duration`, `PerCandRate`, `SchedDateCompl`,`Status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = mysqli_prepare($conn, $query3);
        
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssissidss", $id, $projID, $ProjName, $Year, $Orderdate, $selectedServices, $Duration, $PerCandRate, $SchedDateofCompl,$Prjctstts);

                if (mysqli_stmt_execute($stmt)) {

                    $servicePrice="INSERT INTO `otasservicesprice` (`projid`,`jammerVendorName`, `otherServiceVendor`, `JammerPrice`,`cctvRecordPrice`, `cctvStreamPrice`, `irisScanPrice`, `biometricPrice`, `hhmdPrice`, `gateScorePrice`, `skillTestPrice`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
                    $stmt_service_price=mysqli_prepare($conn,$servicePrice);

                    if($stmt_service_price){
                        mysqli_stmt_bind_param($stmt_service_price,"sssdddddddd",$projID,$jammervendorname,$excludingJammerServiceVendor,$JammerPrice,$CCTVRecordPrice,$CCTVLiveStreamPrice,$IrisPrice,$BioPrice,$HHMDPrice,$GatePrice,$Skill_TestPrice);

                        if(mysqli_stmt_execute($stmt_service_price)){
                            $projdate = "INSERT INTO `otasprojdates` (`projid`, `AplicLivDate`,`AplicLiveEndDate`, `AdmitLivDate`, `ObjMngLiveDate`,`ObjMngEndDate`, `CBTDate`,`NoOfCBTShifts`,`ResultSubmitDate`) VALUES (?, ?, ?, ?,?, ?, ?, ? ,?)";
                            $stmt_projdate = mysqli_prepare($conn, $projdate);
                
                            if ($stmt_projdate) {
                                mysqli_stmt_bind_param($stmt_projdate, "sssssssis", $projID, $AplLivDate, $AplLivEndDate, $AdmitLivDate, $ObjMngDateStart,$ObjMngDateEnd, $CBTDateEscaped,$NoOfCBTShifts,$ResultSub); 

                                if (mysqli_stmt_execute($stmt_projdate)) {
                                    $cancount = "INSERT INTO `otasprcandcount` (`projid`, `ExpectCandCount`, `ActualCandCount`) VALUES (?, ?, ?)";
                                    $stmt_cancount = mysqli_prepare($conn, $cancount);
                
                                    if ($stmt_cancount) {
                                        mysqli_stmt_bind_param($stmt_cancount, "sii", $projID, $ExpCandCount, $ActualCandCount);
                                        if (mysqli_stmt_execute($stmt_cancount)) {
                                            $projval = "INSERT INTO `otasprojval` (`projid`, `ExpectProjVal`, `ActualProjVal`,`QPCost`)VALUES (?, ?, ?, ?)";
                                            $stmt_projval = mysqli_prepare($conn, $projval);
                
                                            if ($stmt_projval) {
                                                mysqli_stmt_bind_param($stmt_projval, "sddi", $projID, $ExpProjVal, $ActProjVal,$qpcost);
        
                                                if (mysqli_stmt_execute($stmt_projval)) {
          
                                                    // Prepare the statements
                                                    $q1 = mysqli_prepare($conn, "INSERT INTO `stg1pymntdetail` (`projid`, `stg1name`, `stg1pcnt`, `stg1amt`, `stg1InvNum`, `stg1InvDate`, `stg1InvAmt`, `stg1pymntRcvd`, `stg1NetPymnt`, `stg1TDS`, `stg1GstTDS`, `stg1GrossPymnt`) VALUES (?, '', '', '', '', '', '', '', '', '', '', '')");
                                                    $q2 = mysqli_prepare($conn, "INSERT INTO `stg2pymntdetail`(`projid`, `stg2name`, `stg2pcnt`, `stg2amt`, `stg2InvNum`, `stg2InvDate`, `stg2InvAmt`, `stg2pymntRcvd`, `stg2NetPymnt`, `stg2TDS`, `stg2GstTDS`, `stg2GrossPymnt`) VALUES (?, '', '', '', '', '', '', '', '', '', '', '')");
                                                    $q3 = mysqli_prepare($conn, "INSERT INTO `stg3pymntdetail` (`projid`, `stg3name`, `stg3pcnt`, `stg3amt`, `stg3InvNum`, `stg3InvDate`, `stg3InvAmt`, `stg3pymntRcvd`, `stg3NetPymnt`, `stg3TDS`, `stg3GstTDS`, `stg3GrossPymnt`) VALUES (?, '', '', '', '', '', '', '', '', '', '', '')");
                                                    $q4 = mysqli_prepare($conn, "INSERT INTO `stg4pymntdetail` (`projid`, `stg4name`, `stg4pcnt`, `stg4amt`, `stg4InvNum`, `stg4InvDate`, `stg4InvAmt`, `stg4pymntRcvd`, `stg4NetPymnt`, `stg4TDS`, `stg4GstTDS`, `stg4GrossPymnt`) VALUES (?, '', '', '', '', '', '', '', '', '', '', '')");
                                                    $q5 = mysqli_prepare($conn, "INSERT INTO `stg5pymntdetail` (`projid`, `stg5name`, `stg5pcnt`, `stg5amt`, `stg5InvNum`, `stg5InvDate`, `stg5InvAmt`, `stg5pymntRcvd`, `stg5NetPymnt`, `stg5TDS`, `stg5GstTDS`, `stg5GrossPymnt`) VALUES (?, '', '', '', '', '', '', '', '', '', '', '')");

                                                    // Bind the parameters
                                                    mysqli_stmt_bind_param($q1, "s", $projID);
                                                    mysqli_stmt_bind_param($q2, "s", $projID);
                                                    mysqli_stmt_bind_param($q3, "s", $projID);
                                                    mysqli_stmt_bind_param($q4, "s", $projID);
                                                    mysqli_stmt_bind_param($q5, "s", $projID);

                                                    // Execute the statements
                                                    $q11 = mysqli_stmt_execute($q1);
                                                    $q21 =  mysqli_stmt_execute($q2);
                                                    $q31 =  mysqli_stmt_execute($q3);
                                                    $q41 =  mysqli_stmt_execute($q4);
                                                    $q51 =  mysqli_stmt_execute($q5);

                                                    // mysqli_stmt_execute($userwise);
                                                    if ($q11 && $q21 && $q31 && $q41 && $q51) {
                                                        $myNewProject="INSERT INTO `userotasproject` (`EmployeeId`, `projid`) VALUES (?,?)";
                                                        $myNewProj_stmt= mysqli_prepare($conn,$myNewProject);
                                                        mysqli_stmt_bind_param($myNewProj_stmt,'ss',$userId,$projID);
                                                        mysqli_stmt_execute($myNewProj_stmt);
                                                        echo"<script>alert('Data inserted.');</script>";
                                                        ?><meta http-equiv="refresh" content="0; url=project-data.php"><?php
                                                    }
                                                } else {
                                                    echo "<script>alert('Record not inserted.');</script>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    echo "<script>alert('Record not inserted.');</script>";
                }
                mysqli_stmt_close($stmt);
                mysqli_stmt_close($stmt_projdate);
                mysqli_stmt_close($stmt_cancount);
                mysqli_stmt_close($stmt_projval);
                mysqli_stmt_close($myNewProj_stmt);
                // mysqli_stmt_close();
            }
        }
    }
?>
<?php }?>