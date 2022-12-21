<?php
session_start();
include ("../config/db_config.php");

$application_id = $_GET['id'];
$status = $_GET['status'];

if($status == 0)
    $setstatus = 1;
else
    $setstatus = 0;

$update_query = $con->query("UPDATE `applicants` SET `status`='$setstatus' WHERE applicant_id = '$application_id'");
if($update_query){
    ?>
    <script>
        alert("Status Updated Successfully");
    </script>
    <?php
    header("Location:applicant.php");
}else{
    ?>
    <script>
        alert("Something went wrong!");
    </script>
    <?php
    header("Location:applicant.php");
}
