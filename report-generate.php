<?php
include "connection.php";
include "js/format.php";
// include 'sidebar.php';
error_reporting(0);
session_start();
if (isset($_POST['search'])) {
    // Check if both start and end dates are provided
    if (!empty($_POST["start-month"]) && !empty($_POST["end-month"])) {
        $start_date = mysqli_real_escape_string($conn, $_POST["start-month"]);
        $end_date = mysqli_real_escape_string($conn, $_POST["end-month"]);

        // Initialize an array to store project IDs
        $projectsWithCBTDate = [];

        // Construct the SQL query to retrieve projid and CBTDate
        $sql = "SELECT *
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
                JOIN client cl ON prdata.ClientId = cl.ClientId
                LEFT JOIN userotasproject up ON prdata.projid = up.projid
                LEFT JOIN employee em ON up.EmployeeId = em.EmployeeId
                ORDER BY `prdata`.`projid` ASC"; 

        // Execute the SQL query
        $result = mysqli_query($conn, $sql);

        // Check if any data is retrieved
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row of the result set
            while ($row = mysqli_fetch_assoc($result)) {
                // Split the CBTDate string into an array of dates
                $cbtDates = explode(', ', $row['CBTDate']);

                // Loop through each date in the array
                foreach ($cbtDates as $cbtDate) {
                    // Check if the date falls within the selected timeframe
                    // if (strtotime($cbtDate) >= strtotime($start_date) && strtotime($cbtDate) <= strtotime($end_date)) {
                    //     // Add the projid to the array if it's not already present
                    //     if (!in_array($row['projid'], $projectsWithCBTDate)) {
                            $projectsWithCBTDate[] = $row['projid'];
                        // }
                        // No need to check remaining dates in this row, move to the next row
                    //     break;
                    // }
                    continue;
                }
            }
        }

        // // Output the project IDs with CBT dates within the selected timeframe
        // if (!empty($projectsWithCBTDate)) {
        //     echo "Project IDs with CBT dates within the selected timeframe:<br>";
        //     foreach ($projectsWithCBTDate as $projectId) {
        //         echo $projectId . "<br>";
        //     }
        // } else {
        //     echo "No project IDs found with CBT dates within the selected timeframe.";
        // }
    } 
    // else {
    //     // Start and end dates are not provided
    //     echo "Please select both start and end dates.";
    // }
} else {
    // Clear the previously printed result
    unset($projectsWithCBTDate);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Data</title>
    <link rel="stylesheet" href="css/table.css">
</head>
<body>
    <section class="home">
        <table border="4">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateForm()">
                <tr class="thead">
                    <td class="thuserdata">Start Date: <input type="date" name="start-month" id="start-month"></td>
                    <td class="thuserdata">End Date: <input type="date" name="end-month" id="end-month"></td>
                </tr>
                <tr class="thead">
                    <td colspan="2"><input type="submit" value="Search" name="search" class="exclbtngen"></td>
                </tr>
            </form>
        </table>
        
        <?php 
            if ($projectsWithCBTDate) {
                echo "
                <div class='card1'>
                    <table border='4'>
                        <thead> 
                            <tr>
                                <td colspan='2' class='thtr'>Quarterly Project Report</td>
                            </tr>
                            <tr class='thead'>
                                <th class='thuserdata'>Project ID</th>
                                <th class='thuserdata'>CBT Completed</th>
                            </tr>
                        </thead>
                        <tbody>";
                            foreach ($projectsWithCBTDate as $projectId) {
                                echo "<tr>";
                                echo "<td class='tduserdata'>" . $projectId . "</td>";
                                echo "<td class='tduserdata'>Yes</td>";
                                echo "</tr>";
                            }
                            echo " 
                            <tr>
                                <td colspan='100%' class='tdxl'>
                                    <a href='word.php'>
                                        <button type='button' class='exclbtngen'>Download Word File</button>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>";
            } 
            else {
                echo "<div class='no_data'>Data not Found</div>";
            }
        ?>
                 
        <script>
            function validateForm() {
                var startDate = document.getElementById("start-month").value;
                var endDate = document.getElementById("end-month").value;
                if (startDate === "" || endDate === "") {
                    alert("Please select both start and end dates.");
                    
                    return false; // Prevent form submission
                }
                return true; // Allow form submission
            }
        </script>
    </section>
    </body>
</html>
