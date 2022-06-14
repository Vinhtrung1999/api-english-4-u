<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/pkgTarget.php');

    $returnArray = [];

    if((isset($_GET['username']) && !empty($_GET['username']))){
            
            $username = $_GET['username'];

            $db = new db();

            $conn = $db -> connection();

            $pkgTarget = new PkgTarget($conn);
            $result = $pkgTarget->getTargetByUser($username);
            $num = $result->rowCount();
            if($num > 0){
                $returnArray['code'] = 0;        
                $returnArray['data'] = [];

                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $temp = array(
                        'idTarget' => $idTarget,
                        'username' => $username,
                        'title' => $title,
                        'target' => (int)$target,
                        'status' => $status,
                        'qty' => $qty
                    );

                    array_push($returnArray['data'], $temp);
                }   

                echo json_encode($returnArray);
            }

            else{
                $returnArray['code'] = 1;
                $returnArray['message'] = 'username not exist or not data';
                echo json_encode($returnArray);
            }

        }
    else{
        $returnArray['code'] = 99;
        $returnArray['message'] = 'Not enough params or not support method';
        echo json_encode($returnArray);
    }
?>