<?php 
session_start();

if(isset($_SESSION['id'])) {
    // Detruire les variable de la sessions
    session_unset();
    // Detruire la session elle meme
    session_destroy();

    echo '<script type="text/javascript"> alert("You are disconnected"); </script>';
    header("Refresh: 3; URL=/index.php");

} else {
    echo '<script type="text/javascript"> alert("You are not connected"); </script>';
    header("Refresh: 2; URL=/index.php");
}

?>