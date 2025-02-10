<!-- PHP INCLUDES -->

<?php

    include "connect.php";
    include 'Includes/functions/functions.php';
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";


    //Getting website settings

    $stmt_web_settings = $con->prepare("SELECT * FROM website_settings");
    $stmt_web_settings->execute();
    $web_settings = $stmt_web_settings->fetchAll();

    $restaurant_name = "";
    $restaurant_email = "";
    $restaurant_address = "";
    $restaurant_phonenumber = "";

    foreach ($web_settings as $option)
    {
        if($option['option_name'] == 'restaurant_name')
        {
            $restaurant_name = $option['option_value'];
        }

        elseif($option['option_name'] == 'restaurant_email')
        {
            $restaurant_email = $option['option_value'];
        }

        elseif($option['option_name'] == 'restaurant_phonenumber')
        {
            $restaurant_phonenumber = $option['option_value'];
        }
        elseif($option['option_name'] == 'restaurant_address')
        {
            $restaurant_address = $option['option_value'];
        }
    }

?>

	<!-- HOME SECTION -->

	<section class="home-section" id="home"> 
    <div class="container">
        <div class="row" style="flex-wrap: nowrap;">
            <div class="col-md-6 home-left-section">
                <div style="padding: 100px 0px; color: white;">
                    <h1>
                        Goodfood
                    </h1>
                    <h2>
                        FAIRE PLAISIR AUX GENS
                    </h2>
                    <hr>
                    <p>
                        Cuisine française authentique pour tous les goûts
                    </p>
                    <div style="display: flex;">
                        <a href="order_food.php" target="_blank" class="bttn_style_1" style="margin-right: 10px; display: flex; justify-content: center; align-items: center;">
                            Commander maintenant
                            <i class="fas fa-angle-right"></i>
                        </a>
                        <a href="#menus" class="bttn_style_2" style="display: flex; justify-content: center; align-items: center;">
                            Voir le menu
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- SECTION NOS QUALITÉS -->

<section class="our_qualities" style="padding:100px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="our_qualities_column">
                    <img src="Design/images/quality_food_img.png" >
                    <div class="caption">
                        <h3>
                            Aliments de qualité
                        </h3>
                        <p>
                            Des ingrédients frais et sélectionnés avec soin pour offrir des plats savoureux et équilibrés.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="our_qualities_column">
                    <img src="Design/images/fast_delivery_img.png" >
                    <div class="caption">
                        <h3>
                            Livraison rapide
                        </h3>
                        <p>
                            Profitez d'un service de livraison rapide pour savourer vos plats préférés sans attente.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="our_qualities_column">
                    <img src="Design/images/original_taste_img.png" >
                    <div class="caption">
                        <h3>
                            Saveur authentique
                        </h3>
                        <p>
                            Un mélange de saveurs uniques qui réveillent vos papilles et vous font voyager.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


	<!-- SECTION NOS MENUS -->
    <section class="our_menus" id="menus">
    <div class="container">
        <h2 class="section-title">DÉCOUVREZ NOS MENUS</h2>

        <!-- Onglets des catégories -->
        <div class="menus_tabs">
            <div class="menus_tabs_picker">
                <ul class="category-list">
                    <?php
                        $stmt = $con->prepare("SELECT * FROM menu_categories");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                        $x = 0;
                        foreach ($rows as $row) {
                            $categoryId = str_replace(' ', '', $row['category_name']);
                            echo "<li class='menu_category_name tab_category_links " . ($x == 0 ? "active_category" : "") . "' onclick=showCategoryMenus(event,'$categoryId')>
                                    <span>" . $row['category_name'] . "</span>
                                  </li>";
                            $x++;
                        }
                    ?>
                </ul>
            </div>

            <!-- Contenu des menus -->
            <div class="menus_tab">
                <?php
                    $stmt = $con->prepare("SELECT * FROM menu_categories");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    $i = 0;
                    foreach ($rows as $row) {
                        $categoryId = str_replace(' ', '', $row['category_name']);
                        echo "<div class='menu_category_content tab_category_content " . ($i == 0 ? "active" : "") . "' id='$categoryId'>";

                        $stmt_menus = $con->prepare("SELECT * FROM menus WHERE category_id = ?");
                        $stmt_menus->execute([$row['category_id']]);
                        $rows_menus = $stmt_menus->fetchAll();

                        if (count($rows_menus) == 0) {
                            echo "<div class='no_menus' style='text-align: center; color: #555; font-size: 1.2em; margin-top: 30px; opacity: 0; animation: fadeIn 1s forwards;'>
                                    <i class='fas fa-utensils' style='font-size: 3em; color: #f5a623; margin-bottom: 10px;'></i> 
                                    <p>Aucun menu disponible pour le moment.</p>
                                  </div>";
                        } else {
                            echo "<div class='menu-grid'>";
                            foreach ($rows_menus as $menu) {
                                $source = "admin/Uploads/images/" . $menu['menu_image'];
                                $menuLink = "order_food.php?menu_id=" . $menu['menu_id']; // Lien vers la page de commande avec l'ID du menu
                                ?>
                                <div class="menu-card">
                                    <a href="<?php echo $menuLink; ?>" class="menu-image-link"> <!-- Lien vers la page de commande -->
                                        <div class="menu-image">
                                            <img src="<?php echo $source; ?>" alt="<?php echo $menu['menu_name']; ?>">
                                        </div>
                                    </a>
                                    <div class="menu-details">
                                        <h5><?php echo $menu['menu_name']; ?></h5>
                                        <span class="menu_price"><?php echo "€" . $menu['menu_price']; ?></span>
                                    </div>
                                </div>
                                <?php
                            }
                            echo "</div>";
                        }

                        echo "</div>";
                        $i++;
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Animation pour un effet de fondu -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .menu-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .menu-card:hover {
        transform: scale(1.05);
    }

    .menu-image img {
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .menu-image img:hover {
        transform: scale(1.05);
    }

    .menu-details {
        padding: 15px;
        background-color: #fff;
        text-align: center;
    }

    .menu-price {
        color: #f5a623;
        font-size: 1.1em;
        font-weight: bold;
    }

    .menu-card:hover .menu-details {
        background-color: #f5f5f5;
    }

    .menu-image-link {
        display: block;
        transition: opacity 0.3s ease;
    }

    .menu-image-link:hover {
        opacity: 0.9;
    }
</style>


<!-- FIN DE LA SECTION NOS MENUS -->

<style>
/* Style Général */
.our_menus {
    padding: 50px 15px;
    background: #141414;
    color: white;
    text-align: center;
}

/* Titre */
.section-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 30px;
    text-transform: uppercase;
    color: #f8b400;
}

/* Catégories */
.category-list {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    gap: 10px;
    flex-wrap: wrap;
}

.menu_category_name {
    background: #222;
    padding: 10px 15px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    color: white;
    border: 2px solid transparent;
    transition: 0.3s;
}

.menu_category_name:hover, .active_category {
    background: #f8b400;
    color: black;
    border: 2px solid #f8b400;
}

/* Grille des Menus */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

/* Carte de Menu */
.menu-card {
    background: #222;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: 0.3s;
    cursor: pointer;
    width: 100%;
    max-width: 250px;
    text-align: center;
}

/* Image */
.menu-image {
    width: 100%;
    height: 150px;
    overflow: hidden;
    position: relative;
}

.menu-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease-in-out;
}

/* Effet de zoom */
.menu-card:hover .menu-image img {
    transform: scale(1.1);
}

/* Détails du Menu */
.menu-details {
    padding: 10px;
}

.menu-details h5 {
    font-size: 16px;
    margin-bottom: 5px;
    color: white;
}

.menu_price {
    display: block;
    font-weight: bold;
    font-size: 14px;
    margin-top: 5px;
    color: #f8b400;
}

/* Message aucun menu */
.no_menus {
    color: #aaa;
    font-size: 14px;
    margin-top: 15px;
}

/* Responsive */
@media (max-width: 768px) {
    .category-list {
        flex-direction: row;
        justify-content: center;
    }

    .menu-grid {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    }
}
</style>

<script>
function showCategoryMenus(event, categoryName) {
    document.querySelectorAll('.tab_category_content').forEach(el => el.style.display = 'none');
    document.getElementById(categoryName).style.display = 'block';

    document.querySelectorAll('.tab_category_links').forEach(el => el.classList.remove('active_category'));
    event.currentTarget.classList.add('active_category');
}
</script>

	<!-- IMAGE GALLERY -->
    <section class="image-gallery" id="gallery">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 30px;">PROMOTION RESTO</h2>
        <?php
            $stmt_image_gallery = $con->prepare("SELECT * FROM image_gallery");
            $stmt_image_gallery->execute();
            $rows_image_gallery = $stmt_image_gallery->fetchAll();

            echo "<div class='row'>";

            foreach ($rows_image_gallery as $row_image_gallery) {
                $source = "admin/Uploads/images/" . $row_image_gallery['image'];
                $image_name = htmlspecialchars($row_image_gallery['image_name']); // Récupération du nom de l'image
                $image_id = uniqid('img_'); // ID unique pour chaque image
                echo "<div class='col-md-4 col-lg-3' style='padding: 10px;'>";
        ?>
                <div class="zoom-container" onclick="openModal('<?php echo $source; ?>', '<?php echo $image_name; ?>')">
                    <img src="<?php echo $source; ?>" alt="Image" class="zoom-image" id="<?php echo $image_id; ?>" />
                </div>
        <?php
                echo "</div>";
            }

            echo "</div>";
        ?>
    </div>
</section>

<!-- Modale pour afficher l'image en grand -->
<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
    <div class="modal-caption" id="modalCaption"></div> <!-- Récupération du nom de l'image -->
</div>

<style>
/* Conteneur de l'image */
.zoom-container {
    position: relative;
    width: 100%;
    height: 220px; /* Taille ajustée */
    cursor: pointer;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 8px; /* Coins arrondis */
    background-color: #f8f8f8; /* Couleur de fond pour éviter le vide */
}

.zoom-image {
    transition: transform 0.3s ease, opacity 0.3s ease;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Effet de zoom réduit */
.zoom-container:hover .zoom-image {
    transform: scale(1.1);
}

/* Modale */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
    transition: transform 0.3s ease;
    border-radius: 10px;
}

/* Agrandissement de l'image dans la modale */
.modal-content:hover {
    transform: scale(1.05);
}

/* Titre de l'image */
.modal-caption {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 18px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    padding: 8px 12px;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 5px;
}

/* Bouton de fermeture */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #fff;
    font-size: 30px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.close:hover {
    color: #bbb;
}

@media screen and (max-width: 768px) {
    .modal-content {
        max-width: 90%;
        max-height: 90%;
    }

    .modal-caption {
        font-size: 16px;
        bottom: 15px;
    }
}
</style>

<script>
function openModal(imageSrc, imageName) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImage");
    var modalCaption = document.getElementById("modalCaption");

    modal.style.display = "flex";
    modalImg.src = imageSrc;
    modalCaption.innerText = imageName || "Restaurant GoodFood"; // Affiche le nom de l'image ou un texte par défaut
}

// Fermer la modale
document.querySelector('.close').addEventListener('click', function () {
    document.getElementById("imageModal").style.display = "none";
});

window.addEventListener('click', function (event) {
    var modal = document.getElementById("imageModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
});
</script>

	<!-- CONTACT US SECTION -->

    <section class="contact-section" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 sm-padding">
                <div class="contact-info">
                    <h2 class="contact-title">
                        Contactez-nous & <br>envoyez-nous un message dès aujourd'hui !
                    </h2>
                    <p class="contact-description">
                        Goodfood est un restaurant spécialisé dans la gastronomie française. Nous mettons un point d'honneur à vous offrir des plats raffinés et un service exceptionnel, le tout dans une ambiance chaleureuse et conviviale.
                    </p>
                    <h3 class="contact-address">
                        <?php echo $restaurant_address; ?>
                    </h3>
                    <h4 class="contact-details">
                        <span>Email :</span> <?php echo $restaurant_email; ?><br> 
                        <span>Téléphone :</span> <?php echo $restaurant_phonenumber; ?>
                    </h4>
                </div>
            </div>
            <div class="col-lg-6 sm-padding">
                <form action="contact.php" method="POST" class="contact-form">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" id="contact_name" name="contact_name" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="email" id="contact_email" name="contact_email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="text" id="contact_subject" name="contact_subject" class="form-control" placeholder="Sujet" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea id="contact_message" name="contact_message" class="form-control" placeholder="Message" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                         <button type="submit" class="btn btn-primary contact-button">Envoyer le message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
/* Style général pour la section de contact */
.contact-section {
    padding: 60px 0;
    background-color: #f7f7f7;
    font-family: 'Roboto', sans-serif;
}

.contact-title {
    font-size: 36px;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 20px;
}

.contact-description {
    font-size: 18px;
    color: #7f8c8d;
    margin-bottom: 30px;
    line-height: 1.6;
}

.contact-address, .contact-details {
    font-size: 16px;
    color: #34495e;
}

.contact-address span, .contact-details span {
    font-weight: bold;
    color: #16a085;
}

/* Formulaire de contact */
.contact-form .form-control {
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.contact-form .form-control:focus {
    border-color: #16a085;
    box-shadow: 0 0 5px rgba(22, 160, 133, 0.5);
}

.contact-form .form-group {
    margin-bottom: 20px;
}

.contact-button {
    background-color: #16a085;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    padding: 12px 30px;
    border: none;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.contact-button:hover {
    background-color: #1abc9c;
    cursor: pointer;
}

.contact-info {
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.contact-info h3, .contact-info h4 {
    margin-top: 10px;
    color: #2c3e50;
}

.contact-info h4 span {
    font-weight: bold;
    color: #16a085;
}

@media (max-width: 767px) {
    .contact-title {
        font-size: 28px;
    }

    .contact-form .form-group {
        margin-bottom: 15px;
    }

    .contact-button {
        padding: 10px 20px;
    }
}

</style>


	<!-- OUR QUALITIES SECTION -->
	
	<section class="our_qualities_v2">
    <div class="container">
        <div class="row">
            <div class="col-md-4" style="padding: 10px;">
                <div class="quality quality_1">
                    <div class="text_inside_quality">
                        <h5>Aliments de Qualité</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding: 10px;">
                <div class="quality quality_2">
                    <div class="text_inside_quality">
                        <h5>Livraison Rapide</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding: 10px;">
                <div class="quality quality_3">
                    <div class="text_inside_quality">
                        <h5>Recettes Originales</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


	<!-- WIDGET SECTION / FOOTER -->

    <section class="widget_section" style="background-color: #222227;padding: 100px 0;">
    <div class="container">
        <div class="row">
            <!-- Informations sur le restaurant -->
            <div class="col-lg-3 col-md-6">
                <div class="footer_widget">
                    <img src="Design/images/logo.png" alt="Logo du Restaurant" style="width: 150px;margin-bottom: 20px;">
                    <p>
                        Notre restaurant est l'un des meilleurs, offrant des menus et plats savoureux. 
                        Vous pouvez réserver une table ou commander de la nourriture.
                    </p>
                    <ul class="widget_social">
                        <li><a href="#" data-toggle="tooltip" title="Facebook"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Twitter"><i class="fab fa-twitter fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Instagram"><i class="fab fa-instagram fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="LinkedIn"><i class="fab fa-linkedin fa-2x"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" title="Google+"><i class="fab fa-google-plus-g fa-2x"></i></a></li>
                    </ul>
                </div>
            </div>

            <!-- Adresse du restaurant -->
            <div class="col-lg-3 col-md-6">
                <div class="footer_widget">
                    <h3>Siège Social</h3>
                    <p>
                        <?php echo $restaurant_address; ?>
                    </p>
                    <p>
                        <?php echo $restaurant_email; ?>
                        <br>
                        <?php echo $restaurant_phonenumber; ?>   
                    </p>
                </div>
            </div>

            <!-- Horaires d'ouverture -->
            <div class="col-lg-3 col-md-6">
                <div class="footer_widget">
                    <h3>Horaires d'Ouverture</h3>
                    <ul class="opening_time">
                        <li>Lundi - Vendredi 11h30 - 20h00</li>
                        <li>Samedi - Dimanche 12h00 - 22h00</li>
                    </ul>
                </div>
            </div>

            <!-- Formulaire d'inscription à la newsletter -->
            <div class="col-lg-3 col-md-6">
                <div class="footer_widget">
                    <h3>Abonnez-vous à nos contenus</h3>
                    <div class="subscribe_form">
                        <form action="#" class="subscribe_form" novalidate="true">
                            <input type="email" name="EMAIL" id="subs-email" class="form_input" placeholder="Adresse e-mail...">
                            <button type="submit" class="submit">S'ABONNER</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


    <!-- FOOTER BOTTOM  -->

    <?php include "Includes/templates/footer.php"; ?>

    <script type="text/javascript">

	    $(document).ready(function()
	    {
	        $('#contact_send').click(function()
	        {
	            var contact_name = $('#contact_name').val();
	            var contact_email = $('#contact_email').val();
	            var contact_subject = $('#contact_subject').val();
	            var contact_message = $('#contact_message').val();

	            var flag = 0;

	            if($.trim(contact_name) == "")
	            {
	            	$('#invalid-name').text('This is a required field!');
	            	flag = 1;
	            }
	            else
	            {
	            	if(contact_name.length < 5)
	            	{
	            		$('#invalid-name').text('Length is less than 5 letters!');
	            		flag = 1;
	            	}
	            }

	            if(!ValidateEmail(contact_email))
	            {
	            	$('#invalid-email').text('Invalid e-mail!');
	            	flag = 1;
	            }

	            if($.trim(contact_subject) == "")
	            {
	            	$('#invalid-subject').text('This is a required field!');
	            	flag = 1;
	            }

	            if($.trim(contact_message) == "")
	            {
	            	$('#invalid-message').text('This is a required field!');
	            	flag = 1;
	            }

	            if(flag == 0)
	            {
	            	$('#sending_load').show();

		            $.ajax({
		                url: "Includes/php-files-ajax/contact.php",
		                type: "POST",
		                data:{contact_name:contact_name, contact_email:contact_email, contact_subject:contact_subject, contact_message:contact_message},
		                success: function (data) 
		                {
		                	$('#contact_status_message').html(data);
		                },
		                beforeSend: function()
		                {
					        $('#sending_load').show();
					    },
					    complete: function()
					    {
					        $('#sending_load').hide();
					    },
		                error: function(xhr, status, error) 
		                {
		                    alert("Internal ERROR has occured, please, try later!");
		                }
		            });
	            }
	            
	        });
	    }); 
	    
	</script>