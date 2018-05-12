<?php  

  // Note: The $user parameter is the 'id' of the user
  function certificateHandler($type,$date,$email,$fname,$lname,$user){  

    //Get the user's first and last name 
    require('config.php'); 
    $query = "SELECT f_name,l_name FROM user WHERE id=$user";               
    $response = mysqli_query($dbc, $query);     
    while($row = mysqli_fetch_assoc($response)){ // An array was returned, use while loop to step into first postion
        $u_fname = "{$row['f_name']}";           // Grab the first name of user  
        $u_lname = "{$row['l_name']}";           // Grab the last name of user            
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
                            \par\\noindent\\rule{15cm}{0.4pt} 
                            \par
                            \bigskip
                            {\\textbf{Authorizing Party Signature:    }}
                            \par\\noindent\\rule{15cm}{0.4pt} 
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
        
        // Close the created LaTex document
        fclose($latexFile); 

        // Execute our PDFTeX program to compile our .tex doc and create pdf
        chdir($directory);                                  // Change working directory to our temporary directory in preparation for exec() call
        $console = shell_exec("pdflatex certificate 2>&1"); // Run the exec() method to invoke subprocess                   
        chdir("../");                                       // Change our working directory back to the dir our php executable code is in  

        // Build a full path
        $path = '/var/www/html/' . $directory . '/certificate.pdf';

        // Email the cert to recipient
        require('emailHandler.php'); // Require our email handler file
        emailHandler($path,$email);  // Call handler to mail out cert, pass in the path to access file & recipient's email


        // ************************************     NOTE    ********************************************* //
        // Code block below to insert doc into the db is not working yet. Hard coded id of 3 just for testing, 
        // will find max id in where eventually
        // ********************************************************************************************** //
        // Insert our newly created certificate.pdf into the newest award entry in the award table (aka - the record w/ highest auto inc) 
        require('config.php'); 
        $query = "UPDATE award SET certificate=LOAD_FILE($path) WHERE id=3";               
        $response = mysqli_query($dbc, $query);     
        mysqli_close($dbc);                         

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
        rmdir("$directory");                         // Now delete the temp directory that was created
    }
    else{
        echo "Directory creation failed";
    }
  }
?>
    
