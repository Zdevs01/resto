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
            <h1>Ajouter une catégorie</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="manage-category.php">Gérer les catégories</a>
                </li>
                <li>
                    <a class="active" href="add-category.php">Ajouter une catégorie</a>
                </li>
            </ul>
        </div>
    </div>

    <?php
    if(isset($_SESSION['add']))
    {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    if(isset($_SESSION['upload']))
    {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }
    ?>
    <br/>

    <!-- Début du formulaire d'ajout de catégorie -->
    <div class="table-data">
        <div class="order">
            <div class="head">

                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="rtable">
                        <tr>
                            <td>Nom</td>
                            <td>
                                <input type="text" name="title" id="ip2" required>
                            </td>
                        </tr>

                        <tr>
                            <td>Choisir une image</td>
                            <td>
                                <input type="file" name="image" required>
                            </td>
                        </tr>

                        <tr>
                            <td>En vedette</td>
                            <td>
                                <input type="radio" name="featured" value="Yes" required> Oui
                                <input type="radio" name="featured" value="No" required> Non
                            </td>
                        </tr>
                        <tr>
                            <td>Actif</td>
                            <td>
                                <input type="radio" name="active" value="Yes" required> Oui
                                <input type="radio" name="active" value="No" required> Non
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Ajouter la catégorie" class="button-8" role="button">  
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <!-- Enregistrement dans la base de données -->
    <?php 
    // Vérifier si le bouton "submit" a été cliqué
    if(isset($_POST['submit']))
    {
        // Récupération des valeurs du formulaire
        $title = $_POST['title'];

        // Vérification des boutons radio
        $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
        $active = isset($_POST['active']) ? $_POST['active'] : "No";

        // Vérification de l'image
        if(isset($_FILES['image']['name']))
        {
            $image_name = $_FILES['image']['name'];

            if($image_name != "")
            {
                // Renommer l'image pour éviter les doublons
                $ext = @end(explode('.', $image_name));
                $image_name = "Categorie_".rand(000, 99999).'.'.$ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/".$image_name;

                // Téléchargement de l'image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Vérification si l'image a été uploadée avec succès
                if($upload == false)
                {
                    $_SESSION['upload'] = "<div class='error text-center'>Échec du téléchargement de l'image</div>";
                    header('location:'.SITEURL.'add-category.php');
                    die();
                }
            }
        }
        else
        {
            $image_name = "";
        }

        // Requête SQL pour insérer la catégorie dans la base de données
        $sql = "INSERT INTO tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'";

        // Exécution de la requête
        $res = mysqli_query($conn, $sql);

        // Vérification de l'exécution de la requête
        if($res == true)
        {
            $_SESSION['add'] = "<div class='success text-center'>Catégorie ajoutée avec succès</div>";
            header('location:'.SITEURL.'manage-category.php');
        }
        else
        {
            $_SESSION['add'] = "<div class='error text-center'>Échec de l'ajout de la catégorie</div>";
            header('location:'.SITEURL.'add-category.php');
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