<?php
  require('sessionValidator.php');

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }

?>

<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors',0);
ini_set('log_errors',1);
require_once('config.php');
session_start();

$_SESSION['location'] = 1;

$key = $_POST["key"];
$query = "SELECT id, email FROM recipient WHERE email LIKE '" . $key . "'";
$result = mysqli_query($dbc, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['recipE'] = $row['email'];
    header('Location: createAward.php');

    
}
else {
    $_SESSION['recipE'] = $key;
    header('Location: addRecipient.php');
}

?>