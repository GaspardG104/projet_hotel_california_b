<?php
require_once '../config/db_connect.php';

$conn = openDatabaseConnection();
$clients = $conn->query("SELECT id, nom FROM clients")->fetchAll(PDO::FETCH_ASSOC);
closeDatabaseConnection($conn);

$conn = openDatabaseConnection();
$chambres = $conn->query("SELECT id, numero FROM chambres")->fetchAll(PDO::FETCH_ASSOC);
closeDatabaseConnection($conn);




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $chambre_id = $_POST['chambre_id'];
    $date_arrivee = $_POST['date_arrivee'];
    $date_depart = $_POST['date_depart'];
    
    
    
    $conn = openDatabaseConnection();
    $stmt = $conn->prepare("INSERT INTO reservations (client_id, chambre_id, date_arrivee, date_depart) VALUES (?, ?, ?, ?)");
    $stmt->execute([$client_id, $chambre_id, $date_arrivee, $date_depart]);
    closeDatabaseConnection($conn);
    
    header("Location: listReservations.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Ajouter une Réservation</title>
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
    <h1>Ajouter une Réservation</h1>
        <div class="container mt-3">
            <form method="POST">
            <!-- Champ Nom du client Avec l'aide de chatgpt pck je n'y arriver pas-->
            <label for="client_id">Client :</label>
            <select name="client_id" required>
                <option value="">-- Sélectionner un client --</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['nom']) ?></option>
                <?php endforeach; ?>
            </select><br>

            <!-- Champ Numero de la chambre Avec l'aide de chatgpt pck je n'y arriver pas non plus-->
            <label for="chambre_id">Numero :</label> 
            <select name="chambre_id" required>
                <option value="">-- Sélectionner le numero --</option>
                <?php foreach ($chambres as $chambre): ?>
                    <option value="<?= $chambre['id'] ?>"><?= htmlspecialchars($chambre['numero']) ?></option>
                <?php endforeach; ?>
            </select><br>
           

            <!-- Champ Date d'Arrivé -->
            <div class="row mb-3 align-items-center">
                <label for="date_arrivee" class="col-2 col-form-label text-end">Date d'arrivée</label>
                <div class="col-4">
                    <input type="date" id="date_arrivee" name="date_arrivee"class="form-control" placeholder="Entrez la date">
                </div>
            </div>
            <!-- Champ Date du départ -->
            <div class="row mb-3 align-items-center">
                <label for="date_depart" class="col-2 col-form-label text-end">Date de départ</label>
                <div class="col-4">
                    <input type="date" id="date_depart" name="date_depart" class="form-control" placeholder="Entrez la date">
                </div>
            </div>

            <div class="row">
                <div class="col-2 text-end">
                    <!-- Bouton de retour -->
                    <a href="listReservations.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
                <div class="col-4 text-end">
                    <!-- Bouton validation -->
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
            </form>
        </div>

    <!-- Parti JS de Bootstrap -->    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>