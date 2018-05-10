<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors',0);
ini_set('log_errors',1);
require_once('config.php');
session_start();

$id = $_GET['id'];

$query = "DELETE FROM award WHERE id=" .$id;

mysqli_query($dbc, $query);

var_dump(http_response_code());
?>