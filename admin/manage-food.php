<?php include('../config/constants.php');
	  //include('login-check.php');
	  error_reporting(0);
      @ini_set('display_errors', 0);

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


	<main>
    <div class="head-title">
        <div class="left">
            <h1>Menu Alimentaire</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Tableau de Bord</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="manage-admin.php">Menu Alimentaire</a>
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
        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['unauthorized']))
        {
            echo $_SESSION['unauthorized'];
            unset($_SESSION['unauthorized']);
        }
    ?>

    <br/>
    <a href="<?php echo SITEURL; ?>add-food.php" class="button-8" role="button">Ajouter un Plat</a>
    <br/><br/>

    <div class="table-data">
        <div class="order">
            <div class="head"></div>

            <table class="">
                <tr>
                    <th>N°</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>En Vedette</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>

                <?php 
                    $sql = "SELECT * FROM tbl_food";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    
                    $sn = 1;

                    if($count > 0)
                    {
                        while($row = mysqli_fetch_assoc($res))
                        {
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                ?>  
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $price; ?> €</td>
                                <td>
                                    <?php 
                                    if($image_name == "")
                                    {
                                        echo "<div class='error text-center'>Image Non Disponible</div>"; 
                                    }
                                    else
                                    {
                                    ?> 
                                        <img src="<?php echo SITEURL; ?>../images/food/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>update-food.php?id=<?php echo $id; ?>" class="button-5" role="button">Modifier</a>
                                    <a href="<?php echo SITEURL; ?>delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="button-7" role="button">Supprimer</a>
                                </td>
                            </tr>
                <?php
                        }
                    }
                    else
                    {
                        echo "<tr><td colspan='7' class='error text-center'>Le tableau des plats est vide</td></tr>";
                    }
                ?>
            </table>

        </div>
    </div>
</main>

	</section>
	<script src="script-admin.js"></script>
</body>
</html>