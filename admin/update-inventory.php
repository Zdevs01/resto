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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Stock - Restaurant</title>
    
    <!-- Icônes Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style-admin.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
    
    <style>
        /* Animations et styles pour une meilleure lisibilité */
        .stock-low {
            color: red;
            font-weight: bold;
            animation: blink 1s infinite;
        }
        @keyframes blink {
            50% { opacity: 0.5; }
        }
        .stock-medium {
            color: orange;
            font-weight: bold;
        }
        .stock-high {
            color: green;
            font-weight: bold;
        }
        .button-update {
            background-color: #ff5722;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        .button-update:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
    
    <?php include('dashbord.php'); ?>
    
    <section id="content">
        <?php include('mess.php'); ?>
        
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>🛒 Mise à jour du Stock</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">🏠 Accueil</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="inventory.php">🔄 Mise à jour du Stock</a></li>
                    </ul>
                </div>
            </div>
            
            <?php 
            $id=$_GET['id'];
            $sql="SELECT * FROM tbl_food WHERE id=$id";
            $res=mysqli_query($conn, $sql);
            
            if($res == true) {
                $count = mysqli_num_rows($res);
                
                if($count==1) {
                    $row=mysqli_fetch_assoc($res);
                    $Item_Name = $row['title'];
                    $stock = $row['stock'];
                } else {
                    header('location:'.SITEURL.'inventory.php');
                }
            }
            ?>
            
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <form action="" method="POST">
                            <table class="rtable">
                                <tr>
                                    <td>🍽️ Nom de l'article</td>
                                    <td><input type="text" name="Item_Name" value="<?php echo $Item_Name; ?>" id="ip2"></td>
                                </tr>
                                <tr>
                                    <td>📦 Stock disponible</td>
                                    <td>
                                        <input type="text" name="stock" value="<?php echo $stock; ?>" id="ip2" 
                                        class="<?php 
                                            echo ($stock < 50) ? 'stock-low' : (($stock < 100) ? 'stock-medium' : 'stock-high');
                                        ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="submit" name="submit" value="🔄 Mettre à jour" class="button-update">
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
if (isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $Item_Name = mysqli_real_escape_string($conn, $_POST['Item_Name']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // Vérification des valeurs reçues (décommente pour tester)
    // var_dump($_POST);

    // Requête SQL de mise à jour
    $sql = "UPDATE tbl_food SET title = '$Item_Name', stock = '$stock' WHERE id='$id'";

    // Exécution de la requête
    $res = mysqli_query($conn, $sql);

    // Vérification du résultat
    if ($res == true) {
        $_SESSION['update'] = "<div class='success'>✅ Stock mis à jour avec succès !</div>";
    } else {
        $_SESSION['update'] = "<div class='error'>❌ Échec de la mise à jour du stock.</div>";
    }

    // Redirection après la mise à jour
    header('location:'.SITEURL.'inventory.php');
    exit;
}
?>
