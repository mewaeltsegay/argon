<?php
include 'DB_Connect.php';

$db = new DB_Connect();
$conn = $db->connect();

$rows = [];
$response = [];

$sql = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST["table"];
    $fields = $_POST["fields"];
    $where = "";


    if (isset($_POST["where"])) {
        $mappedArray = array_map("mapKeys", $_POST["where"]);
        $where = "where " . implode(" and ", $mappedArray);;
    }

    $set = '';
    $x = 1;

    foreach ($fields as $name => $value) {
        $set .= "{$name} = \"{$value}\"";
        if ($x < count($fields)) {
            $set .= ',';
        }
        $x++;
    }

    $sql = "update {$table} set {$set} {$where}";

    if (mysqli_query($conn, $sql) != 1) {
        $response["success"] = "false";
    } else {
        $response["success"] = "true";
    }

    echo json_encode($response);
}

    function mapKeys($array){
        $set = '';
        $x = 1;

        foreach ($array as $name => $value) {
            $set .= $name." = ".$value;
            if ($x < count($array)) {
                $set .= ' and ';
            }
            $x++;
        }
        return $set;
    }
