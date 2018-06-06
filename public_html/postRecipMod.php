<?php
  require('sessionValidator.php');

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }

  require_once('config.php');
  $_SESSION['location'] = 0;

  switch($_SERVER['REQUEST_METHOD']){
    case "PUT":

      $bodyData = file_get_contents('php://input');
      $POST_body = json_decode($bodyData, true);
      $id = $POST_body['id'];
      $f_name = $POST_body['f_name'];
      $l_name = $POST_body['l_name'];
      $email = $POST_body['email'];
      $branch_id = $POST_body['branch_id'];
      $manager_id = $POST_body['manager_id'];
      $job_title = $POST_body['job_title'];
      $salary = $POST_body['salary'];

      $query = "UPDATE recipient SET f_name = ?, l_name = ?, email = ?, branch_id = ?, manager_id = ?, job_title = ?, salary = ? WHERE id = ?";
      $stmt = mysqli_prepare($dbc, $query);
      mysqli_stmt_bind_param($stmt, 'sssiisii', $f_name, $l_name, $email, $branch_id, $manager_id, $job_title, $salary, $id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      var_dump(http_response_code());
      break;

    case "DELETE":
      $id = $_GET['id'];
      $query = "DELETE FROM recipient WHERE id = ?";
      $stmt = mysqli_prepare($dbc, $query);
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      var_dump(http_response_code());
      break;

    default:
      http_response_code(404);
      var_dump(http_response_code());
  }

  mysqli_close($dbc);
  ?>