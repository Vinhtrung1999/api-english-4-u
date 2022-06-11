<?php
class PkgTarget{
    private $conn;

    public function PkgTarget($conn)
    {
        $this->conn = $conn;
    }

    public function addTarget($idTarget, $username, $title, $target){
        try {
            $status = false;

            $stmt = $this->conn->prepare('INSERT INTO pkgtarget (idTarget, username, title, target, status)
                                    VALUES (:idTarget, :username, :title, :target, :status)');
            $stmt->bindParam(':idTarget', $idTarget);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':target', $target);
            $stmt->bindParam(':status', $status);

            $stmt->execute();
            return true;            
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getTargetByUser($username){
        $stmt = $this->conn->prepare("SELECT * FROM pkgtarget WHERE username=:username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt;
    }
}
?>
