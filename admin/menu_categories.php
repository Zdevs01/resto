
<?php
    ob_start();
    session_start();

    $pageTitle = 'Catégories de Menu';

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
            if(current.length > 0)
            {
                current[0].classList.remove("active_link");   
            }
            vertical_menu.getElementsByClassName('menu_categories_link')[0].className += " active_link";
        </script>

        <style type="text/css">
            .categories-table
            {
                -webkit-box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                text-align: center;
                vertical-align: middle;
            }
        </style>

        <?php
        $stmt = $con->prepare("SELECT * FROM menu_categories");
        $stmt->execute();
        $menu_categories = $stmt->fetchAll();
        ?>

        <div class="card">
            <div class="card-header">
                <?php echo $pageTitle; ?>
            </div>
            <div class="card-body">
                
                <!-- BOUTON AJOUTER UNE NOUVELLE CATÉGORIE -->
                <button class="btn btn-success btn-sm" style="margin-bottom: 10px;" type="button" data-toggle="modal" data-target="#add_new_category">
                    <i class="fa fa-plus"></i> Ajouter une Catégorie
                </button>

                <!-- MODAL AJOUTER UNE NOUVELLE CATÉGORIE -->
                <div class="modal fade" id="add_new_category" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ajouter une Nouvelle Catégorie</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="category_name">Nom de la Catégorie</label>
                                    <input type="text" id="category_name_input" class="form-control" placeholder="Nom de la Catégorie" name="category_name">
                                    <div id='required_category_name' class="invalid-feedback">
                                        Le nom de la catégorie est requis !
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-info" id="add_category_bttn">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLEAU DES CATÉGORIES DE MENU -->
                <table class="table table-bordered categories-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom de la Catégorie</th>
                            <th>Gérer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($menu_categories as $category): ?>
                            <tr>
                                <td><?php echo $category['category_id']; ?></td>
                                <td style="text-transform:capitalize;"> <?php echo $category['category_name']; ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete_category_bttn" data-id="<?php echo $category['category_id']; ?>">
                                        <i class="fa fa-trash"></i> Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>  
            </div>
        </div>

        <?php include 'Includes/templates/footer.php'; ?>

        <script type="text/javascript">
            $('#add_category_bttn').click(function()
            {
                var category_name = $("#category_name_input").val().trim();
                if(category_name == "") {
                    $('#required_category_name').show();
                } else {
                    $.ajax({
                        url:"ajax_files/menu_categories_ajax.php",
                        method:"POST",
                        data:{category_name:category_name, do:"Add"},
                        dataType:"JSON",
                        success: function (data) {
                            if(data['alert'] == "Warning") {
                                alert("Attention : " + data['message']);
                            }
                            if(data['alert'] == "Success") {
                                alert("Catégorie ajoutée avec succès !");
                                location.reload();
                            }
                        },
                        error: function() {
                            alert("Une erreur est survenue.");
                        }
                    });
                }
            });

            $('.delete_category_bttn').click(function()
            {
                var category_id = $(this).data('id');
                if(confirm("Êtes-vous sûr de vouloir supprimer cette catégorie ?")) {
                    $.ajax({
                        url:"ajax_files/menu_categories_ajax.php",
                        method:"POST",
                        data:{category_id:category_id, do:"Delete"},
                        success: function () {
                            alert("Catégorie supprimée avec succès !");
                            location.reload();
                        },
                        error: function() {
                            alert("Une erreur est survenue.");
                        }
                    });
                }
            });
        </script>

        <?php
    }
    else
    {
        header('Location: index.php');
        exit();
    }
?>

<!-- JS SCRIPTS -->

<script type="text/javascript">


	// When add category button is clicked

    $('#add_category_bttn').click(function()
    {
        var category_name = $("#category_name_input").val();
        var do_ = "Add";

        if($.trim(category_name) == "")
        {
            $('#required_category_name').css('display','block');
        }
        else
        {
            $.ajax(
            {
                url:"ajax_files/menu_categories_ajax.php",
                method:"POST",
                data:{category_name:category_name,do:do_},
                dataType:"JSON",
                success: function (data) 
                {
                    if(data['alert'] == "Warning")
                    {
                        swal("Warning",data['message'], "warning").then((value) => {});
                    }
                    if(data['alert'] == "Success")
                    {
                        swal("New Category",data['message'], "success").then((value) => {
                            window.location.replace("menu_categories.php");
                        });
                    }
                    
                },
                error: function(xhr, status, error) 
                {
                    alert('AN ERROR HAS BEEN ENCOUNTERED WHILE TRYING TO EXECUTE YOUR REQUEST');
                }
            });
        }
    });

	// When delete category button is clicked

    $('.delete_category_bttn').click(function()
    {
        var category_id = $(this).data('id');
        var do_ = "Delete";

        $.ajax(
        {
            url:"ajax_files/menu_categories_ajax.php",
            method:"POST",
            data:{category_id:category_id,do:do_},
            success: function (data) 
            {
                swal("Delete Category","The category has been deleted successfully!", "success").then((value) => {
                    window.location.replace("menu_categories.php");
                });     
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN ENCOUNTERED WHILE TRYING TO EXECUTE YOUR REQUEST');
            }
          });
    });

</script>

