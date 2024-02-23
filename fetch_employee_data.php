<?php
include('connection.php');
include "sidebar.php";
error_reporting(0);

$response = array();

if ($adminType === 'Admin') {
    $sql = "SELECT * FROM employee em, department dp, roles ro WHERE em.EmployeeId=dp.EmployeeId AND dp.EmployeeId=ro.EmployeeId";
    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);

    if ($total != 0) {
        $employees = array();

        while ($res = mysqli_fetch_assoc($data)) {
            $employee = array(
                'SrNo' => $res['EmployeeId'],
                'Photo' => (!empty($res['emplimage']) && file_exists($res['emplimage'])) ? $res['emplimage'] : 'photos/default_image.jpeg',
                'Name' => $res['Name'],
                'Email' => $res['EmailId'],
                'EmployeeCode' => $res['EmployeeId'],
                'Designation' => $res['Designation'],
                'Gender' => $res['Gender'],
                'DepartmentID' => $res['DepartmentId'],
                'Role' => $res['UserRole'],
                'MobileNo' => $res['MobileNo']
            );

            $employees[] = $employee;
        }

        $response['status'] = 'success';
        $response['message'] = 'Employee data retrieved successfully';
        $response['data'] = $employees;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No data available';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Unauthorized access';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
