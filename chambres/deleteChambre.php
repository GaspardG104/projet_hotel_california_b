<?php
// Inclusion du fichier de connexion à la base de données
require_once '../config/db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérifier si l'ID est valide
if ($id <= 0) {
    header("Location: listChambres.php");
    exit;
}

$conn = openDatabaseConnection();

// Vérifier si la chambre existe
$stmt = $conn->prepare("SELECT * FROM chambres WHERE id = ?");
$stmt->execute([$id]);
$chambre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$chambre) {
    header("Location: listChambres.php");
    exit;
}

// Vérifier si la chambre est utilisée dans des réservations
$stmt = $conn->prepare("SELECT COUNT(*) FROM reservations WHERE chambre_id = ?");
$stmt->execute([$id]);
$count = $stmt->fetchColumn();

$hasReservations = ($count > 0);

// Traitement de la suppression si confirmée
if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    // Si la chambre a des réservations et que l'utilisateur souhaite les supprimer aussi
    if ($hasReservations && isset($_POST['delete_reservations']) && $_POST['delete_reservations'] === 'yes') {
        $stmt = $conn->prepare("DELETE FROM reservations WHERE chambre_id = ?");
        $stmt->execute([$id]);
    } elseif ($hasReservations) {
        // Si la chambre a des réservations mais l'utilisateur ne veut pas les supprimer
        header("Location: listChambres.php?error=1");
        exit;
    }
    
    // Supprimer la chambre
    $stmt = $conn->prepare("DELETE FROM chambres WHERE id = ?");
    $stmt->execute([$id]);
    
    // Rediriger vers la liste des chambres
    header("Location: listChambres.php?deleted=1");
    exit;
}

closeDatabaseConnection($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Supprimer une Chambre</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .warning-box {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #ffeeba;
        }
        .danger-box {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #f5c6cb;
        }
        .form-check {
            margin: 10px 0;
        }
    </style>
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
        <h1>Supprimer une Chambre</h1>
        
        <div class="warning-box">
            <p><strong>Attention :</strong> Vous êtes sur le point de supprimer la chambre numéro <?= htmlspecialchars($chambre['numero']) ?>.</p>
        </div>
        
        <?php if ($hasReservations): ?>
            <div class="danger-box">
                <p><strong>Cette chambre est associée à <?= $count ?> réservation(s).</strong></p>
                <p>La suppression de cette chambre affectera les réservations existantes.</p>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <?php if ($hasReservations): ?>
                <div class="form-check">
                    <input type="checkbox" id="delete_reservations" name="delete_reservations" value="yes">
                    <label for="delete_reservations">Supprimer également les <?= $count ?> réservation(s) associée(s) à cette chambre</label>
                </div>
            <?php endif; ?>
            
            <p>Êtes-vous sûr de vouloir supprimer cette chambre ?</p>
            
            <div class="actions">
                <input type="hidden" name="confirm" value="yes">
                <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                <a href="listChambres.php" class="btn btn-primary">Annuler</a>
            </div>
        </form>
    </div>
        <!-- Parti JS de Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
