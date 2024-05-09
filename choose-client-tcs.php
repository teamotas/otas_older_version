<?php
    include('connection.php');  
     include "sidebar.php";
    error_reporting(0);
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
                <form action="create-project-tcs.php" method="Post" id="projectForm" >
                    <h2>Select Client</h2>
                    <div>
                        <label for="chooseClient" class="label">Select Client to Create Project<sup>*</sup></label>
                        <select name="selectedClient1" id="chooseClient" required>
                            <option value='' selected>--Select Client--</option>
                            <?php 
                            $Q2 = "SELECT * FROM client";
                            $q11 = mysqli_query($conn, $Q2);
                            while ($q01 = mysqli_fetch_assoc($q11)) : ?>
                                <option value="<?php echo $q01['ClientId']; ?>" data-clientid1="<?php echo $q01['ClientId']; ?>"><?php echo $q01['ClientName']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="">
                        <label for="Project" class="label">Select Project<sup>*</sup></label>
                        <select class="selectfont" id="chooseProject" name='selectedProject' required>
                            <option disabled>--Select Project--</option>
                        </select>
                    </div>
                    <div>
                        <span class="required-text"><sup>*</sup>Select client and project</span>
                    </div> 
                    <input type="submit" value="Select" class="btn" name="chooseclient">
                </form>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
            <script>
                function validateForm() {
                    var selectedClient = $('#chooseClient').val();
                    var selectedProject = $('#chooseProject').val();

                    if (selectedClient && selectedProject) {
                    $('#projectForm').submit();
                    } else {
                        alert('Please select both client and project before submitting.');
                    }
                }
                $('#chooseClient').change(function () {
                    var clientId = $(this).val();
                    $.ajax({
                        url: 'get-projects.php',
                        type: 'POST',
                        data: { client_data: clientId },
                        success: function (data) {
                            $('#chooseProject').html(data);
                            console.log(data); // Check the data here
                        }
                    });
                });
            </script>
       </section>
    </body>
</html>
<?php }?>