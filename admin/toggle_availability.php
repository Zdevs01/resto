<?php
require_once 'connect.php'; // Assure-toi que ce fichier est bien inclus

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["menu_id"], $_POST["is_available"])) {
    $menu_id = intval($_POST["menu_id"]);
    $is_available = intval($_POST["is_available"]);

    try {
        $stmt = $con->prepare("UPDATE menus SET is_available = ? WHERE menu_id = ?");
        $stmt->execute([$is_available, $menu_id]);

        if ($stmt->rowCount() > 0) {
            echo "success";
        } else {
            echo "no_change"; // Aucune ligne modifiée
        }
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
} else {
    echo "invalid_request";
}
?>
