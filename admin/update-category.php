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
            <h1>Mettre à Jour la Catégorie</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de Bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="manage-category.php">Gérer les Catégories</a>
                </li>
                <li>
                    <a class="active" href="update-category.php">Mettre à Jour la Catégorie</a>
                </li>
            </ul>
        </div>
    </div>
    <br/>

    <?php 
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_category WHERE id=$id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if($count == 1)
            {
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                $_SESSION['no-category-found'] = "<div class='error'>Catégorie non trouvée.</div>";
                header('location:'.SITEURL.'manage-category.php');
            }
        }
        else
        {
            header('location:'.SITEURL.'manage-category.php');
        }
    ?>
    <div class="table-data">
        <div class="order">
            <div class="head">

                <form action="" method="POST" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Titre : </td>
                            <td>
                                <input type="text" name="title" value="<?php echo $title; ?>" required>
                            </td>
                        </tr>

                        <tr>
                            <td>Image Actuelle : </td>
                            <td>
                                <?php 
                                    if($current_image != "")
                                    {
                                        echo "<img src='".SITEURL."../images/category/".$current_image."' width='150px'>";
                                    }
                                    else
                                    {
                                        echo "<div class='error'>Image non ajoutée.</div>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Nouvelle Image : </td>
                            <td>
                                <input type="file" name="image" required>
                            </td>
                        </tr>

                        <tr>
                            <td>Mis en Avant : </td>
                            <td>
                                <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes" required> Oui 
                                <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No" required> Non 
                            </td>
                        </tr>

                        <tr>
                            <td>Actif : </td>
                            <td>
                                <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes" required> Oui 
                                <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No" required> Non 
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Mettre à Jour" class="button-8" role="button">
                            </td>
                        </tr>
                    </table>
                </form>

                <?php 
                    if(isset($_POST['submit']))
                    {
                        $id = $_POST['id'];
                        $title = $_POST['title'];
                        $current_image = $_POST['current_image'];
                        $featured = $_POST['featured'];
                        $active = $_POST['active'];

                        if(isset($_FILES['image']['name']))
                        {
                            $image_name = $_FILES['image']['name'];
                            if($image_name != "")
                            {
                                $ext = end(explode('.', $image_name));
                                $image_name = "Food_Category_".rand(000, 999).'.'.$ext;
                                $source_path = $_FILES['image']['tmp_name'];
                                $destination_path = "../images/category/".$image_name;
                                $upload = move_uploaded_file($source_path, $destination_path);
                                if($upload==false)
                                {
                                    $_SESSION['upload'] = "<div class='error'>Échec du téléchargement de l'image.</div>";
                                    header('location:'.SITEURL.'manage-category.php');
                                    die();
                                }
                                if($current_image!="")
                                {
                                    $remove_path = "../images/category/".$current_image;
                                    $remove = unlink($remove_path);
                                    if($remove==false)
                                    {
                                        $_SESSION['failed-remove'] = "<div class='error'>Échec de la suppression de l'image actuelle.</div>";
                                        header('location:'.SITEURL.'manage-category.php');
                                        die();
                                    }
                                }
                            }
                            else
                            {
                                $image_name = $current_image;
                            }
                        }
                        else
                        {
                            $image_name = $current_image;
                        }

                        $sql2 = "UPDATE tbl_category SET title = '$title', image_name = '$image_name', featured = '$featured', active = '$active' WHERE id=$id";
                        $res2 = mysqli_query($conn, $sql2);

                        if($res2==true)
                        {
                            $_SESSION['update'] = "<div class='success'>Catégorie mise à jour avec succès.</div>";
                            header('location:'.SITEURL.'manage-category.php');
                        }
                        else
                        {
                            $_SESSION['update'] = "<div class='error'>Échec de la mise à jour de la catégorie.</div>";
                            header('location:'.SITEURL.'manage-category.php');
                        }
                    }
                ?>
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