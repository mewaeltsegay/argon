<?php
include 'DB_Connect.php';

$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();
$columns = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['table'])){
        $sql = "delete from ".$_POST['table']." where unique_id='".$_POST['id']."'";
        $result = mysqli_query($conn,$sql);

        if($result == 1){
            $response['success'] = "true";
        }
        else{
            $response['success'] = "false";
            $response['message'] = mysqli_error($conn);
        }
        echo json_encode($response);
    }
}
