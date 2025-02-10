<?php
    ob_start();
	session_start();

	$pageTitle = 'Menus - GoodFood';

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
                
                vertical_menu.getElementsByClassName('menus_link')[0].className += " active_link";

            </script>

            <style type="text/css">

                .menus-table
                {
                    -webkit-box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                }

                .thumbnail>img 
                {
                    width: 100%;
                    object-fit: cover;
                    height: 300px;
                }

                .thumbnail .caption 
                {
                    padding: 9px;
                    color: #333;
                }

                .menu_form
                {
                    max-width: 750px;
                    margin:auto;
                }

                .panel-X
                {
                    border: 0;
                    -webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.25);
                    box-shadow: 0 1px 3px 0 rgba(0,0,0,.25);
                    border-radius: .25rem;
                    position: relative;
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    -webkit-box-orient: vertical;
                    -webkit-box-direction: normal;
                    -ms-flex-direction: column;
                    flex-direction: column;
                    min-width: 0;
                    word-wrap: break-word;
                    background-color: #fff;
                    background-clip: border-box;
                    margin: auto;
                    width: 600px;
                }

                .panel-header-X 
                {
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    -webkit-box-pack: justify;
                    -ms-flex-pack: justify;
                    justify-content: space-between;
                    -webkit-box-align: center;
                    -ms-flex-align: center;
                    align-items: center;
                    padding-left: 1.25rem;
                    padding-right: 1.25rem;
                    border-bottom: 1px solid rgb(226, 226, 226);
                }

                .save-header-X 
                {
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    -webkit-box-align: center;
                    -ms-flex-align: center;
                    align-items: center;
                    -webkit-box-pack: justify;
                    -ms-flex-pack: justify;
                    justify-content: space-between;
                    min-height: 65px;
                    padding: 0 1.25rem;
                    background-color: #f1fafd;
                }

                .panel-header-X>.main-title 
                {
                    font-size: 18px;
                    font-weight: 600;
                    color: #313e54;
                    padding: 15px 0;
                }

                .panel-body-X
                {
                    padding: 1rem 1.25rem;
                }

                .save-header-X .icon
                {
                    width: 20px;
                    text-align: center;
                    font-size: 20px;
                    color: #5b6e84;
                    margin-right: 1.25rem;
                }
            </style>

        <?php

            $do = '';

            if(isset($_GET['do']) && in_array(htmlspecialchars($_GET['do']), array('Add','Edit')))
                $do = $_GET['do'];
            else
                $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM menus m, menu_categories mc where mc.category_id = m.category_id");
                $stmt->execute();
                $menus = $stmt->fetchAll();

            ?>
<div class="card">
    <div class="card-header">
        <?php echo $pageTitle; ?>
    </div>
    <div class="card-body">

        <!-- BOUTON AJOUTER UN NOUVEAU MENU -->

        <div class="above-table" style="margin-bottom: 1rem!important;">
            <a href="menus.php?do=Add" class="btn btn-success">
                <i class="fa fa-plus"></i> 
                <span>Ajouter un nouveau menu</span>
            </a>
        </div>

        <!-- TABLEAU DES MENUS -->

        <table class="table table-bordered menus-table">
            <thead>
    <tr>
        <th scope="col">Nom du menu</th>
        <th scope="col">Catégorie</th>
        <th scope="col">Description</th>
        <th scope="col">Prix</th>
        <th scope="col">Disponibilité</th>
        <th scope="col">Actions</th>
    </tr>
</thead>
         <tbody>
    <?php foreach ($menus as $menu) { ?>
        <tr>
            <td><?php echo $menu['menu_name']; ?></td>
            <td style="text-transform:capitalize"><?php echo $menu['category_name']; ?></td>
            <td><?php echo $menu['menu_description']; ?></td>
            <td><?php echo $menu['menu_price']." €"; ?></td>
            <td>
                <?php if ($menu['is_available']) { ?>
                    <span class="badge badge-success">Disponible</span>
                <?php } else { ?>
                    <span class="badge badge-danger">Indisponible</span>
                <?php } ?>
            </td>
            <td>
                <ul class="list-inline m-0">
                    <!-- BOUTON CHANGER DISPONIBILITÉ -->
                    <li class="list-inline-item" data-toggle="tooltip" title="Changer Disponibilité">
                        <button class="btn btn-warning btn-sm toggle-availability"
                            data-id="<?php echo $menu['menu_id']; ?>" 
                            data-status="<?php echo $menu['is_available']; ?>">
                            <i class="fa fa-sync"></i>
                        </button>
                    </li>

                    <!-- BOUTON VOIR -->
                    <li class="list-inline-item" data-toggle="tooltip" title="Voir">
                        <button class="btn btn-primary btn-sm rounded-0" type="button" data-toggle="modal" data-target="#view_<?php echo $menu['menu_id']; ?>">
                            <i class="fa fa-eye"></i>
                        </button>

                        <!-- MODAL VOIR -->
                        <div class="modal fade" id="view_<?php echo $menu['menu_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="view_<?php echo $menu['menu_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="thumbnail" style="cursor:pointer">
                                            <?php $source = "Uploads/images/".$menu['menu_image']; ?>
                                            <img src="<?php echo $source; ?>" >
                                            <div class="caption">
                                                <h3>
                                                    <span style="float: right;"><?php echo $menu['menu_price'];?> €</span>
                                                    <?php echo $menu['menu_name'];?>
                                                </h3>
                                                <p><?php echo $menu['menu_description']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- BOUTON MODIFIER -->
                    <li class="list-inline-item" data-toggle="tooltip" title="Modifier">
                        <button class="btn btn-success btn-sm rounded-0">
                            <a href="menus.php?do=Edit&menu_id=<?php echo $menu['menu_id']; ?>" style="color: white;">
                                <i class="fa fa-edit"></i>
                            </a>
                        </button>
                    </li>

                    <!-- BOUTON SUPPRIMER -->
                    <li class="list-inline-item" data-toggle="tooltip" title="Supprimer">
                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#delete_<?php echo $menu['menu_id']; ?>">
                            <i class="fa fa-trash"></i>
                        </button>

                        <!-- MODAL SUPPRESSION -->
                        <div class="modal fade" id="delete_<?php echo $menu['menu_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_<?php echo $menu['menu_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Supprimer le menu</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer le menu "<?php echo strtoupper($menu['menu_name']); ?>" ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <button type="button" data-id="<?php echo $menu['menu_id']; ?>" class="btn btn-danger delete_menu_bttn">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
    <?php } ?>
</tbody>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".toggle-availability").click(function () {
            let button = $(this);
            let menuId = button.data("id");
            let currentStatus = button.data("status");
            let newStatus = currentStatus == 1 ? 0 : 1; // Inverser l'état

            console.log("Envoi de la requête AJAX pour le menu ID:", menuId, "Nouveau statut:", newStatus);

            $.ajax({
                url: "toggle_availability.php",
                type: "POST",
                data: { menu_id: menuId, is_available: newStatus },
                success: function (response) {
                    console.log("Réponse du serveur :", response);

                    if (response.trim() === "success") {
                        // Mise à jour de l'affichage du bouton
                        button.data("status", newStatus);
                        let badge = button.closest("td").find(".badge");
                        if (newStatus == 1) {
                            badge.removeClass("badge-danger").addClass("badge-success").text("Disponible");
                        } else {
                            badge.removeClass("badge-success").addClass("badge-danger").text("Indisponible");
                        }

                        // Afficher une notification et recharger la page après 1.5s
                        alert("La disponibilité du menu a été mise à jour avec succès !");
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        alert("Erreur lors de la mise à jour.");
                    }
                },
                error: function () {
                    alert("Erreur AJAX : Impossible d'envoyer la requête.");
                }
            });
        });
    });
</script>


        </table>  
    </div>
</div>

            <?php
            }

            /*** ADD NEW MENU SCRIPT ***/

            elseif($do == 'Add')
            {
                ?>

                    <div class="card">
    <div class="card-header">
        Ajouter un nouveau menu
    </div>
    <div class="card-body">
        <form method="POST" class="menu_form" action="menus.php?do=Add" enctype="multipart/form-data">
            <div class="panel-X">
                <div class="panel-header-X">
                    <div class="main-title">
                        Nouveau menu
                    </div>
                </div>
                <div class="save-header-X">
                    <div style="display:flex">
                        <div class="icon">
                            <i class="fa fa-sliders-h"></i>
                        </div>
                        <div class="title-container">Détails du menu</div>
                    </div>
                    <div class="button-controls">
                        <button type="submit" name="add_new_menu" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
                <div class="panel-body-X">

                    <!-- NOM DU MENU -->
                    <div class="form-group">
                        <label for="menu_name">Nom du menu</label>
                        <input type="text" class="form-control" onkeyup="this.value=this.value.replace(/[^\sa-zA-Z]/g,'');" value="<?php echo (isset($_POST['menu_name']))?htmlspecialchars($_POST['menu_name']):'' ?>" placeholder="Nom du menu" name="menu_name" required>
                    </div>
                    
                    <!-- CATÉGORIE DU MENU -->
                    <div class="form-group">
                        <?php
                            $stmt = $con->prepare("SELECT * FROM menu_categories");
                            $stmt->execute();
                            $rows_categories = $stmt->fetchAll();
                        ?>
                        <label for="menu_category">Catégorie du menu</label>
                        <select class="custom-select" name="menu_category">
                            <?php
                                foreach($rows_categories as $category)
                                {
                                    echo "<option value='".$category['category_id']."'>";
                                    echo ucfirst($category['category_name']);
                                    echo "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <!-- DESCRIPTION DU MENU -->
                    <div class="form-group">
                        <label for="menu_description">Description du menu</label>
                        <textarea class="form-control" name="menu_description" style="resize: none;" required><?php echo (isset($_POST['menu_description']))?htmlspecialchars($_POST['menu_description']):''; ?></textarea>
                    </div>

                    <!-- PRIX DU MENU EN € -->
                    <div class="form-group">
                        <label for="menu_price">Prix du menu (€)</label>
                        <input type="text" class="form-control" value="<?php echo (isset($_POST['menu_price']))?htmlspecialchars($_POST['menu_price']):'' ?>" placeholder="Prix du menu en €" name="menu_price" required>
                    </div>

                    <!-- IMAGE DU MENU -->
                    <div class="form-group">
                        <label for="menu_image">Image du menu</label>
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="menu_image" id="add_menu_imageUpload" accept=".png, .jpg, .jpeg" required/>
                                <label for="add_menu_imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="add_menu_imagePreview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


                <?php

                /*** ADD NEW menu ***/

                if(isset($_POST['add_new_menu']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_add_menu_form == 0)
                {
                    $menu_name = test_input($_POST['menu_name']);
                    $menu_category = $_POST['menu_category'];
                    $menu_price = test_input($_POST['menu_price']);
                    $menu_description = test_input($_POST['menu_description']);
                    $image = rand(0,100000).'_'.$_FILES['menu_image']['name'];
                    move_uploaded_file($_FILES['menu_image']['tmp_name'],"Uploads/images//".$image);

                    try
                    {
                        $stmt = $con->prepare("insert into menus(menu_name,menu_description,menu_price,menu_image,category_id) values(?,?,?,?,?) ");
                        $stmt->execute(array($menu_name,$menu_description,$menu_price,$image,$menu_category));
                        
                        ?> 
                         <!-- MESSAGE DE SUCCÈS -->

<script type="text/javascript">
    swal("Nouveau menu", "Le nouveau menu a été ajouté avec succès", "success").then((value) => 
    {
        window.location.replace("menus.php");
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

            elseif($do == 'Edit')
            {
                $menu_id = (isset($_GET['menu_id']) && is_numeric($_GET['menu_id']))?intval($_GET['menu_id']):0;

                if($menu_id)
                {
                    $stmt = $con->prepare("Select * from menus where menu_id = ?");
                    $stmt->execute(array($menu_id));
                    $menu = $stmt->fetch();
                    $count = $stmt->rowCount();

                    if($count > 0)
                    {
                        ?>

                        <div class="card">
    <div class="card-header">
        Modifier le Menu
    </div>
    <div class="card-body">
        <form method="POST" class="menu_form" action="menus.php?do=Edit&menu_id=<?php echo $menu['menu_id'] ?>" enctype="multipart/form-data">
            <div class="panel-X">
                <div class="panel-header-X">
                    <div class="main-title">
                        <?php echo $menu['menu_name']; ?>
                    </div>
                </div>
                <div class="save-header-X">
                    <div style="display:flex">
                        <div class="icon">
                            <i class="fa fa-sliders-h"></i>
                        </div>
                        <div class="title-container">Détails du Menu</div>
                    </div>
                    <div class="button-controls">
                        <button type="submit" name="edit_menu_sbmt" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
                <div class="panel-body-X">
                    
                    <!-- ID DU MENU -->
                    <input type="hidden" name="menu_id" value="<?php echo $menu['menu_id'];?>" >
                    
                    <!-- NOM DU MENU -->
                    <div class="form-group">
                        <label for="menu_name">Nom du Menu</label>
                        <input type="text" class="form-control" onkeyup="this.value=this.value.replace(/[^\sa-zA-Z]/g,'');" value="<?php echo $menu['menu_name'] ?>" placeholder="Nom du Menu" name="menu_name">
                        <?php if(isset($_POST['edit_menu_sbmt']) && empty(test_input($_POST['menu_name']))) { ?>
                            <div class="invalid-feedback" style="display: block;">Le nom du menu est obligatoire.</div>
                        <?php } ?>
                    </div>
                    
                    <!-- CATÉGORIE DU MENU -->
                    <div class="form-group">
                        <?php
                            $stmt = $con->prepare("SELECT * FROM menu_categories");
                            $stmt->execute();
                            $rows_categories = $stmt->fetchAll();
                        ?>
                        <label for="menu_category">Catégorie du Menu</label>
                        <select class="custom-select" name="menu_category">
                            <?php foreach($rows_categories as $category) { ?>
                                <option value="<?php echo $category['category_id']; ?>" <?php echo ($category['category_id'] == $menu['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($category['category_name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <!-- DESCRIPTION DU MENU -->
                    <div class="form-group">
                        <label for="menu_description">Description du Menu</label>
                        <textarea class="form-control" name="menu_description" style="resize: none;"><?php echo $menu['menu_description']; ?></textarea>
                        <?php if(isset($_POST['edit_menu_sbmt'])) {
                            if(empty(test_input($_POST['menu_description']))) { ?>
                                <div class="invalid-feedback" style="display: block;">La description du menu est obligatoire.</div>
                            <?php } elseif(strlen(test_input($_POST['menu_description'])) > 200) { ?>
                                <div class="invalid-feedback" style="display: block;">La description doit contenir moins de 200 caractères.</div>
                            <?php }
                        } ?>
                    </div>
                    
                    <!-- PRIX DU MENU -->
                    <div class="form-group">
                        <label for="menu_price">Prix du Menu (€)</label>
                        <input type="text" class="form-control" value="<?php echo $menu['menu_price'] ?>" placeholder="Prix du Menu" name="menu_price">
                        <?php if(isset($_POST['edit_menu_sbmt'])) {
                            if(empty(test_input($_POST['menu_price']))) { ?>
                                <div class="invalid-feedback" style="display: block;">Le prix du menu est obligatoire.</div>
                            <?php } elseif(!is_numeric(test_input($_POST['menu_price']))) { ?>
                                <div class="invalid-feedback" style="display: block;">Prix invalide.</div>
                            <?php }
                        } ?>
                    </div>
                    
                    <!-- IMAGE DU MENU -->
                    <div class="form-group">
                        <label for="menu_image">Image du Menu</label>
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="menu_image" id="edit_menu_imageUpload" accept=".png, .jpg, .jpeg" />
                                <label for="edit_menu_imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <?php $source = "Uploads/images/".$menu['menu_image']; ?>
                                <div style="background-image: url('<?php echo $source; ?>');" id="edit_menu_imagePreview"></div>
                            </div>
                        </div>
                        <?php if(isset($_POST['edit_menu_sbmt']) && !empty($_FILES['menu_image']['name'])) {
                            $image_Name = $_FILES['menu_image']['name'];
                            $image_allowed_extension = array("jpeg","jpg","png");
                            $image_extension = strtolower(pathinfo($image_Name, PATHINFO_EXTENSION));
                            if(!in_array($image_extension, $image_allowed_extension)) { ?>
                                <div class="invalid-feedback" style="display: block;">Format d'image invalide. Seuls JPEG, JPG et PNG sont acceptés.</div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


                        <?php

                        /*** EDIT MENU ***/

                        if(isset($_POST['edit_menu_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_menu_form == 0)
                        {
                            $menu_id = test_input($_POST['menu_id']);
                            $menu_name = test_input($_POST['menu_name']);
                            $menu_category = $_POST['menu_category'];
                            $menu_price = test_input($_POST['menu_price']);
                            $menu_description = test_input($_POST['menu_description']);

                            if(empty($_FILES['menu_image']['name']))
                            {
                                try
                                {
                                    $stmt = $con->prepare("update menus  set menu_name = ?, menu_description = ?, menu_price = ?, category_id = ? where menu_id = ? ");
                                    $stmt->execute(array($menu_name,$menu_description,$menu_price,$menu_category,$menu_id));
                                    
                                    ?> 
                                     <!-- ✅ MESSAGE DE SUCCÈS -->

<script type="text/javascript">
    swal("📋 Modifier le menu", "✅ Le menu a été mis à jour avec succès !", "success").then((value) => 
    {
        window.location.replace("menus.php");
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
                                $image = rand(0,100000).'_'.$_FILES['menu_image']['name'];
                                move_uploaded_file($_FILES['menu_image']['tmp_name'],"Uploads/images//".$image);
                                try
                                {
                                    $stmt = $con->prepare("update menus  set menu_name = ?, menu_description = ?, menu_price = ?, category_id = ?, menu_image = ? where menu_id = ? ");
                                    $stmt->execute(array($menu_name,$menu_description,$menu_price,$menu_category,$image,$menu_id));
                                    
                                    ?> 
                                        <!-- SUCCESS MESSAGE -->

                                        <script type="text/javascript">
                                            swal("Edit Menu","Menu has been updated successfully", "success").then((value) => 
                                            {
                                                window.location.replace("menus.php");
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


        /*** FOOTER BOTTON ***/

        include 'Includes/templates/footer.php';

    }
    else
    {
        header('Location: index.php');
        exit();
    }

?>

<!-- JS SCRIPT -->

<script type="text/javascript">

    // When delete menu button is clicked

    $('.delete_menu_bttn').click(function()
    {
        var menu_id = $(this).data('id');
        var do_ = "Delete";

        $.ajax(
        {
            url:"ajax_files/menus_ajax.php",
            method:"POST",
            data:{menu_id:menu_id,do_:do_},
            success: function (data) 
            {
                swal("Delete Menu","The menu has been deleted successfully!", "success").then((value) => {
                    window.location.replace("menus.php");
                });     
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN ENCOUNTERED WHILE TRYING TO EXECUTE YOUR REQUEST');
            }
          });
    });

    // UPLOAD IMAGE ADD MENU

    function readURL(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function(e) 
            {
                $('#add_menu_imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#add_menu_imagePreview').hide();
                $('#add_menu_imagePreview').fadeIn(650);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#add_menu_imageUpload").change(function() 
    {
        readURL(this);
    });

    // UPLOAD IMAGE EDIT MENU
    
    function readURL_Edit_Menu(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function(e) 
            {
                $('#edit_menu_imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#edit_menu_imagePreview').hide();
                $('#edit_menu_imagePreview').fadeIn(650);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#edit_menu_imageUpload").change(function() 
    {
        readURL_Edit_Menu(this);
    });

</script>
