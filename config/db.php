<?php
class db{
    private $servername = 'localhost';
    private $username = 'root';
    private $pwd = '';
    private $db_name = 'english-4-u';

    public function connection(){
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->db_name", $this->username, $this->pwd);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;          
    }
  
}

?>