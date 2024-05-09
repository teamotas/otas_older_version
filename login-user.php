<?php
  require_once('connection.php');
  error_reporting(0);
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  session_start();

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
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="photos\images.png"/>
    <title>User | LogIn </title>
  </head>
  <body>
    <div class="loginform">
      <form id="form"  action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
        <h2> USER LOGIN </h2>
        <div class="error-input">
          <label for="UserEmail" class="label" >Email Id</label>
          <input type="email" name="EmailId" class='input' id="UserEmail" placeholder="Enter your EmailId"  autocomplete="off">
          <div id="UserEmailError" class="error-message"></div>
          <div class="error">
            <?php if (isset($_SESSION['required_mail'])) {
                echo $_SESSION['required_mail'];
                unset($_SESSION['required_mail']);
            } ?>
          </div>
        </div>
        <div class="error-input">
          <label for="pswd" class="label">Password</label>
          <input type="password" id="pswd" class='input' name="Password" placeholder="Enter your Password"  autocomplete="off">
          <div id="UserPasswordError" class="error-message"></div>
          <div class="error">
            <?php if (isset($_SESSION['required_password'])) {
              echo $_SESSION['required_password'] ;
              unset($_SESSION['required_password']); 
              }
            ?>
          </div>
        </div>
        <div class="centre">
          <div>
            <input type="checkbox" id="showpswd" onclick="password2()">&nbsp;
            <label for="showpswd" class=''>Show Password</label>  </div>
          </div>
          <button type="submit" class="loginbtn" name="login" > LogIn </button> 
          <div class="links">
            <a href="forgot-password.php">Forgot Password</a>
          </div>
        </div>
      </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src='js/login-user.js'></script>
  </body>
</html>
<?php

  $msg = "";
  // LOGIN USER
  if (isset($_POST['login'])){
    $EmailId = mysqli_real_escape_string($conn, $_POST['EmailId']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);

    if(empty($EmailId)){
      $_SESSION['required_mail'] = "Email Address is required";
      header("Location:login-user.php");
      exit();
    }
    if(empty($Password)){
      $_SESSION['required_password'] = "Password is required";
      header("Location:login-user.php");
      exit();
    }

    $query = "SELECT * FROM employee em
    JOIN roles ro ON em.EmployeeId = ro.EmployeeId
    WHERE em.EmailId = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $EmailId);
    mysqli_stmt_execute($stmt);

    $results = mysqli_stmt_get_result($stmt);

    if ($results && mysqli_num_rows($results) > 0) {
      $res = mysqli_fetch_assoc($results);
      $Pswd = $res['Password'];
      $email = $res['EmailId'];
      $userid=$res['EmployeeId'];
      $role=$res['UserRole'];

      if($role == 'User'){
        $verify = password_verify($Password, $Pswd);
        if ($verify) { 
  
          $_SESSION['user_id'] = $userid;

          header("Location: index.php");
          exit(); 
        }
        else{
          $msg = "Invalid Password";
          $_SESSION['error_message'] = $msg;
          header("Location:login-user.php");
          exit();
        }
      }
      else{
        $msg = "Invalid User";
        $_SESSION['error_message'] = $msg;
        header("Location:login-user.php");
        exit();
      }
    }else{
      $msg = "Invalid Email ID";
      $_SESSION['error_message'] = $msg;
      header("Location:login-user.php");
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>