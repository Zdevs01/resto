
<?php 
include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Goodfood</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login-style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
    <style>
        body {
            background: url('images/restaurant-bg.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .brand-logo {
            width: 100px;
            height: 100px;
            background: url('images/logo.png') no-repeat center/cover;
            margin: 0 auto 20px;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 600;
            color: #D35400;
        }
        .inputs {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .inputs label {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .inputs input {
            padding: 10px;
            border: 2px solid #D35400;
            border-radius: 5px;
            outline: none;
        }
        .inputs input:focus {
            border-color: #E67E22;
        }
        .inputs button {
            background: #E67E22;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .inputs button:hover {
            background: #D35400;
        }
        .register-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .register-link a {
            color: #E67E22;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body   style="background-image: url('images/bg-hero.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 60vh; 
            position: relative;">
    <div class="container">
        <div class="brand-logo"></div>
        <div class="brand-title">Bienvenue chez Goodfood</div>
        <form action="" class="inputs" method="POST">
            <label><i class="fas fa-user"></i> Nom d'utilisateur</label>
            <input type="text" name="username" required>
            
            <label><i class="fas fa-lock"></i> Mot de passe</label>
            <input type="password" name="password" required>
            
            <button type="submit" name="submit">Se connecter</button>
        </form>
        <div class="register-link">
            Pas encore de compte ? <a href="register.php">Créez-en un ici</a>
        </div>
    </div>
</body>
</html>


<?php 
    if(isset($_POST['submit']))
    {

       // $username = $_POST['username'];
       // $password = md5($_POST['password']); //md5 encryption

       //Preventing From SQL Injection

       $username = mysqli_real_escape_string($conn, $_POST['username']);
       $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM tbl_users WHERE username='$username' AND password='$password'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if($count == 1)
        {
            //User found, login success
            $_SESSION['login']  = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = $username;
         
            header('location:index.php');
        }
        else
        {
          echo "<script>
                alert('Wrong Username or Password'); 
                window.location.href='login.php';
                </script>";
        
        }
      }

?>