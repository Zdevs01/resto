<?php
    include 'connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $full_name = $_POST['full_name'];
        $role = $_POST['role'];
        $task = $_POST['task'];

        $stmt = $con->prepare("UPDATE employees SET username = ?, email = ?, full_name = ?, role = ?, task = ? WHERE user_id = ?");
        $stmt->execute([$username, $email, $full_name, $role, $task, $user_id]);

        // Journalisation de l'action
        $stmt = $con->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
        $stmt->execute([$user_id, "Modification des informations de l'utilisateur"]);

        header('Location: users.php');
        exit();
    }
?>
