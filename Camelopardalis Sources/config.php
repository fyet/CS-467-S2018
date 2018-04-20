<?php

DEFINE('DB_USER','fyet-db');
DEFINE('DB_PASSWORD','FZYLHbqfslqyA1WB');
DEFINE('DB_HOST','oniddb.cws.oregonstate.edu');
DEFINE('DB_NAME','fyet-db');

$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
    or die("Could not connect to MySql Database: " . mysqli_connect_error());

// Test connection is established    
//echo "Connected to MySql Database";

?>