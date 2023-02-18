<?php
include 'DB_Connect.php';

$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $fields = "(".implode(",",$_POST["fields"]).")";
    $rows = $_POST["rows"];
    $values = implode(",",array_map(function($a) {return "(".implode(",",$a).")";},$rows));

    $sql = "insert into {$_POST['table']}{$fields} values {$values}";
    $result = mysqli_query($conn,$sql);

    if($result == 1){
        $response["success"] = "true";
    }
    else{
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
    }

    echo json_encode($response);
}
