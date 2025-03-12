<?php include('../config/constants.php');
	  //include('login-check.php');

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
            <h1>Changer le Mot de Passe</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-admin.php">Gérer les Administrateurs</a>
                </li>
                <li>
                    <a class="active" href="manage-admin.php">Changer le Mot de Passe</a>
                </li>
            </ul>
        </div>
    </div>

    <?php 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    ?>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td>Mot de passe actuel</td>
                            <td>
                                <input type="password" name="current_password" id="ip2">
                            </td>
                        </tr>

                        <tr>
                            <td>Nouveau mot de passe</td>
                            <td>
                                <input type="password" name="new_password" id="ip2">
                            </td>
                        </tr>

                        <tr>
                            <td>Confirmer le mot de passe</td>
                            <td>
                                <input type="password" name="confirm_password" id="ip2">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <input type="submit" name="submit" value="Changer le mot de passe" class="button-8" role="button">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <?php 
    // Vérifier si le bouton de soumission est cliqué
    if (isset($_POST['submit'])) {
        // Récupérer les données du formulaire
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // Vérifier si l'utilisateur avec l'ID et le mot de passe actuel existe
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                // Vérifier si le nouveau mot de passe et la confirmation correspondent
                if ($new_password == $confirm_password) {
                    // Mise à jour du mot de passe
                    $sql2 = "UPDATE tbl_admin SET password = '$new_password' WHERE id=$id";
                    $res2 = mysqli_query($conn, $sql2);

                    if ($res2 == true) {
                        $_SESSION['change-pwd'] = "<div class='success'>Mot de passe modifié avec succès.</div>";
                        header('location:' . SITEURL . 'manage-admin.php');
                    } else {
                        $_SESSION['pwd-not-match'] = "<div class='error'>Échec du changement de mot de passe. Veuillez réessayer.</div>";
                        header('location:' . SITEURL . 'manage-admin.php');
                    }
                } else {
                    $_SESSION['pwd-not-match'] = "<div class='error'>Les mots de passe ne correspondent pas. Veuillez réessayer.</div>";
                    header('location:' . SITEURL . 'manage-admin.php');
                }
            } else {
                $_SESSION['user-not-found'] = "<div class='error'>Utilisateur non trouvé.</div>";
                header('location:' . SITEURL . 'manage-admin.php');
            }
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