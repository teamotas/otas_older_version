<?php
    include('connection.php');
    error_reporting(0); 
    include "sidebar.php";
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create | Project</title>
        <link rel="stylesheet" href="css/container.css">
    </head>
    <body>
        <section class="home">
            <div class="choose-client" >
                <form action="create_project.php" method="Post" >
                    <h2>Select Client</h2>
                    <label for="chooseClient" class="label">Select Client to Create Project<sup>*</sup></label>
                    <select name="selectedClient" id="chooseClient" required>
                        <option value='' selected>--Select Client--</option>
                        <?php 
                            $Q2 = "SELECT * from client ";
                            $q11 = mysqli_query($conn, $Q2);
                            while ($q01 = mysqli_fetch_assoc($q11)) : ?>
                                <option value="<?php echo $q01['ClientId'];   ?>" data-clientid="<?php echo $q01['ClientId']; ?>"><?php echo $q01['ClientName']; ?></option>
                        <?php endwhile; ?>
                        <div class="error"></div>
                    </select>
                    <div>
                        <span class="required-text"><sup>*</sup>Select client</span>
                    </div> 
                    <input type="submit" value="Select" class="btn" name="chooseclient">
                </form>
            </div>
        </section>
    </body>
</html>
<?php }?>