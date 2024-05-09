<?php
    include 'connection.php';
    $state_id = $_POST['state_data'];

    $city = "SELECT * FROM city WHERE state_id = $state_id  ORDER BY name";
    $city_qry = mysqli_query($conn, $city);

    $output = '<option value="">--Select City--</option>';

    while ($city_row = mysqli_fetch_assoc($city_qry)) {
        $output .= '<option value="' . $city_row['id'] . '">' . $city_row['name'] . '</option>';
    }

    $output .= '<option value="other">Other City</option>';
    echo $output;
?>