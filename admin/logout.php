<?php 
session_start(); // Assurer que la session est bien démarrée
include('../config/constants.php');

// Détruire complètement la session
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session active

// Rediriger vers la page de connexion
header('location: '.SITEURL.'login.php');
exit();
?>
