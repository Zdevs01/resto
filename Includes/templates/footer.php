<!-- DÉBUT DE LA SECTION FOOTER -->
<footer class="footer_section">
    <div class="container">
        <div class="row align-items-center">
            <!-- Copyright -->
            <div class="col-md-6 text-center text-md-start">
                <div class="copyright text-light">
                    © <script>document.write(new Date().getFullYear())</script> Goodfood | Tous droits réservés
                </div>
            </div>

            <!-- Liens rapides et réseaux sociaux -->
            <div class="col-md-6 text-center text-md-end">
                <ul class="footer_social d-flex justify-content-center justify-content-md-end">
                    <li><a href="#"><i class="fas fa-shopping-cart"></i> Commandes</a></li>
                    <li><a href="#"><i class="fas fa-file-contract"></i> Conditions</a></li>
                    <li><a href="admin/"><i class="fas fa-file-contract"></i> Admin</a></li>
                    <li><a href="#"><i class="fas fa-exclamation-triangle"></i> Problème</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- FIN DE LA SECTION FOOTER -->

<style>
    .footer_section {
        background: #1a1a1a;
        padding: 20px 0;
        color: #fff;
        font-size: 14px;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .footer_section.show {
        opacity: 1;
        transform: translateY(0);
    }

    .footer_social {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 15px;
    }

    .footer_social li {
        display: inline-block;
    }

    .footer_social a {
        text-decoration: none;
        color: #fff;
        padding: 8px 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 5px;
        transition: background 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .footer_social a:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .footer_social i {
        font-size: 16px;
        color: #f8b400;
    }

    @media (max-width: 768px) {
        .footer_social {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<!-- INCLUDE JS SCRIPTS -->
<script src="Design/js/jquery.min.js"></script>
<script src="Design/js/bootstrap.min.js"></script>
<script src="Design/js/bootstrap.bundle.min.js"></script>
<script src="Design/js/main.js"></script>

<!-- Animation d'affichage -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const footer = document.querySelector('.footer_section');
        
        setTimeout(() => {
            footer.classList.add('show');
        }, 200);
    });
</script>
