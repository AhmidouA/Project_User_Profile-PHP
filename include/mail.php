<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.PHP';
require '../PHPMailer/src/Exception.PHP';


require_once realpath(dirname(__DIR__) . "/vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__). '/');

$dotenv->load();

$smtpUsername = $_ENV['SMTP_USERNAME'];
$smtpPassword = $_ENV['SMTP_PASSWORD'];
$smtpName = $_ENV['SMTP_NAME'];

$mail = new PHPMailer(true);

try {
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  

    $mail->isSMTP();                       
    $mail->Host       = 'smtp.outlook.com';  
    $mail->SMTPAuth   = true;              
    $mail->Username   = $smtpUsername; 
    $mail->Password   = $smtpPassword;               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587;                


    $mail->setFrom($smtpUsername, $smtpName);
    $mail->addAddress($_POST['email']);


    $mail->isHTML(true);                      
    $mail->Subject = 'Confirmation';
    $mail->Body    = 'Afin de valider votre adresse email, merci de cliquer sur le lien suivant:

    <a href=
        "http://localhost:8000/include/verify.php?
        email='.$_POST['email'].'&token='.$token.'"
        >
            Confirmation
    </a>';


    $mail->send();
    echo "<script type=\"text/javascript\"> alert('Email sent, check you mailbox for validation ')</script>";
} catch (Exception $e) {
    echo "Le message n'a pas pu être envoyé. Erreur du mailer : {$mail->ErrorInfo}";
}







