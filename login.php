<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $errors = [];

    // Vérifier si les champs sont remplis
    if (empty($email) || empty($password)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (empty($errors)) {
        // Vérifier l'email
        $stmt = $pdo->prepare("SELECT id, password FROM usersclient WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            session_start();
            $_SESSION["user_id"] = $user["id"];
            echo json_encode(["success" => true, "message" => "Connexion réussie."]);
        } else {
            echo json_encode(["success" => false, "errors" => ["Email ou mot de passe incorrect."]]);
        }
    } else {
        echo json_encode(["success" => false, "errors" => $errors]);
    }
}
?>
