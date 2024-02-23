<?php
    include('connection.php');
    session_start();
    error_reporting(0);
    if(isset($_GET['Id'])){
        $adminId =$_GET['Id'];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/popup.css">
        <script>
            // console.log("Script executed!");
            window.onload = function() {
                // Fetch the session variable value using JavaScript
                var fileReady = <?php 
                echo isset($_SESSION['fileReady']) ? 'true' : 'false'; ?>;
                
                // Check if the session variable is set to indicate the file is ready
                if (fileReady) {
                    // Display the popup
                    var popup = document.getElementById('popup');
                    popup.style.display = 'block';
                }
            }
            function download(){
                location.replace("generate_excel_employee.php?AdminId=<?php echo $adminId; ?>");
            }
            function closePopup() {
                var popup = document.getElementById('popup');
                popup.style.display = 'none';
                location.replace('employee_data.php');
            }
        </script>
    </head>
    <body>
        <div id="popup" style="display: none;">
            <div class="popup-content">
                <p>Your file is ready for download!</p><br>
                <!-- <p>And it wil save in D:\ drive </p> -->
                <!-- <a href="generate_excel.php">Download</a> -->
                <!-- <a href="userdata.php">Go to userdata page</a> -->
                <button onclick="download()">Download</button>
                <button onclick="closePopup()">Close</button>
            </div>
        </div>
    </body>
</html>