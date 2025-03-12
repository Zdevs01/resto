<?php include('config/constants.php'); ?> 

<?php 
 date_default_timezone_set('Asia/Dhaka');
 if(!isset($_SESSION['user'])) //Si la session utilisateur n'est pas définie
{
    // L'utilisateur n'est pas connecté
    // Redirection vers la page de connexion avec un message

    $_SESSION['no-login-message'] = "<div class='error'>🚫 Veuillez vous connecter pour accéder au panneau d'administration</div>";
    header('location:login.php');
}

    if(isset($_SESSION['user']))
    {
       $username = $_SESSION['user'];

       $fetch_user = "SELECT * FROM tbl_users WHERE username = '$username'";

       $res_fetch_user = mysqli_query($conn, $fetch_user);

       while($rows=mysqli_fetch_assoc($res_fetch_user))
       {
           $id = $rows['id'];
           $name = $rows['name'];
           $email = $rows['email'];
           $add1 = $rows['add1'];
           $city = $rows['city'];
           $phone = $rows['phone'];
           $username = $rows['username'];
           $password = $rows['password'];
       }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Robo Café - Catégories ☕</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" 
      type="image/png" 
      href="images/logo.png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <?php include('include/top2.php'); ?>

        <div class="container-xxl py-5 bg-dark hero-header mb-1" 
        style="background-image: url('images/bg.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 20vh; 
            position: relative;">
            <div class="container text-center my-2 pt-4 pb-1">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Modifier le profil ✏️</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="#">🏠 Accueil</a></li>
                        <li class="breadcrumb-item"><a href="myaccount.php">👤 Mon compte</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">📝 Modifier le profil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

        <!-- Navbar & Hero End -->
        <div class="container bootstrap snippets bootdey">
    <div class="row">
        <div class="profile-info col-md-9">
            <div class="panel">
                <div class="table-data">
                    <div class="order">
                        <div class="head">

                            <form action="" method="POST">
                                <table class="rtable">
                                    <tr>
                                        <td>Nom</td>
                                        <td>
                                            <input type="text" name="cus_name" value="<?php echo $name; ?>" id="ip2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Courriel</td>
                                        <td>
                                            <input type="text" name="cus_email" value="<?php echo $email; ?>" id="ip2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Adresse</td>
                                        <td>
                                            <textarea name="cus_add1" cols="30" rows="5"><?php echo $add1; ?></textarea id="ip2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ville</td>
                                        <td>
                                            <input type="text" name="cus_city" value="<?php echo $city; ?>" id="ip2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Téléphone</td>
                                        <td>
                                            <input type="text" name="cus_phone" value="<?php echo $phone; ?>" id="ip2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="username" value="<?php echo $username; ?>">
                                            <input type="submit" name="submit" value="Mettre à jour" class="btn btn-primary btn-lg">
                                        </td>
                                    </tr>
                                </table>
                            </form>

                            <?php
                            if(isset($_POST['submit']))
                            {
                                $username = $_POST['username'];
                                $cus_name = $_POST['cus_name'];
                                $cus_email = $_POST['cus_email'];
                                $cus_add1 = $_POST['cus_add1'];
                                $cus_city = $_POST['cus_city'];
                                $cus_phone = $_POST['cus_phone'];

                                $update_account = "UPDATE tbl_users SET
                                name = '$cus_name',
                                email = '$cus_email',
                                add1 = '$cus_add1',
                                city = '$cus_city',
                                phone = '$cus_phone'
                                WHERE username='$username'";

                                $res_update_account = mysqli_query($conn, $update_account);
                                if($res_update_account == true)
                                {
                                    $_SESSION['update'] = "<div class='success'>Compte mis à jour avec succès</div>";
                                    header('location:update-account.php');
                                }
                                else
                                {
                                    $_SESSION['update'] = "<div class='error'>Échec de la mise à jour du compte</div>";
                                    header('location:update-account.php');
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
