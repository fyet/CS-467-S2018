<?php

require_once('../database-resources/config.php');
$query = "SELECT email FROM recipient WHERE email = ?";
$stmt = mysqli_prepare($dbc, $query);
mysqli_stmt_bind_param($stmt, 's', $_GET['email']);
mysqli_stmt_execute($stmt);
// bind result variables
mysqli_stmt_bind_result($stmt, $email);
// fetch values
if (mysqli_stmt_fetch($stmt)) {  //if email exists already
    var_dump($email);
}
mysqli_stmt_close($stmt);
?>