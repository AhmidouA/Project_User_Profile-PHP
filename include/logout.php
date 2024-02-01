<?php 
session_start();

if(isset($_SESSION['id'])) {
    session_unset();
    session_destroy();

    echo '<script type="text/javascript"> alert("You are disconnected"); </script>';
    header("Refresh: 3; URL=/index.php");

} else {
    echo '<script type="text/javascript"> alert("You are not connected"); </script>';
    header("Refresh: 2; URL=/index.php");
}

?>