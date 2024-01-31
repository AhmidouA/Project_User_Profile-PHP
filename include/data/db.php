<?php 
$username = 'superUser'; 
$password = 'Djam16021982';
$dbname = 'member_db';

// connexion a la db
try {
    $bdd = new PDO('mysql:host=localhost;dbname='.$dbname, $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
    exit();  // En cas d'échec de la connexion, le script s'arrête ici
}


?>