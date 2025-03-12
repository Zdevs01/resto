<?php
include('config/constants.php');

date_default_timezone_set('Africa/Douala');

if (!isset($_GET['reservation_id'])) {
    die("ID de réservation manquant.");
}

$reservation_id = intval($_GET['reservation_id']);
$query = "SELECT r.*, t.table_number FROM tbl_reservations r 
          JOIN tbl_tables t ON r.table_id = t.id 
          WHERE r.id = $reservation_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Réservation introuvable.");
}

$reservation = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Réservation</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .receipt-container {
            background: #fff;
            width: 380px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
            border: 2px solid #000;
        }
        .logo {
            width: 100px;
            margin-bottom: 10px;
        }
        h2 {
            margin-bottom: 10px;
            font-size: 22px;
            color: #000;
        }
        .info {
            font-size: 16px;
            margin: 5px 0;
        }
        .status {
            font-size: 18px;
            font-weight: bold;
            color: green;
        }
        .qr-code {
            margin-top: 10px;
        }
        .button-container {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
        }
        .button {
            background-color: #000;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin: 0 5px;
        }
        .button:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <img src="images/logo.png" alt="Restaurant Logo" class="logo">
        <h2>Reçu de Réservation</h2>
        
        <p class="info"><strong>Nom du client :</strong> <?= $reservation['nomcl'] ?></p>
        <p class="info"><strong>Téléphone :</strong> <?= $reservation['telcl'] ?></p>
        <p class="info"><strong>Table :</strong> <?= $reservation['table_number'] ?></p>
        <p class="info"><strong>Date :</strong> <?= $reservation['reservation_date'] ?></p>
        <p class="info"><strong>Heure :</strong> <?= $reservation['reservation_time'] ?></p>
        <p class="info"><strong>Nombre de personnes :</strong> <?= $reservation['number_of_people'] ?></p>
        <p class="status">Statut : <?= ucfirst($reservation['status']) ?></p>

        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= urlencode("https://example.com/reservation?id=" . $reservation_id) ?>" alt="QR Code">
        </div>

        <div class="button-container">
            <button class="button" onclick="window.print()">Imprimer</button>
            <button class="button"> <a href="table.php" >  Fermer</a></button>
        </div>
    </div>
</body>
</html>