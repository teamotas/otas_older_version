<?php
    require_once 'phpmailer\src\PHPMailer.php';
    require_once 'phpmailer\src\SMTP.php';
    require_once 'phpmailer\src\Exception.php';
    require_once 'connection.php';

    use Elementor\Modules\WpCli\Update;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Retrieve email details from the database
    if ($_POST['resetPass']) {
        $email = $_POST['EmailId'];
        // Check if the email exists in your user table
        $query = "SELECT * FROM employee WHERE EmailId = '$email'";
        $result = mysqli_query($conn, $query);
        
        if ( mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $userId=$row['EmployeeId'];

            // Generate a unique reset token
            $Token = bin2hex(random_bytes(32));


            // // password reset email details
            // $resetLink = "<a href='http://localhost/otas/create_new_password.php?emid=$userId&token=$Token'><input type='button' value='Click Here' style='color:blue;'> </a>";

            // $recipientEmail =$row['EmailId'];
            // $emailSubject = "Password Reset Link";
            // $emailBody =  "Dear ".$row['Name'].",<br>To reset your password, Click the button below \n" . $resetLink;

            // password reset email details
            $resetLink = "<a href='http://localhost/otas/create_new_password.php?emid=$userId&token=$Token' style='background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;'>Reset Your Password</a>";

            $recipientEmail = $row['EmailId'];
            $emailSubject = "Reset Your Password";
            $emailBody = "<html><body>";
            $emailBody .= "<p>Dear " . $row['Name'] . ",</p>";
            $emailBody .= "<p>We received a request to reset your password. Click the button below to reset your password:</p>";
            $emailBody .= "<p>" . $resetLink . "</p>";
            $emailBody .= "<p>If you did not request a password reset, please ignore this email.</p>";
            $emailBody .= "<p>Thank you,</p>";
            $emailBody .= "<p>EdCIL | OTAS </p> ";
            $emailBody .= "</body></html>";

        }
    }
    else{
        header("location:login_user.php");
    }
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // SMTP host
        $mail->Port = 587;  // SMTP port
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  //TLS encryption
        $mail->SMTPAuth = true;
        $mail->Username = "nitishedcil@gmail.com";  // email username
        $mail->Password = 'qhgc uxhf tyzz wrji';  // email password

        // Sender and recipient details
        $mail->setFrom('nitishedcil@gmail.com', 'Nitish Kumar');  // email and name
        $mail->addAddress($recipientEmail);  //email address fetched from the database

        // Email content
        $mail->Subject = $emailSubject;
        $mail->Body = $emailBody;
        $mail->AltBody = strip_tags($emailBody);  // alternative plain text content

        // Send the email
        $done= $mail->send();
        if($done){

            //store the token into table 
            $tokenquery="UPDATE employee Set token='$Token' Where EmailId='$email'";
            $tquery=mysqli_query($conn,$tokenquery);
            
            echo"<script>
            alert('Email Sent Successfully.');
            </script>" ;
        }          
    } catch (Exception $e) {
        echo"
        <script>
            alert('$mail->ErrorInfo');
            location.replace('forgot_password.php');
        </script>";
    }

    // Close the database connection 
    mysqli_close($conn);
?>