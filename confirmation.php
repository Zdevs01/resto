<?php
include('config/constants.php');

date_default_timezone_set('Africa/Douala');

// Vérifier si un Order_Id est bien passé
if (!isset($_GET['order_id'])) {
    die("ID de commande manquant.");
}

$order_id = intval($_GET['order_id']);
$query = "SELECT * FROM order_manager WHERE order_id = $order_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Commande introuvable.");
}

$order = mysqli_fetch_assoc($result);

$query_items = "SELECT * FROM online_orders_new WHERE order_id = $order_id";
$result_items = mysqli_query($conn, $query_items);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Commande</title>

    <link rel="icon" 
      type="image/png" 
      href="images/logo.png">
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
        .info, .order-item {
            font-size: 16px;
            margin: 5px 0;
        }
        .order-list {
            text-align: left;
            margin-top: 10px;
            padding-left: 0;
        }
        .order-list li {
            list-style: none;
            padding: 5px 0;
            border-bottom: 1px dashed #ccc;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: #e63946;
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
        <img src="images/logo.png" alt="Logo" class="logo">
        <h2>Reçu de Commande</h2>
        
        <p class="info"><strong>Nom du client :</strong> <?= $order['cus_name'] ?></p>
        <p class="info"><strong>Email :</strong> <?= $order['cus_email'] ?></p>
        <p class="info"><strong>Téléphone :</strong> <?= $order['cus_phone'] ?></p>
        <p class="info"><strong>Adresse :</strong> <?= $order['cus_add1'] . ', ' . $order['cus_city'] ?></p>
        <p class="info"><strong>Mode de paiement :</strong> <?= ucfirst($order['payment_mode']) ?></p>
        <p class="info"><strong>Date :</strong> <?= $order['order_date'] ?></p>
        
        <h3>Détails de la commande</h3>
        <ul class="order-list">
            <?php while ($item = mysqli_fetch_assoc($result_items)) : ?>
                <li class="order-item"> <?= $item['Item_Name'] ?> - <?= $item['Quantity'] ?> x <?= number_format($item['Price'], 2) ?> €</li>
            <?php endwhile; ?>
        </ul>
        
        <p class="total">Total : <?= number_format($order['total_amount'], 2) ?> €</p>
        
        <div class="button-container">
            <button class="button" onclick="window.print()">Imprimer</button>
            <button class="button" > <a href="myaccount.php" > Fermer </a> </button>
        </div>
    </div>
</body>
</html>
