<?php
include 'DB_Connect.php';

$db = new DB_Connect();
$conn = $db->connect();

$rows = [];
$response = [];

function mapKeys($array){
    $set = '';
    $x = 1;

    foreach ($array as $name => $value) {
        $set .= $name."= ".$value;
        if ($x < count($array)) {
            $set .= ' and ';
        }
        $x++;
    }
    return $set;
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $table = $_POST["table"];
    $fields = implode(',',$_POST['fields']);
    $where = "";
    $group_by ="";
    $order_by ="";
    $limit = "";

    if(isset($_POST["where"])){
        $mappedArray = array_map("mapKeys",$_POST["where"]);
        $where ="where ".implode(" and ",$mappedArray);;
    }
    if(isset($_POST["group_by"])){
        $group_by = "group by ".implode(",",$_POST["group_by"]);
    }
    if(isset($_POST["order_by"])){
        $order_by = "order by ".implode(",",$_POST["order_by"]["columns"])." ".$_POST["order_by"]["order"];
    }
    if(isset($_POST["limit"])){
        $limit = " limit ".$_POST["limit"];
    }

    $sql = "select {$fields} from {$table} {$where} {$group_by} {$order_by} {$limit}";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            array_push($rows,$row);
        }
        $response["data"] = $rows;
        $response["success"] = 'true';
    }
    else{
        $response["data"] = [];
        $response["success"] = 'true';
    }

    echo json_encode($response);
}
//{
//    table: 'exam',
//    fields: [id,dept_id,module_id,status],
//    where: {
//        id: 1
//    }
//}
