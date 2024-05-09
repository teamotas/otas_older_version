<?php
    include('connection.php'); 
     include "sidebar.php";
    // error_reporting(0);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    $serviceschosen = array();
    if (isset($_POST['updateprojectdata'])) {
        if (isset($_POST['project_id'])) {
            $_SESSION['update_prjct_status']=$_POST['project_id'];
            $prID = $_SESSION['update_prjct_status'];
            $sql = "SELECT *
            FROM otasprojectdata prdata
            JOIN otasprojval prval ON prdata.projid = prval.projid
            JOIN otasprcandcount count ON prval.projid = count.projid
            JOIN otasprojdates dates ON count.projid = dates.projid
            JOIN otasservicesprice serprice ON dates.projid=serprice.projid
            Join client cl On prdata.ClientId=cl.ClientId
            where prdata.projid='$prID'";

            $data = mysqli_query($conn, $sql);
            $total = mysqli_num_rows($data);
            $q3=mysqli_fetch_assoc($data);
            $id=$q3['ClientId'];
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
            $serviceschosen = array();
            if (isset($q3) && !is_null($q3)) {
                $services = $q3["Service"];
                $serviceschosen = !empty($services) ? explode(",", $services) : array();
                $serviceschosen = array_map('trim', $serviceschosen);
            }
        }
    }
  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/multiple_date_picker.css">
        <link rel="stylesheet" href="/Otas/flatpickr-master/dist/flatpickr.min.css">
        <title>Update | Project</title>
    </head>
    <body >
    <section class="home" >  
        <div class="container" >
            <?php $prID = $_SESSION['update_prjct_status'];?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" autocomplete="off" enctype="application/x-www-form-urlencoded" >
                <p id="heading">Update Project Data</p>
                <div class="project-details">
                    <div class="inputbox">
                        <span for="clientname" class='details'>Client Name<sup>*</sup></span>
                        <input type="text" required name="clientName" id="clientname" class="input" disabled value="<?php echo $q1['ClientName'];?>">
                    </div>
                    <div class="inputbox">
                        <span for="clientid" class="details">Client ID<sup>*</sup></span>
                        <input type="text" required name="clientId" id="clientid" class="input" disabled value="<?php echo $q1['ClientId']?>">
                    </div>
                    <div class="inputbox">
                        <span for="clientcity" class="details">Client City<sup>*</sup></span>
                        <input type="text" required name="clientCity" id="clientcity" class="input" disabled value="<?php echo $cityname;?>">
                    </div>
                    <div class="inputbox ">
                        <span for="projectname" class="details">Name Of Project<sup>*</sup> &nbsp; &nbsp;<?php  if(isset($_SESSION['update_prjct_status'])){ echo $prID;}?></span>
                        <input type="text" required name="projectName" id="projectname" class="input" placeholder="Enter Project Name Here" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['NameOfProject'];}?>">
                        <input type="hidden" required name="projectID" disabled id="projectID" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $prID;}?>">
                    </div>
                    <div class="inputbox">
                        <span for="year" class="details">Year<sup>*</sup></span>
                        <input type="number" name="Year" maxlength="4"  id="year" class="input" placeholder="Select year Of Project" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['Year'];}?>" required>
                    </div>
                    <div class="inputbox">
                        <span for="startDate" class="details">Work Order Date(mm/dd/yyyy)<sup>*</sup></span>
                        <input type="date" name="orderDate" id="startDate" class="input" required
                        value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['WorkOrderDate'];}?>">
                    </div>
                    <div class="inputbox">
                        <span for="duration" class="details">Duration (In Days)<sup>*</sup></span>
                        <input name="Duration" class="input" type="number" id="duration" min="1" max="365" placeholder="Enter Duration Of Project"  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['Duration'];}?>" required>
                    </div>
                    <div class="inputbox">
                        <span for="endDate" class='details'>Sched. Compl. Date(mm/dd/yyyy)</span>
                        <input type="date" name="schedCompl" id="endDate" class="input" readonly value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['SchedDateCompl'];}?>" required>
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
                                    <input type="checkbox" id="option1" name="services[]" value="Jammer" <?php echo in_array("Jammer", $serviceschosen) ? 'checked' : ''; ?>> Jammer <br>
                                    <pre class="servicesPrice" id="jammerPrice" <?php  echo isset($q3['JammerPrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>Jammer Price <br><input type="text" name="JammerPrice" id="jammer_Price" class="servicepriceinput" value="<?php if(isset($_SESSION['update_prjct_status'])) { echo $q3['JammerPrice']; } ?>"><br>Jammer Vendor Name <br><select name="jammervendorname" id="" class="servicepriceinput"><option value="">-Select Vendor-</option><option value="BEL" <?php if($q3['jammerVendorName'] =="BEL"){echo"selected";}?>>BEL</option><option value="ECIL" <?php if($q3['jammerVendorName'] =="ECIL"){echo"selected";}?>>ECIL</option></select></pre>
                        
                                    <input type="checkbox" id="option2" name="services[]" value="CCTV Recording" <?php echo in_array("CCTV Recording", $serviceschosen) ? 'checked' : ''; ?>> CCTV Recording<br>
                                    <pre class="servicesPrice"   id="cctv recordingPrice" <?php  echo isset($q3['cctvRecordPrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>CCTV Recording Price<br><input type="text" name="CCTVRecordPrice" id="cctv_recordingPrice" class="servicepriceinput"   value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['cctvRecordPrice'];}?>"></pre>

                                    <input type="checkbox" id="option3" name="services[]" value="CCTV Live Streaming" <?php echo in_array("CCTV Live Streaming", $serviceschosen) ? 'checked' : ''; ?>> CCTV Live Streaming<br>
                                    <pre class="servicesPrice"  id="cctv live streamingPrice" <?php  echo isset($q3['cctvStreamPrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>CCTV Live Streaming Price<br><input type="text" name="CCTVLiveStreamPrice" id="cctv_live_streamingPrice" class="servicepriceinput"  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['cctvStreamPrice'];}?>"></pre>

                                    <input type="checkbox" id="option4" name="services[]" value="Iris Scanning" <?php echo in_array("Iris Scanning", $serviceschosen) ? 'checked' : ''; ?>> Iris Scanning<br>
                                    <pre class="servicesPrice"    id="iris scanningPrice" <?php  echo isset($q3['irisScanPrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>Iris Scanning Price<br><input type="text" name="IrisPrice"  id="iris_scanningPrice" class="servicepriceinput"value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['irisScanPrice'];}?>"></pre>

                                    <input type="checkbox" id="option5" name="services[]" value="Biometric Capturing" <?php echo in_array("Biometric Capturing", $serviceschosen) ? 'checked' : ''; ?>> Biometric Capturing<br>
                                    <pre class="servicesPrice"   id="biometric capturingPrice" <?php  echo isset($q3['biometricPrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>> Biometric Capturing Price<br><input type="text" name="BioPrice" id="biometric_capturingPrice" class="servicepriceinput"  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['biometricPrice'];}?>"></pre>

                                    <input type="checkbox" id="option6" name="services[]" value="HHMD" <?php echo in_array("HHMD", $serviceschosen) ? 'checked' : ''; ?>> HHMD <br>
                                    <pre class="servicesPrice" id="hhmdPrice" <?php  echo isset($q3['hhmdPrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>HHMD Price <br><input type="text" name="HHMDPrice" id="HHMD_Price" class="servicepriceinput" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['hhmdPrice'];}?>"></pre>

                                    <input type="checkbox" id="option7" name="services[]" value="Gate Score" <?php echo in_array("Gate Score", $serviceschosen) ? 'checked' : ''; ?>> Gate Score<br>
                                    <pre class="servicesPrice" id="gate scorePrice" <?php  echo isset($q3['gateScorePrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>Gate Score Price <br><input type="text" name="GatePrice" id="Gate_Price" class="servicepriceinput" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['gateScorePrice'];}?>"></pre>

                                    <input type="checkbox" id="option8" name="services[]" value="Skill Test" <?php echo in_array("Skill Test", $serviceschosen) ? 'checked' : ''; ?>> Skill Test <br>
                                    <pre class="servicesPrice" id="skill testPrice" <?php  echo isset($q3['skillTestPrice']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>Skill Test Price <br><input type="text" name="Skill_TestPrice" id="skill_testPrice" class="servicepriceinput" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['skillTestPrice'];}?>"></pre>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inputbox">
                        <span for="" class="details">Services Vendor(Excluding Jammer)</span>
                        <select name="excludingJammerServiceVendor" id="" class="input">
                            <option value="">-Select Vendor-</option>
                            <option value="TCS" <?php if(isset($q3['otherServiceVendor']) && $q3['otherServiceVendor'] =="TCS"){echo"selected";}?>>TCS</option>
                            <option value="Innovatiview" <?php if(isset($q3['otherServiceVendor']) && $q3['otherServiceVendor'] =="Innovatiview"){echo"selected";}?>>Innovatiview</option>
                        </select>
                    </div>

                    <div class="inputbox">
                        <span for="qpcost" class="details">Question Paper Cost</span>
                        <input type="text" name="qpcost" id="qpcost" class="input" value="<?php if(isset($_SESSION['update_prjct_status'])){ echo $q3['QPCost'];}?>" onchange="updateValue(this.value)">
                    </div>
                    <div class="inputbox">
                        <span for="percandrate" class="details">Per Candidate Rate </span>
                        <input type="text" name="perCandRate" id="percandrate" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['PerCandRate'];}?>" placeholder="Enter Per candidate rate">
                    </div>
                    <div class="inputbox">
                        <span for="expcandcount" class="details">Expected Candidate Count</span>
                        <input type="text" name="expCandCount" id="expcandcount" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ExpectCandCount'];}?>" placeholder="Enter candidate count">
                    </div>
                    <div class="inputbox">
                        <span for="estprojval" class="details">Exp Project Val(Services + QP)(In Rs.)</span>
                        <input type="text" name="estProjVal" id="estprojval" class="input" readonly  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ExpectProjVal'];}?>">
                    </div>
                    <div class="inputbox">
                        <span for="actualcandcount" class="details">Actual Candidate Count</span>
                        <input type="text" name="actualcandCount" id="actualcandcount" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ActualCandCount'];}?>" placeholder="Enter candidate count">
                    </div>
                    <div class="inputbox">
                        <span for="actprojval" class="details">Act. Project Val.(Services + QP)(In Rs.)</span>
                        <input type="text" name="actProjVal" id="actprojval" class="input" readonly  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ActualProjVal'];}?>">
                    </div>

                    <div class="inputbox " >
                        <!-- <span for="AplicDate" class="details">Application Live Details</span> -->
                        <div class="project-details">
                            <div class="inputbox ">
                                <span for="AplLivDate" class="details">Application Start (mm/dd/yyyy)</span>
                                <input type="date" name="AplLivDate" id="AplLivDate" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['AplicLivDate'];}?>">
                            </div>
                            <div class="inputbox "> 
                                <span for="AplLivEndDate" class="details">Application End (mm/dd/yyyy)</span>
                                <input type="date" name="AplLivEndDate" id="AplLivEndDate" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['AplicLiveEndDate'];}?>">
                            </div>
                        </div>
                    </div> 
                    <div class="inputbox " >
                        <span for="AdmitLivDate" class="details">Admit Card Live Date</span>
                        <input type="text" name="AdmitLivDate" id="AdmitLivDate" class="input" placeholder="Select multiple date" value="<?php  if(isset($_SESSION['update_prjct_status'])){ 
                                $cleaned_dates = stripslashes($q3['AdmitLivDate']);
                                $cleaned_dates = trim($cleaned_dates, '"');
                                $dates = explode(', ', $cleaned_dates);
                                if (!empty($dates)) {
                                    $formatted_dates = implode(", ", $dates);
                                    echo $formatted_dates;
                                }}
                            ?>">
                    </div>
                    <div class="inputbox " >
                        <span for="CBTDate" class="details">CBT Date</span>
                        <input type="text" name="CBTDate" id="CBTDate" class="input" placeholder="Select multiple date" value="<?php  if(isset($_SESSION['update_prjct_status'])) {
                            $cleaned_dates = stripslashes($q3['CBTDate']);
                            $cleaned_dates = trim($cleaned_dates, '"');
                            $dates = explode(', ', $cleaned_dates);
                            if (!empty($dates)) {
                                $formatted_dates = implode(", ", $dates);
                                echo $formatted_dates;
                            }}
                            ?>">
                    </div>
                    <div class="inputbox ">
                        <span for="" class="details">CBT Shifts </span>
                        <input type="number" name="NoOfCBTShifts" id="" class="input" placeholder="Enter No Of Shifts" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['NoOfCBTShifts'];}?>">
                    </div>
                    <div class="inputbox " id="objmng">
                        <!-- <span for="ObjMngDate" class="details">Obj. Mgmt. Sched. (mm/dd/yyyy)</span> -->
                        <div class="project-details">
                            <div class="inputbox ">
                                <span for="ObjMngDateStart" class="details">Obj. Start Date(mm/dd/yyyy)</span>
                                <input type="date" name="ObjMngDateStart" id="ObjMngDateStart" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ObjMngLiveDate'];}?>">
                            </div>
                            <div class="inputbox ">
                                <span for="ObjMngDateEnd" class="details">Obj. End Date(mm/dd/yyyy)</span>
                                <input type="date" name="ObjMngDateEnd" id="ObjMngDateEnd" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ObjMngEndDate'];}?>">
                            </div>
                        </div>
                    </div> 
                    <div class="inputbox" >
                        <span for="ResultSub" class="details">Result Subm. Date (mm/dd/yyyy)</span>
                        <input type="date" name="ResultSub" id="ResultSub" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ResultSubmitDate'];}?>">
                    </div>
                    <div class="inputbox" >
                        <span for="prjctstts" class="details">Project Status<sup>*</sup></span>
                        <select name="prjctstts" id="prjctstts" class="input" required autocomplete="off">
                            <option value disabled >--Select--</option>
                            <option value="Ongoing" <?php if($q3['Status'] =="Ongoing"){echo"selected";}?>>Ongoing</option>
                            <option value="Amount Pending" <?php if($q3['Status'] =="Amount Pending"){echo "selected";}?>>Amount Pending</option>
                            <option value="Completed" <?php if($q3['Status'] == "Completed"){echo "selected";}?>>Completed</option>
                        </select>
                    </div>
                    <div class="inputbox  " >
                        <span for="DelayReason" class="details">Delay Reason/ Remarks</span>
                        <textarea id="DelayReason" name="DelayReason" class="input" rows="5" cols="100%" placeholder="Enter Delay Reason/ Remarks"><?php if(isset($_SESSION['update_prjct_status'])) { echo $q3['DelayReason']; } ?></textarea>
                    </div> 
                </div>
                <span class="allfields"><sup>*</sup>Fields are mandatory</span>
                <span class=""><input type="submit" value="Update" name="updateprjctdata"   class="button  input" ></span> 
            </form>
        </div>
        <script>
            function toggleServicePriceVisibility(checkboxId, priceId, priceKey) {
                document.getElementById(checkboxId).addEventListener('change', function() {
                    var priceField = document.getElementById(priceId);
                    
                    // Additional condition: display:none if the rounded price is strictly greater than 0
                    var shouldDisplay = this.checked && <?php echo isset($q3[$priceKey]) && intval($q3[$priceKey]) > 0 ? 'true' : 'false'; ?>;
                    
                    priceField.style.display = shouldDisplay ? 'block' : 'none';
                });
            }

            toggleServicePriceVisibility('option1', 'jammerPrice', 'JammerPrice');
            toggleServicePriceVisibility('option2', 'cctv recordingPrice', 'cctvRecordPrice');
            toggleServicePriceVisibility('option3', 'cctv live streamingPrice', 'cctvStreamPrice');
            toggleServicePriceVisibility('option4', 'iris scanningPrice', 'irisScanPrice');
            toggleServicePriceVisibility('option5', 'biometric capturingPrice', 'biometricPrice');

            toggleServicePriceVisibility('option6', 'hhmdPrice', 'HHMDPrice');
            toggleServicePriceVisibility('option7', 'gate scorePrice', 'GatePrice');
            toggleServicePriceVisibility('option8', 'skill testPrice', 'Skill_TestPrice');
        </script>
        <script src="/Otas/flatpickr-master/dist/flatpickr.min.js"></script>
        <script defer src="js/create-project.js"></script>
        <script defer src="js/services.js"></script>
    </section>
    
    </body>
</html>
<?php 
    if(isset($_POST['updateprjctdata'])){
        $Year= mysqli_real_escape_string($conn,$_POST['Year']);
        $ProjName= mysqli_real_escape_string($conn,$_POST['projectName']);
        $Orderdate= mysqli_real_escape_string($conn,$_POST['orderDate']);
        $Duration= mysqli_real_escape_string($conn,$_POST['Duration']);
        //scheduled date of completion
        $SchedDateofCompl=date('Y-m-d', strtotime($Orderdate . ' + ' . $Duration . ' days'));

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

        $PerCandRate= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['perCandRate']));
        $ExpCandCount= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['expCandCount']));
        $ActualCandCount= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['actualcandCount']));
        $ExpProjVal= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['estProjVal']));
        $ActProjVal=mysqli_real_escape_string($conn, str_replace(',', '', $_POST['actProjVal']));

        // $ActDateofCompl=mysqli_real_escape_string($conn,$_POST['actDOCompl']);
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
       
        $prjctstts=mysqli_real_escape_string($conn,$_POST['prjctstts']);

        $DelayReason=mysqli_real_escape_string($conn,$_POST['DelayReason']);

        $prID = $_SESSION['update_prjct_status'];

        // Prepare the SQL statement with placeholders
        $query3 = "UPDATE `otasprojectdata` SET `NameOfProject`=?, `Year`=?, `WorkOrderDate`=?, `Service`=?, `Duration`=?, `PerCandRate`=?, `SchedDateCompl`=?, `Status`=? ,`DelayReason`=? WHERE `projid`=?";
        $stmt = mysqli_prepare($conn, $query3);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssidssss", $ProjName, $Year, $Orderdate, $selectedServices, $Duration, $PerCandRate, $SchedDateofCompl,  $prjctstts,$DelayReason, $prID);
            
            if (mysqli_stmt_execute($stmt)) {
                $servicePrice="UPDATE `otasservicesprice` SET  `jammerVendorName`=?,`otherServiceVendor`=?,`JammerPrice`=?, `cctvRecordPrice`=?, `cctvStreamPrice`=?, `irisScanPrice`=?, `biometricPrice`=? ,`hhmdPrice`=?,`gateScorePrice`=?,`skillTestPrice`=? Where `projid`=?";
                $stmt_service_price=mysqli_prepare($conn,$servicePrice);

                if($stmt_service_price){
                    mysqli_stmt_bind_param($stmt_service_price,"ssdddddddds",$jammervendorname,$excludingJammerServiceVendor,$JammerPrice,$CCTVRecordPrice,$CCTVLiveStreamPrice,$IrisPrice,$BioPrice,$HHMDPrice,$GatePrice,$Skill_TestPrice,$prID);

                    if(mysqli_stmt_execute($stmt_service_price)){
                        $projdateQuery = "UPDATE `otasprojdates` SET `AplicLivDate`=?,`AplicLiveEndDate`=?, `AdmitLivDate`=?, `ObjMngLiveDate`=?,`ObjMngEndDate`=?, `CBTDate`=?,`NoOfCBTShifts`=?, `ResultSubmitDate`=? WHERE `projid`=?";

                        $stmt_projdate = mysqli_prepare($conn, $projdateQuery);

                        if($stmt_projdate){
                            mysqli_stmt_bind_param($stmt_projdate, "ssssssdss", $AplLivDate,$AplLivEndDate, $AdmitLivDate,  $ObjMngDateStart, $ObjMngDateEnd,$CBTDateEscaped ,$NoOfCBTShifts, $ResultSub, $prID);

                            if(mysqli_stmt_execute($stmt_projdate)){
                                $cancountQuery = "UPDATE `otasprcandcount` SET `ExpectCandCount`=?, `ActualCandCount`=? WHERE `projid`=?";
                                
                                $stmt_cancount = mysqli_prepare($conn, $cancountQuery);
                                if($stmt_cancount){
                                    mysqli_stmt_bind_param($stmt_cancount, "iis", $ExpCandCount, $ActualCandCount, $prID);
                                    if(mysqli_stmt_execute($stmt_cancount)){
                                        $projvalQuery = "UPDATE `otasprojval` SET `ExpectProjVal`=?, `ActualProjVal`=?,`QPCost`=?  WHERE `projid`=?";
                                    
                                        $stmt_projval = mysqli_prepare($conn, $projvalQuery);
                                        if($stmt_projval){
                                            mysqli_stmt_bind_param($stmt_projval, "ddds", $ExpProjVal, $ActProjVal,$qpcost, $prID);
                                            if(mysqli_stmt_execute($stmt_projval)){
                                                echo "<script>alert('Data Updated.');</script>";
                                                // $_SESSION['payment_status_update'] = $prID;

                                                // $secretKey = bin2hex(random_bytes(32)); 
                                                // $iv = bin2hex(random_bytes(16)); 
                                                // $encryptedID = openssl_encrypt($prID, 'AES-256-CBC', $secretKey, 0, $iv);

                                                // // header("Location: payment_status.php?id=$encryptedID");
                                                ?>
                                                <meta http-equiv="refresh" content="0; url=project-data.php">
                                                <?php
                                            } 
                                            else 
                                            {
                                                echo "<script>alert('Record not updated.');</script>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }    
                
            }
            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt_projdate);
            mysqli_stmt_close($stmt_cancount);
            mysqli_stmt_close($stmt_projval);
        }
    }
?>
<?php }?>