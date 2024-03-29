<?php require 'header.html'; ?>
<title>Login</title>
<?php

require_once '../data/db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $request = $bdd->prepare('SELECT * FROM users WHERE email=:email');
    $request->execute(array('email' => $email));
    $result = $request->fetch();

    if (!$result) {
        $message = 'Please enter email valid !!!';
    } elseif ($result['validation'] === 0) {
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



        $update = $bdd->prepare('UPDATE users SET token=:token WHERE email=:email');
        $update->bindValue(':token', $token);
        $update->bindValue(':email', $email);
        $update->execute();


        include('mail.php');
    } else {

        $checkPassword = password_verify($password, $result['password']);

        if ($checkPassword) {

            session_start();


            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['email'] = $email;


            if (isset($_POST['remember-me'])) {

                setcookie('email', $email);
                setcookie('password', $password);
            } else {

                if (isset($_COOKIE['email'])) {
                    setcookie($_COOKIE['email'], '');
                }
                if (isset($_COOKIE['password'])) {
                    setcookie($_COOKIE['password'], "");
                }
            }


            header("Refresh: 3; URL=/index.php");
        } else {

            $message = 'Password invalid';
        }
    }
}
?>

<body>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <?php

                            if (isset($message)) echo $message

                            ?>
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control" value=<?php
                                                                                                        if (isset($_COOKIE['email'])) echo $_COOKIE['email'];
                                                                                                        ?>>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control" value=<?php
                                                                                                                if (isset($_COOKIE['password'])) echo $_COOKIE['password'];
                                                                                                                ?>>
                            </div>
                            <div class="form-group pt-2">
                                <input type="submit" name="login" class="btn btn-info btn-md" value="Login">

                            </div>
                            <div class="form-group">
                                <a href="/include/password_forgot.php" class="text-info">Forgot Password</a>
                            </div>
                            <div id="register-link" class="text-right">
                                <div>
                                    <label for="remember-me" class="text-info">Remember me
                                        <input id="remember-me" name="remember-me" type="checkbox"></label>
                                </div>
                                <div>
                                    <a href="/include/signup.php" class="text-info">Register here</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>