<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once('../../config/db.php');
    include_once('../../models/guest.php');

    $db = new db();
    $conn = $db -> connection();
    
    $guest = new Guest($conn);
    $result = $guest->listGuests();
    $num = $result->rowCount();

    if($num > 0){
        $guestArray = [];
        $guestArray['code'] = 0;        
        $guestArray['data'] = [];

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $guestItem = array(
                'username' => $username,
                'name' => $name,
                'password' => $password
            );

            array_push($guestArray['data'], $guestItem);
        }   

        echo json_encode($guestArray);
    }

?>