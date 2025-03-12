<?php include('../config/constants.php');
	  //include('login-check.php');
	  error_reporting(0);
      @ini_set('display_errors', 0);

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


		<main>
    <div class="head-title">
        <div class="left">
            <h1>Ajouter un Plat</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-admin.php">Ajouter un Plat</a>
                </li>
            </ul>
        </div>
    </div>
    <br>

    <?php 
        if(isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
    ?>

    <div class="table-data">
        <div class="order">
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="rtable">
                    <tr>
                        <td>Nom du Plat</td>
                        <td>
                            <input type="text" name="title" id="ip2">
                        </td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td>
                            <textarea name="description" cols="24" rows="5"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Prix</td>
                        <td>
                            <input type="number" name="price" id="ip2">
                        </td>
                    </tr>

                    <tr>
                        <td>Sélectionner une Image</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Catégorie</td>
                        <td>
                            <select name="category">
                                <?php 
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);

                                    if($count > 0) {
                                        while($row = mysqli_fetch_assoc($res)) {
                                            $id = $row['id'];
                                            $title = $row['title'];
                                ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                                        }
                                    } else {
                                ?>
                                    <option value="0">Aucune catégorie trouvée</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Mis en Avant</td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Oui 
                            <input type="radio" name="featured" value="No"> Non
                        </td>
                    </tr>

                    <tr>
                        <td>Stock</td>
                        <td>
                            <input type="number" name="stock" id="ip2">
                        </td>
                    </tr>

                    <tr>
                        <td>Actif</td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Oui 
                            <input type="radio" name="active" value="No"> Non
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Ajouter le Plat" class="button-8" role="button">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</main>

		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script-admin.js"></script>
</body>
</html>