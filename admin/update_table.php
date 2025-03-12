<?php
include('../config/constants.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $table_number = mysqli_real_escape_string($conn, $_POST['table_number']);
    $capacity = (int) $_POST['capacity'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Vérification si l'ID existe dans la base de données
    $check_sql = "SELECT * FROM tbl_tables WHERE id = $id";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) == 0) {
        echo json_encode(["error" => "Table non trouvée !"]);
        exit();
    }

    // Requête de mise à jour
    $sql = "UPDATE tbl_tables SET 
                table_number = '$table_number',
                capacity = $capacity,
                status = '$status'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => "Table mise à jour avec succès !"]);
    } else {
        echo json_encode(["error" => mysqli_error($conn)]);
    }
}
?>
