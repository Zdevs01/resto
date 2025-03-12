<?php
$host = 'localhost'; // Adresse du serveur MySQL
$user = 'root'; // Nom d'utilisateur MySQL (par défaut sur XAMPP)
$password = ''; // Mot de passe MySQL (vide par défaut sur XAMPP)
$dbname = 'new-food-order'; // Remplace par le nom de ta base de données

// Création de la connexion
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
