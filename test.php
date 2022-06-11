<?php
    $pwd = 'trung dep trai';
    $hash = password_hash($pwd, PASSWORD_DEFAULT);

    $in = 'trung dep trai';
    $check = password_verify($in, $hash);
    echo $check;
?>