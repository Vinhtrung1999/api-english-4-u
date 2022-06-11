<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/sentence.php');

    $returnArray = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST')
        if((isset($_POST['idTarget']) && !empty($_POST['idTarget'])) &&
            (isset($_POST['content']) && !empty($_POST['content']))){
                
            $idContent = 'ST' . rand(1, 1000000);
            $idTarget = $_POST['idTarget'];
            $content = $_POST['content'];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("Y/m/d");            

            $db = new db();

            $conn = $db -> connection();

            $sentence = new Sentence($conn);
            $result = $sentence->addSentence($idContent, $idTarget, $content, $date);
            
            if($result == 1){
                $returnArray['data'] = [];
                $tmp = array(
                    'idContent' => $idContent,
                    'idTarget' => $idTarget,
                    'content' => $content,
                    'date' => $date,
                );
                $returnArray['code'] = 0;
                array_push($returnArray['data'], $tmp);
                echo json_encode($returnArray);
            }

            else{
                $returnArray['code'] = 1;
                $returnArray['message'] = 'Target not exist';
                echo json_encode($returnArray);
            }

        }
        else{
            $returnArray['code'] = 99;
            $returnArray['message'] = 'Not enough params';
            echo json_encode($returnArray);
        }
    else{
        $returnArray['code'] = 99;
        $returnArray['message'] = 'Not support method';
        echo json_encode($returnArray);
    }
?>