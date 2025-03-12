


<?php
include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <link rel="stylesheet" href="css/eipay.css">
    <link rel="icon" type="image/png" href="images/logo.png">
</head>
<body>

<?php 
date_default_timezone_set('Africa/Douala');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['purchase'])) {
        $order_date = date("Y-m-d H:i:s");
        $username = $_POST['cus_name'];
        $cus_name = $_POST['cus_name'];
        $cus_email = $_POST['cus_email'];
        $cus_add1 = $_POST['cus_add1'];
        $cus_city = $_POST['cus_city'];
        $cus_phone = $_POST['cus_phone'];
        $payment_mode = $_POST['pay_mode']; // Ajout du mode de paiement
        $amount = $_POST['amount'];
        
        // Insertion dans la table order_manager
        $query1 = "INSERT INTO `order_manager`(`username`, `cus_name`, `cus_email`, `cus_add1`, `cus_city`, `cus_phone`, `payment_mode`, `order_date`, `total_amount`, `order_status`) 
                   VALUES ('$username', '$cus_name', '$cus_email', '$cus_add1', '$cus_city', '$cus_phone', '$payment_mode', '$order_date', '$amount', 'Pending')";

        if (mysqli_query($conn, $query1)) {
            $Order_Id = mysqli_insert_id($conn); 
            $query2 = "INSERT INTO `online_orders_new`(`order_id`, `Item_Name`, `Price`, `Quantity`) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query2);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "isii", $Order_Id, $Item_Name, $Price, $Quantity);

                foreach ($_SESSION['cart'] as $values) {
                    $Item_Name = $values['Item_Name'];
                    $Price = $values['Price'];
                    $Quantity = $values['Quantity'];

                    mysqli_stmt_execute($stmt);

                    // Mise à jour du stock
                    $update_quantity_query = "UPDATE `tbl_food` SET stock = stock - $Quantity WHERE title = '$Item_Name'";
                    mysqli_query($conn, $update_quantity_query);
                }

                unset($_SESSION['cart']);

                echo "<script>
    alert('Commande enregistrée avec succès !');
    window.location.href='confirmation.php?order_id=$Order_Id'; 
    </script>";

            } else {
                echo "<script>
                    alert('Erreur lors de l\'enregistrement des articles.');
                    window.location.href='mycart.php';
                    </script>";
            }
        } else {
            echo "<script>
                alert('Erreur lors de l\'enregistrement de la commande.');
                window.location.href='mycart.php';
                </script>";
        }
    }
}
?>

</body>
</html>
