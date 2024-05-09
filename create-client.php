<?php
    include('connection.php');
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    $country = "SELECT * FROM countries";
    $county_qry = mysqli_query($conn, $country);
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="photos\images.png"/>
        <title>Create | Client</title>
        <link rel="stylesheet" href="css\container.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> 
        <script defer src="js/create-client.js"></script>
    </head>
    <body>
        <section class="home">
           <div class="client">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateForm()">
                    <h2>Create Client</h2>
                    <div>
                        <label for="clientName" class="label">Client Name<sup>*</sup></label>
                        <input type="text" id="clientName" name="clientName" required>
                    </div>
                    <div class="">
                        <label for="country" class="label">Country<sup>*</sup></label>
                        <select class="selectfont" id="country" name="country" required>
                            <option selected disabled value='' required>--Select Country--</option>
                            <?php while ($row = mysqli_fetch_assoc($county_qry)) : ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="">
                        <label for="state" class="label">State<sup>*</sup></label>
                        <select class="selectfont" id="state" name="state" required>
                            <option selected disabled>--Select State--</option>
                        </select>
                    </div>
                    <div class="">
                        <label for="city" class="label">City <sup>*</sup></label>
                        <select class="selectfont" id="city" name="city" required>
                            <option selected disabled>--Select City--</option>
                            <option value="other">Other City</option>
                        </select>
                    </div>
                    <div style="display: none;" id="otherCityInput">
                        <label for="otherCityInput" class="label">Other City</label>
                        <input type="text" name="otherCity">
                    </div>
                    <div>
                        <span class="required-text"><sup>*</sup>All fields are mandatory</span>
                    </div>
                    <div><button name="createClient" class="btn">Create</button></div>
                </form>
            </div>

        </section>
    </body>
</html>
<?php
    // create client Id
    if (isset($_POST['createClient'])) {
        $clientName = mysqli_real_escape_string($conn, $_POST['clientName']);
        $selectedCity = mysqli_real_escape_string($conn, $_POST['city']);
        $otherCity = mysqli_real_escape_string($conn, $_POST['otherCity']);
        $selectedStateId=mysqli_real_escape_string($conn,$_POST['state']);
        
        if ($selectedCity === 'other' && !empty($otherCity)) {
            $lastCityIdQuery = "SELECT id FROM `city` ORDER BY `id` DESC LIMIT 1";
            $lastCityIdResult = mysqli_query($conn, $lastCityIdQuery);
            
            if ($lastCityIdResult && $row = mysqli_fetch_assoc($lastCityIdResult)) {
                $lastid = $row['id'] + 1;
                $insertCityQuery = "INSERT INTO `city` (`id`, `name`, `state_id`) VALUES ('$lastid', '$otherCity', '$selectedStateId')";
                $insertCityResult = mysqli_query($conn, $insertCityQuery);
                
                if ($insertCityResult) {
                    $newCityId = $lastid;
                    $cityId = $newCityId;
                } else {
                    echo "<script>alert('Failed to add new city to the database.');</script>";
                }
            } else {
                echo "<script>alert('Failed to retrieve the last city ID.');</script>";
            }
        } else {
            $cityId = $selectedCity;
        }
        
        $checkid="SELECT * FROM `client` ORDER BY `ClientId` DESC LIMIT 1";
        $checkresultid=mysqli_query($conn,$checkid);
        
        if (mysqli_num_rows($checkresultid) > 0) {
            $row = mysqli_fetch_assoc($checkresultid);
            $lastClientId = $row['ClientId'];
            $get_numbers = (int) str_replace("CLOTAS_", "", $lastClientId);
            $id_increase = $get_numbers + 1;
            $clientId = "CLOTAS_" . str_pad($id_increase, 3, '0', STR_PAD_LEFT);
        } else 
        {
            $clientId = "CLOTAS_101";
        }
        $query = "INSERT INTO `client`(`ClientId`, `ClientName`, `CityId`) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $clientId, $clientName, $cityId);
            $result = mysqli_stmt_execute($stmt);
        
            if ($result) {
                $_SESSION['Client_ID'] = $clientId;
                echo "
                    <script>
                    alert(' New Entry Added.\\n Name: $clientName \\n Client Id : $clientId');
                    location.replace('clients.php');
                    </script> 
                ";
            } 
            else {
                echo "<script>alert('Record not inserted.');</script>";
            }
        }
        else{
            echo "<script>alert('Failed to prepare the statement.');</script>";
        }
    }
?>

<?php }?>