<?php
require 'header.html';
require_once '../data/db.php';


if ($_GET) {

    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    }


    if (isset($_GET['token'])) {
        $token = $_GET['token'];
    }


    if (!empty($email) && !empty($token)) {

        $request = $bdd->prepare('SELECT * FROM users WHERE email=:email AND token=:token');
        $request->bindValue(':email', $email);
        $request->bindValue(':token', $token);
        $request->execute();


        $number = $request->rowCount();


        if ($number === 1) {

            $update = $bdd->prepare('UPDATE users SET validation=:validation, token=:token WHERE email=:email');
            $update->bindValue(':validation', 1);
            $update->bindValue(':token', 'Email Valid');
            $update->bindValue(':email', $email);


            $result = $update->execute();


            if ($result) {

                echo '<script type="text/javascript"> alert("Your email is valid"); </script>';


                header("Refresh: 3; URL=/index.php");
            }
        }
    }
}
