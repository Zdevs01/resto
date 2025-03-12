<?php include('../config/constants.php'); ?>
<?php //include('login-check.php'); ?>
<?php
           $payment_status_query = "UPDATE order_manager
                   SET payment_status = 'successful'
                   WHERE EXISTS ( SELECT NULL
                   FROM aamarpay
                   WHERE aamarpay.transaction_id = order_manager.transaction_id )";

                   $payment_status_query_result=mysqli_query($conn,$payment_status_query);

                   ?>
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
            <h1>Commandes en ligne</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-online-order.php">Commandes en ligne</a>
                </li>
            </ul>
        </div>
    </div>
    <br/>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <table class="">
                    <thead>
                        <tr>
                            <th>ID Commande</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Mode du paiement</th>
                            <th>Statut de la commande</th>
                            <th>Total</th>
                            <th>Commande</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    $query="SELECT * FROM `order_manager` ORDER BY order_id DESC";
                    $user_result=mysqli_query($conn,$query);

                    while($user_fetch=mysqli_fetch_assoc($user_result))
                    {
                        $order_id = $user_fetch['order_id'];
                        $cus_name = $user_fetch['cus_name'];
                        $cus_email = $user_fetch['cus_email'];
                        $cus_add1 = $user_fetch['cus_add1'];
                        $cus_phone = $user_fetch['cus_phone'];
                        $payment_mode = $user_fetch['payment_mode'];
                        $order_status = $user_fetch['order_status'];
                        $total_amount = $user_fetch['total_amount'];
                    ?>
                     

                        <tr>
                            <td><?php echo $order_id; ?></td>
                            <td><?php echo $cus_name; ?></td>
                            <td><?php echo $cus_email; ?></td>
                            <td><?php echo $cus_add1; ?></td>
                            <td><?php echo $cus_phone ?></td>
                            <td><?php echo $payment_mode ?></td>
                          

                            <td>
                            <?php 
                                if($order_status=="Pending")
                                {
                                    echo "<span class='status process'>En attente</span>";
                                }
                                else if($order_status=="Processing")
                                {
                                    echo "<span class='status pending'>En cours</span>";
                                }
                                else if($order_status=="Delivered")
                                {
                                    echo "<span class='status completed'>Livré</span>";
                                }
                                else if($order_status=="Cancelled")
                                {
                                    echo "<span class='status cancelled'>Annulé</span>";
                                }
                            ?>
                            <br><br>
                            <span>
                                <a href="<?php echo SITEURL; ?>update-online-order.php?id=<?php echo $order_id; ?>" class="button-8" role="button">Mettre à jour</a>
                            </span>
                            </td>

                            <td><?php echo $total_amount; ?> €</td>
                            <?php
                            echo"
                            <td>
                                <table class='tbl-full'>
                                <thead>
                                    <tr>
                                        <th>Nom de l'article</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ";

                                $order_query="SELECT * FROM `online_orders_new` WHERE `order_id`='$user_fetch[order_id]' ORDER BY order_id DESC ";
                                $order_result = mysqli_query($conn,$order_query);
                                
                                while($order_fetch=mysqli_fetch_assoc($order_result))
                                {
                                    echo"
                                        <tr>
                                            <td>$order_fetch[Item_Name]</td>
                                            <td>$order_fetch[Price] €</td>
                                            <td>$order_fetch[Quantity]</td>
                                        </tr>
                                    ";
                                }

                                echo"
                                </tbody>
                                </table>
                            </td>
                        </tr>
                        ";
                    }
                ?>

                    </tbody>
                </table>                       
            </div>
        </div>
    </div>
</main>

		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script-admin.js"></script>
</body>
</html>