<?php include('../config/constants.php');

// Récupération des notifications
$ei_order_notif = "SELECT order_status FROM tbl_eipay WHERE order_status IN ('Pending', 'Processing')";
$res_ei_order_notif = mysqli_query($conn, $ei_order_notif);
$row_ei_order_notif = mysqli_num_rows($res_ei_order_notif);

$online_order_notif = "SELECT order_status FROM order_manager WHERE order_status IN ('Pending', 'Processing')";
$res_online_order_notif = mysqli_query($conn, $online_order_notif);
$row_online_order_notif = mysqli_num_rows($res_online_order_notif);

$stock_notif = "SELECT stock FROM tbl_food WHERE stock < 50";
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
	<title>GoodFood - Admin</title>
</head>
<body>

<?php include('dashbord.php'); ?>
<section id="content">
	<?php include('mess.php'); ?>
	<main>
		<div class="head-title">
			<div class="left">
				<h1>Ajouter un Administrateur</h1>
				<ul class="breadcrumb">
					<li><a href="index.php">Tableau de bord</a></li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li><a href="manage-admin.php">Gestion des Administrateurs</a></li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li><a class="active" href="add-admin.php">Ajouter un Administrateur</a></li>
				</ul>
				<?php
				if(isset($_SESSION['add'])) { 
					echo $_SESSION['add']; 
					unset($_SESSION['add']);
				}
				?>
			</div>    
		</div>

		<br>

		<div class="table-data">
			<div class="order">
				<div class="head">
					<form action="" method="POST">
						<table class="rtable-center">
							<tr>
								<td>Nom complet</td>
								<td><input type="text" name="full_name" required></td>
							</tr>
							<tr>
								<td>Nom d'utilisateur</td>
								<td><input type="text" name="username" required></td>
							</tr>
							<tr>
								<td>Mot de passe</td>
								<td><input type="password" name="password" required></td>
							</tr>
							<tr>
								<td>Rôle</td>
								<td>
									<select name="role" required>
										<option value="Administrateur">Administrateur</option>
										<option value="Serveurs">Serveurs</option>
										<option value="Cuisiniers">Cuisiniers</option>
										<option value="Caissier">Caissier</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="submit" name="submit" value="Ajouter un administrateur" class="button-8">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>    
	</main>
</section>

<script src="script-admin.js"></script>
</body>
</html>

<?php 
if(isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Chiffrement du mot de passe en MD5
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Vérification du rôle valide
    $valid_roles = ['Administrateur', 'Serveurs', 'Cuisiniers', 'Caissier'];
    if (!in_array($role, $valid_roles)) {
        echo "<script>alert('Rôle invalide.'); window.location.href='add-admin.php';</script>";
        exit();
    }

    // Vérifier si le nom d'utilisateur existe déjà
    $check_duplicate = "SELECT username FROM tbl_admin WHERE username = '$username'";
    $res_check_duplicate = mysqli_query($conn, $check_duplicate);

    if(mysqli_num_rows($res_check_duplicate) > 0) {
        echo "<script>alert('Ce nom d\'utilisateur existe déjà ! Veuillez en choisir un autre.'); window.location.href='add-admin.php';</script>";
    } else {
        $sql = "INSERT INTO tbl_admin (full_name, username, password, role) VALUES ('$full_name', '$username', '$password', '$role')";
        $res = mysqli_query($conn, $sql);

        if($res == true) {
            $_SESSION['add'] = "<div class='success'>Administrateur ajouté avec succès.</div>";
            header("location:".SITEURL.'manage-admin.php');
        } else {
            $_SESSION['add'] = "<div class='error'>Échec de l'ajout de l'administrateur.</div>";
            header("location:".SITEURL.'add-admin.php');
        }
    }
}
?>
