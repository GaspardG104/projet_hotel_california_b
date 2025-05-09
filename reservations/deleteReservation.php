<?php
// Inclusion du fichier de connexion à la base de données
require_once '../config/db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérifier si l'ID est valide
if ($id <= 0) {
    header("Location: listReservations.php");
    exit;
}

$conn = openDatabaseConnection();

// Vérifier si la réservation existe
$stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
$stmt->execute([$id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    header("Location: listReservations.php");
    exit;
}


// Traitement de la suppression si confirmée
if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    
    // Supprimer la réservation
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
    
    // Rediriger vers la liste des clients
    header("Location: listReservations.php?deleted=1");
    exit;
}

closeDatabaseConnection($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Supprimer une Réservation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">

    <!-- Partie Font-Aweson-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"rel="stylesheet">

    <!-- Partie Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

</head>
<body>
<?php include '../assets/navbar.php'; ?>

    <div class="container">
        <h1>Supprimer une réservation</h1>
        
        <div class="warning-box">
            <p><strong>Attention :</strong> Vous êtes sur le point de supprimer la réservation <?= htmlspecialchars($reservation['id']) ?>.</p>
        </div>
        
        <form method="post">
            
            <p>Êtes-vous sûr de vouloir supprimer la réservation ?</p>
            
            <div class="actions">
                <input type="hidden" name="confirm" value="yes">
                <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                <a href="listReservations.php" class="btn btn-primary">Annuler</a>
            </div>
        </form>
    </div>
    <!-- Parti JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
