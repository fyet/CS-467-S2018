<?php  

  // Import necessary PHPmailer classes
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  function emailHandler($path,$email){

        // The code structure below is from phpmailer's manual: https://github.com/PHPMailer/PHPMailer   
        require 'vendor/autoload.php'; // the autoload file

        $mail = new PHPMailer(true);                             
        try {
            //Server settings
            $mail->SMTPDebug = 2;   // This is spitting log to browser, when we hit production it will need to be turned off. Log data is shown for now                           
            $mail->isSMTP();                                        
            $mail->Host = 'smtp.gmail.com';                       
            $mail->SMTPAuth = true;                                 
            $mail->Username = 'camelopardalis.awardhub@gmail.com';  
            $mail->Password = 'cs467group!@#$';                     
            $mail->SMTPSecure = 'tls';                              
            $mail->Port = 587;                                      

            //Recipients
            $mail->setFrom('camelopardalis.awardhub@gmail.com', 'Award Hub');
            $mail->addAddress($email); 

            //Attachments
            $mail->addAttachment($path);   

            //Content
            $mail->isHTML(true);                                 
            $mail->Subject = 'Congratulations';
            $mail->Body    = 'You are being recognized for your outstanding achievement! Please accept the attached award certificate as a token of gratitude.';
            $mail->AltBody = 'You are being recognized for your outstanding achievement! Please accept the attached award certificate as a token of gratitude.';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        } 
  }
?>
    