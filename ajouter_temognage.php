<?php
include 'config.php'; // Inclusion du fichier de configuration

header('Content-Type: application/json'); // Pour s'assurer que la réponse est bien en JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nom']) && !empty($_POST['profession']) && !empty($_POST['message'])) {
        $nom = mysqli_real_escape_string($conn, $_POST['nom']);
        $profession = mysqli_real_escape_string($conn, $_POST['profession']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $avatar = "images/default-avatar.jpeg"; // Image par défaut

        $query = "INSERT INTO testimonials (nom, profession, message, avatar) VALUES ('$nom', '$profession', '$message', '$avatar')";

        if (mysqli_query($conn, $query)) {
            echo json_encode(["status" => "success", "message" => "Témoignage ajouté avec succès !"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur SQL : " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont requis."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode invalide."]);
}
?>
