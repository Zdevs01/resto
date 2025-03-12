<?php include('../config/constants.php'); ?>
<?php
$ei_order_notif = "SELECT order_status FROM tbl_eipay WHERE order_status='Pending' OR order_status='Processing'";
$res_ei_order_notif = mysqli_query($conn, $ei_order_notif);
$row_ei_order_notif = mysqli_num_rows($res_ei_order_notif);

$online_order_notif = "SELECT order_status FROM order_manager WHERE order_status='Pending' OR order_status='Processing'";
$res_online_order_notif = mysqli_query($conn, $online_order_notif);
$row_online_order_notif = mysqli_num_rows($res_online_order_notif);

$stock_notif = "SELECT stock FROM tbl_food WHERE stock<50";
$res_stock_notif = mysqli_query($conn, $stock_notif);
$row_stock_notif = mysqli_num_rows($res_stock_notif);

$message_notif = "SELECT message_status FROM message WHERE message_status = 'unread'";
$res_message_notif = mysqli_query($conn, $message_notif);
$row_message_notif = mysqli_num_rows($res_message_notif);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style-admin.css">
	<link rel="icon" type="image/png" href="../images/logo.png">
	<title>GoodFood Admin</title>
</head>
<body>
	<?php include('dashbord.php'); ?>
	<section id="content">
		<?php include('mess.php'); ?>
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Modifier un Administrateur</h1>
					<ul class="breadcrumb">
						<li><a href="index.php">Tableau de bord</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="manage-admin.php">Modifier un Administrateur</a></li>
					</ul>
				</div>
			</div>

			<?php 
			$id = $_GET['id'];
			$sql = "SELECT * FROM tbl_admin WHERE id=$id";
			$res = mysqli_query($conn, $sql);
			if ($res && mysqli_num_rows($res) == 1) {
				$row = mysqli_fetch_assoc($res);
				$full_name = $row['full_name'];
				$username = $row['username'];
				$role = $row['role'];
			} else {
				header('location:' . SITEURL . 'manage-admin.php');
			}
			?>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<form action="" method="POST">
							<table class="rtable">
								<tr>
									<td>Nom Complet</td>
									<td><input type="text" name="full_name" value="<?php echo $full_name; ?>" id="ip2"></td>
								</tr>
								<tr>
									<td>Nom d'utilisateur</td>
									<td><input type="text" name="username" value="<?php echo $username; ?>" id="ip2"></td>
								</tr>
								<tr>
									<td>Rôle</td>
									<td>
										<select name="role" id="ip2">
											<option value="Administrateur" <?php if($role == 'Administrateur') echo 'selected'; ?>>Administrateur</option>
											<option value="Serveurs" <?php if($role == 'Serveurs') echo 'selected'; ?>>Serveurs</option>
                                            option value="Cuisiniers" <?php if($role == 'Cuisiniers') echo 'selected'; ?>>Cuisiniers</option>
                                            <option value="Caissier" <?php if($role == 'Caissier') echo 'selected'; ?>>Caissier</option>
										</select>
									</td>

                                   
								</tr>
								<tr>
									<td colspan="2">
										<input type="hidden" name="id" value="<?php echo $id; ?>">
										<input type="submit" name="submit" value="Mettre à Jour" class="button-8" role="button">
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>

			<?php 
			if (isset($_POST['submit'])) {
				$id = $_POST['id'];
				$full_name = $_POST['full_name'];
				$username = $_POST['username'];
				$role = $_POST['role'];

				$sql = "UPDATE tbl_admin SET full_name = '$full_name', username = '$username', role = '$role' WHERE id='$id'";
				$res = mysqli_query($conn, $sql);

				if ($res) {
					$_SESSION['update'] = "<div class='success'>Administrateur mis à jour avec succès</div>";
				} else {
					$_SESSION['update'] = "<div class='error'>Échec de la mise à jour de l'administrateur</div>";
				}
				header('location:' . SITEURL . 'manage-admin.php');
			}
			?>
		</main>
	</section>
	<script src="script-admin.js"></script>
</body>
</html>
