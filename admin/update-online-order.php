<?php include('../config/constants.php');
      //include('login-check.php'); 

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
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style-admin.css">
	<link rel="icon" 
      type="image/png" 
      href="../images/logo.png">

	<title>GoodFood Admin</title>
</head>
<body>

<?php include('dashbord.php'); ?>
	<section id="content">
	<?php include('mess.php'); ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    
	
	<main>
    <div class="head-title">
        <div class="left">
            <h1>Mettre à Jour la Commande en Ligne</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-online-order.php">Commandes sur Place</a>
                </li>
            </ul>
        </div>
    </div>

    <br>

    <?php 
    
    $id=$_GET['id'];
    $sql="SELECT * FROM order_manager WHERE order_id=$id";
    $res=mysqli_query($conn, $sql);

    if($res == true)
    {
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            $row=mysqli_fetch_assoc($res);

            $order_id = $row['order_id'];
            $cus_name = $row['cus_name'];
            $cus_email = $row['cus_email'];
            $cus_add1 = $row['cus_add1'];
            $cus_phone = $row['cus_phone'];
            $payment_status = $row['payment_status'];
            $order_status = $row['order_status'];
        }
        else
        {
            header('location:'.SITEURL.'manage-online-order.php');
        }
    }
    ?>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <form action="" method="POST">
                    <table class="rtable">
                        <tr>
                            <td>Nom du Client</td>
                            <td>
                                <input type="text" name="cus_name" value="<?php echo $cus_name; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <input type="text" name="cus_email" value="<?php echo $cus_email; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Adresse</td>
                            <td>
                                <input type="text" name="cus_add1" value="<?php echo $cus_add1; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Téléphone</td>
                            <td>
                                <input type="text" name="cus_phone" value="<?php echo $cus_phone; ?>" id="ip2">
                            </td>
                        </tr>
                        <tr>
                            <td>Statut de la Commande</td>
                            <td>
                                <select name="order_status">
                                    <option <?php if($order_status=="Pending"){ echo "selected";} ?> value="Pending">En attente</option>
                                    <option <?php if($order_status=="Processing"){ echo "selected";} ?> value="Processing">En cours</option>
                                    <option <?php if($order_status=="Delivered"){ echo "selected";} ?> value="Delivered">Livré</option>
                                    <option <?php if($order_status=="Cancelled"){ echo "selected";} ?> value="Cancelled">Annulé</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                <input type="submit" name="submit" value="Mettre à Jour" class="button-8" role="button">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <?php 
    if(isset($_POST['submit']))
    {
        $order_id = $_POST['order_id'];
        $cus_name = $_POST['cus_name'];
        $cus_email = $_POST['cus_email'];
        $cus_add1 = $_POST['cus_add1'];
        $cus_phone = $_POST['cus_phone'];
        $order_status = $_POST['order_status'];

        $sql = "UPDATE order_manager SET
        order_id = '$order_id',
        cus_name = '$cus_name',
        cus_email = '$cus_email',
        cus_add1 = '$cus_add1',
        cus_phone = '$cus_phone',
        order_status = '$order_status' 
        WHERE order_id='$order_id'";

        $res = mysqli_query($conn, $sql);

        if($res == true){
            $_SESSION['update'] = "<div class='success'>Commande mise à jour avec succès</div>";
            header('location:'.SITEURL.'manage-online-order.php');
        }
        else{
            $_SESSION['update'] = "<div class='error'>Échec de la mise à jour de la commande</div>";
            header('location:'.SITEURL.'manage-online-order.php');
        }
    }
    ?>
</main>

	</section>
	<script src="script-admin.js"></script>
</body>
</html>