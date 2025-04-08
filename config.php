<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $error) {
    exit("erreur de connexion : ".$error->getMessage());
}

echo "parfait";


?>