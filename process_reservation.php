<?php
include('config/constants.php');

header('Content-Type: application/json'); // Définir le type de contenu JSON

if (!isset($conn)) {
    echo json_encode(["status" => "error", "message" => "Erreur de connexion à la base de données."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée."]);
    exit;
}

// Vérification et récupération des entrées utilisateur
$table_id = $_POST['table_id'] ?? null;
$nomcl = $_POST['nomcl'] ?? null;
$telcl = $_POST['telcl'] ?? null;
$date = $_POST['date'] ?? null;
$time = $_POST['time'] ?? null;
$people = $_POST['people'] ?? null;
$user_id = 1; // Remplacer par l'ID du client connecté dynamiquement

// Vérification des champs requis
if (empty($table_id) || empty($nomcl) || empty($telcl) || empty($date) || empty($time) || empty($people) || !is_numeric($people) || (int)$people <= 0) {
    echo json_encode(["status" => "error", "message" => "Tous les champs sont requis et valides."]);
    exit;
}

$people = (int) $people;

// Vérifier si le numéro de téléphone est valide (ex: 8 à 15 chiffres)
if (!preg_match("/^\d{8,15}$/", $telcl)) {
    echo json_encode(["status" => "error", "message" => "Numéro de téléphone invalide."]);
    exit;
}

// Démarrer une transaction pour assurer la cohérence des données
mysqli_begin_transaction($conn);

try {
    // Vérifier la disponibilité de la table et sa capacité
    $stmt = $conn->prepare("SELECT capacity, seats_taken FROM tbl_tables WHERE id=? AND status='available'");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("i", $table_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $capacity = $row['capacity'];
        $seats_taken = $row['seats_taken'];
        $places_restantes = $capacity - $seats_taken;

        if ($people > $places_restantes) {
            throw new Exception("Capacité insuffisante sur cette table. Sélectionnez une autre table.");
        }
    } else {
        throw new Exception("Table non trouvée ou déjà réservée.");
    }

    // Insérer la réservation
    $stmt = $conn->prepare("INSERT INTO tbl_reservations (user_id, table_id, nomcl, telcl, reservation_date, reservation_time, number_of_people, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("iissssi", $user_id, $table_id, $nomcl, $telcl, $date, $time, $people);

    if (!$stmt->execute()) {
        throw new Exception("Erreur lors de l'insertion de la réservation : " . $stmt->error);
    }

    $reservation_id = $conn->insert_id;

    // Mettre à jour le nombre de places occupées
    $stmt = $conn->prepare("UPDATE tbl_tables SET seats_taken = seats_taken + ? WHERE id=?");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("ii", $people, $table_id);
    if (!$stmt->execute()) {
        throw new Exception("Erreur lors de la mise à jour des places : " . $stmt->error);
    }

    // Vérifier si la table doit être marquée comme "reserved"
    $stmt = $conn->prepare("UPDATE tbl_tables SET status='reserved' WHERE id=? AND seats_taken >= capacity");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("i", $table_id);
    if (!$stmt->execute()) {
        throw new Exception("Erreur lors de la mise à jour du statut de la table : " . $stmt->error);
    }

    // Si tout est OK, valider la transaction
    mysqli_commit($conn);

    echo json_encode(["status" => "success", "message" => "Table réservée avec succès !", "reservation_id" => $reservation_id]);

} catch (Exception $e) {
    // En cas d'erreur, annuler la transaction
    mysqli_rollback($conn);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

?>
