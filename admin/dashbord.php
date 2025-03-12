<?php

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user-role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['user-role']; // Stocker le rôle de l'utilisateur
?>
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">



<section id="sidebar">
    <a href="#" class="brand">
        <img src="../images/logo.png" width="80px" alt="Logo GoodFood">
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="index.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Tableau de Bord</span>
            </a>
        </li>
        
        <!-- 🏆 Accès Administrateur -->
        <?php if ($role == 'Administrateur') { ?>
        <li>
            <a href="manage-admin.php">
                <i class='bx bxs-user-detail'></i>
                <span class="text">Gestion des Administrateurs</span>
            </a>
        </li>
        <li>
            <a href="manage-category.php">
                <i class='bx bxs-category-alt'></i>
                <span class="text">Catégories</span>
            </a>
        </li>
        <li>
            <a href="manage-food.php">
			<i class='bx bxs-bowl-hot'></i>
                <span class="text">Plats & Menus</span>
            </a>
        </li>
        <li>
            <a href="inventory.php">
                <i class='bx bxs-store-alt'></i>
                <span class="text">Gestion du Stock</span>
            </a>
        </li>
        <?php } ?>

        <!-- 🛒 Accès Serveurs, Caissiers et Administrateurs -->
        <?php if (in_array($role, ['Administrateur', 'Serveurs', 'Caissier'])) { ?>
        <li>
            <a href="manage-online-order.php">
                <i class='bx bxs-cart'></i>
                <span class="text">Commandes</span>
                <?php if (isset($row_online_order_notif) && $row_online_order_notif > 0) { ?>
                    <span class="num-ei"><?php echo $row_online_order_notif; ?></span>
                <?php } ?>
            </a>
        </li>
        <?php } ?>

        <!-- 🍽️ Accès Serveurs et Administrateurs -->
        <?php if (in_array($role, ['Administrateur', 'Serveurs'])) { ?>
        <li>
            <a href="table.php">
			<i class='bx bx-chair'></i>
                <span class="text">Tables & Placement</span>
            </a>
        </li>
        <li>
            <a href="voir-reservation.php">
                <i class='bx bxs-calendar-event'></i>
                <span class="text">Réservations</span>
            </a>
        </li>
        <?php } ?>

        <!-- 🍳 Accès Cuisiniers et Administrateurs -->
        <?php if (in_array($role, ['Administrateur', 'Cuisiniers'])) { ?>
        <li>
            <a href="Cuisine.php">
                <i class='bx bxs-hot'></i>
                <span class="text">Ma Cuisine</span>
            </a>
        </li>
		<li>
            <a href="Cuisine.php">
                <i class='bx bxs-hot'></i>
                <span class="text">Ma Cuisine</span>
            </a>
        </li>
        <?php } ?>
        <li>
            <a href="messages.php">
                <i class='bx bxs-hot'></i>
                <span class="text">Mes Messages</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu">
        <li>
            <a href="logout.php" class="logout">
                <i class='bx bxs-exit'></i>
                <span class="text">Déconnexion</span>
            </a>
        </li>
    </ul>
</section>
