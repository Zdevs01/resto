<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>GoodFood - Categories</title>
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
     style="background-image: url('images/bg-hero.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 60vh; 
            position: relative;">

    <!-- Overlay pour améliorer la lisibilité -->
    <div style="position: absolute; 
                top: 0; left: 0; width: 100%; height: 100%; 
                background: rgba(0, 0, 0, 0.5); /* Ajuste l'opacité si nécessaire */
                z-index: 1;"></div>

    <div class="container text-center my-3 pt-1 pb-1" style="position: relative; z-index: 2;">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Catégories</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-white-50">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Catégories</li>
            </ol>
        </nav>
    </div>
</div>

        <!-- Navbar & Hero End -->


        <!-- Categories Start -->
        <div class="container">
            <div class="row">
               
                    
                        <?php
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);

                        if($count>0)
                         {
                            while($row=mysqli_fetch_assoc($res))
                             {
                                //Get the Values
                                $id = $row['id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];

                                ?>
                        <div class="col-lg-3">
                            <div class="card">
                                <img src="images/category/<?php echo $image_name; ?>" class="card-img-top" alt="...">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $title; ?></h5>
                                    <a href="category-foods.php?category_id=<?php echo $id; ?>">
                                    <button class="btn btn-primary btn-sm">Explorer la Categorie</button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
                    
                             }

                           }
                            
                        else
                        {
                        //Categories are not available
                        echo "Categories not found";
                        }

                        
                        
                        ?>

                
              
            </div>
        </div>






        
        <!-- Categories End  -->
        

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
</body>

</html>