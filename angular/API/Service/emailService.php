<?php

require    'phpmailer/src/Exception.php';
require    'phpmailer/src/PHPMailer.php';
require    'phpmailer/src/SMTP.php';

include '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Config/logger.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 


class EmailService{
    private $mailer;

    //create instance for phpmailer while creating obj for EmailService
    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    //this is the function used to send email.
    public function sendEmail($userData) {
        try {
            //Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host       = 'smtp.gmail.com'; // Specify the SMTP server (in this case, Gmail)
            $this->mailer->SMTPAuth   = true; // if set to true it will require authentication
            $this->mailer->Username   = 'sathishkumar.m@nilaapps.co.in'; // email
            $this->mailer->Password   = 'fxywviwqbzfpkdju'; //  email password
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $this->mailer->Port       = 587;

            //Recipients
            // $this->mailer->setFrom('sathishkumar.m@nilaapps.co.in', 'sathish');
            $recipient = 'sathishenfield1996@gmail.com';
            $this->mailer->addAddress($recipient);

            // Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "Registration Successfull";

            // Attach the PDF file
            // $pdfFilePath = '/home/sathishkumar/Downloads/Assignment-6.pdf';
            // $this->mailer->addAttachment($pdfFilePath, 'Generated_PDF_File.pdf');

            // Check if the recipient's email ends with 'gmail.com' and select the appropriate template
            if (strpos($recipient, 'gmail') !== false) {
                // Load the Gmail template
                $htmlContent = file_get_contents('/opt/lampp/htdocs/Mystudio_webapp/angular/app/view/gmailTemplate.html');
            } elseif (strpos($recipient, 'yahoo') !== false) {
                // Load the Yahoo template
                $htmlContent = file_get_contents('/opt/lampp/htdocs/Mystudio_webapp/angular/app/view/yahooTemplate.html');
            }else{
                // Load the default template
                $htmlContent = file_get_contents('/opt/lampp/htdocs/Mystudio_webapp/angular/app/view/defaultTemplate.html');
            }
            //set hmtl content according to the type of mail.
            $htmlContent = str_replace('name',$userData['user_name'],$htmlContent);
            $htmlContent = str_replace('email',$userData['email'],$htmlContent);
            $htmlContent = str_replace('phno',$userData['phone_number'],$htmlContent);
            $this->mailer->Body  = $htmlContent;
            if ($this->mailer->send()) {
                return true;
            } else {
                Logger::log_api("Email could not be sent. Error: " . $this->mailer->ErrorInfo);
                return false;
            }
        } catch (Throwable $e) {
            //log exeception message to the logger api
            Logger::log_api("Email sending failed with an exception: " . $e->getMessage());
            return false;
        }
    } 
}
?>
