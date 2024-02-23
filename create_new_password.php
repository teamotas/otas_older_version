<?php
    require_once('connection.php');
    $token = isset($_GET['token']) ? $_GET['token'] : null;
    $id = isset($_GET['emid']) ? $_GET['emid'] : null;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create | Password</title>
        <link rel="stylesheet" href="css/password.css">
        <link rel="icon" type="image/png" href="photos\images.png"/>
        <script src="js/create_user.js"></script>
    </head>
    <body>
        <div class='Passbox'>
            <div>    <h2>Create New Password</h2>     </div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="application/x-www-form-urlencoded" onsubmit="return validateForm3();">
                <div class="">
                    <label for="pswd" class="label">New Password</label>
                    <input type="password" name="Password" class="input" id='pswd' autocomplete="off"
                    placeholder="Enter Password">
                </div>
                <div class="">
                    <label for="pswd" class="label">Confirm Password</label>
                    <input type="password" name="ConfirmPassword" class="input" id='pswd1' autocomplete="off"
                    placeholder="Enter Confirm Password">
                </div>
                <input type="hidden" name="id" value="<?php echo $id?>">
                <input type="hidden" name="token" value="<?php echo $token;?>">
                <div class="showpswd">
                    <input type="checkbox" onclick="password()" id="showpswd">&nbsp;<label for="showpswd" >Show Password</label>
                </div>
                <div>
                    <input type="submit" value='Update' name='create'>
                </div>
            </form>
        </div>
    </body>
</html>
<?php
    if(isset($_POST['create'])){ 
        $Password=mysqli_real_escape_string($conn,$_POST['Password']);
        $ConfirmPassword=mysqli_real_escape_string($conn,$_POST['ConfirmPassword']);
        $id=mysqli_real_escape_string($conn,$_POST['id']);
        $token=mysqli_real_escape_string($conn,$_POST['token']);

        // if (empty($Password)) { array_push($errors, "Password is required"); }
        // if (empty($ConfirmPassword)) { array_push($errors, "Confirm Password required"); }

        if($id){
            if($token){
                $done="SELECT * from employee where EmployeeId='$id' AND token='$token'";
                $doneq=mysqli_query($conn,$done);
                if(mysqli_num_rows($doneq) >0){

                    if ($Password === $ConfirmPassword) {
                        $Password=$ConfirmPassword;

                        $encpswd=password_hash($Password,PASSWORD_DEFAULT);

                        $Q="UPDATE employee set Password='$encpswd', token=0 where EmployeeId=$id";
                        $Q2=mysqli_query($conn,$Q);
                        if($Q2){
                            echo"<script> alert('Password Updated.');</script>" ;
                        }
                        else{
                            echo"<script>alert('Password Not Updated.');</script>";
                        }
                    }
                }
                else{
                    echo"<script> alert('Link Expired.');</script>";
                }
            }
            else{
                echo"<script> alert('Token Not Found.');</script>";
            }
        }
        else{
            echo"<script> alert('Employee ID Not Found.');</script>" ;
        }
    }
?>