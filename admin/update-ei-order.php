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
            <h1>Modifier la commande sur place</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-ei-order.php">Commandes sur place</a>
                </li>
            </ul>
        </div>
    </div>

    <br>

    <?php 
    // Récupération de l'ID de la commande
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_eipay WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);

            $table_id = $row['table_id'];
            $amount = $row['amount'];
            $tran_id = $row['tran_id'];
            $order_date = $row['order_date'];
            $payment_status = $row['payment_status'];
            $order_status = $row['order_status'];
        } else {
            // Redirection si la commande n'existe pas
            header('location:'.SITEURL.'manage-ei-order.php');
        }
    }
    ?>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <form action="" method="POST">
                    <table class="rtable">
                        <tr>
                            <td>ID Table</td>
                            <td>
                                <input type="text" name="table_id" value="<?php echo $table_id; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Montant</td>
                            <td>
                                <input type="text" name="amount" value="<?php echo $amount; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>ID Transaction</td>
                            <td>
                                <input type="text" name="tran_id" value="<?php echo $tran_id; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Date de commande</td>
                            <td>
                                <input type="text" name="order_date" value="<?php echo $order_date; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Statut du paiement</td>
                            <td>
                                <input type="text" name="payment_status" value="<?php echo $payment_status; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Statut de la commande</td>
                            <td>
                                <select name="order_status">
                                    <option <?php if($order_status=="Pending"){ echo "selected";} ?> value="Pending">En attente</option>
                                    <option <?php if($order_status=="Processing"){ echo "selected";} ?> value="Processing">En cours</option>
                                    <option <?php if($order_status=="Delivered"){ echo "selected";} ?> value="Delivered">Livrée</option>
                                    <option <?php if($order_status=="Cancelled"){ echo "selected";} ?> value="Cancelled">Annulée</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Mettre à jour" class="button-8">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <?php 
    // Vérification si le formulaire a été soumis
    if (isset($_POST['submit'])) {
        // Récupération des valeurs du formulaire
        $id = $_POST['id'];
        $table_id = $_POST['table_id'];
        $amount = $_POST['amount'];
        $tran_id = $_POST['tran_id'];
        $order_date = $_POST['order_date'];
        $payment_status = $_POST['payment_status'];
        $order_status = $_POST['order_status'];

        // Mise à jour de la commande dans la base de données
        $sql = "UPDATE tbl_eipay SET
            table_id = '$table_id',
            amount = '$amount',
            tran_id = '$tran_id',
            order_date = '$order_date',
            payment_status = '$payment_status',
            order_status = '$order_status' 
            WHERE id = '$id'";

        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            $_SESSION['update'] = "<div class='success'>Commande mise à jour avec succès</div>";
            header('location:'.SITEURL.'manage-ei-order.php');
        } else {
            $_SESSION['update'] = "<div class='error'>Échec de la mise à jour</div>";
            header('location:'.SITEURL.'manage-ei-order.php');
        }
    }
    ?>
</main>

		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script-admin.js"></script>
</body>
</html>