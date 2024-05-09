<?php
    include('connection.php');    
    include "sidebar.php";
    session_start();
    // error_reporting(0); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if(($adminType==='Admin')||($userType==='User')){
?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <section class="home">      
            <div class="card-container">
                <div class="card" onclick="window.location.href='project-data.php'">
                    <div class="icon2">
                        <img src="photos/clipboard.png" alt="" class="img2">
                    </div>
                    <h2>All Projects</h2>
                    <p><?php echo $allProjects; ?></p>
                </div>

                <div class="card" onclick="window.location.href='ongoing-projects.php'">
                    <div class="icon2">
                        <img src="photos/contract.png" alt="" class="size img2">
                    </div>
                    <h2>Ongoing Projects</h2>
                    <p><?php echo $ongoingProjects; ?></p>
                </div>

                <div class="card" onclick="window.location.href='pending-projects.php'">
                    <div class="icon2">
                        <img src="photos/clock.png" alt="" class="img2"></img>
                    </div>
                    <h2>Amount Pending Projects</h2>
                    <p><?php echo $pendingProjects; ?></p>
                </div>

                <div class="card" onclick="window.location.href='completed-projects.php'">
                    <div class="icon2">
                        <img src='photos/planner.png' class="img2"></img>
                    </div>
                    <h2>Completed Projects</h2>
                    <p><?php echo $completedProjects; ?></p>
                </div>
                <?php if($adminType==='Admin'){?>
                <div class="card" onclick="window.location.href='admin-data.php'">
                    <div class="icon2">
                        <img src='photos/multiple-users-silhouette.png' class="img2"></img>
                    </div>  
                    <h2>Admin</h2>
                    <p><?php echo $activeAdmin; ?></p>
                </div>
                <div class="card" onclick="window.location.href='user-data.php'">
                    <div class="icon2">
                        <img src='photos/multiple-users-silhouette.png' class="img2"></img>
                    </div>  
                    <h2>User</h2>
                    <p><?php echo $activeusers; ?></p>
                </div>
                <?php }?>
            </div>  
        </section>
    </body>
</html>
<?php 
}else{
    header("Location: login-admin.php");}
?>