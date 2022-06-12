<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/sentence.php');
    include_once('../../models/pkgTarget.php');

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

            //check status pkg target
            $pkgTarget = new PkgTarget($conn);
            $result_getTargetById = $pkgTarget->getTargetById($idTarget);
            $num = $result_getTargetById->rowCount();
            if($num > 0){
                while($row = $result_getTargetById->fetch(PDO::FETCH_ASSOC)){
                    $status_check = $row['status'];
                    $target = (int)$row['target'];
                };
                
                if(!$status_check){
                    //check count
                    $sentence = new Sentence($conn);
                     
                    //add sentence
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

                        //set target
                        $result_getSentenceByTarget = $sentence->getSentenceByTarget($idTarget);
                        $num_sentence = $result_getSentenceByTarget->rowCount();
                        if($num_sentence == $target){
                            $result_updateStatus = $pkgTarget->updateStatus($idTarget);
                        }

                        echo json_encode($returnArray);
                    }

                    else{
                        $returnArray['code'] = 1;
                        $returnArray['message'] = 'Target not exist';
                        echo json_encode($returnArray);
                    }
                }
                else{
                    $returnArray['code'] = 1;
                    $returnArray['message'] = 'Status was completed';
                    echo json_encode($returnArray);
                }
            }
            else{
                $returnArray['code'] = 1;
                $returnArray['message'] = 'target not exist';
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