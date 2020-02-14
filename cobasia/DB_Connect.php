<?php
class DB_Connect {
    private $conn;
 
    // koneksi ke database
    public function connect() {
        require_once 'Config.php';
         
        // koneksi ke mysql database
        $this->conn = new mysqli(HOST, USER, PASS, DB);
         
        // return database handler
        return $this->conn;
    }
}
 
?>