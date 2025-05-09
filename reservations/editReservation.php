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

//Récupérer la liste des clients et chambres pour le menu depliant 
$clients = $conn->query("SELECT id, nom FROM clients ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$chambres = $conn->query("SELECT id, numero FROM chambres ORDER BY numero")->fetchAll(PDO::FETCH_ASSOC);

//Mise à jour de la réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $chambre_id = $_POST['chambre_id'];
    $date_arrivee = $_POST['date_arrivee'];
    $date_depart = $_POST['date_depart'];

    // Validation des données
    $errors = [];
    
    if (empty($client_id)) {
        $errors[] = "Le client est obligatoire.";
    }
        
    if ($chambre_id <= 0) {
        $errors[] = "La chambre doit être renseigner.";
    }
        
    if (empty($date_arrivee)) {
        $errors[] = "La date d'arrivée est obligatoire.";
    }
    
    if (empty($date_depart)) {
        $errors[] = "La date de départ est obligatoire.";
    }
    
    // Si pas d'erreurs, mettre à jour les données
    if (empty($errors)) {
        $update_stmt = $conn->prepare("UPDATE reservations SET client_id = ?, chambre_id = ?, date_arrivee = ?, date_depart = ? WHERE id = ?");
        $update_stmt->execute([$client_id, $chambre_id, $date_arrivee, $date_depart, $id]);

        // Rediriger vers la liste des reservations
        header("Location: listReservations.php?success=1");
        exit;
    }
}else{
        // Récupérer les données de la réservation
        
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si le client n'existe pas, rediriger
        if (!$reservation) {
            header("Location: listReservations.php");
            exit;
        }

}

closeDatabaseConnection($conn);
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Modifier une Réservation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error-message {
            color: #e74c3c;
            margin: 10px 0;
            padding: 10px;
            background-color: #f9e7e7;
            border-left: 4px solid #e74c3c;
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
        <h1>Modifier une Reservation</h1>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error-message">
                <?php foreach($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <!-- Champ Nom du client Avec l'aide de chatgpt pck je n'y arriver pas-->
                <label for="client_id">Client :</label>
                <select name="client_id" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>"<?= $client['id'] == $reservation['client_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($client['nom']) ?></option>
                    <?php endforeach; ?>
                </select><br>
            </div>
            
            <div class="form-group">
                <!-- Champ Numero de la chambre Avec l'aide de chatgpt pck je n'y arriver pas non plus-->
                <label for="chambre_id">Numero :</label> 
                <select name="chambre_id" required>
                    <option value="">-- Sélectionner le numero --</option>
                    <?php foreach ($chambres as $chambre): ?>
                        <option value="<?= $chambre['id'] ?>"<?= $chambre['id'] == $reservation['chambre_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($chambre['numero']) ?></option>
                    <?php endforeach; ?>
                </select><br>
            </div>

            <div class="form-group">
                <!-- Champ Date d'Arrivé -->
                <div class="row mb-3 align-items-center">
                    <label for="date_arrivee" class="col-2 col-form-label text-end">Date d'arrivée</label>
                    <div class="col-2">
                        <input type="date" id="date_arrivee" name="date_arrivee"class="form-control" value="<?= htmlspecialchars($reservation['date_arrivee']) ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <!-- Champ Date du départ -->
                <div class="row mb-3 align-items-center">
                    <label for="date_depart" class="col-2 col-form-label text-end">Date de départ</label>
                    <div class="col-2">
                        <input type="date" id="date_depart" name="date_depart" class="form-control" value="<?= htmlspecialchars($reservation['date_depart']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="actions">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="listReservations.php" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
    <!-- Parti JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
