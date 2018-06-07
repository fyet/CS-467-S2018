<?php

  // Note: The $user parameter is the 'id' of the user
  function certificateHandler($type,$date,$email,$fname,$lname,$user){

    //Get the user's first and last name
    require('config.php');
    $query = "SELECT f_name,l_name,signature FROM user WHERE id=$user";
    $response = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_assoc($response)){ // An array was returned, use while loop to step into first postion
        $u_fname = "{$row['f_name']}";           // Grab the first name of user
        $u_lname = "{$row['l_name']}";           // Grab the last name of user
        $signature_data = "{$row['signature']}"; // Grab the raw sig data of user
    }
    mysqli_close($dbc);                          // close the connection we just instantiated

    // Create a unique temp directory to hold the .tex doc and generated cert pdf
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
    // So, since the Apache user has read, write, and execute permissions it will be able to write a .tex document,
    // execute 'pdflatex' command to compile doc, delete files, etc.
    $randomNum = rand();                                   // Generate a random number
    $directory = "temp" . $randomNum;                      // Append the random number to the dir name so it is a unique dir per call
    mkdir("./$directory");                                 // Create the directory

    // Get the signature of the user
    $sig_path = $directory . "/signature.png";
    // Take the decoded contents extracted from db and put it into a .png file (see 'postSig.php', we used file_get_contents() to grab raw data from file and store raw data in db)
    file_put_contents($sig_path, $signature_data); 

    // Check to ensure the directory was created successfully
    if(is_dir("$directory")){ // If the directory in question exists...

        // Create a LaTeX .tex document in temp directory and inject form data into the content
        $latexFile = fopen("./$directory/certificate.tex","w+") or die("Certificate file creation failed"); // Open a certificate document with write permissions

        // Prepare non-variable document contents
        $latexContent1 = "  \documentclass{article}
                            \usepackage[a4paper,margin=0.1in,landscape]{geometry}
                            \usepackage{xcolor}
                            \usepackage{graphicx}
                            \pagestyle{empty}
                            \begin{document}
                            \pagecolor{yellow!30}
                            \begin{center}
                            \includegraphics{../public/border_graphic.png}
                            \\vspace{2.5cm}
                            \begin{Huge}
                            \\textbf{\\textit{";
        $latexContent2 = "  }}
                            \\end{Huge}
                            \\end{center}
                            \bigskip
                            \begin{center}
                            \begin{LARGE}
                            has been granted to
                            \\end{LARGE}
                            \\end{center}
                            \bigskip
                            \begin{center}
                            \begin{huge}
                            \\textbf{";
        $latexContent3 ="   }
                            \\end{huge}
                            \\end{center}
                            \bigskip
                            \begin{center}
                            \begin{LARGE}
                            on this \\textbf{";
        $latexContent4 = "  } for outstanding achievements
                            \\end{LARGE}
                            \\end{center}
                            \\vspace{2.5cm}
                            \begin{flushleft}
                            \begin{Large}
                            {\\textbf{Authorizing Party:      }";
        $latexContent5 = "  }
                            \par\\noindent\\rule{18cm}{0.4pt}
                            \par
                            \bigskip
                            {\\textbf{Authorizing Party Signature:    }}\includegraphics{../";
        $latexContent6 =    "}\par\\noindent\\rule{18cm}{0.4pt}
                            \par
                            \\end{Large}
                            \\end{flushleft}
                            \\vspace{2.5cm}
                            \begin{center}
                            \includegraphics{../public/border_graphic.png}
                            \\end{center}
                            \\end{document}";

        // Write our contents into the certificate document
        fwrite($latexFile,$latexContent1);
        fwrite($latexFile,$type);
        fwrite($latexFile,$latexContent2);
        fwrite($latexFile,$fname);
        fwrite($latexFile," ");
        fwrite($latexFile,$lname);
        fwrite($latexFile,$latexContent3);
        fwrite($latexFile,$date);
        fwrite($latexFile,$latexContent4);
        fwrite($latexFile,$u_fname);
        fwrite($latexFile," ");
        fwrite($latexFile,$u_lname);
        fwrite($latexFile,$latexContent5);
        fwrite($latexFile,$sig_path);
        fwrite($latexFile,$latexContent6);        

        // Close the created LaTex document
        fclose($latexFile);

        // Execute our PDFTeX program to compile our .tex doc and create pdf
        chdir($directory);                                  // Change working directory to our temporary directory in preparation for exec() call
        $console = shell_exec("pdflatex certificate 2>&1"); // Run the exec() method to invoke subprocess
        chdir("../");                                       // Change our working directory back to the dir our php executable code is in

        // Build a full path
        $path = '/var/www/html/' . $directory . '/certificate.pdf';

        // Handle database activities to get the last award
        require('config.php'); // Connect to DB, a new instance is now available via $dbc variable
        $query = "SELECT MAX(id) FROM award"; // Define a query that will find record w/ max id (aka - the last award created)
        $response = mysqli_query($dbc, $query); // Run query 
        while($row = mysqli_fetch_assoc($response)){   // An array was returned, use while loop to step into first postion
            $last_award_created = "{$row['MAX(id)']}"; // Grab the id of the last award created (db auto-increments id so last will be highest id)
        }
        mysqli_close($dbc); // Close connection

        // Handle database activities to inject the contents of certificate.pdf file into db 
        require('config.php'); // Connect to DB, a new instance is now available via $dbc variable
        $cert_data = file_get_contents($path,true); // See - http://php.net/manual/en/function.file-get-contents.php (function is binary safe, we are dealing with binary files - aka images)
        $cert_escpd = mysqli_real_escape_string($dbc, $cert_data); // See - http://php.net/manual/en/mysqli.real-escape-string.php (just in case we have chars that need to be escaped)
        $query = "UPDATE award SET certificate='$cert_escpd' WHERE id='$last_award_created'"; // Define a query that will inject the contents of our binary file into blob record w/ max id (aka - the last record created)
        $response = mysqli_query($dbc, $query); // Run query 
        mysqli_close($dbc); // Close connection

        // Email the cert to recipient
        require('emailHandler.php'); // Require our email handler file
        //emailHandler($path,$email);  // Call handler to mail out cert, pass in the path to access file & recipient's email
        // Define remaining parameters that have not already been defined above
        $subject = 'Congratulations';
        $body = 'You are being recognized for your outstanding achievement! Please accept the attached award certificate as a token of gratitude.';
        emailHandler($email,$subject,$body,$path);

        // Clean up all the temp items that were created
        if(is_file("./$directory/certificate.tex")){ // If the file in question exists..
            unlink("./$directory/certificate.tex");  // Delete the certificate.tex doc
        }
        if(is_file("./$directory/certificate.aux")){ // If the file in question exists..
            unlink("./$directory/certificate.aux");  // Delete the certificate.aux doc
        }
        if(is_file("./$directory/certificate.log")){ // If the file in question exists..
            unlink("./$directory/certificate.log");  // Delete the certificate.log doc
        }
        if(is_file("./$directory/certificate.pdf")){ // If the file in question exists..
            unlink("./$directory/certificate.pdf");  // Delete the certificate.pdf doc
        }
        if(is_file("./$directory/signature.png")){   // If the file in question exists..
            unlink("./$directory/signature.png");    // Delete the signature.png file
        }
        rmdir("$directory");                         // Now delete the temp directory that was created
    }
    else{
        echo "Directory creation failed";
    }
  }
?>
