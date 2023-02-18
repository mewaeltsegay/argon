<?php
include 'DB_Connect.php';

function hashSSHA($password) {

    $salt = sha1(rand());
    $salt = substr($salt, 0, 10);
    $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
    $hash = array("salt" => $salt, "encrypted" => $encrypted);
    return $hash;
}

$db = new DB_Connect();
$conn = $db->connect();

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $uuid = uniqid('',true);
    $password = $_POST["password"];
    $hash = hashSSHA($password);
    $enc_pass = $hash["encrypted"];
    $salt = $hash["salt"];

    $sql = "INSERT INTO `users`(`uname`, `user_name`, `password`, `salt`, `dept_id`, `user_type`,`unique_id`) VALUES ('{$_POST["uname"]}','{$_POST["user_name"]}','{$enc_pass}','{$salt}',{$_POST["dept_id"]},'{$_POST["user_type"]}','{$uuid}')";
    $result = mysqli_query($conn,$sql);

    if($result){
        $response["success"] = "true";
    }
    else{
        $response["success"] = "false";
    }

    echo json_encode($response);
}


