
<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Robo Cafe</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" 
      type="image/png" 
      href="images/logo.png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <?php include('include/top2.php'); ?>

            <div class="container-xxl py-5 bg-dark hero-header mb-1" 
     style="background-image: url('images/bg.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 20vh; 
            position: relative;">
                <div class="container text-center my-2 pt-4 pb-1">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Cart</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <div class="container">
    <div class="row">
        <div class="col-lg-12"></div>

        <div class="col-lg-9 table-responsive">
            <table class="table" id="cart_table">
                <thead class="text-center">
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Nom de l'article</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Sous-total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php 
                    
                    $prix_article = 0;
                    $montant_total = 0;
                    
                    if(isset($_SESSION['cart']))
                    {
                        foreach($_SESSION['cart'] as $key => $value)
                        {
                            $prix_article = $value['Price'] * $value['Quantity'];
                            $montant_total += $prix_article;
                            
                            $sn = $key + 1;
                            
                            echo "
                            <tr>
                                <td>$sn</td>
                                <td>$value[Item_Name]</td>
                                <td>$value[Price]  <input type='hidden' class='iprice' value='$value[Price]'> €</td>
                                <td>
                                    <form action='manage-cart.php' method='POST'>
                                        <input class='text-center iquantity' name='Mod_Quantity' onchange='this.form.submit();' type='number' value='$value[Quantity]' min='1' max='20'>
                                        <input type='hidden' name='Item_Name' value='$value[Item_Name]'>
                                    </form>
                                </td>
                                <td class='itotal'></td>
                                <td>
                                    <form action='manage-cart.php' method='POST'>
                                        <button name='Remove_Item' class='btn btn-danger btn-sm'>🗑️ Supprimer</button>
                                        <input type='hidden' name='Item_Name' value='$value[Item_Name]'>
                                    </form>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-lg-3">
            <div class="border bg-light rounded p-4">
                <h4 class="text-center">Total à payer</h4>
                <h2 class="text-center" id="gtotal"> </h2>

                <br>

                <?php
                if(isset($_SESSION['user']))
                {
                    $username = $_SESSION['user'];

                    $fetch_user = "SELECT * FROM tbl_users WHERE username = '$username'";
                    $res_fetch_user = mysqli_query($conn, $fetch_user);
                    while($rows=mysqli_fetch_assoc($res_fetch_user))
                    {
                        $username = $rows['username'];
                        $nom_client = $rows['name'];
                        $email_client = $rows['email'];
                        $adresse_client = $rows['add1'];
                        $ville_client = $rows['city'];
                        $telephone_client = $rows['phone'];
                    }

                    if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)
                    {
                ?>

                <?php
                error_reporting(0);
                date_default_timezone_set('Europe/Paris');

                function rand_string($length) {
                    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";    
                    $size = strlen($chars);
                    $str = "";
                    for($i = 0; $i < $length; $i++) {
                        $str .= $chars[rand(0, $size - 1)];
                    }
                    return $str;
                }
                $transaction_id = rand_string(10);
                ?> 

                <form action="purchase.php" method="POST">
               <input type="hidden" name="amount" value="<?php echo $montant_total; ?>" class="form-control">
                    <input type="hidden" name="tran_id" value="CMD-<?php echo $transaction_id; ?>" class="form-control">
                    
                    <div class="form-group">
                        <h4 class="text-center">Adresse de livraison</h4>
                    </div>

                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" name="cus_name" value="<?php echo $nom_client; ?>" class="form-control" required readonly>
                    </div>

                    <div class="form-group">
                        <label>Email :</label>
                        <input type="email" name="cus_email" value="<?php echo $email_client; ?>" class="form-control" required readonly>
                    </div>

                    <div class="form-group">
                        <label>Adresse :</label>
                        <input type="text" name="cus_add1" value="<?php echo $adresse_client; ?>" class="form-control" required readonly>
                    </div>

                    <div class="form-group">
                        <label>Ville :</label>
                        <input type="text" name="cus_city" value="<?php echo $ville_client; ?>" class="form-control" required readonly>
                    </div>

                    <div class="form-group">
                        <label>Téléphone :</label>
                        <input type="tel" name="cus_phone" value="<?php echo $telephone_client; ?>" class="form-control" required readonly>
                    </div>

                    <br>
                    <a href="update-account.php">🔄 Modifier l'adresse de livraison</a>
                    <br><br>

                    <div class="form-check">
    <input class="form-check-input" type="radio" name="pay_mode" value="carte" id="paiement_carte" required>
    <label class="form-check-label" for="paiement_carte">
        💳 Payer par carte bancaire
    </label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio" name="pay_mode" value="sur_place" id="paiement_sur_place" required>
    <label class="form-check-label" for="paiement_sur_place">
        💵 Payer sur place
    </label>
</div>

                    <br>

                    <?php $_SESSION['amount'] = $montant_total; ?>

                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button class="btn btn-success btn-lg" name="purchase">🛒 Valider la commande</button>
                    </div>
                </form>

                <?php
                    }
                }
                else
                {
                    echo "⚠️ Veuillez vous connecter pour passer commande.";
                    ?>
                    <a href="login.php" class="btn btn-primary">🔑 Se connecter</a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

    </div>

        <!-- Footer Start -->
        <?php include('include/foot.php'); ?>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        var gt=0;
        var iprice=document.getElementsByClassName('iprice');
        var iquantity=document.getElementsByClassName('iquantity');
        var itotal=document.getElementsByClassName('itotal');
        var igtotal=document.getElementById('gtotal');

        function subTotal()
        {
            gt=0;
            for(i=0;i<iprice.length;i++)
            {
                itotal[i].innerText=(iprice[i].value)*(iquantity[i].value);

                gt=gt+(iprice[i].value)*(iquantity[i].value);
            }
            gtotal.innerText=gt;
        }

        subTotal();


    </script>
</body>

</html>