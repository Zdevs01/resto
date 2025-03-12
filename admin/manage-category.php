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
		<!-- NAVBAR -->
		<?php

		 if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['remove']))
        {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['no-category-found']))
        {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['failed-remove']))
        {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        
        
        ?>

		<!-- MAIN -->
		<main>
    <div class="head-title">
        <div class="left">
            <h1>Catégories</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-admin.php">Catégories</a>
                </li>
            </ul>
        </div>
    </div>

    <br/>

    <!-- Bouton Ajouter une catégorie -->
    <a href="<?php echo SITEURL; ?>add-category.php" class="button-8" role="button">Ajouter une catégorie</a>

    <br/><br/>

    <div class="table-data">
        <div class="order">
            <div class="head"></div>
            <table class="">
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Image</th>
                    <th>En vedette</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>

                <?php 
                // Récupération et affichage des catégories depuis la base de données
                $sql = "SELECT * FROM tbl_category";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $sn = 1; // Initialisation du compteur de numéro de série

                if($count > 0)
                {
                    // Affichage des données si disponibles
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>
                                <?php 
                                if($image_name != "")
                                {
                                    // Affichage de l’image si disponible
                                    ?>
                                    <img src="<?php echo SITEURL; ?>../images/category/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                }
                                else
                                {
                                    // Message si aucune image n'est disponible
                                    echo "<div class='error'>Aucune image disponible</div>";
                                }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>update-category.php?id=<?php echo $id; ?>" class="button-5" role="button">Modifier</a>
                                <a href="<?php echo SITEURL; ?>delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="button-7" role="button">Supprimer</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    // Message si aucune catégorie n'est ajoutée
                    ?>
                    <tr>
                        <td colspan="6"><div class="error">Aucune catégorie ajoutée</div></td>
                    </tr>
                    <?php
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