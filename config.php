
<?php
$host = "localhost"; // ou l'adresse du serveur MySQL
$user = "root"; // utilisateur MySQL
$password = ""; // mot de passe MySQL
$dbname = "new-food-order"; // remplace par le vrai nom de ta base

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
?>
