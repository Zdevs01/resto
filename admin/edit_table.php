<?php
include('../config/constants.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Récupération des infos de la table
    $sql = "SELECT * FROM tbl_tables WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    $table = mysqli_fetch_assoc($res);

    if (!$table) {
        echo "Table introuvable.";
        exit;
    }
} else {
    echo "ID non spécifié.";
    exit;
}

// Mise à jour des informations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_number = mysqli_real_escape_string($conn, $_POST['table_number']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql_update = "UPDATE tbl_tables SET table_number = '$table_number', status = '$status' WHERE id = $id";
    if (mysqli_query($conn, $sql_update)) {
        echo "Mise à jour réussie.";
        header("Location: table.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Table</title>
</head>
<body>
    <h1>Modifier la Table</h1>
    <form method="post">
        <label>Numéro de Table :</label>
        <input type="text" name="table_number" value="<?php echo htmlspecialchars($table['table_number']); ?>" required>
        <br>

        <label>Statut :</label>
        <select name="status">
            <option value="Libre" <?php if ($table['status'] == 'Libre') echo 'selected'; ?>>Libre</option>
            <option value="Occupée" <?php if ($table['status'] == 'Occupée') echo 'selected'; ?>>Occupée</option>
            <option value="Réservée" <?php if ($table['status'] == 'Réservée') echo 'selected'; ?>>Réservée</option>
        </select>
        <br>

        <input type="submit" value="Enregistrer">
        <a href="table.php">Annuler</a>
    </form>
</body>
</html>
