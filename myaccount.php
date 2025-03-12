<?php include('config/constants.php'); ?>

<?php 
// Définir le fuseau horaire
 date_default_timezone_set('Asia/Dhaka');
 
 // Vérifier si l'utilisateur est connecté
 if(!isset($_SESSION['user'])) {
    // L'utilisateur n'est pas connecté ❌
    // Rediriger vers la page de connexion avec un message
    $_SESSION['no-login-message'] = "<div class='error'>Veuillez vous connecter pour accéder au panneau d'administration ⚠️</div>";
    header('location:'.SITEURL.'login.php');
}

// Récupérer les informations de l'utilisateur connecté
if(isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $fetch_user = "SELECT * FROM tbl_users WHERE username = '$username'";
    $res_fetch_user = mysqli_query($conn, $fetch_user);

    while($rows = mysqli_fetch_assoc($res_fetch_user)) {
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
    <title>Robo Café</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Icône du site -->
    <link rel="icon" type="image/png" href="images/logo.png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Feuilles de style -->
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
        <!-- Chargement en cours ⏳ -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
        
        <!-- Barre de navigation et bannière -->
        <?php include('include/top2.php'); ?>

        <div class="container-xxl py-5 bg-dark hero-header mb-1" style="background-image: url('images/bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 20vh; position: relative;">
            <div class="container text-center my-2 pt-4 pb-1">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Mon Compte 🏠</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="Mon Compte"><a href="myaccount.php">Mon Compte</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="container bootstrap snippets bootdey">
            <div class="row">
                <div class="profile-nav col-md-3">
                    <div class="panel">
                        <div class="user-heading round">
                            <a href="myaccount.php">
                                <img src="images/avatar.png" alt="Avatar">
                            </a>
                            <h1><?php echo $name; ?></h1>
                        </div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="update-account.php"> <i class="fa fa-edit"></i> Modifier le profil ✏️</a></li>
                            <li><a href="view-orders.php"> <i class="fa-solid fa-square-list"></i> Voir mes commandes 🛒</a></li>
                            <li><a href="update-password.php"> <i class="fa fa-key"></i> Changer le mot de passe 🔑</a></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-info col-md-9">
                    <div class="panel">
                        <div class="panel-body bio-graph-info">
                            <h1>Informations personnelles 👤</h1>
                            <div class="row">
                                <div class="bio-row">
                                    <p><span>Nom :</span> <?php echo $name; ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Email :</span> <?php echo $email; ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Adresse :</span> <?php echo $add1; ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Ville :</span> <?php echo $city; ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Téléphone :</span> <?php echo $phone; ?></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Nom d'utilisateur :</span> <?php echo $username; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pied de page -->
        <?php include('include/foot.php'); ?>

        <!-- Retour en haut ⬆️ -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- Scripts JavaScript -->
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
    <script src="js/main.js"></script>
</body>
</html>
