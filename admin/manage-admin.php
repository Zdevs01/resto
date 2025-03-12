<?php include('../config/constants.php'); ?>
<?php
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
    <title>GoodFood Admin</title>
</head>
<body>
    <?php include('dashbord.php'); ?>
    <section id="content">
        <?php include('mess.php'); ?>
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Panneau d'Administration</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Tableau de bord</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="manage-admin.php">Panneau d'Administration</a></li>
                    </ul>
                </div>
            </div>
            <br>
            <a href="add-admin.php" class="button-8" role="button">Ajouter un Administrateur</a>
            <div class="table-data">
                <div class="order">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom Complet</th>
                                <th>Nom d'utilisateur</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_admin";
                        $res = mysqli_query($conn, $sql);
                        if ($res == TRUE) {
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($rows = mysqli_fetch_assoc($res)) {
                                    $id = $rows['id'];
                                    $full_name = $rows['full_name'];
                                    $username = $rows['username'];
                                    $role = $rows['role'];
                                    ?>
                                    <tr>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo ucfirst($role); ?></td>
                                        <td>
                                            <a href="update-password.php?id=<?php echo $id; ?>" class="button-5">Changer le Mot de Passe</a>
                                            <a href="update-admin.php?id=<?php echo $id; ?>" class="button-6">Modifier</a>
                                            <a href="delete-admin.php?id=<?php echo $id; ?>" class="button-7">Supprimer</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <script src="script-admin.js"></script>
</body>
</html>
