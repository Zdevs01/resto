<?php
include('../config/constants.php');
error_reporting(0);
@ini_set('display_errors', 0);

$date_filter = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

$query = "SELECT r.id, r.nomcl, r.telcl, r.reservation_date, r.reservation_time, r.number_of_people, r.status, t.table_number
          FROM tbl_reservations r
          JOIN tbl_tables t ON r.table_id = t.id";

if (!empty($date_filter)) {
    $query .= " WHERE r.reservation_date = '$date_filter'";
}

$query .= " ORDER BY r.reservation_date DESC, r.reservation_time DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style-admin.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
    <title>Gestion des Réservations - GoodFood Admin</title>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            color: #333;
        }
        .reservation-container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        .reservation-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease-in-out;
            border-left: 6px solid #ffc107;
        }
        .reservation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
        }
        .reservation-details {
            flex: 1;
            padding-right: 20px;
        }
        .status {
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }
        .pending { background: #ffc107; color: white; }
        .confirmed { background: #28a745; color: white; }
        .cancelled { background: #dc3545; color: white; }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .btn-view {
            display: block;
            width: max-content;
            margin: 10px auto;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .btn-view:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php include('dashbord.php'); ?>
    <section id="content">
        <?php include('mess.php'); ?>
        
        <div class="reservation-container">
            <h2>📋 Liste des Réservations</h2>
           

            <!-- Formulaire de filtre par date -->
            <form method="GET" class="filter-form">
    <div class="filter-group">
        <label for="filter_date">📅 Sélectionnez une date :</label>
        <input type="date" id="filter_date" name="filter_date" value="<?= htmlspecialchars($date_filter) ?>">
        <button type="submit">🔍 Filtrer</button>
    </div>
</form>

<style>
    .filter-form {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .filter-group {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .filter-group label {
        font-weight: bold;
        margin-right: 10px;
        color: #333;
    }

    .filter-group input {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        transition: 0.3s;
    }

    .filter-group input:focus {
        border-color: #007bff;
    }

    .filter-group button {
        padding: 10px 15px;
        font-size: 16px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
        transition: background 0.3s ease-in-out;
    }

    .filter-group button:hover {
        background: #0056b3;
    }
</style>


            <?php
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $status_class = strtolower($row['status']);
                    echo "<div class='reservation-card'>
                            <div class='reservation-details'>
                                <h3>🍽️ Table: {$row['table_number']}</h3>
                                <p>👤 Client: <strong>{$row['nomcl']}</strong></p>
                                <p>📞 Tel: <strong>{$row['telcl']}</strong></p>
                                <p>🗓️ Date: <strong>{$row['reservation_date']}</strong></p>
                                <p>⏰ Heure: <strong>{$row['reservation_time']}</strong></p>
                                <p>👥 Personnes: <strong>{$row['number_of_people']}</strong></p>
                            </div>
                            <span class='status $status_class'>{$row['status']}</span>
                          </div>";
                }
            } else {
                echo "<p style='text-align:center; font-weight:bold; color:#888;'>Aucune réservation trouvée.</p>";
            }
            ?>
        </div>
    </section>

    <script src="script-admin.js"></script>
</body>
</html>