<?php
    include 'connection.php';
    include 'sidebar.php';

    $clientId = $_POST['client_data'];
    $project_query = "SELECT * 
    FROM `otasprojectdata` prdata
    JOIN userotasproject up ON prdata.projid = up.projid
    WHERE `prdata`.`ClientId` = ? AND up.EmployeeId = ?";
    
    $stmt = mysqli_prepare($conn, $project_query);
    mysqli_stmt_bind_param($stmt, 'ss', $clientId, $userId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $output = '<option value="">--Select project--</option>';
    while ($project_row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="'. $project_row['projid'] .'">' . $project_row['NameOfProject'] . '</option>';
    }

    echo $output;
?>
