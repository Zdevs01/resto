<?php
$host = "localhost";
$user = "root"; // Remplace par ton utilisateur MySQL
$password = ""; // Remplace par ton mot de passe MySQL
$database = "new-food-order"; // Remplace par le nom de ta base de données

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}
?>
