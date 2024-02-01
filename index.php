<?php require 'include/header.html'; ?>
<title>Home Page</title>

<body>
    <div class="home">
        <div class="session">
            <?php
            session_start();
            if (isset($_SESSION['id'])) {
                echo 'Hello ' . $_SESSION['username'];
            ?>
        </div>
        <h1 class="title-home"><a href="include/logout.php">Logout</a> </h1><br>

    <?php
            } else {
    ?> 

        <div class="disconnected">
            <h1 class="title-home"><a href="include/signup.php">Signup</a></h1> <br>
            <h1 class="title-home"><a href="include/login.php">Login</a></h1> <br>
        </div>
    <?php
            }
    ?>
    </div>
</body>