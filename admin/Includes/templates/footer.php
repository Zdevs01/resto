<!-- Effet de chargement de page -->
<div id="loading-screen">
    <div class="spinner"></div>
</div>

<!-- INCLUDE JS SCRIPTS -->
<script src="Design/js/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="Design/js/bootstrap.bundle.min.js"></script>
<script src="Design/js/main.js"></script>

<!-- ANIMATIONS & INTERACTIVITÉ -->
<script>
$(document).ready(function () {
    // Effet de chargement plus fluide
    setTimeout(() => { $("#loading-screen").fadeOut(600); }, 500);

    // Animation au scroll avec transition plus douce
    $(window).scroll(function () {
        $(".animate-on-scroll").each(function () {
            var position = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();

            if (position < scroll + windowHeight - 100) {
                $(this).addClass("animate__animated animate__fadeInUp");
            }
        });
    });

    // Effet d'animation au passage sur les boutons
    $(".btn").hover(
        function () { $(this).addClass("animate__pulse"); },
        function () { $(this).removeClass("animate__pulse"); }
    );

    // Confirmation avant suppression
    $(".delete-btn").on("click", function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        swal({
            title: "Êtes-vous sûr ?",
            text: "Cette action est irréversible.",
            icon: "warning",
            buttons: ["Annuler", "Oui, supprimer"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = link;
            }
        });
    });
});
</script>

<!-- STYLES POUR ANIMATIONS -->
<style>
/* Effet de chargement */
#loading-screen {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(255, 107, 107, 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.spinner {
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid #fff;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Animation au scroll */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

/* Effet sur les boutons */
.btn {
    transition: all 0.25s ease-in-out;
}

.btn:hover {
    transform: scale(1.07);
}
</style>
