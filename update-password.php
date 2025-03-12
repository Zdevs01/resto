<?php include('config/constants.php'); ?> 

<?php 
date_default_timezone_set('Africa/Douala'); // Définir le fuseau horaire

if(!isset($_SESSION['user'])) // Si la session utilisateur n'est pas définie
{
    // L'utilisateur n'est pas connecté
    // Rediriger vers la page de connexion avec un message

    $_SESSION['no-login-message'] = "<div class='error'>🚫 Veuillez vous connecter pour accéder au panneau d'administration.</div>";
    header('location:'.SITEURL.'login.php');
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
    <title>Robo Café - Catégories</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/logo.png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Feuilles de style pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Feuilles de style des bibliothèques -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Feuille de style Bootstrap personnalisée -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Feuille de style du template -->
    <link href="css/style.css" rel="stylesheet">
    
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Début du Spinner -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
        <!-- Fin du Spinner -->

        <!-- Début de la barre de navigation & Hero -->
        <?php include('include/top2.php'); ?>

        <div class="container-xxl py-5 bg-dark hero-header mb-1" 
             style="background-image: url('images/bg.jpg'); 
                    background-size: cover; 
                    background-position: center; 
                    background-repeat: no-repeat; 
                    min-height: 20vh; 
                    position: relative;">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Mon Compte</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="myaccount.php">Mon Compte</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Mon Compte</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Fin de la barre de navigation & Hero -->


        <div class="container bootstrap snippets bootdey">
  <div class="row">

            <div class="table-data">
			<div class="order">
			<div class="head">

            <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>🔑 Mot de passe actuel</td>
                    <td>
                        <input type="password" name="current_password" id="ip2">
                    </td>
                </tr>

                <tr>
                    <td>🔒 Nouveau mot de passe</td>
                    <td>
                        <input type="password" name="new_password" id="ip2">
                    </td>

                </tr>

                <tr>
                    <td>✅ Confirmer le mot de passe</td>
                    <td>
                        <input type="password" name="confirm_password" id="ip2">
                    </td>

                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="submit" name="submit" value="🔄 Changer le mot de passe" class="button-8" role="button">
                    </td>
                </tr>

            </table>

        </form>

        </div>
        </div>
        </div>

        <?php 
// Vérifier si le bouton a été cliqué
if(isset($_POST['submit'])){

   $username = $_POST['username'];
   $current_password = md5($_POST['current_password']);
   $new_password = md5($_POST['new_password']);
   $confirm_password = md5($_POST['confirm_password']);

        $update_password = "SELECT * FROM tbl_users WHERE username='$username' AND password='$current_password'";

        $res_update_password = mysqli_query($conn, $update_password);

        if($res_update_password == true)
        {
            $count = mysqli_num_rows($res_update_password);

            if($count==1)
            {

                if($new_password==$confirm_password){

                    $sql2_update_password = "UPDATE tbl_users SET
                        password = '$new_password'
                        WHERE username='$username'
                    ";

                    $res2_update_password = mysqli_query($conn, $sql2_update_password);
                    if($res2_update_password==true)
                    {
                         $_SESSION['change-pwd'] = "<div class='success'>✅ Mot de passe changé avec succès.</div>";
                         header('location:'.SITEURL.'myaccount.php');
                    }
                    else
                    {
                        $_SESSION['pwd-not-match'] = "<div class='error'>❌ Échec du changement de mot de passe. Veuillez réessayer.</div>";

                        header('location:'.SITEURL.'myaccount.php');
                    }
                }
                else
                {
                    $_SESSION['pwd-not-match'] = "<div class='error'>⚠️ Les mots de passe ne correspondent pas. Veuillez réessayer.</div>";

                    header('location:'.SITEURL.'myaccount.php');

                }
            }
            else
            {
                $_SESSION['user-not-found'] = "<div class='error'>🚫 Utilisateur non trouvé.</div>";
                header('location:'.SITEURL.'admin/myaccount.php');
            }
        }

}

?>

<!-- Catégories Début -->
<div class="container">
    <div class="row">
    </div>
</div>
<!-- Catégories Fin  -->

<!-- Pied de page Début -->
<?php include('include/foot.php'); ?>
<!-- Pied de page Fin -->

<!-- Retour en haut -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


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
