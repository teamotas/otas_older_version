<?php
  require('connection.php');   error_reporting(0);
  include "sidebar.php";
  session_start();

 if($adminType==='Admin'){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Create | User</title>
      <link rel="stylesheet" href="css/container.css">
      <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
      <script src="js/create_user.js"></script>
  </head>
  <body>
    <section class="home">
      <div class="user" >
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off" enctype="application/x-www-form-urlencoded" >
            <div class="heading"><h2>Create User</h2></div>
            <div class="">
                <label for="name" class="label">Name <sup>*</sup> <span id="nameError" class="error-message"></span></label>
                <input type="text" name="Name" id="name"  autocomplete="off"
                placeholder="Enter Name" >
            </div>
            <div class="">
                <label for="email" class="label">Email Id<sup>*</sup><span id="emailError" class="error-message"></span>
                </label>
                <input type="email" name="EmailId" id="email"  autocomplete="off" placeholder="@edcil.co.in" > </div>
            <div class="">
                <label for="empid" class="label">Employee Id<sup>*</sup><span id="empIdError" class="error-message"></span></label>
                <input type="text" name="EmployeeId" id="empid"  autocomplete="off" placeholder="Enter Employee Id ">
            </div>
            <div class="">
                <label for="profilename" class="label">Designation<sup>*</sup><span id="designationError" class="error-message"></span></label>
                <input type="text" name="Designation" id="profilename" autocomplete="off" placeholder="Enter Designation" >
            </div>
            <div  class="selection">
              <div class="select">
                <label for="userrole" class="label">User Role :</label>
                <select id="userrole" name="UserRole" value='Not Selected'  autocomplete="off" >
                  <option value  selected>Select</option>
                  <option value="Read">Read</option>
                  <option value="User">User</option>
                  <option value="Admin">Admin</option>
                </select>
              </div>
              <div class="select">
                <label for="department" class="label">Department<sup>*</sup> :</label>
                <select id="department" name="Department"  autocomplete="off" >
                  <option   >Select</option>
                  <option value='OTAS'>OTAS</option>
                </select>
                <span id="departmentError" class="error-message-side"></span>
              </div>
            </div>
            <div class="Gender">
              <span class="label">Gender<sup>*</sup>:</span>
              <span id="genderError" class="error-message"></span> 
              <input type="radio" name="Gender" id="male" value="Male" autocomplete="off" class="" >
              <label for="male" >&nbsp;Male</label>
              <input type="radio" name="Gender" id="female" value="Female" autocomplete="off" class="">
              <label for="female" >&nbsp;Female</label>
            </div>
            <div class="">
              <label for="dob" class="label">Date Of Birth</label>
              <input type="date" name="DateOfBirth" id="dob"  autocomplete="off" placeholder="Select Date Of Birth">
            </div>
            <div class="">
                <label for="mobile" class="label">Mobile No<sup>*</sup><span id="phoneError" class="error-message"></span></label>
                <input type="tel" name="MobileNo" id="mobile" maxlength="10"  autocomplete="off" placeholder="Enter Mobile Number" >
            </div>
            <div class="">
              <label for="pswd" class="label">Password<sup>*</sup>
                <div class="info-icon">
                  <i class='bx bx-error-circle'></i>
                  <div class="tooltip">
                    <p>Password must contain:</p>
                    <ul>
                      <li>At least 8 characters</li>
                      <li>At least one uppercase letter</li>
                      <li>At least one number</li>
                      <li>At least one special character</li>
                    </ul>
                  </div>
                </div>
              </label>
              <input type="password" name="Password" id="pswd" autocomplete="off" placeholder="Enter Password" >
              <span id="passwordError" class="error-message"></span>
            </div>
            <div class="">
              <label for="pswd" class="label">Confirm Password<sup>*</sup></label>
              <input type="password" name="ConfirmPassword" id="pswd1" autocomplete="off" placeholder="Enter Confirm Password" >
              <span id="confirmPasswordError" class="error-message"></span>
              <div class='showpswd'>
                <input type="checkbox" id="showpswd" onclick="password()">&nbsp;<label for="showpswd"  class="label" >&nbsp;&nbsp;Show Password</label>
              </div>
            <div>
          <button type="submit" class="btn" name="create">Create</button>
        </form>
      </div>
    </section>
  </body>
</html>
<?php 
   $errors = array();
  // Create User
  if(isset($_POST['create'])){
    $Name= mysqli_real_escape_string($conn,$_POST['Name']);
    $EmailId= mysqli_real_escape_string($conn,$_POST['EmailId']);
    $EmployeeId= mysqli_real_escape_string($conn,$_POST['EmployeeId']);
    $UserRole= mysqli_real_escape_string($conn,$_POST['UserRole']);
    $Department= mysqli_real_escape_string($conn,$_POST['Department']);
    $Designation= mysqli_real_escape_string($conn,$_POST['Designation']);
    $MobileNo= mysqli_real_escape_string($conn,$_POST['MobileNo']);
    $DateOfBirth= mysqli_real_escape_string($conn,$_POST['DateOfBirth']);
    $Gender= mysqli_real_escape_string($conn,$_POST['Gender']);
    $Password=mysqli_real_escape_string($conn,$_POST['Password']);
    $ConfirmPassword=mysqli_real_escape_string($conn,$_POST['ConfirmPassword']);

    if(empty($Name) || empty($EmailId) || empty($EmployeeId) || empty($Department) || empty($Designation) || empty($MobileNo) || empty($Password) || empty($ConfirmPassword)) {
      $errors = "* Fields are required.";
      echo $errors;
    }

    function validateEmail($email) {
      if (empty($email)) {
        return "Email address is required.";
      }
      
      $emailRegex = '/^[a-zA-Z0-9_.-]+@edcil\.co\.in$/';
      if (!preg_match($emailRegex, $email)) {
        return "Invalid email address.";
      }
      return ""; 
    }
    if ($Password !== $ConfirmPassword) {
      $errors[] = "Passwords do not match.";
    }
    function validatePassword($Password) {
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $Password)) {
        $errors[] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
    }}
    // Email validation
    $emailError = validateEmail($EmailId);
    if (!empty($emailError)) {
        $errors['email'] = $emailError;
    }

    // Password validation
    $passwordError = validatePassword($Password);
    if (!empty($passwordError)) {
        $errors['password'] = $passwordError;
    }
    if (empty($errors)) {
      $user_check_query = "SELECT * FROM employee WHERE EmployeeId=? OR EmailId=? LIMIT 1";
      $stmt = mysqli_prepare($conn, $user_check_query);
      mysqli_stmt_bind_param($stmt, "ss", $EmployeeId, $EmailId);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      $user = mysqli_fetch_assoc($result);

      if ($user['EmployeeId'] === $EmployeeId || $user['EmailId'] === $EmailId) {
        echo"<script>alert('User already exists.');</script>";
        ?><meta http-equiv="refresh" content="0;  URL=index.php" /><?php
      }
      else{
        $encpswd=password_hash($Password,PASSWORD_DEFAULT);//encrypt the password
        $query = "INSERT INTO employee (Name,EmailId,EmployeeId,Designation,MobileNo,DateOfBirth,Gender,Password) VALUES (?,?,?,?,?,?,?,?)";
        $noquery=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($noquery,"ssssisss",$Name,$EmailId,$EmployeeId,$Designation,$MobileNo,$DateOfBirth,$Gender,$encpswd);

        if(mysqli_stmt_execute($noquery)){
          $query2="INSERT INTO roles(EmployeeId,UserRole) VALUES(?,?)";
          $noquery2=mysqli_prepare($conn,$query2) ;
          mysqli_stmt_bind_param($noquery2,"ss", $EmployeeId,$UserRole);
        
          if(mysqli_stmt_execute($noquery2)){
            $checkid="SELECT * FROM `department` ORDER BY `DepartmentId` DESC LIMIT 1";
            $checkresultid=mysqli_query($conn,$checkid);

            if ($checkresultid) {
              if (mysqli_num_rows($checkresultid) > 0){
                $row = mysqli_fetch_assoc($checkresultid);
                $lastid=$row['DepartmentId'];
                $get_numbers=(int) str_replace("OTAS","",$lastid);
                $id_increase=$get_numbers+1;
                $get_string=str_pad($id_increase,5,0,STR_PAD_LEFT);
                $DepartmentId="OTAS" . $get_string;
              } 
              else {
                $DepartmentId="OTAS00001";
              }
              $query3="INSERT INTO `department`(`DepartmentName`, `DepartmentId`, `EmployeeId`) VALUES (?,?,?)";
              $noquery3=mysqli_prepare($conn,$query3);
              mysqli_stmt_bind_param($noquery3,"sss",$Department,$DepartmentId,$EmployeeId);

              if(mysqli_stmt_execute($noquery3)){
                echo"<script>
                alert(' New Entry Added.\\n Name: $Name \\n Department Id : $DepartmentId');
                location.replace('employee_data.php');</script> ";
              }
              else{
                echo"<script>
                alert('Record not inserted.');
                </script>";
              }
            }
          }
        }
      }
      mysqli_close($conn);
    }
  }
?>
<?php }?>