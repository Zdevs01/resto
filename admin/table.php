<?php include('../config/constants.php');
      error_reporting(0);
      @ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style-admin.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
    <title>Gestion des Tables - GoodFood Admin</title>
    <style>
      /* Styles pour le modal */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
    width: 40%;
    backdrop-filter: blur(8px);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
}

/* Effet d'apparition */
.modal.show {
    opacity: 1;
    visibility: visible;
}

/* Contenu du modal */
.modal-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
    position: relative;
}

.modal h2 {
    text-align: center;
    font-size: 22px;
    color: #333;
    margin-bottom: 10px;
}

/* Bouton de fermeture */
.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    color: #888;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close:hover {
    color: #d9534f;
}

/* Champs de formulaire */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

label {
    font-size: 16px;
    color: #555;
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

/* Bouton de soumission */
button {
    background: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background: #0056b3;
}









/* Styles pour le modal */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
    width: 40%;
    backdrop-filter: blur(8px);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
}

/* Effet d'apparition */
.modal.show {
    opacity: 1;
    visibility: visible;
}

/* Contenu du modal */
.modal-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.modal h2 {
    text-align: center;
    font-size: 22px;
    color: #333;
    margin-bottom: 10px;
}

/* Bouton de fermeture */
.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    color: #888;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close:hover {
    color: #d9534f;
}

/* Champs de formulaire */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

label {
    font-size: 16px;
    color: #555;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

/* Bouton de soumission */
button {
    background: #28a745;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background: #218838;
}

















/* Style du tableau */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

/* En-tête du tableau */
thead {
    background: #007bff;
    color: white;
    font-size: 16px;
    text-transform: uppercase;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

/* Lignes du tableau */
tbody tr:nth-child(even) {
    background: #f9f9f9;
}

tbody tr:hover {
    background: #f1f1f1;
}

/* Statut avec badge coloré */
.status-badge {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: bold;
    text-transform: capitalize;
}

.status-available {
    background: #28a745;
    color: white;
}

.status-occupied {
    background: #dc3545;
    color: white;
}

/* Boutons d'action */
.btn-edit, .btn-delete {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-edit {
    background: #ffc107;
    color: #333;
}

.btn-edit:hover {
    background: #e0a800;
}

.btn-delete {
    background: #dc3545;
    color: white;
    margin-left: 8px;
}

.btn-delete:hover {
    background: #c82333;
}

    </style>
</head>
<body>

    <?php include('dashbord.php'); ?>
    <section id="content">
        <?php include('mess.php'); ?>
        <main>
            <h1>Gestion des Tables</h1>
            <button class="btn-add" id="openModal">➕ Ajouter une Table</button>
            <a href="voir-reservation.php" class="btn-view">📅 Voir les Réservations</a>
            
            <table>
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Capacité</th>
            <th>Places Restantes</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT id, table_number, capacity, seats_taken, status FROM tbl_tables";
        $res = mysqli_query($conn, $sql);
        
        if ($res == TRUE) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $table_number = $row['table_number'];
                $capacity = $row['capacity'];
                $seats_taken = $row['seats_taken'];
                $remaining_seats = $capacity - $seats_taken;
                $status = $row['status'];

                // Définition de la classe du badge selon le statut
                $statusClass = ($status == 'available') ? 'status-available' : 'status-occupied';

                echo "<tr>
                        <td>$table_number</td>
                        <td>$capacity</td>
                        <td>$remaining_seats</td>
                        <td><span class='status-badge $statusClass'>$status</span></td>
                        <td>
                            <button class='btn-edit' data-id='$id'>✏️ Modifier</button>
                            <a href='delete_table.php?id=$id' class='btn-delete'>❌ Supprimer</a>
                        </td>
                      </tr>";
            }
        }
        ?>
    </tbody>
</table>


            <div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeEditModal">&times;</span>
        <h2>Modifier la Table</h2>
        <form id="editForm"  action="update_table.php" method="POST" >
            <input type="hidden" id="edit_id" name="id">
            
            <label>Numéro de Table :</label>
            <input type="text" id="edit_table_number" name="table_number" required>
            
            <label>Capacité :</label>
            <input type="number" id="edit_capacity" name="capacity" required>
            
            <label>Statut :</label>
            <select id="edit_status" name="status" required>
                <option value="available">Disponible</option>
                <option value="occupied">Occupée</option>
            </select>
            
            <button type="submit">Mettre à Jour</button>
        </form>
    </div>
</div>

        </main>
    </section>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Ajouter une Nouvelle Table</h2>
            <form action="add_table.php" method="POST">
                <label>Numéro de Table :</label>
                <input type="text" name="table_number" required>
                
                <label>Capacité :</label>
                <input type="number" name="capacity" required>
                
                <label>Statut :</label>
<select name="status" required>
    <option value="available">Disponible</option>
    <option value="occupied">Occupée</option>
</select>

                
                <button type="submit" name="submit">Ajouter</button>

            </form>
        </div>
    </div>
    
    <script>
        document.getElementById("openModal").addEventListener("click", function() {
            document.getElementById("modal").style.display = "block";
        });
        document.getElementById("closeModal").addEventListener("click", function() {
            document.getElementById("modal").style.display = "none";
        });
        window.onclick = function(event) {
            if (event.target == document.getElementById("modal")) {
                document.getElementById("modal").style.display = "none";
            }
        }

        window.onload = function () {
    const modal = document.getElementById("editModal");
    const closeModal = document.getElementById("closeEditModal");

    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("Bouton Modifier cliqué");

            let tableId = this.getAttribute("data-id");

            fetch(`get_table.php?id=${tableId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    document.getElementById("edit_id").value = data.id;
                    document.getElementById("edit_table_number").value = data.table_number;
                    document.getElementById("edit_capacity").value = data.capacity;
                    document.getElementById("edit_status").value = data.status;
                    
                    modal.style.display = "block";
                });
        });
    });

    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
};

window.onload = function () {
    const modal = document.getElementById("editModal");
    const closeModal = document.getElementById("closeEditModal");

    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("Bouton Modifier cliqué");  // Vérification

            let tableId = this.getAttribute("data-id");

            fetch(`get_table.php?id=${tableId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);  // Vérification de la réponse

                    if (data.error) {
                        alert("Erreur : " + data.error);
                        return;
                    }

                    // Remplir les champs du formulaire
                    document.getElementById("edit_id").value = data.id;
                    document.getElementById("edit_table_number").value = data.table_number;
                    document.getElementById("edit_capacity").value = data.capacity;
                    document.getElementById("edit_status").value = data.status;
                    
                    modal.style.display = "block";
                })
                .catch(error => console.error("Erreur lors de la récupération des données :", error));
        });
    });

    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
};



document.getElementById("editForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Empêche le rechargement de la page

    let formData = new FormData(this);

    fetch("update_table.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text()) // Change en `.text()` pour déboguer
    .then(data => {
        console.log(data); // Affiche la réponse du serveur dans la console
        alert(data); // Montre un message de confirmation
        location.reload(); // Recharge la page pour voir les changements
    })
    .catch(error => console.error("Erreur lors de la mise à jour :", error));
});



document.getElementById("editForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("update_table.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert("Table mise à jour avec succès !");
        document.getElementById("editModal").classList.remove("show");
        setTimeout(() => location.reload(), 500);
    })
    .catch(error => console.error("Erreur :", error));
});

// Gestion de l'ouverture et de la fermeture du modal
document.querySelectorAll(".btn-edit").forEach(btn => {
    btn.addEventListener("click", function() {
        document.getElementById("editModal").classList.add("show");
    });
});

document.getElementById("closeEditModal").addEventListener("click", function() {
    document.getElementById("editModal").classList.remove("show");
});


document.getElementById("closeModal").addEventListener("click", function() {
    document.getElementById("modal").classList.remove("show");
});

document.querySelectorAll(".btn-add").forEach(btn => {
    btn.addEventListener("click", function() {
        document.getElementById("modal").classList.add("show");
    });
});

document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("add_table.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert("Table ajoutée avec succès !");
        document.getElementById("modal").classList.remove("show");
        setTimeout(() => location.reload(), 500);
    })
    .catch(error => console.error("Erreur :", error));
});


    </script>

<script src="script-admin.js"></script>
</body>
</html>