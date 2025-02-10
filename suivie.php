<?php
// Connexion à la base de données
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'resto';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer les commandes en cours avec les informations du client
$sql = "SELECT c.id, cl.client_name, c.statut 
        FROM commandes c
        JOIN clients cl ON c.client_id = cl.client_id
        ORDER BY c.id DESC";
$result = $conn->query($sql);

$commandes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $commandes[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Commandes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #1a1a2e;
            color: white;
            font-family: Arial, sans-serif;
        }
        .commande {
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease;
        }
        .commande:hover {
            transform: scale(1.05);
        }
        .statut {
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        .statut i {
            margin-right: 8px;
        }
        .en_attente { color: yellow; }
        .en_preparation { color: orange; }
        .pret { color: limegreen; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Suivi des Commandes</h2>
        <div id="commandes-container">
            <?php foreach ($commandes as $commande): ?>
                <div class="commande">
                    <span>Commande #<?= $commande['id'] ?> - <?= htmlspecialchars($commande['client_name']) ?></span>
                    <span class="statut <?= strtolower(str_replace(' ', '_', $commande['statut'])) ?>">
                        <i class="fas <?= $commande['statut'] == 'En attente' ? 'fa-hourglass-start' : ($commande['statut'] == 'En préparation' ? 'fa-fire' : 'fa-check-circle') ?>"></i>
                        <?= htmlspecialchars($commande['statut']) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function rafraichirCommandes() {
            fetch('suivie.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('commandes-container').innerHTML =
                        new DOMParser().parseFromString(data, 'text/html').getElementById('commandes-container').innerHTML;
                });
        }
        setInterval(rafraichirCommandes, 5000); // Mise à jour toutes les 5 secondes
    </script>
</body>
</html>
