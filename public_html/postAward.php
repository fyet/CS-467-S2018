<?php 

require_once('config.php');
session_start();
$_SESSION['user'] = 1;


$type = $_POST['typeAward'];
$date = $_POST['dateAward'];
$email =  $_POST['recipEmail'];
$fname = $_POST['recipFName'];
$lname = $_POST['recipLName'];
$user = $_SESSION['user'];

$query = "SELECT id FROM recipient WHERE email LIKE '" . $email . "'";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_assoc($result);
$recipID = $row['id'];

$sql = "INSERT INTO award (accolade_date, accolade_type, user_id, recipient_id) VALUES (?,?,?,?)";

$stmt = mysqli_prepare($dbc, $sql);

mysqli_stmt_bind_param($stmt, 'ssii', $date, $type, $user, $recipID);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

mysqli_close($dbc);

?>