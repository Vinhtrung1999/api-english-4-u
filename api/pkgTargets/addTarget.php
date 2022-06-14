<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/pkgTarget.php');

    $returnArray = [];

    if((isset($_POST['username']) && !empty($_POST['username'])) &&
        (isset($_POST['title']) && !empty($_POST['title'])) &&
        (isset($_POST['target']) && !empty($_POST['target'])) &&
        (is_numeric($_POST['target']))){
            
            $idTarget = 'TG' . rand(1, 100000);
            $username = $_POST['username'];
            $title = $_POST['title'];
            $target = $_POST['target'];

            

            $db = new db();

            $conn = $db -> connection();

            $pkgTarget = new PkgTarget($conn);
            $result = $pkgTarget->addTarget($idTarget, $username, $title, (int)$target);
            
            if($result == 1){
                $returnArray['data'] = [];
                $tmp = array(
                    'idTarget' => $idTarget,
                    'username' => $username,
                    'title' => $title,
                    'target' => (int)$target,
                    'status' => false,
                    'qty' => 0
                );
                $returnArray['code'] = 0;
                array_push($returnArray['data'], $tmp);
                echo json_encode($returnArray);
            }

            else{
                $returnArray['code'] = 1;
                $returnArray['message'] = 'target not exist';
                echo json_encode($returnArray);
            }

        }
    else{
        $returnArray['code'] = 99;
        $returnArray['message'] = 'Not enough params or not support method';
        echo json_encode($returnArray);
    }
?>