<?php 
	session_start();
	$pageTitle = 'Admin Login';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
		header('Location: dashboard.php');
	}
?>

<?php include 'connect.php'; ?>
<?php include 'Includes/functions/functions.php'; ?>
<?php include 'Includes/templates/header.php'; ?>

<!-- STYLES CSS -->
<style>
    /* Arrière-plan animé */
    body {
        background: linear-gradient(45deg, #ff6600, #ffcc00);
        background-size: 400% 400%;
        animation: gradientBG 10s ease infinite;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .login-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }

    .form-input {
        position: relative;
        margin-bottom: 20px;
    }

    .form-input input {
        width: 100%;
        padding: 12px 40px;
        border-radius: 10px;
        border: 2px solid #ddd;
        outline: none;
        transition: all 0.3s ease-in-out;
    }

    .form-input input:focus {
        border-color: #ff6600;
        box-shadow: 0 0 8px rgba(255, 102, 0, 0.5);
    }

    .form-input i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
    }

    .login-btn {
        background: #ff6600;
        color: white;
        font-weight: 700;
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-btn:hover {
        background: #e65c00;
        box-shadow: 0 5px 15px rgba(255, 102, 0, 0.3);
    }

    .forgotPW {
        display: block;
        margin-top: 10px;
        color: #555;
        text-decoration: none;
    }

    .forgotPW:hover {
        color: #ff6600;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<!-- FORMULAIRE DE CONNEXION -->
<div class="login-container">
    <span class="login-title">
        <i class="fas fa-user-lock"></i> Connexion Admin
    </span>

    <form action="index.php" method="POST">
        <!-- MESSAGE D'ERREUR PHP -->
        <?php
        if(isset($_POST['admin_login'])) {
            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);
            $hashedPass = sha1($password);

            $stmt = $con->prepare("SELECT user_id, username, password FROM users WHERE username = ? AND password = ?");
            $stmt->execute(array($username, $hashedPass));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if($count > 0) {
                $_SESSION['username_restaurant_qRewacvAqzA'] = $username;
                $_SESSION['password_restaurant_qRewacvAqzA'] = $password;
                $_SESSION['userid_restaurant_qRewacvAqzA'] = $row['user_id'];
                header('Location: dashboard.php');
                die();
            } else {
                echo '<div class="error-message"><i class="fas fa-exclamation-circle"></i> Identifiant ou mot de passe incorrect !</div>';
            }
        }
        ?>

        <!-- CHAMP UTILISATEUR -->
        <div class="form-input">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        </div>

        <!-- CHAMP MOT DE PASSE -->
        <div class="form-input">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Mot de passe" required>
        </div>

        <!-- BOUTON DE CONNEXION -->
        <button type="submit" name="admin_login" class="login-btn">Se Connecter</button>

        <!-- LIEN MOT DE PASSE OUBLIÉ -->
        <a href="#" class="forgotPW">Mot de passe oublié ?</a>
    </form>
</div>

<?php include 'Includes/templates/footer.php'; ?>
