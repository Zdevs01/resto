<?php
	
	//Start session
    session_start();

    //Set page title
    $pageTitle = 'Dashboard';

    //PHP INCLUDES
    include 'connect.php';
    include 'Includes/functions/functions.php'; 
    include 'Includes/templates/header.php';

    //TEST IF THE SESSION HAS BEEN CREATED BEFORE

    if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
    {
    	include 'Includes/templates/navbar.php';

    	?>

            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('dashboard_link')[0].className += " active_link";

            </script>

            <!-- TOP 4 CARTES -->

<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="fa fa-users fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span><?php echo countItems("client_id","clients")?></span></div>
                        <div>Total Clients</div>
                    </div>
                </div>
            </div>
            <a href="clients.php">
                <div class="panel-footer">
                    <span class="pull-left">Voir les détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="fas fa-utensils fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span><?php echo countItems("menu_id","menus")?></span></div>
                        <div>Total Menus</div>
                    </div>
                </div>
            </div>
            <a href="menus.php">
                <div class="panel-footer">
                    <span class="pull-left">Voir les détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="far fa-calendar-alt fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span>32</span></div>
                        <div>Total Réservations</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Voir les détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="fas fa-pizza-slice fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div class="huge"><span><?php echo countItems("order_id","placed_orders")?></span></div>
                        <div>Total Commandes</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Voir les détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>


            <!-- START ORDERS TABS -->

            <div class="card" style = "margin: 20px 10px">

                <!-- TABS BUTTONS -->

                <div class="card-header tab" style="padding:0px;">
    <button class="tablinks_orders active" onclick="openTab(event, 'recent_orders','tabcontent_orders','tablinks_orders')">Commandes Récentes</button>
    <button class="tablinks_orders" onclick="openTab(event, 'completed_orders','tabcontent_orders','tablinks_orders')">Commandes Terminées</button>
    <button class="tablinks_orders" onclick="openTab(event, 'canceled_orders','tabcontent_orders','tablinks_orders')">Commandes Annulées</button>
</div>


                <!-- TABS CONTENT -->
                
                <div class="card-body">
                    <div class='responsive-table'>

                        <!-- RECENT ORDERS -->

                      <table class="table X-table tabcontent_orders" id="recent_orders" style="display:table">
    <thead>
        <tr>
            <th>Heure de commande</th>
            <th>Menus sélectionnés</th>
            <th>Prix total</th>
            <th>Client</th>
            <th>Gérer</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $stmt = $con->prepare("SELECT * 
                                FROM placed_orders po, clients c
                                WHERE po.client_id = c.client_id
                                AND canceled = 0
                                AND delivered = 0
                                ORDER BY order_time;");
            $stmt->execute();
            $placed_orders = $stmt->fetchAll();
            $count = $stmt->rowCount();
            
            if ($count == 0) {
                echo "<tr><td colspan='5' style='text-align:center;'>Aucune commande récente disponible</td></tr>";
            } else {
                foreach ($placed_orders as $order) {
                    echo "<tr>";
                        echo "<td>" . $order['order_time'] . "</td>";
                        echo "<td>";
                            $stmtMenus = $con->prepare("SELECT menu_name, quantity, menu_price
                                                        FROM menus m, in_order in_o
                                                        WHERE m.menu_id = in_o.menu_id
                                                        AND order_id = ?");
                            $stmtMenus->execute(array($order['order_id']));
                            $menus = $stmtMenus->fetchAll();

                            $total_price = 0;

                            foreach ($menus as $menu) {
                                echo "<span style='display:block'>" . $menu['menu_name'] . "</span>";
                                $total_price += ($menu['menu_price'] * $menu['quantity']);
                            }
                        echo "</td>";
                        echo "<td>" . $total_price . "€</td>";
                        echo "<td>";
                            ?>
                            <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo "client_" . $order['client_id']; ?>" data-placement="top">
                                <?php echo $order['client_id']; ?>
                            </button>
                            <div class="modal fade" id="<?php echo "client_" . $order['client_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Détails du client</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li><strong>Nom complet : </strong><?php echo $order['client_name']; ?></li>
                                                <li><strong>Téléphone : </strong><?php echo $order['client_phone']; ?></li>
                                                <li><strong>Email : </strong><?php echo $order['client_email']; ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        echo "</td>";
                        echo "<td>";
                            $cancel_data = "cancel_order" . $order["order_id"];
                            $deliver_data = "deliver_order" . $order["order_id"];
                            ?>
                            <ul class="list-inline m-0">
                                <li class="list-inline-item" data-toggle="tooltip" title="Livrer la commande">
                                    <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $deliver_data; ?>" data-placement="top">
                                        <i class="fas fa-truck"></i>
                                    </button>
                                    <div class="modal fade" id="<?php echo $deliver_data; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Livrer la commande</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">Marquer la commande comme livrée ?</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                    <button type="button" data-id="<?php echo $order['order_id']; ?>" class="btn btn-info deliver_order_button">Oui</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-inline-item" data-toggle="tooltip" title="Annuler la commande">
                                    <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $cancel_data; ?>" data-placement="top">
                                        <i class="fas fa-calendar-times"></i>
                                    </button>
                                    <div class="modal fade" id="<?php echo $cancel_data; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Annuler la commande</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Motif d'annulation</label>
                                                        <textarea class="form-control" id="cancellation_reason_order_<?php echo $order['order_id']; ?>" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                                    <button type="button" data-id="<?php echo $order['order_id']; ?>" class="btn btn-danger cancel_order_button">Annuler la commande</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <?php
                        echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>




                      <!-- COMMANDES TERMINÉES -->

<table class="table X-table tabcontent_orders" id="completed_orders">
    <thead>
        <tr>
            <th>
                Heure de Création de la Commande
            </th>
            <th>
                Menus
            </th>
            <th>
                Client
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
            $stmt = $con->prepare("SELECT * 
                                FROM placed_orders po , clients c
                                WHERE 
                                    po.client_id = c.client_id
                                    AND
                                    delivered = 1
                                    AND
                                    canceled = 0
                                ORDER BY order_time;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $count = $stmt->rowCount();
            
            if ($count == 0) {
                echo "<tr>";
                echo "<td colspan='3' style='text-align:center;'>";
                echo "La liste de vos commandes terminées sera affichée ici";
                echo "</td>";
                echo "</tr>";
            } else {
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row['order_time'];
                    echo "</td>";
                    echo "<td>";

                    $stmtMenus = $con->prepare("SELECT menu_name, quantity
                            FROM menus m, in_order in_o
                            WHERE m.menu_id = in_o.menu_id
                            AND order_id = ?");
                    $stmtMenus->execute(array($row['order_id']));
                    $menus = $stmtMenus->fetchAll();
                    foreach ($menus as $menu) {
                        echo "<span style='display:block'>".$menu['menu_name']."</span>";
                    }

                    echo "</td>";
                    echo "<td>";
                    echo $row['client_name'];
                    echo "</td>";
                    echo "</tr>";
                }
            }
        ?>

    </tbody>
</table>


                        <!-- COMMANDES ANNULÉES -->

<table class="table X-table tabcontent_orders" id="canceled_orders">
    <thead>
        <tr>
            <th>
                Heure de Création de la Commande
            </th>
            <th>
                Client
            </th>
            <th>
                Raison de l'Annulation
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
            $stmt = $con->prepare("SELECT * 
                                FROM placed_orders po , clients c
                                WHERE 
                                    po.client_id = c.client_id
                                    AND 
                                    canceled = 1
                                ORDER BY order_time;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $count = $stmt->rowCount();

            if ($count == 0) {
                echo "<tr>";
                echo "<td colspan='3' style='text-align:center;'>";
                echo "La liste de vos commandes annulées sera affichée ici";
                echo "</td>";
                echo "</tr>";
            } else {
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row['order_time'];
                    echo "</td>";
                    echo "<td>";
                    echo $row['client_name'];
                    echo "</td>";
                    echo "<td>";
                    echo $row['cancellation_reason'];
                    echo "</td>";
                    echo "</tr>";
                }
            }
        ?>

    </tbody>
</table>

                    </div>
                </div>
            </div>

            <!-- END ORDERS TABS -->
<!-- DÉBUT DES ONGLETS DE RÉSERVATIONS -->

<div class="card" style="margin: 20px 10px">

    <!-- BOUTONS DES ONGLETS -->

    <div class="card-header tab" style="padding:0px;">
        <button class="tablinks_reservations active" onclick="openTab(event, 'recent_reservations','tabcontent_reservations','tablinks_reservations')">Réservations Récentes</button>
        <button class="tablinks_reservations" onclick="openTab(event, 'completed_reservations','tabcontent_reservations','tablinks_reservations')">Réservations Terminées</button>
        <button class="tablinks_reservations" onclick="openTab(event, 'canceled_reservations','tabcontent_reservations','tablinks_reservations')">Réservations Annulées</button>
    </div>

    <!-- CONTENU DES ONGLETS -->
    
    <div class="card-body">
        <div class='responsive-table'>

            <!-- RÉSERVATIONS RÉCENTES -->

            <table class="table X-table tabcontent_reservations" id="recent_reservations" style="display:table">
                <thead>
                    <tr>
                        <th>Date de Création</th>
                        <th>Date et Heure de Réservation</th>
                        <th>Nombre de Convives</th>
                        <th>ID de la Table</th>
                        <th>Gérer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $con->prepare("SELECT * FROM reservations WHERE selected_time > ? AND canceled = 0");
                        $timestamp = time();
                        $formatted_time = date('y-m-d h:i:s', $timestamp);
                        $stmt->execute(array($formatted_time));
                        $reservations = $stmt->fetchAll();
                        $count = $stmt->rowCount();
                        
                        if($count == 0) {
                            echo "<tr><td colspan='5' style='text-align:center;'>La liste de vos prochaines réservations s'affichera ici</td></tr>";
                        } else {
                            foreach($reservations as $reservation) {
                                echo "<tr>";
                                echo "<td>" . $reservation['date_created'] . "</td>";
                                echo "<td>" . $reservation['selected_time'] . "</td>";
                                echo "<td>" . $reservation['nbr_guests'] . "</td>";
                                echo "<td>" . $reservation['table_id'] . "</td>";
                                echo "<td>";
                                $cancel_data_reservation = "cancel_reservation" . $reservation["reservation_id"];
                                $liberate_data = "liberate_table" . $reservation["reservation_id"];
                    ?>
                                <ul class="list-inline m-0">
                                    <!-- Bouton Libérer la Table -->
                                    <li class="list-inline-item" data-toggle="tooltip" title="Libérer la Table">
                                        <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $liberate_data; ?>">
                                            <i class="far fa-check-circle"></i>
                                        </button>
                                    </li>
                                    <!-- Bouton Annuler la Réservation -->
                                    <li class="list-inline-item" data-toggle="tooltip" title="Annuler la Réservation">
                                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $cancel_data_reservation; ?>">
                                            <i class="fas fa-calendar-times"></i>
                                        </button>
                                    </li>
                                </ul>
                    <?php
                                echo "</td></tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

            <!-- RÉSERVATIONS TERMINÉES -->
            <table class="table X-table tabcontent_reservations" id="completed_reservations">
                <thead>
                    <tr>
                        <th>Date de Création</th>
                        <th>Date de Réservation</th>
                        <th>ID de la Table</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $con->prepare("SELECT * FROM reservations WHERE selected_time < ? AND canceled = 0 ORDER BY selected_time");
                        $stmt->execute(array($formatted_time));
                        $rows = $stmt->fetchAll();
                        $count = $stmt->rowCount();
                        
                        if($count == 0) {
                            echo "<tr><td colspan='3' style='text-align:center;'>La liste de vos réservations terminées s'affichera ici</td></tr>";
                        } else {
                            foreach($rows as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['date_created'] . "</td>";
                                echo "<td>" . $row['selected_time'] . "</td>";
                                echo "<td>" . $row['table_id'] . "</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

            <!-- RÉSERVATIONS ANNULÉES -->
            <table class="table X-table tabcontent_reservations" id="canceled_reservations">
                <thead>
                    <tr>
                        <th>Date de Création</th>
                        <th>Motif d'Annulation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $con->prepare("SELECT * FROM reservations WHERE canceled = 1 ORDER BY date_created");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                        $count = $stmt->rowCount();
                        
                        if($count == 0) {
                            echo "<tr><td colspan='2' style='text-align:center;'>La liste de vos réservations annulées s'affichera ici</td></tr>";
                        } else {
                            foreach($rows as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['date_created'] . "</td>";
                                echo "<td>" . $row['cancellation_reason'] . "</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

            <!-- END RESERVATIONS TABS -->

        <?php

    	include 'Includes/templates/footer.php';

    }
    else
    {
    	header("Location: index.php");
    	exit();
    }

?>

<!-- JS SCRIPTS -->

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".liberate_table_button").forEach(button => {
            button.addEventListener("click", function () {
                let reservationId = this.getAttribute("data-id");
                console.log("Libération de la table avec ID :", reservationId);
                libererTable(reservationId);
            });
        });
    });

    function libererTable(reservationId) {
        fetch("liberate_table.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "reservation_id=" + reservationId
        })
        .then(response => response.text())
        .then(data => {
            console.log("Réponse du serveur :", data);
            location.reload(); // Recharger la page pour voir les modifications
        })
        .catch(error => console.error("Erreur :", error));
    }

    // LORSQUE LE BOUTON DE LIVRAISON DE COMMANDE EST CLIQUÉ
    $('.deliver_order_button').click(function() {
        var order_id = $(this).data('id');
        var do_ = 'Deliver_Order';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data: { do_: do_, order_id: order_id },
            success: function (data) {
                $('#deliver_order' + order_id).modal('hide');
                swal("Commande livrée", "La commande a été marquée comme livrée", "success").then((value) => {
                    window.location.replace("dashboard.php");
                });
            },
            error: function(xhr, status, error) {
                alert("UNE ERREUR S'EST PRODUITE LORS DU TRAITEMENT DE VOTRE DEMANDE !");
            }
        });
    });

    // LORSQUE LE BOUTON D'ANNULATION DE COMMANDE EST CLIQUÉ
    $('.cancel_order_button').click(function() {
        var order_id = $(this).data('id');
        var cancellation_reason_order = $('#cancellation_reason_order_' + order_id).val();
        var do_ = 'Cancel_Order';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data: { order_id: order_id, cancellation_reason_order: cancellation_reason_order, do_: do_ },
            success: function (data) {
                $('#cancel_order' + order_id).modal('hide');
                swal("Commande annulée", "La commande a été annulée avec succès", "success").then((value) => {
                    window.location.replace("dashboard.php");
                });
            },
            error: function(xhr, status, error) {
                alert("UNE ERREUR S'EST PRODUITE LORS DU TRAITEMENT DE VOTRE DEMANDE !");
            }
        });
    });
</script>
