<?php
    session_start();
    include('connection.php');
    // require("jwt_auth.php");
    error_reporting(0); 
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    $adminType='';
    $adminName='';
    $adminId='';
    
    $userType='';
    $userName='';
    $userId='';

    if(isset($_SESSION['admin_id'])){
        $adminId = $_SESSION['admin_id'];
        $q78 = "SELECT * 
                FROM employee em, department dp, roles ro  
                WHERE em.EmployeeId = dp.EmployeeId 
                AND dp.EmployeeId = $adminId 
                AND ro.UserRole = 'Admin'";
        
        $adminDataQuery = mysqli_query($conn, $q78);
        
        if ($adminDataQuery) {
            // Check if any rows are returned
            if (mysqli_num_rows($adminDataQuery) > 0) {
                // Fetch the first row as an associative array
                $adminData = mysqli_fetch_assoc($adminDataQuery);
                $adminType = $adminData['UserRole'];
                $adminName = $adminData['Name'];
                $adminId=$adminData['EmployeeId'];
               
            } else {
                header("Location: login_admin.php");
                exit();
            }
        } else {
            // Handle query execution error
            echo "Error executing query: " . mysqli_error($conn);
            header("Location: login_admin.php");
            exit();
        }
        
    }
    else if(isset($_SESSION['user_id'])){
        $userId = $_SESSION['user_id'];
        $q78 = "SELECT * 
                FROM employee em, department dp, roles ro  
                WHERE em.EmployeeId = dp.EmployeeId 
                AND dp.EmployeeId = $userId 
                AND ro.UserRole = 'User'";
        
        $userDataQuery = mysqli_query($conn, $q78);
        
        if ($userDataQuery) {
            // Check if any rows are returned
            if (mysqli_num_rows($userDataQuery) > 0) {
                // Fetch the first row as an associative array
                $userData = mysqli_fetch_assoc($userDataQuery);
                $userType = $userData['UserRole'];
                $userName = $userData['Name'];
                $userId=$userData['EmployeeId'];
               
            } else {
                header("Location: login_user.php");
                exit();
            }
        } else {
            // Handle query execution error
            echo "Error executing query: " . mysqli_error($conn);
            header("Location: login_user.php");
            exit();
        }
        
    }
    
    if($adminType==='Admin'){
        $ongoingProjectsquery="SELECT * FROM `otasprojectdata` WHERE `Status`= 'Ongoing'";
        $result = mysqli_query($conn, $ongoingProjectsquery);
        $ongoingProjects = mysqli_num_rows($result);

        $pendingprojectquery="SELECT * FROM `otasprojectdata` WHERE `Status`= 'Amount Pending'";
        $result2 = mysqli_query($conn, $pendingprojectquery);
        $pendingProjects = mysqli_num_rows($result2); 

        $completedProjectsquery="SELECT * FROM `otasprojectdata` WHERE `Status`= 'Completed'";
        $result3 = mysqli_query($conn, $completedProjectsquery);
        $completedProjects = mysqli_num_rows($result3);

        $allProjects=$ongoingProjects+$pendingProjects+$completedProjects;

        $activeAdminquery="SELECT * FROM employee em,roles ro  WHERE em.EmployeeId=ro.EmployeeId And `UserRole`='Admin' ";
        $result4 = mysqli_query($conn, $activeAdminquery);
        $activeAdmin = mysqli_num_rows($result4);

        $activeusersquery="SELECT * FROM employee em,roles ro  WHERE em.EmployeeId=ro.EmployeeId And `UserRole`='User' ";
        $result5 = mysqli_query($conn, $activeusersquery);
        $activeusers = mysqli_num_rows($result5);
    }
    else if($userType==='User'){
        $ongoingProjectsquery = "SELECT *
        FROM `otasprojectdata` otasprdata
        JOIN `userotasproject` usrotasproj ON otasprdata.projid = usrotasproj.projid
        WHERE 
            otasprdata.`Status` = 'Ongoing' AND
            usrotasproj.EmployeeId = $userId ";
    
        $result = mysqli_query($conn, $ongoingProjectsquery);
        $ongoingProjects = mysqli_num_rows($result);
    
     
        $pendingprojectquery="SELECT *
        FROM `otasprojectdata` otasprdata
        JOIN `userotasproject` usrotasproj ON otasprdata.projid = usrotasproj.projid
        WHERE 
            otasprdata.`Status` = 'Amount Pending' AND
            usrotasproj.EmployeeId = $userId ";
        $result2 = mysqli_query($conn, $pendingprojectquery);
        $pendingProjects = mysqli_num_rows($result2); 
     
        $completedProjectsquery="SELECT *
        FROM `otasprojectdata` otasprdata
        JOIN `userotasproject` usrotasproj ON otasprdata.projid = usrotasproj.projid
        WHERE 
            otasprdata.`Status` = 'Completed' AND
            usrotasproj.EmployeeId = $userId ";
        $result3 = mysqli_query($conn, $completedProjectsquery);
        $completedProjects = mysqli_num_rows($result3);
     
        $allProjects=$ongoingProjects+$pendingProjects+$completedProjects;
     
    }
    if(($adminType==='Admin')||($userType==='User')){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="css/index.css">
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="icon" type="image/png" href="photos\images.png"/>
        <title>Dashboard | OTAS</title> 
    </head>
    <body>
    <?php ?>
        <header class="header-bar ">
            <div class="menu-button">
                <i class="bx bx-menu "></i>
            </div>
            <div class="image-text"> 
                <span class="image"><img src="photos\EdCIL_logo_svg.svg.png" alt="EDCIL"></span> 
                <div class="text logo-text"><span class="name">EDCIL | OTAS</span></div>
                    <div ><p class="usertype"><?php  if($adminName ){echo $adminName ;} else {echo $userName ;}?></p></div>
            </div> 
        </header>
        <nav class="sidebar open">
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="index.php">
                        <i class='bx bx-home-alt icon' ></i>
                        <span class="text nav-text" >Home</span>
                    </a>
                </li> 
                <?php if($adminType==='Admin'){?>
                <li class="nav-link">
                    <a href="#" class=''>
                        <i class='bx bx-user icon'></i>
                        <span class="text nav-text">Users</span>
                        <i class='hide bx bxs-chevron-down dropdown-icon'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="create-user.php">Create User</a></li>
                        <li><a href="employee-data.php" >Employee Data</a></li>
                    </ul>
                </li>
                <?php }?>
                
                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-briefcase icon' ></i>
                        <span class="text nav-text">Clients</span>
                        <i class='bx bxs-chevron-down dropdown-icon'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <?php //if($adminType==='Admin'){?>
                            <li><a href="create-client.php">Create Client</a></li>
                        <?php //}?>
                        <li><a href="clients.php">Client Data</a></li>
                    </ul>
                </li>
                
                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-task icon' ></i>
                        <span class="text nav-text">Projects</span>
                        <i class='bx bxs-chevron-down dropdown-icon'></i>
                    </a>
                    <ul class="dropdown-menu">
                    <?php if($userType==='User'){?>
                        <li><a href="choose-client.php" >Create Project</a></li>
                        <?php }?>
                        <li><a href="project-data.php">All Projects</a></li>
                    </ul>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-terminal icon' ></i>
                        <span class="text nav-text">TCS</span>
                        <i class='bx bxs-chevron-down dropdown-icon'></i>
                    </a>
                    <ul class="dropdown-menu">
                    <?php if($userType==='User'){?>
                        <li ><a href="choose-client-tcs.php">Create Project</a></li>
                        <?php }?>
                        <li><a href="project-data-tcs.php">All Projects</a></li>
                    </ul>
                </li>
            </ul>

            <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-task icon' ></i>
                        <span class="text nav-text">QPR Generator</span>
                        <i class='bx bxs-chevron-down dropdown-icon'></i>
                    </a>
                    <ul class="dropdown-menu">
                    <?php //if($userType===''){?>
                        <li><a href="report-generate.php">Generate Quarterly Report</a></li>
                        <? //}?>
                        <!-- <li><a href="#">PROJECTS IN PROGRESS Report Generate</a></li>
                        <li><a href="#">Fully Completed Report Generate</a></li>
                        <li><a href="#">Physically Completed Financially not Completed Report Generate</a></li> -->
                        
                    </ul>
                </li>

            <div class="bottom-content" >
                <li class="">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text" name="logout">Logout</span>
                    </a>
                </li>
            </div>
        </nav>
        <section class="home"  > 
    
        </section>
        <script defer src="js/sidebar.js"></script>
    </body>
</html>
<?php } ?>