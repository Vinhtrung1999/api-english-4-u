<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/guest.php');

    $returnArray = [];

    if((isset($_POST['username']) && !empty($_POST['username'])) &&
        (isset($_POST['name']) && !empty($_POST['name'])) &&
        (isset($_POST['password']) && !empty($_POST['password']))){
            
            $username = $_POST['username'];
            $name = $_POST['name'];
            $password = $_POST['password'];

            

            $db = new db();

            $conn = $db -> connection();

            $guest = new Guest($conn);
            $result = $guest->addGuest($username, $name, $password);
            
            if($result == 1){
                $returnArray['data'] = [];
                $tmp = array(
                    'username' => $username,
                    'name' => $name,
                    'password' => $password
                );
                $returnArray['code'] = 0;
                array_push($returnArray['data'], $tmp);
                echo json_encode($returnArray);
            }

            else{
                $returnArray['code'] = 1;
                $returnArray['message'] = 'username or password was existed';
                echo json_encode($returnArray);
            }

        }
    else{
        $returnArray['code'] = 99;
        $returnArray['message'] = 'Not enough params or not support method';
        echo json_encode($returnArray);
    }
?>