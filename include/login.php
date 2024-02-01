<?php require 'header.html'; ?>
<?php

require_once '../data/db.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $request = $bdd -> prepare('SELECT * FROM users WHERE email=:email');
    $request -> execute(array('email' => $email));
    $result = $request->fetch();

    if(!$result) {
        $message = 'Please enter email valid !!!';     
    } elseif ($result['validation'] === 0) { // si il n'a pas encore valider son adresse email on lui renvoi un token et un mail
        function token_random_string($length = 20) {
            // Définition d'une chaîne de caractères contenant des chiffres et des lettres (minuscules et majuscules)
            $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
            // Initialisation d'une chaîne vide pour stocker le jeton généré
            $token = '';

            // Boucle pour générer chaque caractère du jeton
            for ($i = 0; $i < $length; $i++) {
                // Ajout d'un caractère aléatoire de la chaîne $characters au jeton
                // Cette partie génère un nombre aléatoire compris entre 0 et la longueur de la chaîne 
                // comme  on commence par 0, grace au -1 ça fait 20
                $token = $token.$characters[rand(0, strlen($characters) - 1)]; // concatenation 
            }
            return $token;
        }
        $token = token_random_string(20);

        // si il n'a pas valider l'ancien mail (ancien token)
        // on génére un nouveau token
        $update = $bdd -> prepare('UPDATE users SET token=:token WHERE email=:email');
        $update -> bindValue(':token', $token);
        $update -> bindValue(':email', $email);
        $update -> execute();

        // Inclure et exécuter le script d'envoi de courrier
        include('mail.php');

    } else {
        $checkPassword = password_verify($password, $result['password']);

        if($checkPassword) {
            session_start();
            
            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['email'] = $email;

            header("Refresh: 3; URL=/index.php");
        }
        else {
            $message = 'Password invalid';
        }
    }

}
?>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <?php
                            // Afficher les messages d'erreur s'ils existent
                            if (isset($message)) echo $message

                            ?>
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" class="btn btn-info btn-md" value="Login">
                                <a href="/include/signup.php" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
