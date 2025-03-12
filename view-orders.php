<?php include('config/constants.php'); ?>

<?php 
// Définir le fuseau horaire
 date_default_timezone_set('Asia/Dhaka');
 
 // Vérifier si l'utilisateur est connecté
 if(!isset($_SESSION['user'])) // Si la session utilisateur n'est pas définie
{
    // L'utilisateur n'est pas connecté ❌
    // Redirection vers la page de connexion avec un message ⚠️

    $_SESSION['no-login-message'] = "<div class='error'>Veuillez vous connecter pour accéder au panneau d'administration ⚠️</div>";
    header('location:login.php');
}

// Si l'utilisateur est connecté ✅
if(isset($_SESSION['user']))
{
   $username = $_SESSION['user'];

   // Récupérer les informations de l'utilisateur 🔍
   $fetch_user = "SELECT * FROM tbl_users WHERE username = '$username'";

   $res_fetch_user = mysqli_query($conn, $fetch_user);

   while($rows=mysqli_fetch_assoc($res_fetch_user))
   {
       $id = $rows['id'];
       $name = $rows['name'];
       $email = $rows['email'];
       $adresse = $rows['add1'];
       $ville = $rows['city'];
       $telephone = $rows['phone'];
       $nom_utilisateur = $rows['username'];
       $mot_de_passe = $rows['password'];
   }
}
?>

<?php
// Mettre à jour le statut de paiement ✅💳
$payment_status_query = "UPDATE order_manager
       SET payment_status = 'successful'
       WHERE EXISTS (
       SELECT NULL
       FROM aamarpay
       WHERE aamarpay.transaction_id = order_manager.transaction_id )";

$payment_status_query_result=mysqli_query($conn,$payment_status_query);
?>

<!DOCTYPE html>
<html lang="fr"> <!-- Langue définie en français 🇫🇷 -->

<head>
    <meta charset="utf-8">
    <title>Robo Café ☕🤖</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/logo.png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icones et styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Chargement Spinner ⏳ -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
        <!-- Fin du Spinner -->

        <!-- Barre de navigation et en-tête -->
        <?php include('include/top2.php'); ?>

        <div class="container-xxl py-5 bg-dark hero-header mb-1" 
     style="background-image: url('images/bg.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 20vh; 
            position: relative;">
            <div class="container text-center my-2 pt-4 pb-1">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Commandes 🛒</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="myaccount.php">Mon compte</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Commandes</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Fin de la barre de navigation et de l'en-tête -->

    <div class="container bootstrap snippets bootdey">
<div class="row">
  <div class="profile-nav col-md-3">
      <div class="panel">
          <div class="user-heading round">
              <a href="myaccount.php">
                  <img src="images/avatar.png" alt="">
              </a>
              <h1><?php echo $name; ?></h1>
          </div>

          <ul class="nav nav-pills nav-stacked">
                 <li><a href="update-account.php"> <i class="fa fa-edit"></i> ✏️ Modifier le profil</a></li>
              <li><a href="view-orders.php"> <i class="fa fa-edit"></i> 📦 Voir les commandes</a></li>
              <li><a href="update-password.php"> <i class="fa fa-edit"></i> 🔑 Changer le mot de passe</a></li>
          </ul>
      </div>
  </div>
  <div class="profile-info col-md-9">
      <div class="panel">
<div class="table-data">
  <div class="order">
    <div class="head">
    </div>
    <table class="">
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>Mode de Paiement</th>
                <th>Statut de la Commande</th>
                <th>Total</th>
                <th>Détails</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $query="SELECT * FROM `order_manager` WHERE username='$username' ORDER BY order_id DESC";
        $user_result=mysqli_query($conn,$query);
        while($user_fetch=mysqli_fetch_assoc($user_result))
        {
            $order_id = $user_fetch['order_id'];
            $payment_mode = $user_fetch['payment_mode'];
            $order_status = $user_fetch['order_status'];
            $total_amount = $user_fetch['total_amount'];
            ?>
            <tr>
                <td><?php echo $order_id; ?></td>
                <td><?php echo $payment_mode; ?> </td>
                <td>
                    <?php 
                    if($order_status=="Pending")
                    {
                        echo "<span class='status process'>🕒 $order_status</span>";
                    }
                    else if($order_status=="Processing")
                    {
                        echo "<span class='status pending'>⏳ $order_status</span>";
                    }
                    else if($order_status=="Delivered")
                    {
                        echo "<span class='status completed'>✅ $order_status</span>";
                    }
                    else if($order_status=="Cancelled")
                    {
                        echo "<span class='status cancelled'>❌ $order_status</span>";
                    }
                    ?>
                </td>
                <td><?php echo $total_amount; ?> €</td>
                <td>
                    <table class=''>
                    <thead>
                        <tr>
                            <th>Nom de l'Article</th>
                            <th>Prix €</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $order_query="SELECT * FROM `online_orders_new` WHERE `order_id`='$user_fetch[order_id]' ORDER BY order_id DESC ";
                    $order_result = mysqli_query($conn,$order_query);
                    while($order_fetch=mysqli_fetch_assoc($order_result))
                    {
                        echo"<tr>
                            <td>$order_fetch[Item_Name]</td>
                            <td>$order_fetch[Price] €</td>
                            <td>$order_fetch[Quantity]</td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                    </table>

                    


                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
  </div>
</div>
      </div>
  </div>
</div>
</div>

<!-- Catégories Start -->
<div class="container">
    <div class="row">
    </div>
</div>


 
        <!-- Categories End  -->
        

        <!-- Footer Start -->
        <?php include('include/foot.php'); ?>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
