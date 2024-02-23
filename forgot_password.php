<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forgot | Password</title>
        <link rel="stylesheet" href="css/password.css">
        <link rel="icon" type="image/png" href="photos\images.png"/>
    </head>
    <body>
        <div class="Passbox"> 
            <form action="mail.php" method="POST" enctype="application/x-www-form-urlencoded" onsubmit="return validateForm4();">
                <div>
                    <h2>Reset Password</h2>
                </div>
                <div>
                    <label for="email" class="label">Enter Email Address<sup style="  color:red;  font-size:1.5rem;">*</sup></label>
                    <input type="email" name="EmailId" class='input' id="email" placeholder="Enter Your Email Address Here">
                </div>
                <div>
                    <span style="display:inline-flex; color:red; font-size:1.4rem;"><sup >*</sup>Please enter your email address to recieve create password link.</span>
                </div>
                <div>
                    <input type="submit" value='Send' name='resetPass'>
                </div>
            </form>
        </div>
    </body>
</html>
