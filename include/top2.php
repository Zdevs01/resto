<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="<?php echo SITEURL; ?>" class="navbar-brand p-0">
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
                <?php
                if(isset($_SESSION['user']))
                {
                    $username = $_SESSION['user'];
                    ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?php echo $username; ?></a>
                        <div class="dropdown-menu m-0">
                            <a href="myaccount.php" class="dropdown-item">Mon Compte</a>
                            <a href="logout.php" class="dropdown-item">Déconnexion</a>
                        </div>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <a href="login.php" class="nav-item nav-link">Connexion</a>
                    <?php
                }
                ?>
            </div>
            <?php
                $count=0;
                if(isset($_SESSION['cart']))
                {
                    $count=count($_SESSION['cart']);
                }
            ?>
            <a href="mycart.php" class="btn btn-primary py-2 px-4">
                <i class="fas fa-shopping-cart"></i>
                <span> Panier <?php echo $count; ?></span>
            </a>
        </div>
    </nav>

    