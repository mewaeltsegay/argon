<?php
include 'DB_Connect.php';

$db = new DB_Connect();
$conn = $db->connect();

$rows = [];
$response = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $dept_id = $_POST["dept_id"];
    $accyear = $_POST["academic_year"];
    $status = $_POST["status"];

    $sql = "insert into attendance(student_id, date, status) 
                select id,DATE_FORMAT(date(now()), '%Y-%m-%d'),'Absent' from trainee_info where acadamic_year='{$accyear}' and status='{$status}' and DATE_FORMAT(date(now()), '%Y-%m-%d') not in (select distinct date from attendance)";

    if(mysqli_query($conn,$sql)){
        $response["success"] = "true";
    }
    else{
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
    }

    echo json_encode($response);
}
