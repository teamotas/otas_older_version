<?php
  session_start();
  require('connection.php');
  error_reporting(0);
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1); 
  
  if (isset($_SESSION['error_message'])) {
      echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
      unset($_SESSION['error_message']); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | LogIn </title>
  <link rel="stylesheet" href="css/login.css">
  <link rel="icon" type="image/png" href="photos/images.png">

  <style>    
    input, select {padding: 0 1rem;} 
    .error-message {
      color: red;
      font-size: 1.35rem;
      margin: 0.5rem 0 0 0.5rem;
      display: none; 
    }
  </style>
</head>
<body>
<div class="Logo"></div>
  <div class="loginform">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
      <h2> ADMIN LOGIN </h2>
      <div>
        <label for="AdminId" class="label">Email Id</label>
        <input type="email" name="AdminId" id="AdminId" placeholder="Enter your EmailId" autocomplete="off" class="input">
        <div id="AdminEmailError" class="error-message"></div>
        <div class="error">
          <?php if (isset($_SESSION['required_mail'])) {
              echo $_SESSION['required_mail'];
              unset($_SESSION['required_mail']);
          } ?>
        </div>
      </div>
      <br>
      <div>
        <label for="AdminPswd" class="label">Password</label>
        <input type="password" name="AdminPswd" id="AdminPswd" placeholder="Enter your Password" autocomplete="off" class="input">
        <div id="AdminPasswordError" class="error-message"></div>
        <div class="error">
          <?php if (isset($_SESSION['required_password'])) {
            echo $_SESSION['required_password'] ;
            unset($_SESSION['required_password']); 
            }
          ?>
        </div>
      </div>  
      <div class='centre'> <input type="checkbox" id='showpswd' onclick="password1()">&nbsp;<label for="showpswd">Show Password</label>  </div>  <br>
      <button class="loginbtn" type='submit' name="admin_login">LogIn</button>
      <div class="links">
        <a href="forgot_password.php">Forgot Password</a>
      </div>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script defer src='js/login_admin.js'></script>
</body>
</html>
<?php
  $msg = "";
  if (isset($_POST['admin_login'])) {
    $EmailId = mysqli_real_escape_string($conn, $_POST['AdminId']);
    $Password = mysqli_real_escape_string($conn, $_POST['AdminPswd']);

    if(empty($EmailId)){
      $_SESSION['required_mail'] = "Email Address is required";
      header("Location:login_admin.php");
      exit();
    }
    if(empty($Password)){
      $_SESSION['required_password'] = "Password is required";
      header("Location:login_admin.php");
      exit();
    }

    $query = "SELECT * FROM employee em
    JOIN roles ro ON em.EmployeeId = ro.EmployeeId
    WHERE em.EmailId = ? ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $EmailId);
    mysqli_stmt_execute($stmt);

    $results = mysqli_stmt_get_result($stmt);

    if ($results && mysqli_num_rows($results) > 0) {
        $res = mysqli_fetch_assoc($results);
        $Pswd = $res['Password'];
        $role = $res['UserRole'];
        $adminId=$res['EmployeeId'];

        if ($role == 'Admin') {
            $verify = password_verify($Password, $Pswd);
            if ($verify) {

              $_SESSION['admin_id'] = $adminId;

        
              header("Location:index.php");
              exit();
            } else {
                $msg = "Invalid Password";
                $_SESSION['error_message'] = $msg;
                header("Location:login_admin.php");
                exit();
            }
        } else {
            $msg = "Invalid User";
            $_SESSION['error_message'] = $msg;
            header("Location:login_admin.php");
            exit();
        }
    } else {
        $msg = "Invalid Email ID";
        $_SESSION['error_message'] = $msg;
        header("Location:login_admin.php");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>
