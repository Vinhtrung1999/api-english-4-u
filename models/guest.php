<?php
    class Guest{
        private $conn;
        // public $username;
        // public $name;
        // public $pwd;

        public function Guest($conn){
            $this->conn = $conn;
        }

        public function listGuests(){
            $stmt = $this->conn->prepare("SELECT * FROM guest");
            $stmt->execute();
            return $stmt;
        }

        public function getGuest($username){
            $stmt = $this->conn->prepare("SELECT * FROM guest WHERE username=:username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt;
        }

        public function addGuest($username, $name, $password){
            try{
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare('INSERT INTO guest (username, name, password)
                                        VALUES (:username, :name, :password)');
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':password', $hash);

                $stmt->execute();
                return true;
            }
            catch(PDOException $e){
                return false;
            }
            
        }
    }
?>