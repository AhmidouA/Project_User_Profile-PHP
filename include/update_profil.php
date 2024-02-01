<?php require 'header.html' ;?>
<title>Update Profile</title>
<?php
session_start();

if (isset($_POST['update']) AND isset($_SESSION['id'])) {

    $id = $_SESSION['id'];

    if (empty($_POST['username']) || !preg_match('/[a-zA-Z0-9]+/', $_POST['username'])) {
        $message = 'Your Username must be character string (alphanumérique) !';
    } elseif (empty($_POST['password']) || $_POST['password'] !== $_POST['confirmPassword']) {
        $message = 'Password and Confirm password not valid!';
    } else {
        // inclure un ficher pour save le signup
        require_once '../data/db.php';

        // On vérifie si le username n'est pas deja enregistré.
        $checkUsername = $bdd->prepare('SELECT * FROM users where username=:username');
        $checkUsername->bindValue('username', $_POST['username']);
        $checkUsername->execute();

        // Retourne la 1er valeur trouvé
        $findUsername = $checkUsername->fetch();

        if ($findUsername) {
            $message = 'Le username existe déja, veuillez choisir un autre';
        } else {
             // hach
             $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

             // Liaison des valeurs aux paramètres de la requête
             $request = $bdd->prepare('UPDATE users SET username = :username, password = :password WHERE id=:id');
             $request->bindValue(':username', $_POST['username']);
             $request->bindValue(':password', $password); // password haché
             $request->bindValue(':id', $id);

             // Exécution de la requête
             $request->execute();
             echo '<script type="text/javascript"> alert("Profile Edit"); </script>';
             header("Refresh: 1; URL=/include/profile.php");
             
         }
        }
    }
?>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Edit</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <?php
                        // Afficher les messages d'erreur s'ils existent
                        if (isset($message)) echo $message

                        ?>
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Edit</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                    
                            <div class="form-group">
                                <label for="password" class="text-info">New Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword" class="text-info">Confirm Password:</label><br>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" class="btn btn-info btn-md" value="Update">
                                <!-- <a href="/include/login.php" class="btn btn-info btn-md">Login</a> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>