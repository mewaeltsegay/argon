<?php
/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

class DB_Connect {
    private $conn;

    // Connecting to database
    public function connect() {
        require_once 'config.php';

        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        if(!$this->conn){
            die("Connection failed:". mysqli_connect_error());
        }
        // return database handler
        return $this->conn;
    }
}

?>
