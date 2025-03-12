<?php include('../config/constants.php'); ?>
<?php //include('login-check.php'); ?>
<?php
$ei_order_notif = "SELECT order_status from tbl_eipay
					WHERE order_status='Pending' OR order_status='Processing'";

$res_ei_order_notif = mysqli_query($conn, $ei_order_notif);

$row_ei_order_notif = mysqli_num_rows($res_ei_order_notif);

$online_order_notif = "SELECT order_status from order_manager
					WHERE order_status='Pending'OR order_status='Processing' ";

$res_online_order_notif = mysqli_query($conn, $online_order_notif);

$row_online_order_notif = mysqli_num_rows($res_online_order_notif);

$stock_notif = "SELECT stock FROM tbl_food
				WHERE stock<50";

$res_stock_notif = mysqli_query($conn, $stock_notif);
$row_stock_notif = mysqli_num_rows($res_stock_notif);

//Message Notification
$message_notif = "SELECT message_status FROM message
				 WHERE message_status = 'unread'";
$res_message_notif = mysqli_query($conn, $message_notif);
$row_message_notif = mysqli_num_rows($res_message_notif);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style-admin.css">
	<link rel="icon" 
      type="image/png" 
      href="../images/logo.png">

	<title>GoodFood Admin</title>
</head>
<body>


	<!-- SIDEBAR -->
	<?php include('dashbord.php'); ?>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include('mess.php'); ?>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
    <div class="head-title">
        <div class="left">
            <h1>Commandes sur place</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-online-order.php">Commandes sur place</a>
                </li>
            </ul>
        </div>
    </div>

    <br>
    
    <div class="table-data">
        <div class="order">
            <div class="head"></div>

            <table>
                <tr>
                    <th>N°</th>
                    <th>ID Table</th>
                    <th>Montant</th>
                    <th>ID Transaction</th>
                    <th>Date de commande</th>
                    <th>Statut du paiement</th>
                    <th>Statut de la commande</th>
                    <th>Actions</th>
                </tr>

                <?php 
                // Récupérer les commandes sur place depuis la base de données
                $sql = "SELECT * FROM tbl_eipay ORDER BY id DESC";

                // Exécuter la requête
                $res = mysqli_query($conn, $sql);

                // Compter le nombre de résultats
                $count = mysqli_num_rows($res);
                $sn = 1; // Numéro de série initialisé à 1

                if($count > 0) {
                    // Afficher les commandes existantes
                    while($row = mysqli_fetch_assoc($res)) {
                        // Récupérer les détails de la commande
                        $id = $row['id'];
                        $table_id = $row['table_id'];
                        $amount = $row['amount'];
                        $tran_id = $row['tran_id'];
                        $order_date = $row['order_date'];
                        $payment_status = $row['payment_status'];
                        $order_status = $row['order_status'];
                ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $table_id; ?></td>
                            <td><?php echo $amount; ?> FCFA</td>
                            <td><?php echo $tran_id; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td><span class="status process"><?php echo $payment_status; ?></span></td>
                            <td>
                                <?php 
                                if($order_status == "Pending") {
                                    echo "<span class='status process'>$order_status</span>";
                                } else if($order_status == "Processing") {
                                    echo "<span class='status pending'>$order_status</span>";
                                } else if($order_status == "Delivered") {
                                    echo "<span class='status completed'>$order_status</span>";
                                } else if($order_status == "Cancelled") {
                                    echo "<span class='status cancelled'>$order_status</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo SITEURL; ?>update-ei-order.php?id=<?php echo $id; ?>" class="button-5">Modifier</a>
                                <a href="<?php echo SITEURL; ?>delete-ei-order.php?id=<?php echo $id; ?>" class="button-7">Supprimer</a>
                            </td>
                        </tr>

                <?php
                    }
                } else {
                    // Aucun enregistrement trouvé
                    echo "<tr><td colspan='8' class='error'>Aucune commande disponible</td></tr>";
                }
                ?>

            </table>
        </div>
    </div>
</main>

		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script-admin.js"></script>
</body>
</html>