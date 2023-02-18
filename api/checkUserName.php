<?php
include 'DB_Connect.php';

$db = new DB_Connect();
$conn = $db->connect();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["username"];

    $sql = "select unique_id from users where user_name = '{$user_name}'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "false";
    }
    else{
        echo "true";
    }
}

