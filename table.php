<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Robo Cafe - Réservation</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" type="image/png" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
</head>
<body>
<div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <?php include('include/top2.php'); ?>
<div class="container-xxl py-5 bg-dark hero-header mb-1" 
     style="background-image: url('images/3408.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            min-height: 20vh; 
            position: relative;">

<div class="container text-center my-3 pt-1 pb-1">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Réserver une Table</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Table</li>
                        </ol>
                    </nav>
                </div>




        </div>
  </div>


  
        <div class="container my-5">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-4">Tables Disponibles</h2>
                    <div class="container">
    <div class="row">
        <?php
       $query = "SELECT *, (capacity - seats_taken) AS places_restantes FROM tbl_tables WHERE status='available' AND (capacity - seats_taken) > 0";

        $result = mysqli_query($conn, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<p>Aucune table disponible pour le moment.</p>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-4">
                    <div class="card table-card p-3 mb-3 text-center" data-id="' . $row['id'] . '">
                        <h5>Table ' . $row['table_number'] . '</h5>
                        <p>Capacité: ' . $row['capacity'] . ' personnes</p>
                        <p>Places restantes: ' . $row['places_restantes'] . '</p>
                    </div>
                </div>';
            }
            
        }
        ?>
    </div>
</div>

<style>
    .table-card {
    border: 2px solid #007bff;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.table-card:hover, .table-card.selected {
    background-color: #007bff;
    color: white;
    border-color: #0056b3;
}

</style>

                </div>
                <div class="col-md-4">
                    <h2 class="mb-4">Réserver une Table</h2>
                    <form id="reservation-form">
                        <input type="hidden" id="table_id" name="table_id">

                        <div class="mb-3">
                            <label for="nomcl" class="form-label">Nom Du Client</label>
                            <input type="text" id="nomcl" name="nomcl" class="form-control" required>
                        </div>
                        <div class="mb-3">
                <label for="telcl" class="form-label">Numéro De Téléphone</label>
                <input type="tel" id="telcl" name="telcl" class="form-control" minlength="8"  required>
            </div> 

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label">Heure</label>
                            <input type="time" id="time" name="time" class="form-control" required>
                        </div>
                        <div class="mb-3">
    <label for="people" class="form-label">Nombre de personnes</label>
    <select id="people" name="people" class="form-control" required>
        <option value="" disabled selected>Choisissez...</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
    </select>
</div>

                        <button type="submit" class="btn btn-primary">Réserver</button>
                    </form>
                    <div id="ticket-container" style="display:none; margin-top:20px;">
                    <button id="download-ticket" class="btn btn-success">Télécharger recu</button>
                </div>

</div>

                
                </div>
            </div>
        </div>

        <?php include('include/foot.php'); ?>
    </div>


    <script>

document.addEventListener("DOMContentLoaded", function () {
    // Sélection des tables
    document.querySelectorAll(".table-card, .table-select").forEach(element => {
        element.addEventListener("click", function () {
            document.querySelectorAll(".table-card").forEach(el => el.classList.remove("selected"));
            this.classList.add("selected");

            let tableId = this.getAttribute("data-id");
            document.getElementById("table_id").value = tableId;

            Swal.fire({
                icon: 'info',
                title: 'Table sélectionnée',
                text: `Vous avez choisi la ${this.querySelector("h5")?.innerText || this.innerText}`,
                timer: 2000
            });
        });
    });

    // Gestion du formulaire de réservation
    document.getElementById('reservation-form').addEventListener('submit', function (e) {
        e.preventDefault();
        let selectedTableId = document.getElementById('table_id').value;
        let numberOfPeople = parseInt(document.getElementById('people').value);

        if (!selectedTableId) {
            Swal.fire({ icon: 'error', title: 'Erreur', text: 'Veuillez sélectionner une table avant de réserver.', timer: 2500 });
            return;
        }

        checkTableCapacity(selectedTableId, numberOfPeople);
    });

    // Charger la carte Google Maps
    loadMap();
});

// 📌 Fonction pour charger la carte avec les tables disponibles
function loadMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: { lat: 4.0511, lng: 9.7679 }
    });

    fetch('fetch_available_tables.php')
        .then(response => response.json())
        .then(tables => {
            tables.forEach(table => {
                let marker = new google.maps.Marker({
                    position: { lat: parseFloat(table.latitude), lng: parseFloat(table.longitude) },
                    map: map,
                    title: `Table ${table.table_number} - Capacité: ${table.capacity} personnes`
                });

                marker.addListener('click', function () {
                    document.getElementById('table_id').value = table.id;
                    Swal.fire({ icon: 'info', title: 'Table sélectionnée', text: `Table ${table.table_number} choisie pour la réservation !`, timer: 2000 });
                });
            });
        })
        .catch(error => {
            console.error("Erreur de chargement des tables :", error);
            Swal.fire({ icon: 'error', title: 'Erreur', text: 'Impossible de charger les tables.', timer: 2500 });
        });
}

// 📌 Vérification de la capacité de la table avant validation
function checkTableCapacity(tableId, numberOfPeople) {
    fetch('check_table_capacity.php?table_id=' + tableId)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire({ icon: 'error', title: 'Erreur', text: data.error, timer: 3000 });
                return;
            }

            if (numberOfPeople > data.places_restantes) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Capacité insuffisante',
                    text: 'Cette table ne peut pas accueillir autant de personnes. Choisissez une autre table ou combinez plusieurs tables.',
                    timer: 4000
                });
            } else {
                finalizeReservation(tableId, numberOfPeople);
            }
        })
        .catch(error => {
            console.error("Erreur de vérification de capacité :", error);
            Swal.fire({ icon: 'error', title: 'Erreur réseau', text: 'Impossible de vérifier la capacité de la table.', timer: 3000 });
        });
}

// 📌 Finalisation de la réservation
function finalizeReservation(tableId, numberOfPeople) {
    let nomcl = document.getElementById('nomcl').value;
    let telcl = document.getElementById('telcl').value;
    let date = document.getElementById('date').value;
    let time = document.getElementById('time').value;

    fetch('process_reservation.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `table_id=${tableId}&nomcl=${nomcl}&telcl=${telcl}&date=${date}&time=${time}&people=${numberOfPeople}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            Swal.fire({ icon: 'success', title: 'Réservation réussie', text: data.message, timer: 3500 })
            .then(() => {
                document.getElementById('ticket-container').style.display = 'block';
                document.getElementById('download-ticket').onclick = function () {
                    window.open('generate_ticket.php?reservation_id=' + data.reservation_id, '_blank');
                };
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Erreur', text: data.message, timer: 3000 });
        }
    })
    .catch(error => {
        console.error("Erreur de traitement de la réservation :", error);
        Swal.fire({ icon: 'error', title: 'Erreur réseau', text: 'Impossible de finaliser la réservation.', timer: 3000 });
    });
}





    </script>




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
</body>
</html>