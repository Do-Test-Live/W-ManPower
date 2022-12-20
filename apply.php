<?php
session_start();
$user_id = $_SESSION['user'];
include ('config/db_config.php');
$post_id = $_POST['post_id'];

$select_query = $con->query("SELECT * FROM `applicants` WHERE user_id = '$user_id' and job_id = '$post_id'");
if($select_query -> num_rows < 1){
    $insert_query = $con->query("INSERT INTO `applicants`(`user_id`, `job_id`) VALUES ('$user_id','$post_id')");
    if($insert_query){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>201));
    }
}else{
    echo json_encode(array("statusCode"=>202));
}
