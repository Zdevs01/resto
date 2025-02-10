<?php
    ob_start();
    session_start();

    $pageTitle = '👥 Liste des Clients';

    if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
    {
        include 'connect.php';
        include 'Includes/functions/functions.php'; 
        include 'Includes/templates/header.php';
        include 'Includes/templates/navbar.php';
?>

<script type="text/javascript">
    var vertical_menu = document.getElementById("vertical-menu");
    var current = vertical_menu.getElementsByClassName("active_link");

    if(current.length > 0) {
        current[0].classList.remove("active_link");   
    }
    
    vertical_menu.getElementsByClassName('clients_link')[0].className += " active_link";
</script>

<?php
    $do = 'Manage';

    if($do == "Manage") {
        $stmt = $con->prepare("SELECT * FROM clients");
        $stmt->execute();
        $clients = $stmt->fetchAll();
?>
        <div class="card shadow-lg border-0">
            <div class="card-header bg-warning text-white text-center">
                <h3>👥 Nos Clients Précieux</h3>
            </div>
            <div class="card-body">

                <!-- TABLEAU DES CLIENTS -->
                <table class="table table-striped table-hover clients-table">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">🏷️ Nom</th>
                            <th scope="col">📞 Téléphone</th>
                            <th scope="col">📧 E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clients as $client) { ?>
                            <tr class="animate__animated animate__fadeInUp">
                                <td>🔹 <?= ucfirst($client['client_name']); ?></td>
                                <td>📲 <?= $client['client_phone']; ?></td>
                                <td>✉️ <a href="mailto:<?= $client['client_email']; ?>"><?= $client['client_email']; ?></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>  
            </div>
        </div>
<?php
    }
    include 'Includes/templates/footer.php';
    }
    else {
        header('Location: index.php');
        exit();
    }
?>
