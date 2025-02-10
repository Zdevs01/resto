<?php
include 'connect.php'; // Connexion à la base de données

if(isset($_POST['menu_id'])) {
    $menu_id = $_POST['menu_id'];
    $current_status = $_POST['current_status'];

    // Inverser l'état du menu
    $new_status = $current_status ? 0 : 1;

    $stmt = $conn->prepare("UPDATE menus SET is_available = ? WHERE menu_id = ?");
    $stmt->execute([$new_status, $menu_id]);

    echo json_encode(["success" => true, "new_status" => $new_status]);
} else {
    echo json_encode(["success" => false]);
}
?>
