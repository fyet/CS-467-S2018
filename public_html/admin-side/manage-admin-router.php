<?php
//Establish connection with DB
require_once '../config.php';
// Import necessary PHPmailer classes and custom functions
require_once 'emailHandler.php';

//Route request based on HTTP method
switch($_SERVER['REQUEST_METHOD']) {
  case "POST": //Creates new admin
    //Get form values from POST
    $email = $_POST['email'];
    //Generate 8 character temporary password
    //Source: https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
    $pwd = str_shuffle(bin2hex(openssl_random_pseudo_bytes(4)));
    $date = date("Y-m-d");
    $type = 'admin'; //Set manually
    //Add form data to DB
    $query = "INSERT INTO user (email, psword, creation_date, account_type) VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $email, $pwd, $date, $type);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //Send email to new admin
    $subject = 'New Administrator Account on Award Hub';
    $msgBody = 'Welcome to Award Hub!<br>
                  <p>A new administrative account has been created for
                  you in the Award Hub system. Your temporary password is:</p>
                  <p><strong>'.$pwd.'</strong></p>
                  <p>Please login using the link provided below:</p>
                  <a href=\'http://18.188.194.159/login.php\'>http://18.188.194.159/login.php</a>';
    emailHandler($email, $subject, $msgBody);
    //Send response code back to client
    http_response_code(201);
    var_dump(http_response_code());
    break;
  case "PUT": //updates admin email
    $bodyData = file_get_contents('php://input');
    //error_log(print_r($bodyData, true));
    //Convert JSON to associative array
    $PUT_body = json_decode($bodyData, true);
    $id = $PUT_body['id'];
    $email = $PUT_body['email'];
    //Create and send query
    $query = "UPDATE user SET email = ? WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'si', $email, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //Send response code back to client
    var_dump(http_response_code());
    break;
  case "DELETE": //deletes admin record
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
