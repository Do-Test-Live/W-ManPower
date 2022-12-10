<?php
session_start();
$user = $_SESSION['user'];
$post_id = $_POST['post_id'];
include ('config/db_config.php');
$check_saved_post = $con->query("select * from saved_post where post_id = '$post_id' and user_id = '$user'");
if($check_saved_post-> num_rows == 0){
    $saved_post = $con->query("INSERT INTO `saved_post`(`user_id`, `post_id`) VALUES ('$user','$post_id')");
    if ($saved_post) {
        echo json_encode(array("statusCode"=>200));
    }
    else {
        echo json_encode(array("statusCode"=>201));
    }
}