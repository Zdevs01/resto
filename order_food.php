<!-- PHP INCLUDES -->

<?php
    //Set page title
    $pageTitle = 'Order Food';

    include "connect.php";
    include 'Includes/functions/functions.php';
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";


?>

    <!-- ORDER FOOD PAGE STYLE -->

	<style type="text/css">
        body
        {
            background: #f7f7f7;
        }

		.text_header
		{
			margin-bottom: 5px;
    		font-size: 18px;
    		font-weight: bold;
    		line-height: 1.5;
    		margin-top: 22px;
    		text-transform: capitalize;
		}

        .items_tab
        {
            border-radius: 4px;
            background-color: white;
            overflow: hidden;
            box-shadow: 0 0 5px 0 rgba(60, 66, 87, 0.04), 0 0 10px 0 rgba(0, 0, 0, 0.04);
        }

        .itemListElement
        {
            font-size: 14px;
            line-height: 1.29;
            border-bottom: solid 1px #e5e5e5;
            cursor: pointer;
            padding: 16px 12px 18px 12px;
        }

        .item_details
        {
            width: auto;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -webkit-flex-direction: row;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -webkit-box-align: center;
            -webkit-align-items: center;
        }

        .item_label
        {
        	color: #9e8a78;
            border-color: #9e8a78;
            background: white;
            font-size: 12px;
            font-weight: 700;
        }

        .btn-secondary:not(:disabled):not(.disabled).active, .btn-secondary:not(:disabled):not(.disabled):active 
        {
            color: #fff;
            background-color: #9e8a78;
            border-color: #9e8a78;
        }

        .item_select_part
        {
            display: flex;
            -webkit-box-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            align-items: center;
            flex-shrink: 0;
        }

        .select_item_bttn
        {
            width: 55px;
            display: flex;
            margin-left: 30px;
            -webkit-box-pack: end;
            justify-content: flex-end;
        }

        .menu_price_field
        {
        	width: auto;
            display: flex;
            margin-left: 30px;
            -webkit-box-align: baseline;
            align-items: baseline;
        }

        .order_food_section
        {
            max-width: 720px;
            margin: 50px auto;
            padding: 0px 15px;
        }

        .item_label.focus,
        .item_label:focus
        {
            outline: none;
            background:initial;
            box-shadow: none;
            color: #9e8a78;
            border-color: #9e8a78;
        }

        .item_label:hover
        {
            color: #fff;
            background-color: #9e8a78;
            border-color: #9e8a78;
        }

        /* Make circles that indicate the steps of the form: */
        .step 
        {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;  
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active 
        {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish 
        {
            background-color: #4CAF50;
        }


        .order_food_tab
        {
            display: none;
        }

        .next_prev_buttons
        {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            cursor: pointer;
        }

        .client_details_tab  .form-control
        {
            background-color: #fff;
            border-radius: 0;
            padding: 25px 10px;
            box-shadow: none;
            border: 2px solid #eee;
        }

        .client_details_tab  .form-control:focus 
        {
            border-color: #ffc851;
            box-shadow: none;
            outline: none;
        }

	</style>

    <!-- START ORDER FOOD SECTION -->

	<section class="order_food_section">

       <?php
if (isset($_POST['submit_order_food_form']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Selected Menus
    $selected_menus = $_POST['selected_menus'];

    // Client Details
    $client_full_name = test_input($_POST['client_full_name']);
    $client_phone_number = test_input($_POST['client_phone_number']);
    $client_email = test_input($_POST['client_email']);
    $delivery_option = test_input($_POST['delivery_option']);
    $delivery_address = $delivery_option === 'delivery' ? test_input($_POST['client_delivery_address']) : null;

    if ($delivery_option === 'delivery' && empty($delivery_address)) {
        echo "<div class='alert alert-danger'>Veuillez fournir une adresse de livraison.</div>";
    } else {
        $con->beginTransaction();
        try {
            // Insert client data
            $stmtClient = $con->prepare("INSERT INTO clients(client_name, client_phone, client_email) VALUES(?, ?, ?)");
            $stmtClient->execute([$client_full_name, $client_phone_number, $client_email]);
            $client_id = $con->lastInsertId();

            // Insert order
            $stmtOrder = $con->prepare("INSERT INTO placed_orders(order_time, client_id, delivery_address) VALUES(?, ?, ?)");
            $stmtOrder->execute([date("Y-m-d H:i"), $client_id, $delivery_address]);
            $order_id = $con->lastInsertId();

            // Insert ordered items
            foreach ($selected_menus as $menu) {
                $stmt = $con->prepare("INSERT INTO in_order(order_id, menu_id) VALUES(?, ?)");
                $stmt->execute([$order_id, $menu]);
            }

            $con->commit();
            // Après la commande réussie
echo "<div class='alert alert-success'>Commande créée avec succès ! Redirection en cours...</div>";
echo "<script>setTimeout(function(){ window.location.href='suivie.php'; }, 2000);</script>";
exit();

            exit();
        } catch (Exception $e) {
            $con->rollBack();
            echo "<div class='alert alert-danger'>Erreur: " . $e->getMessage() . "</div>";
        }
    }
}
?>


<!-- ORDER FOOD FORM -->
<div class="container mt-5">
    <form method="post" id="order_food_form" action="order_food.php" class="p-4 rounded shadow-lg bg-light animate__animated animate__fadeInUp">
        <h2 class="text-center mb-4 text-primary">🍽️ Commandez votre repas</h2>

        <!-- CHOIX DES ARTICLES -->
        <div class="order_food_tab" id="menus_tab">
            <h4 class="text_header">1. Choisissez vos articles</h4>
            <div class="alert alert-danger d-none" role="alert">
                Veuillez sélectionner au moins un article !
            </div>

            <div>
                <?php
                    $stmt = $con->prepare("SELECT * FROM menu_categories");
                    $stmt->execute();
                    $menu_categories = $stmt->fetchAll();

                    foreach ($menu_categories as $category) {
                        echo "<h5 class='mt-3 text-success'>" . $category['category_name'] . "</h5>";
                        echo "<div class='row'>";

                        $stmt = $con->prepare("SELECT * FROM menus WHERE category_id = ?");
                        $stmt->execute(array($category['category_id']));
                        $rows = $stmt->fetchAll();

                        foreach ($rows as $row) {
                            // Déterminer si le menu est disponible
                            $is_available = $row['is_available'] ? "Disponible" : "Indisponible";
                            $availability_class = $row['is_available'] ? "text-success" : "text-danger";
                            $disabled = $row['is_available'] ? "" : "disabled";
                            
                            // Ajouter l'icône
                            $menu_icon = "<img src='Design/images/favicon-icon.png' alt='menu-icon' class='menu-icon' style='width: 25px; height: 25px;'>";

                            echo "<div class='col-md-4 col-sm-6'>
                                    <div class='card menu-card mb-3 p-3 shadow-sm rounded animate__animated animate__fadeInUp'>
                                        <div class='d-flex justify-content-between align-items-center'>
                                            <div class='d-flex align-items-center'>
                                                $menu_icon
                                                <h6 class='fw-bold ms-2'>" . $row['menu_name'] . "</h6>
                                            </div>
                                            <span class='badge bg-primary'>" . $row['menu_price'] . "€</span>
                                        </div>
                                        <div class='d-flex justify-content-between align-items-center'>
                                            <p class='$availability_class'>$is_available</p>
                                            <input type='checkbox' name='selected_menus[]' value='" . $row['menu_id'] . "' class='form-check-input' $disabled>
                                            <label class='form-check-label' $disabled>Sélectionner</label>
                                        </div>
                                    </div>
                                </div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
        </div>

        <!-- DÉTAILS DU CLIENT -->
        <div class="order_food_tab" id="clients_tab">
            <h4 class="text_header mt-4"><i class="fas fa-user"></i> 2. Détails du Client</h4>
            <div class="row g-3 order-container">
                <div class="col-md-12">
                    <input type="text" name="client_full_name" class="form-control" placeholder="👤 Nom complet" required>
                </div>
                <div class="col-md-6">
                    <input type="email" name="client_email" class="form-control" placeholder="📧 E-mail" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="client_phone_number" class="form-control" placeholder="📱 Numéro de téléphone" required>
                </div>
                <div class="col-md-12">
                    <label for="delivery-option" class="form-label"><i class="fas fa-truck"></i> Choisissez une option :</label>
                    <select id="delivery-option" name="delivery_option" class="form-control">
                        <option value="pickup">Récupérer sur place</option>
                        <option value="delivery">Se faire livrer</option>
                    </select>
                </div>
                <div id="delivery-fields" class="delivery-container hidden col-md-12">
                    <label for="client_delivery_address" class="form-label"><i class="fas fa-map-marker-alt"></i> Adresse de livraison :</label>
                    <input type="text" name="client_delivery_address" class="form-control" placeholder="📍 Entrez votre adresse">
                </div>
            </div>
        </div>

        <!-- BOUTONS DE NAVIGATION -->
        <div class="text-center mt-4">
            <input type="hidden" name="submit_order_food_form">
            <button type="button" class="btn btn-secondary me-2" id="prevBtn" onclick="nextPrev(-1)">
                <i class="fas fa-arrow-left"></i> Précédent
            </button>
            <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">
                Suivant <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <!-- INDICATEURS D'ÉTAPES -->
        <div class="text-center mt-4">
            <span class="step"></span>
            <span class="step"></span>
        </div>
    </form>
</div>

<!-- Animation JS for smooth transitions -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Smooth transitions between tabs
        const tabs = document.querySelectorAll('.order_food_tab');
        let currentTab = 0;

        // Show the current tab
        function showTab(n) {
            tabs[n].classList.add('animate__fadeIn');
            tabs[n].style.display = "block";
        }

        // Hide the current tab
        function hideTab(n) {
            tabs[n].classList.remove('animate__fadeIn');
            tabs[n].style.display = "none";
        }

        // Next/Previous button functionality
        function nextPrev(n) {
            if (currentTab + n >= 0 && currentTab + n < tabs.length) {
                hideTab(currentTab);
                currentTab += n;
                showTab(currentTab);
            }
        }

        showTab(currentTab); // Show first tab by default
    });
</script>

<!-- Add some CSS for responsive design and smooth transitions -->
<style>
    /* Make the form container responsive */
    .container {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Responsive card layout */
    .menu-card {
        transition: transform 0.3s ease;
    }

    .menu-card:hover {
        transform: scale(1.05);
    }

    /* Style the form inputs and buttons */
    .form-control {
        border-radius: 10px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
    }

    /* Style for the menu icon */
    .menu-icon {
        margin-right: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .order_food_tab {
            padding: 15px;
        }

        .menu-card {
            margin-bottom: 20px;
        }
    }
</style>





















<!-- STYLES AMÉLIORÉS -->
<style>
    .order-container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px;
        font-size: 16px;
    }

    .form-label {
        font-weight: bold;
        margin-top: 10px;
    }

    /* Style des cartes de menu */
    .menu-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        cursor: pointer;
        border-radius: 12px;
    }

    .menu-card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Animation pour l'adresse de livraison */
    .hidden {
        opacity: 0;
        height: 0;
        overflow: hidden;
        transition: opacity 0.5s ease-in-out, height 0.5s ease-in-out;
    }

    .visible {
        opacity: 1;
        height: auto;
    }

    /* Boutons de navigation */
    .btn {
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>

<!-- SCRIPTS -->
<script>
    document.getElementById("delivery-option").addEventListener("change", function() {
        var deliveryFields = document.getElementById("delivery-fields");
        if (this.value === "delivery") {
            deliveryFields.classList.add("visible");
            deliveryFields.classList.remove("hidden");
        } else {
            deliveryFields.classList.add("hidden");
            deliveryFields.classList.remove("visible");
        }
    });

    function nextPrev(n) {
        // Ici, tu peux ajouter la logique pour afficher/masquer les différentes étapes
    }
</script>


	<!-- WIDGET SECTION / FOOTER -->

    


    <!-- FOOTER BOTTOM  -->

  


    <!-- JS SCRIPTS -->

    <script type="text/javascript">

        /* TOGGLE MENU SELECT BUTTON */

        $('.menu_label').click(function() 
        {
            $(this).button('toggle');
            
        });

    </script>

    <!-- JS SCRIPT FOR NEXT AND BACK TABS -->

    <script type="text/javascript">
        
        var currentTab = 0;
        showTab(currentTab);

        //Show Tab Function

        function showTab(n) 
        {
            var x = document.getElementsByClassName("order_food_tab");
            x[n].style.display = "block";
            
            if (n == 0) 
            {
                document.getElementById("prevBtn").style.display = "none";
            } 
            else 
            {
                document.getElementById("prevBtn").style.display = "inline";
            }
            
            if (n == (x.length - 1)) 
            {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } 
            else 
            {
                document.getElementById("nextBtn").innerHTML = "Next";
            }

            fixStepIndicator(n)
        }

        // Next Prev Function

        function nextPrev(n) 
        {
            var x = document.getElementsByClassName("order_food_tab");
            
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) 
            {
                // ... the form gets submitted:
                document.getElementById("order_food_form").submit();
                return false;
            }

            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        // Validate Form Function

        function validateForm()
        {
            var x, id_tab, valid = true;
            x = document.getElementsByClassName("order_food_tab");
            id_tab = x[currentTab].id;

            if(id_tab == "menus_tab")
            {
                if(x[currentTab].querySelectorAll('input[type="checkbox"]:checked').length == 0)
                {
                    x[currentTab].getElementsByClassName("alert")[0].style.display = "block";
                    valid = false;
                }
                else
                {
                    x[currentTab].getElementsByClassName("alert")[0].style.display = "none";
                }
            }
            if(id_tab == "clients_tab")
            {
                y = x[currentTab].getElementsByTagName("input");
                z = x[currentTab].getElementsByClassName("invalid-feedback");

                for (var i = 0; i < y.length; i++) 
                {
                    if(y[i].value == "")
                    {
                        z[i].style.display = "block";
                        valid = false;
                    }
                    if(y[i].type == "email" && !ValidateEmail(y[i].value))
                    {
                        z[i].style.display = "block";
                        valid = false;
                    }
                }
            }

            if (valid) 
            {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }

            return valid;
        }



        function fixStepIndicator(n) 
        {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            
            for (i = 0; i < x.length; i++) 
            {
                x[i].className = x[i].className.replace(" active", "");
            }
            
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }

    
    </script>
