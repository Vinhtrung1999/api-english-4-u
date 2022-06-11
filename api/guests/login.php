<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/guest.php');
    
    $guestArray = [];
    
    if((isset($_POST['username']) && !empty($_POST['username'])) &&
        (isset($_POST['password']) && !empty($_POST['password']))){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new db();
        $conn = $db -> connection();
        
        $guest = new Guest($conn);
        $result = $guest->getGuest($username, $password);
        $num = $result->rowCount();
        // check username
        if($num > 0){
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $data = $row;
            };
            
            // check password
            $check = password_verify($password, $data['password']);

            if($check){
                $guestArray['code'] = 0;        
                $guestArray['data'] = [];

                array_push($guestArray['data'], $data);
                echo json_encode($guestArray);
            }
            else{
                $guestArray['code'] = 1;
                $guestArray['message'] = 'Password is wrong!!!';
                echo json_encode($guestArray);
            }
            
        }
        else{
            $guestArray['code'] = 1;
            $guestArray['message'] = 'Username is wrong!!!';
            echo json_encode($guestArray);
        }
    }
    else{
        $guestArray['code'] = 99;
        $guestArray['message'] = 'Not enough params or not support method';
        echo json_encode($guestArray);
    }
?>