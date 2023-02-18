<?php

include 'DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

function getUserByUsernameAndPassword($username, $password) {
    $db = new DB_Connect();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = ?");

    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // verifying user password
        $salt = $user['salt'];
        $encrypted_password = $user['password'];
        $hash = checkhashSSHA($salt, $password);
        // check for password equality
        if ($encrypted_password == $hash) {
            // user authentication details are correct
            $user["password"] = "";
            return $user;
        }
    } else {
        return NULL;
    }
}

function checkhashSSHA($salt, $password) {

    $hash = base64_encode(sha1($password . $salt, true) . $salt);

    return $hash;
}

$response = [];
$rows = [];

$user = getUserByUsernameAndPassword($_POST["username"],$_POST["password"]);

if($user == NULL){
    $response["success"] = "false";
}
else{
    $sql = "select concat(year(acadamic_start),'/',year(acadamic_end)) as acadamic_year from settings where seid = 1";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            array_push($rows,$row);
        }
        $user["academic_year"] = $rows[0]["acadamic_year"];
    }
    $response["success"] = "true";
    $response["data"] = $user;

}

echo json_encode($response);


