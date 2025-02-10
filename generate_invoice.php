require('fpdf/fpdf.php');
require 'connect.php';  // Assurez-vous que ce fichier contient la connexion à la base de données

// Vérifiez si l'ID de réservation est passé dans l'URL
if (!isset($_GET['reservation_id'])) {
    die("ID de réservation manquant.");
}

$reservation_id = $_GET['reservation_id']; // Utilisation d'un nom de variable sans accent

// Préparer la requête SQL pour récupérer les détails de la réservation
$stmt = $con->prepare("SELECT r.*, c.client_name, c.client_phone, c.client_email, t.* 
                       FROM reservations r 
                       JOIN clients c ON r.client_id = c.client_id 
                       JOIN tables t ON r.table_id = t.id 
                       WHERE r.reservation_id = ?");
$stmt->execute([$reservation_id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    die("Réservation non trouvée.");
}

// Définir les en-têtes pour générer le PDF et forcer le téléchargement
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Facture_Reservation_'.$reservation_id.'.pdf"');

// Création du PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(190, 10, 'Facture de Réservation', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Merci pour votre confiance.', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Afficher les informations de la réservation dans le PDF
$pdf->Cell(100, 10, "Nom du client: {$reservation['client_name']}", 0, 1);
$pdf->Cell(100, 10, "E-mail : {$reservation['client_email']}", 0, 1);
$pdf->Cell(100, 10, "Téléphone : {$reservation['client_phone']}", 0, 1);
$pdf->Ln(10);
$pdf->Cell(100, 10, "Date et Heure : {$reservation['selected_time']}", 0, 1);
$pdf->Cell(100, 10, "Nombre de personnes : {$reservation['nbr_guests']}", 0, 1);
$pdf->Cell(100, 10, "Table: {$reservation['table_name']}", 0, 1);
$pdf->Ln(10);
$pdf->Cell(190, 10, "Total: Gratuit", 1, 1, 'C');

// Générer le PDF et forcer son téléchargement
$pdf->Output();
