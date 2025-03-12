<?php
include('../config/constants.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = mysqli_real_escape_string($conn, $_POST['table_number']);
    $capacity = (int) $_POST['capacity'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Vérification si la table existe déjà
    $check_sql = "SELECT * FROM tbl_tables WHERE table_number = '$table_number'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        echo "<script>alert('Le numéro de table existe déjà !'); window.location.href='table.php';</script>";
        exit();
    }

    // Requête d'insertion
    $sql = "INSERT INTO tbl_tables (table_number, capacity, seats_taken, status) 
    VALUES ('$table_number', $capacity, 0, '$status')";


if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => "Table mise à jour avec succès !"]);
} else {
    echo json_encode(["error" => mysqli_error($conn)]);
}


}
?>
