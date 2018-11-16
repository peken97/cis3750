<?php
include "sql_setup.php";
include "logging_functions.php";

// useful constant variables to be declared
// SQL Table Names
$table_users = "users";
$table_advertisements = "advertisements";

// Error messages to interface between javascript and php
$return_error = "FAIL";
$return_success = "SUCCESS";

// Other 
$cookieOneDay = 86400;
$permission_type_merchant = 1;
$permission_type_admin = 0;

$action = filter_input(INPUT_POST, "action");

switch($action){

    case "attempt_login":

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        if(attempt_login($email, $password) == TRUE){
            $permission_type = retrieveUserPermission($email);
            session_start();
            $_SESSION["permission_type"] = $permission_type;
            $_SESSION["user_email"] = $email;
            $_SESSION["login"] = "TRUE";
            echo $return_success;
        }
        else{
            echo $return_error;
        }

    break;
    case "attempt_logout":
        session_start();

        $email = filter_input(INPUT_POST, "email");
        
        session_destroy();

        echo $return_success;

    break;
    case "add_new_user":

        $email = filter_input(INPUT_POST, "email");
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        echo addNewUser($email, $username, $password);


    break;
    case "get_all_user_data":

        echo getAllUserData();

    break;
    case "delete_user":
        $user_id = filter_input(INPUT_POST, "user_id");

        echo deleteUser($user_id);

    break;
    case "get_user_id":
        $constraint_name = filter_input(INPUT_POST, "constraint_name");
        $constraint_value = filter_input(INPUT_POST, "constraint_value");

        echo getUserID($constraint_name, $constraint_value);

    break;
    case "add_new_advertisement":
        //&user_id=" + user_id + "&advertisement_name=" + advertisement_name + "&file_name=" + file_name;
        $user_id = filter_input(INPUT_POST, "user_id");
        $advertisement_name = filter_input(INPUT_POST, "advertisement_name");
        $file_name = filter_input(INPUT_POST, "file_name");

        echo addNewAdvertisement($user_id, $advertisement_name, $file_name);

    break;
    case "get_all_advertisement_data":

        echo getAllAdvertisementData();

    break;
    case "get_username":
        $constraint_name = filter_input(INPUT_POST, "constraint_name");
        $constraint_value = filter_input(INPUT_POST, "constraint_value");

        echo get_username($constraint_name, $constraint_value);

    break;
    default:
        echo $return_error;
    break;


}

function getAllAdvertisementData(){
    global $conn;
    global $table_advertisements;
    global $return_error;

    $query = "SELECT * FROM {$table_advertisements}";

    $result = mysqli_query($conn, $query);

    $i = 0; 
    $rows = array();

    while($row = mysqli_fetch_assoc($result)){
        $rows[$i] = $row;
        $i += 1;
    }

    return json_encode($rows);
}

function addNewAdvertisement($user_id, $advertisement_name, $file_name){

    global $conn;
    global $table_advertisements;
    global $return_success;
    global $return_error;

    $query = "INSERT INTO {$table_advertisements} (user_id, advertisement_name, file_name) VALUES ({$user_id}, '{$advertisement_name}', '{$file_name}')";

    writeToLog("Query: {$query}");

    $result = mysqli_query($conn, $query);

    writeToLog("Result: {$result}");

    if($result == TRUE){
        return $return_success;
    }

    return $return_error;

}

function get_username($constraint_name, $constraint_value){
    global $conn;
    global $table_users;
    global $return_success;
    global $return_error;

    $query = "SELECT username FROM {$table_users} WHERE {$constraint_name}='{$constraint_value}'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row["username"];
}

function getUserID($constraint_name, $constraint_value){
    global $conn;
    global $table_users;
    global $return_success;
    global $return_error;

    $query = "SELECT user_id FROM {$table_users} WHERE {$constraint_name}='{$constraint_value}'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row["user_id"];

}

function getUsernameFromUserID($user_id){
    global $conn;
    global $table_users;
    global $return_success;
    global $return_error;

    $query = "SELECT username FROM {$table_users} WHERE user_id='{$user_id}'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row["username"];

}

function deleteUser($user_id){
    global $conn;
    global $table_users;
    global $return_success;
    global $return_error;

    $query = "DELETE FROM {$table_users} WHERE user_id={$user_id}";

    $result = mysqli_query($conn, $query);

    if($result == TRUE){
        return $return_success;
    }

    return $return_error;

}

function getAllUserData(){
    global $conn;
    global $table_users;
    global $return_error;

    $query = "SELECT * FROM {$table_users} WHERE permission_type=1";

    $result = mysqli_query($conn, $query);

    $i = 0; 
    $rows = array();

    while($row = mysqli_fetch_assoc($result)){
        $rows[$i] = $row;
        $i += 1;
    }

    return json_encode($rows);
}

function doesUserExist($email){
    global $conn;
    global $table_users;
    global $return_success;
    global $return_error;

    $query = "SELECT * FROM {$table_users} WHERE email='{$email}'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) != 0){
        writeToLog("User '{$email}' already exists");
        return $return_error;
    }
    writeToLog("User '{$email}' does not exist");
    return $return_success;
}

function createNewFolderAdvertisement($username){

    writeToLog("Attempting to make a directory for {$username}");
    $success = mkdir("../ads/" . $username);
    writeToLog("Result for attempting to make a directory for {$username} is [{$success}]");
}

function addNewUser($email, $username, $password){

    global $conn;
    global $table_users;
    global $permission_type_merchant;
    global $return_success;
    global $return_error;

    if(doesUserExist($email) == $return_error){
        return $return_error;
    }

    $query = "INSERT INTO {$table_users} (username, email, password, permission_type) VALUES ('{$username}', '{$email}', '{$password}', {$permission_type_merchant})";

    writeToLog("Query: {$query}");

    $result = mysqli_query($conn, $query);

    writeToLog("Result: {$result}");

    if($result == TRUE){
        createNewFolderAdvertisement($username);
        return $return_success;
    }

    return $return_error;
}

function retrieveUserPermission($email){
    global $conn;
    global $table_users;

    $query = "SELECT permission_type FROM {$table_users} WHERE email='{$email}'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row["permission_type"];
}

function attempt_login($email, $password){

    global $conn;
    global $table_users;

    $query = "SELECT * FROM {$table_users} WHERE email='{$email}' AND password='{$password}'";

    $result = mysqli_query($conn, $query);
    if($result->num_rows == 0){
        return FALSE;
    }
    return TRUE;

    
}


?>