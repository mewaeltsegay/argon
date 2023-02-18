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

    $sql = "insert into {$_POST['table']}{$fields} values {$values};";
    $sql .= "insert ignore into companies(company_name) select distinct corporation from tmp_data;";
    $sql .= "insert into trainee_info (first_name,middle_name,last_name,gender,birthdate,ethnicity_id,national_id,phone_number,company_id,experience,edu_level,dept_id,level,batch,acadamic_year,status,student_id)
                select SUBSTRING_INDEX(tmp_data.full_name,' ', 1) AS first_name,
                       SUBSTRING_INDEX(SUBSTRING_INDEX(tmp_data.full_name, ' ', 2),' ', -1) AS middle_name, 
                       SUBSTRING_INDEX(tmp_data.full_name,' ', -1) AS last_name,tmp_data.gender,tmp_data.birthdate,ethnic_groups.ethnicity_id,tmp_data.national_id,tmp_data.phone_no,
                       companies.company_id, tmp_data.experience, tmp_data.edu_status, departments.dept_id, tmp_data.level, tmp_data.batch, tmp_data.acadamic_year,'Enrolled',tmp_data.SID 
                from tmp_data left join ethnic_groups on ethnic_groups.ethnicity_name = tmp_data.ethnicity left join companies on companies.company_name = tmp_data.corporation left join departments on departments.dept_name = tmp_data.department;
            ";
    $sql .= "delete from tmp_data where 1;";

    if (mysqli_multi_query($conn, $sql)) {
        $response["success"] = "success";
    } else {
        $response["success"] = "failure";
        $response["message"] = mysqli_error($conn);
    }

    echo json_encode($response);
}
