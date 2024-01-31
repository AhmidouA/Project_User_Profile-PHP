<?php
// Importer les classes PHPMailer dans l'espace de noms global
// Celles-ci doivent être en haut de votre script, pas à l'intérieur d'une fonction
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.PHP';
require 'PHPMailer/src/Exception.PHP';

// Créer une instance de PHPMailer avec la gestion des exceptions activée
$mail = new PHPMailer(true);

try {
    // Configuration du serveur
    // Activer la sortie de débogage verbose // Pour éviter d'avoir le rapport. Activer pour faire le 1er test
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  

    $mail->isSMTP();                        // Envoyer via SMTP
    $mail->Host       = 'smtp.outlook.com';   // Définir le serveur SMTP
    $mail->SMTPAuth   = true;               // Activer l'authentification SMTP
    $mail->Username   = '';  // Nom d'utilisateur SMTP
    $mail->Password   = '';                // Mot de passe SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Activer le chiffrement TLS
    $mail->Port       = 587;                 // Port TCP à utiliser; utilisez 465 si vous avez défini `SMTPSecure = PHPMailer::ENCRYPTION_SMTPS`

    // Définir l'expéditeur et les destinataires
    $mail->setFrom('', '');
    $mail->addAddress('', '');

    // Configuration du contenu HTML
    $mail->isHTML(true);                       // Définir le format de l'email en HTML
    $mail->Subject = 'Cet email est un test'; // Définir le sujet de l'email
    $mail->Body    = 'Afin de valider votre adresse email, merci de cliquer sur le lien suivant'; // Corps HTML de l'email

    // Envoyer l'email
    $mail->send();
    echo "<script type=\"text/javascript\"> alert('Email sent, check you mailbox for validation ')</script>";
} catch (Exception $e) {
    echo "Le message n'a pas pu être envoyé. Erreur du mailer : {$mail->ErrorInfo}";
}







