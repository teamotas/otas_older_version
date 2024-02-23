<?php
    include('connection.php');  include "sidebar.php";
    session_start();
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    if($adminType==='Admin'){
    if (isset($_POST['updateEmployee'])){
        if(isset($_POST['employee_id'])){  
            $_SESSION["id"]= $_POST['employee_id'];
            $id =$_SESSION['id'];
            $q2 = "SELECT * FROM employee em
            JOIN department dp ON em.EmployeeId = dp.EmployeeId
            JOIN roles ro ON dp.EmployeeId = ro.EmployeeId
            WHERE em.EmployeeId = ?";
            $stmt = mysqli_prepare($conn, $q2);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $re = mysqli_fetch_assoc($result);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="photos\images.png"/>
        <title>Update | UserData</title>
        <link rel="stylesheet" href="css/container.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script defer src="js/update_user.js"></script>
    </head>
    <body>
    <section class="home">
        <div class="user">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  enctype="multipart/form-data" >
                <?php //include('errors.php');?>
                <h2  >Update User Details</h2><br>
                <div class="image-preview">
                    <?php if (!empty($re['emplimage']) && file_exists($re['emplimage'])) : ?>
                        <img src="<?php echo $re['emplimage'];?>" alt="Uploaded Image" class="preview-image">
                    <?php else : ?>
                        <img src="photos/default_image.jpeg" alt="Default Image" class="preview-image">
                    <?php endif; ?>
                </div>                
                <div class="">
                    <label for="emplimage1" class='label'>Upload Image</label>
                    <input type="file" name="emplimage" id="emplimage1" value="<?php if (!empty($re['emplimage']) && file_exists($re['emplimage'])) { echo ($re['emplimage']); } ?>">

                    <?php if (!empty($re['emplimage']) && file_exists($re['emplimage'])) : ?>
                        <p>File Name : <?php echo basename($re['emplimage']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="">
                    <label for="name" class="label">Name<sup>*</sup><span id="nameError" class="error-message"></span> </label>
                    <input type="text" name="Name" id="name"   value="<?php echo $re['Name']; ?>" s> 
                </div>
                <div class="">
                    <label for="email" class='label'>Email ID<sup>*</sup><span id="emailError" class="error-message"></span></label>
                    <input type="email" name="EmailId" id="email"   value="<?php echo $re['EmailId']; ?>" >
                </div>
                <div class="">
                    <label for="empid" class="label">
                        Employee Code<sup>*</sup><span id="empIdError" class="error-message"></span>
                    </label>
                    <input type="text" name="EmployeeId" id="empid" disabled value="<?php echo isset($re['EmployeeId']) ? htmlspecialchars($re['EmployeeId']) : ''; ?>">
                </div>
                <div class="">
                    <label for="profilename" class="label">Designation<sup>*</sup><span id="designationError" class="error-message"></span></label>
                    <input type="text" name="Designation" id="profilename"  value="<?php echo $re['Designation']; ?>" >
                </div>
                <div >
                    <span>
                        <label for="userrole" class="label">User Role :</label>
                        <select id="userrole" name="UserRole" value='Not Selected' >
                            <option value disabled selected>Select</option>
                            <option value="Read"<?php if($re['UserRole'] == "Read"){echo "selected";}?> >Read</option>
                            <option value="User" <?php if($re['UserRole'] == "User"){echo "selected";}?>>User</option>
                            <option value="Admin" <?php if($re['UserRole'] == "Admin"){echo "selected";}?>>Admin</option>
                        </select>
                    </span>
                </div>
                <div class="Gender">Gender <sup>*</sup>:<span id="genderError" class="error-message"></span>
                    <input type="radio" name="Gender" id="male" value="Male" <?php if($re['Gender']== 'Male'){echo 'Checked';}?> >
                    <label for="male" >&nbsp;Male</label>
                    <input type="radio" name="Gender" id="female" value="Female" <?php if($re['Gender']== 'Female'){echo 'Checked';}?>>
                    <label for="female" >&nbsp;Female</label>
                </div>
                <div class="">
                    <label for="dob" class="label">Date Of Birth</label>
                    <input type="date" name="DateOfBirth" id="dob"   value="<?php echo $re['DateOfBirth']; ?>">
                </div>
                <div class="">
                    <label for="mobile" class="label">Mobile No<sup>*</sup><span id="phoneError" class="error-message"></span></label>
                    <input type="tel" name="MobileNo" id="mobile" maxlength="10"  value="<?php echo $re['MobileNo']; ?>" >
                </div>
                <input type="hidden" name="existingImage" value="<?php echo $re['emplimage']; ?>">
                <input type="submit" value="Update" class="btn" name="update2" >
            </form> 
        </div>
    </section>
    </body>
</html>
<?php
    // Update data in three tables  $_GET['key1']
    if(isset($_POST['update2'])){    
        $existingImage = $_POST['existingImage'];
        if (!empty($_FILES['emplimage']['name'])) {
            // Upload new image
            $filename = $_FILES['emplimage']['name'];
            $tempname = $_FILES['emplimage']['tmp_name'];
            $folder = 'employee_images/' . $filename;
            move_uploaded_file($tempname, $folder);
            // Use the new image path for the update
            $imagePath = $folder;
        } else {
            // Use the existing image path if it exists
            if (!empty($existingImage) && file_exists($existingImage)) {
                $imagePath = $existingImage;
            } else {
                // Use the default image path if no existing image or file not found
                $imagePath = 'photos/default_image.jpeg';
            }
        }

        $id = $_SESSION['id'];
        $Name = mysqli_real_escape_string($conn, $_POST['Name']);
        $EmailId = mysqli_real_escape_string($conn, $_POST['EmailId']);
        $EmployeeId = mysqli_real_escape_string($conn, $_POST['EmployeeId']);
        $Designation = mysqli_real_escape_string($conn, $_POST['Designation']);
        $MobileNo = mysqli_real_escape_string($conn, $_POST['MobileNo']);
        $DateOfBirth = mysqli_real_escape_string($conn, $_POST['DateOfBirth']);
        $Gender = mysqli_real_escape_string($conn, $_POST['Gender']);
        $UserRole = mysqli_real_escape_string($conn, $_POST['UserRole']);

        $query = "UPDATE employee em
        JOIN roles ro ON em.EmployeeId = ro.EmployeeId
        SET `em`.`emplimage` = ?,
        `em`.`Name` = ?,
        `em`.`EmailId` = ?,
        `em`.`Designation` = ?,
        `em`.`MobileNo` = ?,
        `em`.`DateOfBirth` = ?,
        `em`.`Gender` = ?,
        `ro`.`UserRole` = ?
        WHERE em.EmployeeId = ?";
        $stmt = mysqli_prepare($conn, $query);
        
        mysqli_stmt_bind_param($stmt, "ssssssssi", $imagePath, $Name, $EmailId, $Designation, $MobileNo, $DateOfBirth, $Gender, $UserRole, $id);

        if(mysqli_stmt_execute($stmt)) {
            echo"<script>alert('Records Updated');</script>";
            ?> <meta http-equiv="refresh" content="0;  URL=employee_data.php" /><?php
        } else {
            echo "Error updating data: " . mysqli_error($conn);
        }

    }
    // Close database connection
    mysqli_close($conn);
?>

<?php }?>