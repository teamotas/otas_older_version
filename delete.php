<?php
  include('connection.php');
  error_reporting(0);
  session_start();
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  if(isset($_POST['delTcsProject'])){
    if(isset($_POST['project_id1'])){
      $id1=$_POST['project_id1'];
      $sql = "DELETE prdata, cbt, result
      FROM tcsprojectdata prdata
      JOIN tcscbtdata cbt ON prdata.projid=cbt.projid
      JOIN tcsresultdata result ON cbt.projid=result.projid
      WHERE prdata.projid = '$id1'";
      
      $data = mysqli_query($conn, $sql);
      if ($data){
        if($data){
          echo"<script>alert('Record Deleted.');</script>";
          ?><meta http-equiv="refresh" content="0  URL=project_data_tcs.php" /><?php
        }
        else{
          echo"<script>alert('Failed');</script>";
        }
      }
    }
  }

  if(isset($_POST['delProject'])){
    if(isset($_POST['project_id'])){
      $id2=$_POST['project_id'];
      $sql = "DELETE prdata,serprice,prval,count,dates,stg1,stg2,stg3,stg4,stg5
        FROM otasprojectdata prdata
        JOIN otasservicesprice serprice ON prdata.projid=serprice.projid
        JOIN otasprojval prval ON  serprice.projid= prval.projid
        JOIN otasprcandcount count ON prval.projid = count.projid
        JOIN otasprojdates dates ON count.projid = dates.projid
        JOIN stg1pymntdetail stg1 ON dates.projid=stg1.projid
        JOIN stg2pymntdetail stg2 ON stg1.projid=stg2.projid
        JOIN stg3pymntdetail stg3 ON stg2.projid=stg3.projid
        JOIN stg4pymntdetail stg4 ON stg3.projid=stg4.projid
        JOIN stg5pymntdetail stg5 ON stg4.projid=stg5.projid
      WHERE prdata.projid = ?";
      
      $stmt = mysqli_prepare($conn, $sql);
      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $id2);
        if (mysqli_stmt_execute($stmt)) {
          // Deletion successfull
          echo"<script>alert('Record Deleted.');</script>";
          ?><meta http-equiv="refresh" content="0  URL=project_data.php" /><?php
        } 
        else {
          // Deletion failed
          echo"<script>alert('Failed');</script>";
        }
        mysqli_stmt_close($stmt);
      } 
      else {
        // Query preparation failed
        ?><meta http-equiv="refresh" content="0  URL=project_data.php" /><?php
      }
    }
  }
  if (isset($_POST['delemployee'])){
    if(isset($_POST['employee_id'])){
      $id=$_POST['employee_id'];
      $queryy="DELETE employee,department,roles
      FROM employee 
      JOIN department ON employee.EmployeeId=department.EmployeeId
      JOIN roles ON department.EmployeeId=roles.EmployeeId WHERE employee.EmployeeId='$id'";  

      $data=mysqli_query($conn,$queryy);
      if($data){
        echo"<script>alert('Record Deleted.');
        location.replace('employee_data.php');
        </script>";
      }
      else{
          echo"<script>alert('Failed');</script>";
      }
    }
  }

  if (isset($_POST['delclient'])){
    if(isset($_POST['client_id'])){
      $id=$_POST['client_id'];
      $queryy="DELETE FROM `client` WHERE ClientId='$id'";  
      $data=mysqli_query($conn,$queryy);

      if($data){
        echo"
        <script>
          alert('Record Deleted.');
          location.replace('clients.php');
        </script>";
      }
      else{
        echo"<script>alert('Failed');</script>";
      }
    }
  }

?>