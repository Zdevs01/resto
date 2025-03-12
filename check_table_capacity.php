
<?php
include('config/constants.php');

if (isset($_GET['table_id'])) {
    $table_id = intval($_GET['table_id']);
    
    $query = "SELECT capacity, seats_taken FROM tbl_tables WHERE id = $table_id";
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $places_restantes = $row['capacity'] - $row['seats_taken'];
        echo json_encode(['places_restantes' => $places_restantes]);
    } else {
        echo json_encode(['error' => 'Table non trouvée']);
    }
} else {
    echo json_encode(['error' => 'ID de table manquant']);
}
?>
