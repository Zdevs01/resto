<div class="container-xxl position-relative p-0" 
     style="background-image: url('images/bg-hero.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 100vh;">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <img src="images/logo.png" alt="Logo GoodFood"> 
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="index.php" class="nav-item nav-link active">Accueil</a>
                <a href="about.php" class="nav-item nav-link">À Propos</a>
                <a href="categories.php" class="nav-item nav-link">Catégories</a>
                <a href="menu.php" class="nav-item nav-link">Menu</a>
                <a href="table.php" class="nav-item nav-link">table</a>
                
                <a href="contact.php" class="nav-item nav-link">Contact</a>
                <?php if(isset($_SESSION['user'])) { ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <?php echo $_SESSION['user']; ?>
                        </a>
                        <div class="dropdown-menu m-0">
                            <a href="myaccount.php" class="dropdown-item">Mon Compte</a>
                            <a href="logout.php" class="dropdown-item">Déconnexion</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <a href="login.php" class="nav-item nav-link">Connexion</a>
                <?php } ?>
            </div>
            <a href="mycart.php" class="btn btn-primary py-2 px-4">
                <i class="fas fa-shopping-cart"></i>
                <span>Panier <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
            </a>
        </div>
    </nav>

    <div class="container-xxl py-5 hero-header mb-5">
    <div class="container my-5 py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-3 text-white animated slideInLeft">
                    🍽️ Savourez Nos<br>Délicieux Plats
                </h1>
                
                <!-- Boutons avec icônes et emojis -->
                <div class="d-flex flex-wrap">
                    <a href="categories.php" 
                       class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">
                        <i class="fas fa-utensils"></i> 🍽️ Explorer les Catégories
                    </a>
                    
                    <a href="table.php" 
                       class="btn btn-outline-light py-sm-3 px-sm-5 animated slideInLeft" 
                       style="animation-delay: 0.2s;">
                        <i class="fas fa-chair"></i> 🛋️ Réserver une Table
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                <img class="img-fluid" src="images/hero1.png" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Ajout de Font Awesome pour les icônes -->
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>


</div>
