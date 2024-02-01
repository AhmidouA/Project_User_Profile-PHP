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
    $mail->Subject = 'Confirm Your Email';
    $mail->Body    = 'To confirm your email address, please click on the following link:

    <a href=
        "http://localhost:8000/include/verify.php?
        email='.$_POST['email'].'&token='.$token.'"
        >
            Confirm your Email
    </a>';


    if (!$mail->send()) {
        echo "<script type='text/javascript'>
            alert('Erreur d'envoi de l'e-mail : ' .$mail->ErrorInfo);
        </script>";
    } else {
        echo '<script type="text/javascript">
            alert("E-mail envoyé, vérifiez votre boîte de réception pour le mot de passe de réinitialisation");
        </script>';
    }

?>