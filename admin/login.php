<?php 
session_start();
include('../config/constants.php'); 

if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si l'utilisateur est déjà connecté
if(isset($_SESSION['user-role'])) {
    header('location: index.php');
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
    <title>Connexion Admin</title>
    <style>
        /* 🔥 Fond d'écran restaurant stylé */
        body {
            background-image: url('../images/bg-hero.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        /* 🎭 Style du conteneur */
        .container {
            width: 400px;
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(255, 165, 0, 0.5);
            text-align: center;
        }

        /* ✨ Effet neon sur le titre */
        .brand-title {
            font-size: 24px;
            font-weight: 600;
            color: #FFA500;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-shadow: 0px 0px 10px #ffbf47;
        }

        /* 🌟 Champs de saisie */
        .inputs label {
            color: #FFF;
            font-size: 14px;
            display: block;
            text-align: left;
            margin-top: 10px;
        }

        .inputs input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #FFA500;
            background: #222;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        .inputs input:focus {
            border: 1px solid #ffbf47;
            box-shadow: 0px 0px 10px rgba(255, 165, 0, 0.5);
        }

        /* 🔘 Bouton stylé */
        .inputs button {
            background: #FFA500;
            color: black;
            font-size: 16px;
            font-weight: 600;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .inputs button:hover {
            background: #ffbf47;
            box-shadow: 0px 0px 10px rgba(255, 165, 0, 0.7);
        }

        /* 🚀 Style des notifications */
        .message-box {
            width: 90%;
            padding: 10px;
            margin: 0 auto 15px auto;
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .success {
            background-color: #28a745;
            color: white;
            border-left: 5px solid #218838;
        }

        .error {
            background-color: #dc3545;
            color: white;
            border-left: 5px solid #c82333;
        }

        /* Icônes */
        .message-box i {
            font-size: 20px;
        }

        /* 🌊 Effet animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>
<body>

<div class="container">
    <div class="brand-title">Panneau Admin</div>

    <!-- 🔔 Affichage des notifications -->
    <?php 
        if(isset($_SESSION['login'])) {
            echo "<div class='message-box " . (strpos($_SESSION['login'], 'success') !== false ? 'success' : 'error') . "'>
                    <i class='fas " . (strpos($_SESSION['login'], 'success') !== false ? 'fa-check-circle' : 'fa-exclamation-circle') . "'></i> 
                    ".$_SESSION['login']."
                  </div>";
            unset($_SESSION['login']);
        }
    ?>

    <!-- 🔐 Formulaire de connexion -->
    <form action="" class="inputs" method="POST">
        <label><i class="fas fa-user"></i> Nom d'utilisateur</label>
        <input type="text" name="username" required placeholder="Entrez votre nom d'utilisateur">
        
        <label><i class="fas fa-lock"></i> Mot de passe</label>
        <input type="password" name="password" required placeholder="Entrez votre mot de passe">
        
        <button type="submit" name="submit">Se connecter</button>
    </form>
</div>

</body>
</html>

<?php 


if(isset($_POST['submit'])) {
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        $res = mysqli_query($conn, $sql);

        if (!$res) {
            die("Erreur SQL : " . mysqli_error($conn));
        }

        if(mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            
            $_SESSION['login'] = "✅ Connexion réussie ! Bienvenue 👋";
            $_SESSION['user-admin'] = $username;
            $_SESSION['user-role'] = $row['role']; // Stocker le rôle

            // Redirection en fonction du rôle
            if ($row['role'] == 'Administrateur') {
                header('location: index.php');
            } elseif ($row['role'] == 'Serveur') {
                header('location: Cuisine.php');
            } else {
                header('location: index.php'); // Redirection par défaut
            }
            exit();
        } else {
            $_SESSION['login'] = "❌ Mauvais identifiants ! Veuillez réessayer.";
            header('location: login.php');
            exit();
        }
    } else {
        echo "<script>alert('Veuillez remplir tous les champs !');</script>";
    }
}
?>
