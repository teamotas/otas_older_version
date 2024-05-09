<?php
    include('connection.php');
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    $serviceschosen = array();
    if (isset($_POST['updateprojectdata'])) {
        if (isset($_POST['project_id1'])) {
            $_SESSION['update_prjct_status']=$_POST['project_id1'];
            $prID = $_SESSION['update_prjct_status'];
            // echo $prID;
            $sql = "SELECT *
            FROM tcsprojectdata prdata
            JOIN otasprcandcount count ON prdata.projid = count.projid
            JOIN tcscbtdata cbt ON count.projid=cbt.projid
            JOIN tcsresultdata res ON cbt.projid=res.projid
            Join client cl On prdata.ClientId=cl.ClientId
            where prdata.projid='$prID'";

            $data = mysqli_query($conn, $sql);
            $total = mysqli_num_rows($data);
            $q3=mysqli_fetch_assoc($data);
            $id=$q3['ClientId'];
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
        $serviceschosen = array();

        if (isset($q3) && !is_null($q3)) {
            $services = $q3["Service"];
            $serviceschosen = !empty($services) ? explode(",", $services) : array();
            $serviceschosen = array_map('trim', $serviceschosen);
            // print_r($serviceschosen);
        }
    }
 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/common.css">
        <title>Update | Data</title>
    </head>
    <body >
        <section class="home">
            <div class="container" >
                <?php   // $prID = $_SESSION['update_prjct_status']; // echo $prID?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" autocomplete="off" enctype="application/x-www-form-urlencoded" >
                    <h2>Update Project Data</h2>
                    <div class="project-details">
                        <div class="inputbox">
                            <span for="clientname" class='details'>Client Name</span>
                            <input type="text" name="clientName" id="clientname" class="input" disabled value="<?php echo $q1['ClientName'];?>" required>
                        </div>
                        <div class="inputbox">
                            <span for="clientid" class="details">Client ID</span>
                            <input type="text" name="clientId" id="clientid" class="input" disabled value="<?php echo $q1['ClientId']?>"required>
                            <input type="hidden" name="clientId" id="clientid"  value="<?php echo $q1['ClientId']?>">
                        </div>
                        <div class="inputbox">
                            <span for="clientcity" class="details">Client City</span>
                            <input type="text" name="clientCity" id="clientcity" class="input" disabled value="<?php echo $cityname;?>"required>
                        </div> 
                        <!-- <div class="inputbox">
                            <span for="projectID" class="details">Project ID<sup>*</sup></span>
                            <input type="text" name="projectID" disabled id="projectID" class="input" required value="<?php  //if(isset($_SESSION['update_prjct_status'])){ echo $prID;}?>">
                        </div> -->
                        <div class="inputbox projname">
                            <span for="projectname" class="details">Name Of Project<sup>*</sup>  </span>
                            <input type="text" name="projectName" id="projectname" class="input" placeholder="Enter Project Name Here" required value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['NameOfProject'];}?>">
                        </div>
                        <div class="inputbox"> 
                                <span for="year" class="details">Year<sup>*</sup></span>
                                <input type="number"  maxlength="4" name="Year" id="year" class="input" placeholder="Select year Of Project" required value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['Year'];}?>" readonly>
                        </div>
                        <div class="inputbox">
                            <span for="startDate" class="details">Work Order Date(mm/dd/yy)<sup>*</sup></span>
                            <input type="date" name="orderDate" id="startDate" class="input"
                            required value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['WorkOrderDate'];}?>" >
                        </div>
                        <div class="inputbox">
                            <span for="duration" class="details">Duration (In Days)<sup>*</sup></span>
                            <input name="Duration" class="input" type="number" id="duration" min="1" max="365" placeholder="Enter Duration Of Project" required  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['Duration'];}?>">
                        </div>
                        <div class="inputbox">
                            <span for="endDate" class='details'>Sched. Compl. Date(mm/dd/yy)</span>
                            <input type="date" name="schedCompl" id="endDate" class="input" readonly required value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['SchedDateCompl'];}?>">
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
                                        <input type="checkbox" id="selectAll">  &nbsp;Select All
                                    </div>
                                    <hr style="color:#eae8e4  ;">
                                    <div class="select-options">
                                        <input type="checkbox" id="option2" name="services[]" value="CCTV Recording" <?php echo in_array("CCTV Recording", $serviceschosen) ? 'checked' : ''; ?>> CCTV Recording<br>
                                        <!-- <pre class="servicesPrice"  id="cctv recordingPrice">CCTV Recording Price<br><input type="number" name="CCTVRecordPrice" id="cctv_recordingPrice" class="servicepriceinput"></pre> -->

                                        <input type="checkbox" id="option3" name="services[]" value="CCTV Live Streaming" <?php echo in_array("CCTV Live Streaming", $serviceschosen) ? 'checked' : ''; ?>> CCTV Live Streaming<br>
                                        <!-- <pre class="servicesPrice"  id="cctv live streamingPrice">CCTV Live Streaming Price<br><input type="number" name="CCTVLiveStreamPrice" id="cctv_live_streamingPrice" class="servicepriceinput"></pre> -->

                                        <input type="checkbox" id="option4" name="services[]" value="Iris Scanning" <?php echo in_array("Iris Scanning", $serviceschosen) ? 'checked' : ''; ?>> Iris Scanning<br>
                                        <!-- <pre class="servicesPrice"   id="iris scanningPrice">Iris Scanning Price<br><input type="number" name="IrisPrice"  id="iris_scanningPrice" class="servicepriceinput"></pre> -->

                                        <input type="checkbox" id="option5" name="services[]" value="Biometric Capturing" <?php echo in_array("Biometric Capturing", $serviceschosen) ? 'checked' : ''; ?>> Biometric Capturing<br>
                                        <!-- <pre class="servicesPrice"  id="biometric capturingPrice">Biometric Capturing Price<br><input type="number" name="BioPrice" id="biometric_capturingPrice" class="servicepriceinput"></pre> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="inputbox">
                            <span for="percandrate" class="details">Per Candidate Rate </span>
                            <input type="text" name="perCandRate" id="percandrate" class="input" required value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['PerCanRate'];}?>"  placeholder="Enter Per candidate rate">
                        </div>
                        <div class="inputbox">
                            <span for="expcandcount" class="details">Expected Candidate Count</span>
                            <input type="text" name="expCandCount" id="expcandcount" class="input" required value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ExpectCandCount'];}?>" placeholder="Enter candidate count" readonly>
                        </div>
                        <div class="inputbox">
                            <span for="estprojval" class="details">Estimated Project Value (In Rs.)</span>
                            <input type="text" name="estProjVal" id="estprojval" class="input" required readonly  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ExpectedVal'];}?>">
                        </div>
                        <div class="inputbox">
                            <span for="actualcandcount" class="details">Actual Candidate Count</span>
                            <input type="text" name="actualcandCount" id="actualcandcount" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ActualCandCount'];}?>" placeholder="Enter candidate count" readonly >
                        </div> 
                        <div class="inputbox">
                            <span for="actprojval" class="details">Actual Project Value (In Rs.)</span>
                            <input type="text" name="actProjVal" id="actprojval" class="input" readonly  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ActualVal'];}?>">
                        </div>
                        <div class="inputbox" >
                            <span for="prjctstts" class="details">Project Status<sup>*</sup></span>
                            <select name="prjctstts" id="prjctstts" class="input" required autocomplete="off">
                                <option value >--Select--</option>
                                <option value="Ongoing" <?php if($q3['Status'] =="Ongoing"){echo"selected";}?>>Ongoing</option>
                                <option value="Amount Pending" <?php if($q3['Status'] =="Amount Pending"){echo "selected";}?>>Amount Pending</option>
                                <option value="Completed" <?php if($q3['Status'] == "Completed"){echo "selected";}?>>Completed</option>
                            </select>
                        </div>
                    </div>
                    <span style=" color:red; font-size:1.4rem;"><sup>*</sup>All fields are mandatory</span>
                    <span class="">
                        <input type="submit" value="Update" name="updatetcsprjctdata"   class="button  input" >
                    </span>
                </form>
            </div>
            <script defer src="js/create-project-tcs.js"></script>
            <script defer src='js/services.js'></script>
        </section>
    </body>
</html>
<?php 
    if(isset($_POST['updatetcsprjctdata'])){
        $clientId= mysqli_real_escape_string($conn,$_POST['clientId']);
        $Year= mysqli_real_escape_string($conn,$_POST['Year']);
        $ProjName= mysqli_real_escape_string($conn,$_POST['projectName']);
        $Orderdate= mysqli_real_escape_string($conn,$_POST['orderDate']);
        $Duration= mysqli_real_escape_string($conn,$_POST['Duration']);
        $SchedDateofCompl=date('Y-m-d', strtotime($Orderdate . ' + ' . $Duration . ' days'));
        if (isset($_POST['services']) && is_array($_POST['services'])) {
            $selectedServices = implode(", ", $_POST['services']);
        } else {
            $selectedServices = ''; // or any default value
        }

        $PerCandRate = mysqli_real_escape_string($conn, str_replace(',', '', $_POST['perCandRate']));
        $ExpProjVal = mysqli_real_escape_string($conn, str_replace(',', '', $_POST['estProjVal']));
        $ActProjVal = mysqli_real_escape_string($conn, str_replace(',', '', $_POST['actProjVal']));

        $prjctstts=mysqli_real_escape_string($conn,$_POST['prjctstts']);

        $prID = $_SESSION['update_prjct_status'];

        $query3="UPDATE `tcsprojectdata` SET `ClientId`=?,`NameOfProject`=?,`Year`=?,`WorkOrderDate`=?,`Duration`=?,`SchedDateCompl`=?,`PerCanRate`=?,`ExpectedVal`=?,`ActualVal`=?,`Service`=?,`Status`=? WHERE `projid`= ?";
        $stmt = mysqli_prepare($conn, $query3);

        if($stmt){    
            mysqli_stmt_bind_param($stmt, "ssssisiddsss", $clientId,$ProjName, $Year, $Orderdate,$Duration, $SchedDateofCompl, $PerCandRate,$ExpProjVal, $ActProjVal, $selectedServices, $prjctstts,  $prID);

            if (mysqli_stmt_execute($stmt)) {                
                echo "<script>alert('Data Updated.');</script>";
                ?><meta http-equiv="refresh" content="0; url=project-data-tcs.php"><?php
            } 
            else{
                echo "<script>alert('Record not updated.');</script>";
                ?><meta http-equiv="refresh" content="0; url=project-data-tcs.php"><?php
            }
        }
        mysqli_stmt_close($stmt);
    }
?>



<?php }?>