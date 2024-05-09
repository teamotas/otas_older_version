<?php 
    include "connection.php"; 
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    if(($adminType==='Admin')||($userType==='User')){
    $sql="SELECT * from  client ";
    $query=mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clients</title>
        <link rel="stylesheet" href="css/table.css">
    </head>
    <body>
        <section class="home">
            <?php if (mysqli_num_rows($query) > 0) { ?>
                <table border="4" style="background:scroll;" >
                    <thead > 
                        <tr>
                            <td colspan="100%"  class="thtr">Client Data</td>
                        </tr>
                        <tr class="thead">
                            <th class=" thclientstyle">Sr. No.</th>
                            <th class=" thclientstyle">Client Name</th>
                            <th class=" thclientstyle">Client Id</th>
                            <th class=" thclientstyle">Client City</th>
                            <th class=" thclientstyle">State</th>
                            <th class=" thclientstyle">Country</th>
                            <!-- <th class=" thclientstyle" colspan="">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $srNo = 1;
                        while ($client = mysqli_fetch_assoc($query)) {
                        $cityId = $client['CityId'];
                        $cityname = '';
                        $statename = '';
                        $countryname = '';
                        if ($cityId >= 0) {
                            $sql = "SELECT c.name AS city_name, s.name AS state_name, co.name AS country_name
                            FROM city c
                            INNER JOIN state_uts s ON c.state_id = s.id
                            INNER JOIN countries co ON s.country_id = co.id
                            WHERE c.id = '$cityId'";
                            $d2 = mysqli_query($conn, $sql);
                            $r2 = mysqli_fetch_assoc($d2);
                            $cityname = $r2['city_name'];
                            $statename = $r2['state_name'];
                            $countryname = $r2['country_name'];
                        }
                        echo ' 
                            <tr class="tr">
                                <td class="tdclientstyle">' . $srNo . '</td>
                                <td class="tdclientstyle">' . $client["ClientName"] . '</td>
                                <td class="tdclientstyle">' . $client["ClientId"] . '</td>
                                <td class="tdclientstyle">' . $cityname . '</td>
                                <td class="tdclientstyle">' . $statename . '</td>
                                <td class="tdclientstyle">' .$countryname .'</td>
                            </tr>
                        ';
                        $srNo++;
                    }?>
                    </tbody>
                </table>
            <?php } else{?>
                <div class="no_data">
                    <div><h3> No Client Available </h3></div>&nbsp;&nbsp;
                    <div>
                        <p>Want to create client <a href='create-client.php'>Click here</a></p>
                    </div>
                </div>
            <?php }?>
        </section>
    </body>
</html>
<!-- <td align="center">
    <form action="update_client_data.php" method="post">
        <input type="hidden" name="updateClient" value="true">
        <input type="hidden" name="client_id" value="'.$client["ClientId"].'">
        <input type="submit" class="updatebtn" value="Update">
    </form>
</td> -->                             
<?php }?>