<?php
//Establish connection with DB
require_once '../config.php';
// Import necessary PHPmailer classes and custom functions
require_once 'emailHandler.php';

//Route request based on HTTP method
switch($_SERVER['REQUEST_METHOD']) {
  case "POST": //Creates new admin
    //Get form values from POST
    $bodyData = file_get_contents('php://input');
    $POST_body = json_decode($bodyData, true);
    $f_name = $POST_body['f_name'];
    $l_name = $POST_body['l_name'];
    $email = $POST_body['email'];
    //Generate 8 character temporary password
    //Source: https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
    $pwd = str_shuffle(bin2hex(openssl_random_pseudo_bytes(4)));
    $creationDate = date("Y-m-d");
    $lastChange = $creationDate;
    $type = 'standard'; //Set manually
    //Add form data to DB
    $query = "INSERT INTO user (f_name, l_name, email, psword, creation_date, account_type, last_change) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'sssssss', $f_name, $l_name, $email, $pwd, $creationDate, $type, $lastChange);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //Send email to new user
    $subject = 'New Account on Award Hub';
    $msgBody = $f_name.' '.$l_name.',<br>
                <p>Welcome to Award Hub! A new account has been created for you in the Award Hub
                system. Your temporary password is:</p>
                <p><strong>'.$pwd.'</strong></p>
                <p>Please login using the link provided below:</p>
                <a href=\'http://18.188.194.159/login.php\'>http://18.188.194.159/login.php</a>';
    emailHandler($email, $subject, $msgBody);
    //Send response code back to client
    http_response_code(201);
    var_dump(http_response_code());
    break;
  case "PUT": //updates user record
    $bodyData = file_get_contents('php://input');
    $POST_body = json_decode($bodyData, true);
    $id = $POST_body['id'];
    $f_name = $POST_body['f_name'];
    $l_name = $POST_body['l_name'];
    $email = $POST_body['email'];
    $lastChange = date("Y-m-d");
    //error_log(print_r($bodyData, true));
    //Create and send query
    $query = "UPDATE user SET f_name = ?, l_name = ?, email = ?, last_change = ? WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $f_name, $l_name, $email, $lastChange, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //Send response code back to client
    var_dump(http_response_code());
    break;
  case "DELETE": //deletes user record
    $id = $_GET['id'];
    $query = "DELETE FROM user WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //Send response code back to client
    var_dump(http_response_code());
    break;
  default:
    //Error
    http_response_code(404);
    var_dump(http_response_code());
}

//close DB connection
mysqli_close($dbc);

//PHP error log location for Matt's local environment:
//   /Applications/MAMP/logs/php_error.log
