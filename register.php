
<?php 
include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Goodfood</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('background-food.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
            animation: fadeIn 1s;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .inputs {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .inputs input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: 0.3s;
        }
        .inputs input:focus {
            border-color: #ff4500;
            box-shadow: 0 0 5px rgba(255, 69, 0, 0.5);
        }
        button {
            background: #ff4500;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #e63900;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body    style="background-image: url('images/bg-hero.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 60vh; 
            position: relative;">
    <div class="container">
        <div class="brand-title"><i class="fas fa-utensils"></i> Inscription</div>
        <form action="register.php" method="POST" class="inputs">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="add1" placeholder="Adresse" required>
            <input type="text" name="city" placeholder="Ville" required>
            <input type="number" name="phone" placeholder="Téléphone" required>
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="create_account">Créer un compte</button>
        </form>
    </div>
</body>
</html>


<?php 
    if(isset($_POST['create_account']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $add1 = $_POST['add1'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //md5 encryption

        $check_duplicate = "SELECT username FROM tbl_users
						    WHERE username = '$username'";
	      $res_check_duplicate = mysqli_query($conn, $check_duplicate);

        $rows_check_duplicate = mysqli_num_rows($res_check_duplicate);
	      if($rows_check_duplicate>0)
	      {
		      echo "<script>
                alert('Username already exists! Try a different username.'); 
                window.location.href='register.php';
                </script>";
	      }
	    else
	    {
	  	$sql = "INSERT INTO tbl_users SET
        name='$name',
        email = '$email',
        add1 = '$add1',
        city = '$city',
        phone = '$phone',
        username='$username',
        password='$password'
    	";

        $res = mysqli_query($conn, $sql);

        echo "<script>
                alert('Account Created'); 
                window.location.href='login.php';
                </script>";

                
	}
    //header("location:".SITEURL.'login.php');

    }
?>