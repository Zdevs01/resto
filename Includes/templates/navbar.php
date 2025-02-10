<!-- DÉBUT DE LA SECTION NAVBAR -->

<header id="header" class="header-section">
    <div class="container">
        <nav class="navbar">
            <a href="index.php" class="navbar-brand"  >
                <img src="Design/images/logo.png" alt="Logo du restaurant" style="width: 150px;">
            </a>
            <div class="d-flex menu-wrap align-items-center">
                <div class="mainmenu" id="mainmenu">
                    <ul class="nav">
                        <li><a href="index.php#home">ACCUEIL</a></li>
                        <li><a href="index.php#menus">MENUS</a></li>
                        <li><a href="index.php#gallery">PROMOTION</a></li>
                        <li><a href="index.php#about">À PROPOS</a></li>
                        <li><a href="index.php#contact">CONTACT</a></li>
                    </ul>
                </div>

                <!-- Icône de Profil -->
               

                <!-- Bouton de réservation -->
                <div class="header-btn" style="margin-left:10px">
                    <a href="table-reservation.php" target="_blank" class="menu-btn">Réserver une table</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="header-height" style="height: 120px;"></div>

<!-- FIN DE LA SECTION NAVBAR -->

<style>
    .profile-icon {
        cursor: pointer;
    }

    .profile-menu {
        position: absolute;
        top: 120%;
        right: 0;
        min-width: 150px;
        border-radius: 8px;
        z-index: 1000;
        animation: slideDown 0.3s ease-in-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .profile-menu a {
        text-decoration: none;
        padding: 5px 10px;
        display: block;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .profile-menu a:hover {
        background-color: #f0f0f0;
    }
</style>

<script>
    const profileIcon = document.getElementById('profileIcon');
    const profileMenu = document.getElementById('profileMenu');

    profileIcon.addEventListener('click', () => {
        const isVisible = profileMenu.style.display === 'block';
        profileMenu.style.display = isVisible ? 'none' : 'block';
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener('click', (e) => {
        if (!profileIcon.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.style.display = 'none';
        }
    });
</script>
