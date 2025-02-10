<?php
    ob_start();
	session_start();

	$pageTitle = 'Utilisateurs';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
		include 'connect.php';
  		include 'Includes/functions/functions.php'; 
		include 'Includes/templates/header.php';
		include 'Includes/templates/navbar.php';

        ?>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('users_link')[0].className += " active_link";

            </script>

        <?php
            $do = '';

            if(isset($_GET['do']) && in_array(htmlspecialchars($_GET['do']), array('Add','Edit')))
                $do = $_GET['do'];
            else
                $do = 'Manage';

            if($do == "Manage")
            {
               $stmt = $con->prepare("SELECT users.*, roles.role_name FROM users 
LEFT JOIN roles ON users.role_id = roles.role_id");

                $stmt->execute();
                $users = $stmt->fetchAll();

            ?>
            <a href="users.php?do=Add" class="btn btn-primary mb-3">Ajouter un utilisateur</a>

                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">

   <!-- TABLE DES UTILISATEURS -->

<table class="table table-bordered users-table">
    <thead>
        <tr>
            <th scope="col">Nom d'utilisateur</th>
            <th scope="col">E-mail</th>
            <th scope="col">Nom complet</th>
            <th scope="col">Rôle</th>
            <th scope="col">Gérer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['username']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['full_name']; ?></td>
                <td><?= $user['role_name'] ?? 'Non assigné'; ?></td>
                <td>
                    <a href="users.php?do=Edit&user_id=<?= $user['user_id']; ?>" class="btn btn-success btn-sm">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
  
                    </div>
                </div>
            <?php
            }
            # Edit the user details
            elseif($do == 'Edit')
            {
                $user_id = (isset($_GET['user_id']) && is_numeric($_GET['user_id']))?intval($_GET['user_id']):0;
                
                if($user_id)
                {
                    $stmt = $con->prepare("Select * from users where user_id = ?");
                    $stmt->execute(array($user_id));
                    $user = $stmt->fetch();
                    $count = $stmt->rowCount();
                    if($count > 0)
                    {
                        ?>
<div class="card">
    <div class="card-header">
        Modifier l'utilisateur
    </div>
    <div class="card-body">
        <form method="POST" class="menu_form" action="users.php?do=Edit&user_id=<?php echo $user['user_id'] ?>">
            <div class="panel-X">
                <div class="panel-header-X">
                    <div class="main-title">
                        <?php echo $user['full_name']; ?>
                    </div>
                </div>

                <div class="save-header-X">
                    <div style="display:flex">
                        <div class="icon">
                            <i class="fa fa-sliders-h"></i>
                        </div>
                        <div class="title-container">Détails de l'utilisateur</div>
                    </div>
                    <div class="button-controls">
                        <button type="submit" name="edit_user_sbmt" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
                <div class="panel-body-X">
                    
                    <!-- ID Utilisateur -->
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id'];?>" >

                    <!-- Champ Nom d'utilisateur -->
                    <div class="form-group">
                        <label for="user_name">Nom d'utilisateur</label>
                        <input type="text" class="form-control" value="<?php echo $user['username'] ?>" placeholder="Nom d'utilisateur" name="user_name">
                        <?php
                            $flag_edit_user_form = 0;

                            if(isset($_POST['edit_user_sbmt']))
                            {
                                if(empty(test_input($_POST['user_name'])))
                                {
                                    ?>
                                        <div class="invalid-feedback" style="display: block;">
                                            Le nom d'utilisateur est requis.
                                        </div>
                                    <?php

                                    $flag_edit_menu_form = 1;
                                }
                            }
                        ?>
                    </div>
                
                    <!-- Champ Nom complet -->
                    <div class="form-group">
                        <label for="full_name">Nom complet</label>
                        <input type="text" class="form-control" value="<?php echo $user['full_name'] ?>" placeholder="Nom complet" name="full_name">
                        <?php
                            if(isset($_POST['edit_user_sbmt']))
                            {
                                if(empty(test_input($_POST['full_name'])))
                                {
                                    ?>
                                        <div class="invalid-feedback" style="display: block;">
                                            Le nom complet est requis.
                                        </div>
                                    <?php

                                    $flag_edit_menu_form = 1;
                                }
                            }
                        ?>
                    </div>
                    
                    <!-- Champ Email Utilisateur -->
                    <div class="form-group">
                        <label for="user_email">E-mail de l'utilisateur</label>
                        <input type="email" class="form-control" value="<?php echo $user['email'] ?>" placeholder="E-mail de l'utilisateur" name="user_email">
                        <?php
                            if(isset($_POST['edit_user_sbmt']))
                            {
                                if(empty(test_input($_POST['user_email'])))
                                {
                                    ?>
                                        <div class="invalid-feedback" style="display: block;">
                                            L'e-mail est requis.
                                        </div>
                                    <?php

                                    $flag_edit_menu_form = 1;
                                }
                                elseif(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL))
                                {
                                    ?>
                                        <div class="invalid-feedback" style="display: block;">
                                            L'e-mail est invalide.
                                        </div>
                                    <?php

                                    $flag_edit_menu_form = 1;
                                }
                            }
                        ?>
                    </div>
                    
                    <!-- Champ Rôle Utilisateur -->
                    <div class="form-group">
                        <label for="user_role">Rôle</label>
                        <select class="form-control" name="user_role">
                            <?php
                            $roles = $con->query("SELECT * FROM roles")->fetchAll();
                            foreach ($roles as $role) {
                                $selected = ($role['role_id'] == $user['role_id']) ? "selected" : "";
                                echo "<option value='{$role['role_id']}' $selected>{$role['role_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Champ Mot de Passe Utilisateur -->
                    <div class="form-group">
                        <label for="user_password">Mot de passe de l'utilisateur</label>
                        <input type="password" class="form-control" placeholder="Changer le mot de passe" name="user_password">
                        <?php
                            if(isset($_POST['edit_user_sbmt']))
                            {
                                if(!empty($_POST['user_password']) and strlen($_POST['user_password']) < 8)
                                {
                                    ?>
                                        <div class="invalid-feedback" style="display: block;">
                                            Le mot de passe doit contenir au moins 8 caractères.
                                        </div>
                                    <?php

                                    $flag_edit_menu_form = 1;
                                }
                            }
                        ?>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>


                        <?php

                        /*** EDIT MENU ***/

                        if(isset($_POST['edit_user_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_user_form == 0)
                        {
                            $user_id = test_input($_POST['user_id']);
                            $user_name = test_input($_POST['user_name']);
                            $user_fullname = $_POST['full_name'];
                            $user_email = test_input($_POST['user_email']);
                            $user_password = $_POST['user_password'];

                            if(empty($user_password))
                            {
                                try
                                {
                                    $stmt = $con->prepare("update users  set username = ?, email = ?, full_name = ? where user_id = ? ");
                                    $stmt->execute(array($user_name,$user_email,$user_fullname,$user_id));
                                    
                                    ?> 
                                        <!-- SUCCESS MESSAGE -->

                                        <script type="text/javascript">
                                            swal("Edit User","User has been updated successfully", "success").then((value) => 
                                            {
                                                window.location.replace("users.php");
                                            });
                                        </script>

                                    <?php

                                }
                                catch(Exception $e)
                                {
                                    echo 'Error occurred: ' .$e->getMessage();
                                }
                            }
                            else
                            {
                                $user_password = sha1($user_password);
                                try
                                {
                                   $user_role = isset($_POST['user_role']) ? intval($_POST['user_role']) : null;
if (!$user_role) {
    die('Erreur : rôle utilisateur invalide.');
}


$stmt = $con->prepare("UPDATE users SET username = ?, email = ?, full_name = ?, role_id = ? WHERE user_id = ?");
$stmt->execute([$user_name, $user_email, $user_fullname, $user_role, $user_id]);

                                    $stmt->execute(array($user_name,$user_email,$user_fullname,$user_password,$user_id));
                                    
                                    ?> 
                                        <!-- SUCCESS MESSAGE -->

                                        <script type="text/javascript">
                                            swal("Edit User","User has been updated successfully", "success").then((value) => 
                                            {
                                                window.location.replace("users.php");
                                            });
                                        </script>

                                    <?php

                                }
                                catch(Exception $e)
                                {
                                    echo 'Error occurred: ' .$e->getMessage();
                                }
                            }
                        }

                    }
                    else
                    {
                        header('Location: menus.php');
                    }
                }
                else
                {
                    header('Location: menus.php');
                }
            }
            elseif($do == "Add")
{
    ?>
    <div class="card">
        <div class="card-header">
            Ajouter un utilisateur
        </div>
        <div class="card-body">
            <form method="POST" action="users.php?do=Insert">
                <div class="form-group">
                    <label>Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="user_name" required>
                </div>
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" class="form-control" name="full_name" required>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="user_email" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" class="form-control" name="user_password" required>
                </div>
                <div class="form-group">
                    <label>Rôle</label>
                    <select class="form-control" name="user_role">
                        <?php
                        $roles = $con->query("SELECT * FROM roles")->fetchAll();
                        foreach ($roles as $role) {
                            echo "<option value='{$role['role_id']}'>{$role['role_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" name="add_user_sbmt">Ajouter</button>
            </form>
        </div>
    </div>
    <?php
}
elseif($do == "Insert")
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user_name = test_input($_POST['user_name']);
        $full_name = test_input($_POST['full_name']);
        $user_email = test_input($_POST['user_email']);
        $user_password = sha1($_POST['user_password']);
        $user_role = $_POST['user_role'];

        $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
$stmt->execute([$user_name, $user_email]);
$exists = $stmt->fetchColumn();

if ($exists > 0) {
    die('Erreur : Nom d’utilisateur ou email déjà utilisé.');
}


      try {
    $stmt = $con->prepare("INSERT INTO users (username, full_name, email, password, role_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_name, $full_name, $user_email, $user_password, $user_role]);
    
    echo '<script>swal("Succès", "Utilisateur ajouté avec succès", "success").then(() => { window.location.replace("users.php"); });</script>';
} catch (PDOException $e) {
    die('Erreur SQL : ' . $e->getMessage());
}
$user_name = htmlspecialchars(test_input($_POST['user_name']));
$full_name = htmlspecialchars(test_input($_POST['full_name']));
$user_email = htmlspecialchars(test_input($_POST['user_email']));
if (!$stmt) {
    echo '<script>swal("Erreur", "L\'ajout a échoué", "error");</script>';
    exit();
}

        ?>
        <script type="text/javascript">
            swal("Utilisateur ajouté", "Le nouvel utilisateur a été ajouté avec succès", "success").then(() => {
                window.location.replace("users.php");
            });
        </script>
        <?php
    }
    else
    {
        header('Location: users.php');
    }
}




        /* FOOTER BOTTOM */

        include 'Includes/templates/footer.php';

    }
    else
    {
        header('Location: index.php');
        exit();
    }
?>