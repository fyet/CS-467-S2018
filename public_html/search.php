<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors',0);
ini_set('log_errors',1);
require_once('config.php');
session_start();

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