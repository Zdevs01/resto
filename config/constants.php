<?php  
// Activer la sortie tampon pour éviter les erreurs d'envoi d'en-têtes
ob_start();

// Vérifier si une session est déjà active avant de l'initialiser
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définition des constantes
define('SITEURL', 'http://localhost/resto/admin/'); // Ajoute ton URL correcte

define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'new-food-order');

// Connexion à la base de données
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

// Sélection de la base de données
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); 
?>
