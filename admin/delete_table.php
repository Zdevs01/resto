<?php
include('../config/constants.php');
error_reporting(0);
@ini_set('display_errors', 0);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Vérifier si l'ID existe
    $check_sql = "SELECT * FROM tbl_tables WHERE id = $id";
    $check_res = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_res) == 0) {
        echo "<script>alert('Table non trouvée !'); window.location.href='table.php';</script>";
        exit();
    }
    
    // Suppression de l'enregistrement
    $sql = "DELETE FROM tbl_tables WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Table supprimée avec succès !'); window.location.href='table.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression !'); window.location.href='table.php';</script>";
    }
} else {
    echo "<script>alert('ID manquant !'); window.location.href='table.php';</script>";
}
?>
