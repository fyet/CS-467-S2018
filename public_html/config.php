<?php

DEFINE('DB_USER','root');
DEFINE('DB_PASSWORD','camelopardalis');
DEFINE('DB_HOST','http://18.188.194.159');
DEFINE('DB_NAME','camelopardalis');

$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
    or die("Could not connect to MySql Database: " . mysqli_connect_error());

// Test connection is established    
//echo "Connected to MySql Database";

?>