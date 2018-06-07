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

$email =  $_POST['email'];
$fname = $_POST['f_name'];
$lname = $_POST['l_name'];
$branchID = $_POST['branch'];
$managerID = $_POST['manager'];
$jobTitle = $_POST['job_title'];
$salary = $_POST['salary'];
$hireDate = $_POST['hire_date'];

$sql = "INSERT INTO recipient (email, f_name, l_name, branch_id, manager_id, job_title, salary, hire_date) VALUES (?,?,?,?,?,?,?,?)";

$stmt = mysqli_prepare($dbc, $sql);

mysqli_stmt_bind_param($stmt, 'sssiisis', $email, $fname, $lname, $branchID, $managerID, $jobTitle, $salary, $hireDate);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

mysqli_close($dbc);

if($_SESSION['location'] == 0){
    $_SESSION['location'] = 0;
    unset($_SESSION["recipE"]);
    header('Location: edit-recipient.php');
}else
    header('Location: createAward.php');

?>