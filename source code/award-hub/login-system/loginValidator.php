<?php

    // Start Session - http://php.net/manual/en/function.session-start.php
    session_start();    
    
    // Declare session varaibles 
    $_SESSION['user'];
    $_SESSION['location'];
    $_SESSION['recipE'];
    $_SESSION['accountType'];

    // NOTE: Used password_hash($raw_pwd, PASSWORD_DEFAULT); to generate all pwds 

    // Grab the username, password, and type from the submitted form 
    $submitted_un = $_POST["uemail"];
    $submitted_pwd = $_POST["psw"];

    // Get hashed pw from database
    require('../database-resources/config.php'); // Instantiate a connection to our database

    // Clean the input to protect against sql injection. We will use the mysqli_real_escape_string function
    // Citations: 
    //   1. https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection
    //   2. http://php.net/manual/en/mysqli.real-escape-string.php 
    $submitted_un = mysqli_real_escape_string ($dbc, $submitted_un);
    $submitted_pwd = mysqli_real_escape_string ($dbc, $submitted_pwd);

    // Define query
    $query = "SELECT id,psword,account_type FROM user WHERE email='$submitted_un'";               
    $response = mysqli_query($dbc, $query);             // Invoke query
    if($response){                                      // Check to make sure we had a response 
        while($row = mysqli_fetch_assoc($response)){    // An array was returned, use while loop to step into first postion
            $user_id = "{$row['id']}";                  // Grab theid of user
            $hashed_pwd = "{$row['psword']}";           // Grab the password of user   
            $type = "{$row['account_type']}";           // Grab the password of user        
        }
        mysqli_close($dbc);     // Close connection to database 

        // Compare the user's submitted password with the user's password. If they match...
        if (password_verify($submitted_pwd, $hashed_pwd)) { // See http://php.net/manual/en/function.password-verify.php
            
            // Initialize session variables
            $_SESSION['user'] = $user_id; // Set the user to the user id 
            $_SESSION['location'] = 0;    // This will be re-initialized in later file 
            $_SESSION['recipE'] = 0;      // This will be re-initialized in later file 
            $_SESSION['accountType'] = $type; // Set the account type to the type returned in db

            // Check to if the user is a standard user or admin user, direct them to the appropriate section of site
            if($type == "standard"){  // User is standard user, needs to be directed to admin branch
                // Redirect the user to the home page
                header("Location: http://18.188.194.159/award-hub/user-side/user-home.php");
            }
            else if($type == "admin"){ // User is admin user, needs to be directed to admin branch
                 // Redirect the user to the home page
                 header("Location: http://18.188.194.159/award-hub/admin-side/admin-home.php");               
            } 
            else{  // Some undefined error occured.
                header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Error%20-%20Contact%20Administrator");
            }
        } 
        // The password wasn't verified. Redirect user to 'login.php' w/ GET parameters informing them of error.
        else{
            header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Invalid%20Credentials");
        }
    }  
    // The provided user did not exist in database. Redirect user to 'login.php' w/ GET parameters informing them of error. 
    else{
        header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Invalid%20Credentials");
    }

?>
