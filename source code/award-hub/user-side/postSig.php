<?php 

  require('../login-system/sessionValidator.php');

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }

  // Variable declaration
  $user = $_SESSION['user'];
  $_SESSION['location'] = 0;

  // Catch the post data from form submition
  $img_uri = $_POST['my_hidden']; // Draw out the value of contents in id 'my_hidden'. This will either be 'empty' or an URI encoded string

    // Create a unique temp directory to hold the signature.png
    // NOTE: The Apache server has a group set up for var/www/html called 'aum'. The three users that this group comrpises of
    //       are "Apache" (aka 'www-data'), "ubuntu", and "mysql". The following commands were made to configure group/server:
    //       > sudo groupadd aum
    //       > sudo usermod -a -G aum www-data
    //       > sudo usermod -a -G aum ubuntu
    //       > sudo usermod -a -G aum mysql
    //       > sudo chown -R root:aum /var/www/html
    //       > sudo chmod -R o+rwx /var/www/html/
    // What this means: Since the '-R' flag was set on the last two commands, the 'aum' user has the +rwx permissions effective
    // recursively, or for all directiores and files created within /var/www/html/. We are about to create a temporary directory.
    // So, since the Apache user has read, write, and execute permissions it will be able to read/write a .png document to dir
    $randomNum = rand();                                   // Generate a random number
    $directory = "temp" . $randomNum;                      // Append the random number to the dir name so it is a unique dir per call
    mkdir("./$directory");                                 // Create the directory

    // Check to ensure the directory was created successfully
    if(is_dir("$directory")){ // If the directory in question exists...    

      // Handle Signature - case when the signature pad was not used
      if($img_uri == "empty"){ 
        // The $_FILE array is passed with post. This data can be extracted & handled as desired. See - http://php.net/manual/en/features.file-upload.post-method.php for specification    
        if ($_FILES['file']['size'] > 0){ // Per php.net, if no file is selected the size will be zero. Check if a file exists...
          $file_data = file_get_contents($_FILES['file']['tmp_name']); // Contents of file is in ['file']['tmp_name']. Also, see http://php.net/manual/en/function.file-get-contents.php, 
          // Resize the image so it will fit in our certificate. See - http://php.net/manual/en/function.imagecopyresampled.php for code below
          list($width_orig, $height_orig) = getimagesize($_FILES['file']['tmp_name']);
          if($_FILES['file']['type'] == 'image/png'){ // See - http://php.net/manual/en/features.file-upload.post-method.php, extract type & make sure it is png
            $width = 300; // Set witdth to match canvas element 
            $height = 75; // Set height to match canvas element 
            $path = "/var/www/html/award-hub/user-side/" . $directory . "/signature.png"; // Create a path & file name for the new signature to be dumped into
            $new_img = imagecreatetruecolor($width,$height);  // Resized image will be the same size as the canvas element (more indepth ratio handling could be done at this point)
            $orig_img = imagecreatefrompng($_FILES['file']['tmp_name']); // create image from contents 
            imagecopyresampled($new_img, $orig_img, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig); // Resample the image
            imagepng($new_img, $path); // Capture the binary contents of the png and dump into file in predefined path
            
            // Handle database activities
            require_once('../database-resources/config.php');                         // Connect to DB, a new instance is now available via $dbc variable
            $signature_data = file_get_contents($path, true);                         // See - http://php.net/manual/en/function.file-get-contents.php (function is binary safe, we are dealing with binary files - aka images)
            $signature_escpd = mysqli_real_escape_string($dbc, $signature_data);      // See - http://php.net/manual/en/mysqli.real-escape-string.php (just in case we have chars that need to be escaped)
            $query = "UPDATE user SET signature='$signature_escpd' WHERE id='$user'"; // Define a query that will inject the contents of our binary file into blob
            $response = mysqli_query($dbc, $query);                                   // Run query 
            mysqli_close($dbc);                                                       // Close connection
          }
          // Input file must be png
          else{
            echo "File type not supported"; // Print error
          }
        }
      }
      // Handle Signature - case when the signature pad was used 
      else{
        // Citing code from signature_pad man page: https://github.com/szimek/signature_pad, modifications were made to suit the case of this project
        $encoded_image = explode(",", $img_uri)[1];              // Take the URI string and explode it so that it is parsed into an array. The deliminator is the "," because we just want the encoded string portion. 
        $decoded_image = base64_decode($encoded_image);          // Decode the encoded string with base64_decode(). See - http://php.net/manual/en/function.base64-decode.php 
        $path = "/var/www/html/award-hub/user-side/" . $directory . "/signature.png"; // Create a path & file name for the new signature to be dumped into
        file_put_contents($path, $decoded_image);                // Take the decoded contents and put it into a .png file 

        // Handle database activities
        require_once('../database-resources/config.php');                         // Connect to DB, a new instance is now available via $dbc variable
        $signature_data = file_get_contents($path, true);                         // See - http://php.net/manual/en/function.file-get-contents.php (function is binary safe, we are dealing with binary files - aka images)
        $signature_escpd = mysqli_real_escape_string($dbc, $signature_data);      // See - http://php.net/manual/en/mysqli.real-escape-string.php (just in case we have chars that need to be escaped)
        $query = "UPDATE user SET signature='$signature_escpd' WHERE id='$user'"; // Define a query that will inject the contents of our binary file into blob
        $response = mysqli_query($dbc, $query);                                   // Run query 
        mysqli_close($dbc);                                                       // Close connection
      }   

      // Clean up all the temp items that were created
      if(is_file("./$directory/signature.png")){   // If the file in question exists..
          unlink("./$directory/signature.png");    // Delete the signature.png file
      }
      rmdir("$directory");                         // Now delete the temp directory that was created
      }
      else{
        echo "Directory creation failed";
      }

    // Re-direct the user to the user home page 
    header("Location: http://18.188.194.159/award-hub/user-side/user-home.php");  
?>