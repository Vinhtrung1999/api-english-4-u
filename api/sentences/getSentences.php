<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/sentence.php');

    $returnArray = [];
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if((isset($_GET['idTarget']) && !empty($_GET['idTarget']))){
                $idTarget = $_GET['idTarget'];

                $db = new db();

                $conn = $db -> connection();

                $sentence = new Sentence($conn);
                $result = $sentence->getSentenceByTarget($idTarget);
                $num = $result->rowCount();
                if($num > 0){
                    $returnArray['code'] = 0;        
                    $returnArray['data'] = [];

                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        $temp = array(
                            'idContent' => $idContent,
                            'idTarget' => $idTarget,
                            'content' => $content,
                            'date' => $date
                        );

                        array_push($returnArray['data'], $temp);
                    }   

                    echo json_encode($returnArray);
                }

                else{
                    $returnArray['code'] = 1;
                    $returnArray['message'] = 'Not data';
                    echo json_encode($returnArray);
                }

            }
        else{
            $returnArray['code'] = 99;
            $returnArray['message'] = 'Not enough params';
            echo json_encode($returnArray);
        }
    }
    else{
        $returnArray['code'] = 99;
        $returnArray['message'] = 'Method is not supported';
        echo json_encode($returnArray);
    }
?>