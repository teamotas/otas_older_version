<?php
    include('connection.php');
    include "sidebar.php";
    error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    if($adminType==='Admin'){
    $sql = "SELECT * FROM employee em, department dp, roles ro  WHERE em.EmployeeId=dp.EmployeeId AND dp.EmployeeId=ro.EmployeeId AND ro.UserRole='User'";
    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/table.css">
    </head>
    <body>
        <section class="home">
            <div class="card1">
                <?php if ($total != 0) {?>
                    <table border="4"  >
                        <thead > 
                            <tr>
                                <td colspan="100%"  class="thtr">User</td>
                            </tr>
                            <tr class="thead">
                                <th class="thuserdata">Sr. No.</th>
                                <th class="thuserdata">Photo</th>
                                <th class="thuserdata">Name</th>
                                <th class="thuserdata">Email ID</th>
                                <th class="thuserdata">Employee Code</th>
                                <th class="thuserdata">Designation</th>
                                <th class="thuserdata">Gender</th>
                                <th class="thuserdata">Department ID</th>
                                <th class="thuserdata">Role</th>
                                <th class="thuserdata">Mobile No.</th>
                                <th class="thuserdata" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $srNo = 1;
                            mysqli_data_seek($data, 0); 
                            while (($res = mysqli_fetch_assoc($data))) {
                                echo '
                                <tr class="tr">
                                    <td>&nbsp;&nbsp;&nbsp;'.$srNo.'</td>
                                    <td class="tduserphoto"><img src="' .  (!empty($res['emplimage']) && file_exists($res['emplimage']) ? $res['emplimage'] : 'photos/default_image.jpeg') . '
                                    " class="tduserimg"></td>
                                    <td class="tduserdata">'.$res["Name"].'</td>
                                    <td class="tduserdata">'.$res["EmailId"].'</td>
                                    <td class="tduserdata">'.$res["EmployeeId"].'</td>
                                    <td class="tduserdata">'.$res["Designation"].'</td>
                                    <td class="tduserdata">'.$res["Gender"].'</td>
                                    <td class="tduserdata">'.$res["DepartmentId"].'</td>
                                    <td class="tduserdata">'.$res["UserRole"].'</td>
                                    <td class="tduserdata">'.$res["MobileNo"].'</td>
                                    <td align="center">
                                        <form action="update-user-data.php" method="post">
                                            <input type="hidden" name="updateEmployee" value="true">
                                            <input type="hidden" name="employee_id" value="'.$res["EmployeeId"].'">
                                            <input type="submit" class="updatebtn" value="Update" style="height:4rem; width:fit-content;">
                                        </form>
                                    </td>
                                </tr>';
                                $srNo++;
                            }
                            ?>
                        </tbody>
                    </table>
                <?php }else{?>
                    <div class="no_data">
                        <div><h3> No data available </h3></div>&nbsp;&nbsp;
                    </div>
                <?php }?>
            </div>
        </section>
    </body>
</html>
<?php }?>