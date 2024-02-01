<?php require 'include/header.html'; ?>
<title>Home Page</title>
<body>
    <div class="session">
        <?php
        session_start();
        if(isset($_SESSION['id'])) {
            echo 'Hello ' .$_SESSION['username'];
        }
        ?>
    </div>
    <div class="home">
        <h1 class="title-home"><a href="include/signup.php">Signup</a> <br></h1>
        <h1 class="title-home"> <a href="include/login.php">Login</a> <br></h1>
    </div>
</body>