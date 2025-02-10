<?php
// Fonction de validation des entrées
function test_input($data) {
    $data = trim($data);             // Supprime les espaces en début et en fin
    $data = stripslashes($data);      // Supprime les antislashes
    $data = htmlspecialchars($data);  // Convertit les caractères spéciaux en entités HTML
    return $data;
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resto";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_subject']) && isset($_POST['contact_message'])) {
    $contact_name = test_input($_POST['contact_name']);
    $contact_email = test_input($_POST['contact_email']);
    $contact_subject = test_input($_POST['contact_subject']);
    $contact_message = test_input($_POST['contact_message']);

    // Préparation de la requête SQL
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $contact_name, $contact_email, $contact_subject, $contact_message);

    // Exécution de la requête
    if ($stmt->execute()) {
        // Message de succès avec redirection
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Le message a été envoyé avec succès et a été enregistré dans la base de données.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        
        // Redirection après 3 secondes
        echo '<script type="text/javascript">
                setTimeout(function() {
                    window.location.href = "index.php"; // Redirection vers index.php après 3 secondes
                }, 3000); // 3000ms = 3 secondes
              </script>';
    } else {
        // Message d'erreur
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                Un problème est survenu lors de l\'envoi du message. Veuillez réessayer !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>
