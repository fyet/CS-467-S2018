<?php
  require('../login-system/sessionValidator.php');

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }
?>

<?php

require_once('../database-resources/config.php');
$_SESSION['location'] = 0;

$type = $_POST['typeAward'];
$date = $_POST['dateAward'];
$email =  $_POST['recipEmail'];
$fname = $_POST['recipFName'];
$lname = $_POST['recipLName'];
$time = $_POST['timeAward'];
$user = $_SESSION['user'];

$query = "SELECT id FROM recipient WHERE email LIKE '" . $email . "'";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_assoc($result);
$recipID = $row['id'];

$sql = "INSERT INTO award (accolade_date, accolade_type, user_id, recipient_id, accolade_time) VALUES (?,?,?,?,?)";

$stmt = mysqli_prepare($dbc, $sql);

mysqli_stmt_bind_param($stmt, 'ssiis', $date, $type, $user, $recipID, $time);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

mysqli_close($dbc);

require_once '../certificate-handler/certificateHandler.php';

certificateHandler($type,$date,$email,$fname,$lname,$user); // Compile & Email Certificate Document

header("Location: http://18.188.194.159/award-hub/user-side/user-home.php"); 

?>
