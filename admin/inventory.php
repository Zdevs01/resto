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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style-admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Gestion du Stock - Restaurant</title>
</head>
<body class="bg-gray-100 font-sans">

    <!-- SIDEBAR -->
    <?php include('dashbord.php'); ?>
    <!-- SIDEBAR -->
	<!-- CONTENT -->

		
		
		
		<!-- NAVBAR -->
    <section id="content" class="p-6">
	<?php include('mess.php'); ?>
        <main>
            <div class="head-title flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Gestion des Stocks 📦</h1>
                    <ul class="breadcrumb flex items-center text-gray-600 text-sm">
                        <li><a href="index.php" class="hover:text-blue-500">Tableau de bord</a></li>
                        <li class="mx-2">/</li>
                        <li class="font-semibold text-blue-500">Inventaire</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="p-3 text-left">Nom du Produit</th>
                            <th class="p-3 text-center">Image</th>
                            <th class="p-3 text-center">Stock Disponible</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        $sql = "SELECT * FROM tbl_food";
                        $res = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($res) > 0)
                        {
                            while($row = mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $Item_Name = $row['title'];
                                $image_name = $row['image_name'];
                                $stock = $row['stock'];
                        ?>  
                        <tr class="border-b">
                            <td class="p-3">🍽️ <?php echo $Item_Name; ?></td>
                            <td class="p-3 text-center">
                                <?php if($image_name!="") { ?>
                                    <img src="<?php echo SITEURL; ?>../images/food/<?php echo $image_name; ?>" class="w-16 h-16 rounded-lg mx-auto">
                                <?php } else { ?>
                                    <span class="text-red-500">Image non disponible</span>
                                <?php } ?>
                            </td>
                            <td class="p-3 text-center">
                                <span class="px-3 py-1 rounded-lg text-white text-sm font-semibold <?php 
                                    echo ($stock < 50) ? 'bg-red-500 animate-pulse' : (($stock < 100) ? 'bg-yellow-500' : 'bg-green-500');
                                ?>">
                                    <?php echo $stock; ?> <?php echo ($stock < 50) ? '⚠️' : (($stock < 100) ? '🟡' : '✅'); ?>
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                <a href="<?php echo SITEURL; ?>update-inventory.php?id=<?php echo $id; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Modifier ✏️</a>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
    <script src="script-admin.js"></script>
</body>
</html>
