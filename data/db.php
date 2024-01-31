<?php 
require_once realpath(dirname(__DIR__) . "/vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__). '/');

$dotenv->load();

$dbUser = $_ENV['DB_USER']; 
$dbPassword = $_ENV['DB_PASSWORD'];
$dbName = $_ENV['DB_NAME'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname='.$dbName, $dbUser, $dbPassword);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
    exit(); 
}
?>