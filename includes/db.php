<?php
$host = 'localhost';
$dbname = 'behanzin_institute';
$username = 'root'; // À remplacer par votre nom d'utilisateur
$password = 'root'; // À remplacer par votre mot de passe

try {
    $pdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>