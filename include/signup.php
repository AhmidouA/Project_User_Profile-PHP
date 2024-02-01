<?php require 'header.html'; ?>

<body>
    <?php

    if (isset($_POST['signup'])) {
        if (empty($_POST['username']) || !preg_match('/[a-zA-Z0-9]+/', $_POST['username'])) {
            $message = 'Your Username must be character string (alphanumérique) !';
        } elseif (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = 'Your email address is invalid !';
        } elseif (empty($_POST['password']) || $_POST['password'] !== $_POST['confirmPassword']) {
            $message = 'Password and Confirm password not valid!';
        } else {

            require_once '../data/db.php';


            $checkUsername = $bdd->prepare('SELECT * FROM users where username=:username');
            $checkUsername->bindValue('username', $_POST['username']);
            $checkUsername->execute();


            $findUsername = $checkUsername->fetch();


            $checkMail = $bdd->prepare('SELECT * FROM users where email=:email');
            $checkMail->bindValue('email', $_POST['email']);
            $checkMail->execute();

            $findMail = $checkMail->fetch();

            if ($findUsername) {
                $message = 'Le username existe déja, veuillez choisir un autre';
            } elseif ($findMail) {
                $message = 'Le mail existe déja, veuillez choisir un autre';
            } else {

                function token_random_string($length = 20)
                {

                    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';


                    $token = '';


                    for ($i = 0; $i < $length; $i++) {



                        $token = $token . $characters[rand(0, strlen($characters) - 1)];
                    }
                    return $token;
                }

                $token = token_random_string(20);


                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


                $request = $bdd->prepare('INSERT INTO users (username, email, password, token) 
                            VALUES (:username, :email, :password, :token)');
                $request->bindValue(':username', $_POST['username']);
                $request->bindValue(':email', $_POST['email']);
                $request->bindValue(':password', $password);
                $request->bindValue(':token', $token);


                $request->execute();


                include('mail.php');
            }
        }
    }
    ?>


    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <?php

                        if (isset($message)) echo $message

                        ?>
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Signup</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="username" class="text-info">Email:</label><br>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword" class="text-info">Confirm Password:</label><br>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="signup" class="btn btn-info btn-md" value="Submit">
                                <a href="/include/login.php" class="btn btn-info btn-md">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>