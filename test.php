on recomence je veux ressortir le recu apres resevation voici mes codes  <?php include('config/constants.php'); ?>
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
     style="background-image: url('images/8504.jpg'); 
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
  </div>
        <div class="container my-5">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-4">Tables Disponibles</h2>
                    <div class="container">
    <div class="row">
        <?php
        $query = "SELECT * FROM tbl_tables WHERE status='available'";
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
                    </div>
                </div>';
            }
        }
        ?>
    </div>
</div>
<input type="hidden" id="table_id" name="table_id">
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
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label">Heure</label>
                            <input type="time" id="time" name="time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="people" class="form-label">Nombre de personnes</label>
                            <input type="number" id="people" name="people" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Réserver</button>
                    </form>
                    <div id="ticket-container" style="display:none; margin-top:20px;">
                    <button id="download-ticket" class="btn btn-success">Télécharger recu</button>
                </div>
                
                </div>
            </div>
        </div>

        <?php include('include/foot.php'); ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".table-card").forEach(card => {
        card.addEventListener("click", function () {
            document.querySelectorAll(".table-card").forEach(el => el.classList.remove("selected"));
            this.classList.add("selected");
            let tableId = this.getAttribute("data-id");
            document.getElementById("table_id").value = tableId;

            Swal.fire({
                icon: 'info',
                title: 'Table sélectionnée',
                text: 'Vous avez choisi la ' + this.querySelector("h5").innerText
            });
        });
    });
});

        document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".table-select").forEach(button => {
        button.addEventListener("click", function () {
            let tableId = this.getAttribute("data-id");
            document.getElementById("table_id").value = tableId;

            Swal.fire({
                icon: 'info',
                title: 'Table sélectionnée',
                text: 'Vous avez choisi la table ' + this.innerText
            });
        });
    });
});

        function loadMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: { lat: 4.0511, lng: 9.7679 }
            });

            <?php
            $query = "SELECT * FROM tbl_tables WHERE status='available'";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "var marker = new google.maps.Marker({
                    position: { lat: " . $row['latitude'] . ", lng: " . $row['longitude'] . " },
                    map: map,
                    title: 'Table " . $row['table_number'] . " - Capacité: " . $row['capacity'] . " personnes'
                });
                marker.addListener('click', function() {
                    document.getElementById('table_id').value = " . $row['id'] . ";
                    Swal.fire({ icon: 'info', title: 'Table sélectionnée', text: 'Table " . $row['table_number'] . " choisie pour la réservation !' });
                });";
            }
            ?>
        }
        window.onload = loadMap;

        document.getElementById('reservation-form').addEventListener('submit', function(e) {
    e.preventDefault();
    let tableId = document.getElementById('table_id').value;
    let date = document.getElementById('date').value;
    let time = document.getElementById('time').value;
    let people = document.getElementById('people').value;

    if (!tableId) {
        Swal.fire({ icon: 'error', title: 'Erreur', text: 'Veuillez sélectionner une table sur la carte !' });
        return;
    }

    fetch('process_reservation.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: table_id=${tableId}&date=${date}&time=${time}&people=${people}
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            Swal.fire({ icon: 'success', title: 'Réservation réussie', text: data.message })
            .then(() => location.reload());
        } else {
            Swal.fire({ icon: 'error', title: 'Erreur', text: data.message });
        }
    });
});

    </script>
</body>
</html>                                                                                                                                                    <?php
include('config/constants.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_id = $_POST['table_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $people = $_POST['people'];
    $user_id = 1; // Remplace par l'ID du client connecté

    if (empty($table_id) || empty($date) || empty($time) || empty($people)) {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont requis."]);
        exit;
    }

    // Vérifier si la table est toujours disponible
    $check_query = "SELECT * FROM tbl_tables WHERE id='$table_id' AND status='available'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Insérer la réservation
        $insert_query = "INSERT INTO tbl_reservations (user_id, table_id, reservation_date, reservation_time, number_of_people, status) 
                         VALUES ('$user_id', '$table_id', '$date', '$time', '$people', 'pending')";
        if (mysqli_query($conn, $insert_query)) {
            // Mettre à jour le statut de la table en "reserved"
            $update_query = "UPDATE tbl_tables SET status='reserved' WHERE id='$table_id'";
            mysqli_query($conn, $update_query);
            echo json_encode(["status" => "success", "message" => "Table réservée avec succès !"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur lors de la réservation."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Cette table n'est plus disponible."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée."]);
}
?>