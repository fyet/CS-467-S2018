<?php

    // NOTE: Used password_hash($raw_pwd, PASSWORD_DEFAULT); to generate all pwds 

    // Grab the username & password from the submitted form 
    $submitted_un = $_POST["uemail"];
    $submitted_pwd = $_POST["psw"];

    // Get hashed pw from database
    require('config.php');                              // Instantiate a connection to our database

    // Clean the input to protect against sql injection. We will use the mysqli_real_escape_string function
    // Citations: 
    //   1. https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection
    //   2. http://php.net/manual/en/mysqli.real-escape-string.php 
    $submitted_un = mysqli_real_escape_string ($dbc, $submitted_un);
    $submitted_pwd = mysqli_real_escape_string ($dbc, $submitted_pwd);
    
    $query = "SELECT psword FROM user WHERE email='$submitted_un'";               
    $response = mysqli_query($dbc, $query);             // Invoke query
    if($response){                                      // Check to make sure we had a response 
        while($row = mysqli_fetch_assoc($response)){    // An array was returned, use while loop to step into first postion
            $hashed_pwd = "{$row['psword']}";           // Grab the first name of user           
        }
        mysqli_close($dbc);     // Close connection to database 

        // Compare the user's submitted password with the user's password. If they match...
        if (password_verify($submitted_pwd, $hashed_pwd)) { // See http://php.net/manual/en/function.password-verify.php
            // Set up session info here...

            // Redirect the user to the home page
            header("Location: http://18.188.194.159/user-home.php");
        } 
        // The password wasn't verified. Redirect user to 'login.php' w/ GET parameters informing them of error.
        else{
            header("Location: http://18.188.194.159/login.php?error=Invalid%20Credentials");
        }
    }  
    // The provided user did not exist in database. Redirect user to 'login.php' w/ GET parameters informing them of error. 
    else{
        header("Location: http://18.188.194.159/login.php?error=Invalid%20Credentials");
    }

?>