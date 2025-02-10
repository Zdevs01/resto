<?php
require 'connect.php'; // Assure-toi que ce fichier contient la connexion à la BDD

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["reservation_id"])) {
        echo "Erreur: ID de réservation manquant";
        exit;
    }

    $reservation_id = intval($_POST["reservation_id"]);

    $stmt = $con->prepare("UPDATE reservations SET canceled = 1 WHERE reservation_id = ?");
    if ($stmt->execute([$reservation_id])) {
        echo "Table libérée avec succès";
    } else {
        echo "Erreur lors de la libération de la table";
    }
}
?>
