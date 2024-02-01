<?php require 'header.html'; ?>
<title>Password forgot</title>
</head>

<body>

    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.PHP';
    require '../PHPMailer/src/Exception.PHP';

    require_once realpath(dirname(__DIR__) . "/vendor/autoload.php");

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__) . '/');
    $dotenv->load();

    $smtpUsername = $_ENV['SMTP_USERNAME'];
    $smtpPassword = $_ENV['SMTP_PASSWORD'];
    $smtpName = $_ENV['SMTP_NAME'];

    $mail = new PHPMailer(true);

    if (isset($_POST['password_forget'])) {
        function token_random_string($leng = 20)
        {
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
            for ($i = 0; $i < $leng; $i++) {
                $token .= $str[rand(0, strlen($str) - 1)];
            }
            return $token;
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = "Enter a valid email address";
        } else {

            require_once '../data/db.php';

            $requete = $bdd->prepare('SELECT * FROM users WHERE email=:email');
            $requete->bindvalue(':email', $_POST['email']);
            $requete->execute();

            $result = $requete->fetch();
            $nombre = $requete->rowCount();

            if ($nombre != 1) {
                $message = "The email address entered does not correspond to any user of our member area";
            } else {

                if ($result['validation'] != 1) {

                    $token = token_random_string(20);
                    $update = $bdd->prepare('UPDATE users SET token =:token WHERE email=:email');
                    $update->bindvalue(':token', $token);
                    $update->bindvalue(':email', $_POST['email']);
                    $update->execute();

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

                    $mail->Subject = 'Email confirmation';
                    $mail->Body = 'To validate your email address, please click on the following link:
                    <a href="http://localhost:8000/include/verify.php?token=' . $token . '&email=' . $_POST['email'] . ' ">Confirmation</a>';

                    if (!$mail->send()) {
                        $message = "Email not sent";
                        echo 'Errors:' . $mail->ErrorInfo;
                    } else {
                        $message =  "Your email address is not yet confirmed. We have mailed you instructions to confirm your email address that you provided. You should receive them soon.";
                    }
                } else {
                    $token = token_random_string(20);

                    $requete1 = $bdd->prepare('SELECT * FROM reset_password WHERE email=:email');
                    $requete1->bindvalue(':email', $_POST['email']);
                    $requete1->execute();

                    $nombre1 = $requete1->rowCount();

                    if ($nombre1 == 0) {
                        $requete2 = $bdd->prepare('INSERT INTO reset_password (email,token) VALUES(:email, :token)');
                        $requete2->bindvalue(':email', $_POST['email']);
                        $requete2->bindvalue(':token', $token);
                        $requete2->execute();
                        
                    } else {
                        $requete3 = $bdd->prepare('UPDATE reset_password SET token=:token WHERE email=:email');
                        $requete3->bindvalue(':token', $token);
                        $requete3->bindvalue(':email', $_POST['email']);
                        $requete3->execute();
                    }

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

                    $mail->Subject = ('Reset password');
                    $mail->Body = ('To reset your password, please click on the following link:
                    <a href="http://localhost:8000/include/new_password.php?token=' . $token . '&email=' . $_POST['email'] . ' ">Reset password</a>');

                    if (!$mail->send()) {
                        $message = "Email not sent";
                        echo 'Errors:' . $mail->ErrorInfo;
                    } else {
                        $message1 =  "We have mailed you instructions for resetting your password. You should receive them soon.";
                    }
                }
            }
        }
    }
    ?>

    <div id="login">
        <h3 class="text-center text-white pt-5">Forgot password</h3>
        <h6 class="text-center text-white pt-5">Please enter your email address below, we will send you descriptions to reset your password </h6>

        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">

                        <center>
                            <div class="container" style="background-color:#FB6969;">
                                <font color="#8B0505"><?php if (isset($message)) echo $message; ?></font>
                            </div>
                        </center>

                        <center>
                            <div class="container" style="background-color:#95D588;">
                                <font color="#115702"><?php if (isset($message1)) echo $message1; ?></font>
                            </div>
                        </center>


                        <form id="login-form" class="form" action="" method="post">

                            <div class="form-group">
                                <label for="email" class="text-info">Votre adresse Email:</label><br>
                                <input type="email" name="email" id="email" class="form-control" placeholder='Exemple: dupond@domaine.com'>
                            </div>

                            <div class="form-group">

                                <input type="submit" name="password_forget" class="btn btn-info btn-md" value="Reset password">

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>