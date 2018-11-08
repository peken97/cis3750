<?php

$action = filter_input(INPUT_POST, "action");
$email = filter_input(INPUT_POST, "email");

$return_error = "FAIL";
$return_error = "SUCCESS";

switch($action){

    case "attempt_login":

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        attempt_login($email, $password);

    break;
    default:
        echo $return_error;
    break;


}

function attempt_login($email, $password){
    echo $email . $password;
}


?>