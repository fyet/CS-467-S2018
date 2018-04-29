<?php 

require_once('config.php');
session_start();

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

?>