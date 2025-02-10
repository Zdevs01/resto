<?php
    ob_start();
    session_start();

    $pageTitle = 'Paramètres du Site';

    if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
    {
        include 'connect.php';
        include 'Includes/functions/functions.php'; 
        include 'Includes/templates/header.php';
        include 'Includes/templates/navbar.php';

        $stmt = $con->prepare("SELECT * FROM website_settings");
        $stmt->execute();
        $options = $stmt->fetchAll();

        // Initialisation de la variable $form_flag
        $form_flag = 0;

        // Vérification et insertion des données soumises via le formulaire
        if (isset($_POST['save_settings']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($options as $option) {
                // Vérification si chaque champ est vide
                if (empty($_POST[$option['option_name']])) {
                    echo "<div class='invalid-feedback' style='display:block'>";
                    echo "Le champ " . $option['option_name'] . " est requis !";
                    echo "</div>";
                    $form_flag = 1;
                } else {
                    // Mise à jour des paramètres dans la base de données
                    $stmt_update = $con->prepare("UPDATE website_settings SET option_value = ? WHERE option_name = ?");
                    $stmt_update->execute([$_POST[$option['option_name']], $option['option_name']]);
                }
            }
        }

        ?>

        <div class="card">
            <div class="card-header">
                Paramètres du site
            </div>
            <div class="card-body">
                <form method="POST" class="website_settings_form" action="website-settings.php">
                    <div class="panel-X">
                        <div class="panel-header-X">
                            <div class="main-title">
                                Paramètres
                            </div>
                        </div>
                        <div class="save-header-X">
                            <div style="display:flex">
                                <div class="icon">
                                    <i class="fa fa-sliders-h"></i>
                                </div>
                                <div class="title-container">Détails du site web</div>
                            </div>
                            <div class="button-controls">
                                <button type="submit" name="save_settings" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                        <div class="panel-body-X">
                        <?php
                            foreach ($options as $option) {
                                ?>
                                <div class="form-group">
                                    <label for="<?php echo $option['option_name'] ?>">
                                        <?php echo $option['option_name'] ?>
                                    </label>
                                    <input type="text" value="<?php echo (isset($_POST[$option['option_name']])) ? $_POST[$option['option_name']] : $option['option_value'] ?>" name="<?php echo $option['option_name'] ?>" class="form-control">
                                    <?php
                                        if(isset($_POST['save_settings']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                                            if(empty($_POST[$option['option_name']])) {
                                                echo "<div class='invalid-feedback' style='display:block'>";
                                                echo "Le champ ".$option['option_name']." est requis !";
                                                echo "</div>";
                                                $form_flag = 1;
                                            }
                                        }
                                    ?>
                                </div>
                                <?php
                            }
                        ?>
                        </div>
                    </div>
                </form>

                <!-- MISE À JOUR DES PARAMÈTRES DU SITE -->
                <?php
                    // Vérification de la valeur de $form_flag avant de traiter la mise à jour
                    if (isset($_POST['save_settings']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $form_flag == 0) {
                        // Afficher un message de succès ou rediriger après la mise à jour
                        echo "<div class='alert alert-success'>Les paramètres ont été mis à jour avec succès.</div>";
                    }
                ?>

            </div>
        </div>

        <?php

        /*** INCLURE LE FOOTER ***/

        include 'Includes/templates/footer.php';
    }
    else
    {
        header('Location: index.php');
        exit();
    }
?>
