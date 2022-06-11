<?php
class Sentence{
    private $conn;

    public function Sentence($conn)
    {
        $this->conn = $conn;
    }

    public function addSentence($idContent, $idTarget, $content, $date){
        try {
            $stmt = $this->conn->prepare('INSERT INTO sentence (idContent, idTarget, content, date)
                                    VALUES (:idContent, :idTarget, :content, :date)');
            $stmt->bindParam(':idContent', $idContent);
            $stmt->bindParam(':idTarget', $idTarget);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':date', $date);

            $stmt->execute();
            return true;            
        } catch (PDOException $e) {
            return false;
        }
    }

    // public function getTargetByUser($username){
    //     $stmt = $this->conn->prepare("SELECT * FROM pkgtarget WHERE username=:username");
    //     $stmt->bindParam(':username', $username);
    //     $stmt->execute();

    //     return $stmt;
    // }
}
?>
