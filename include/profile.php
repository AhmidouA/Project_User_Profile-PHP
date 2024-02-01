
<?php
require 'header.html';
session_start();

if (isset($_SESSION['id'])) {
?>
<title>Profile</title>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Profil</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <table>
                            <tr><td>Name: </td><td><?= $_SESSION['username'] ?></td></tr>
                            <tr><td>Email: </td><td><?= $_SESSION['email'] ?></td></tr>
                            <tr><td><a href="update_profil.php"> Update Profil</a></td></tr>
                            <tr><td><a href="/index.php">Home Page</a></td></tr>
                        </table>
<?php 
}
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
