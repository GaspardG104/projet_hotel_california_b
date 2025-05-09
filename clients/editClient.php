<?php
// Inclusion du fichier de connexion à la base de données
require_once '../config/db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérifier si l'ID est valide
if ($id <= 0) {
    header("Location: listClients.php");
    exit;
}

$conn = openDatabaseConnection();

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $nombre_personnes = $_POST['nombre_personnes'];
    
    
    // Validation des données
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom du client est obligatoire.";
    }
    
    if ($telephone <= 0) {
        $errors[] = "Le téléphone doit être renseigner.";
    }
    
    if (empty($email)) {
        $errors[] = "L'adresse e-mail est obligatoire.";
    }

    if ($nombre_personnes <= 0) {
        $errors[] = "Le nombre de personnes doit être renseigner.";
    }

    // Si pas d'erreurs, mettre à jour les données
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE clients SET nom= ?, telephone = ?, email = ?, nombre_personnes = ? WHERE id = ?");
        $stmt->execute([$nom, $telephone, $email, $nombre_personnes, $id]);
        
        // Rediriger vers la liste des clients
        header("Location: listClients.php?success=1");
        exit;
    }
} else {
    // Récupérer les données du client
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si le client n'existe pas, rediriger
    if (!$client) {
        header("Location: listClients.php");
        exit;
    }
}

closeDatabaseConnection($conn);
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Modifier un Client</title>
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
        <h1>Modifier un Client</h1>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error-message">
                <?php foreach($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="nom">Nom du Client:</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="telephone">Numéro de téléphone:</label>
                <input type="number" id="telephone" name="telephone" value="<?= $client['telephone'] ?>" min="1" required>
            </div>

            <div class="form-group">
                <label for="telephone">Adresse e-mail:</label>
                <input type="text" id="email" name="email" value="<?= $client['email'] ?>" min="1" required>
            </div>

            <div class="form-group">
                <label for="nombre_personnes">Nombre de personnes:</label>
                <input type="number" id="nombre_personnes" name="nombre_personnes" value="<?= $client['nombre_personnes'] ?>" min="1" required>
            </div>
            
            <div class="actions">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="listClients.php" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
    <!-- Parti JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
