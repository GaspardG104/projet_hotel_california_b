
<?php
require_once '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $nombre_personnes = $_POST['nombre_personnes'];
    
    $conn = openDatabaseConnection();
    $stmt = $conn->prepare("INSERT INTO clients (nom, telephone, email, nombre_personnes) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $telephone, $email, $nombre_personnes]);
    closeDatabaseConnection($conn);
    
    header("Location: listClients.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajouter un Client</title>
    <!-- Partie Font-Aweson-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"rel="stylesheet">

    <!-- Partie Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

</head>
<body>
<?php include '../assets/navbar.php'; ?>
    <h1>Ajouter une Client</h1>
    <div class="container mt-3">
    <form method="post">
        <div class="row mb-3 align-items-center">
            <label for="capacite" class="col-2 col-form-label text-end">Nom:</label>
            <div class="col-4  align-items-center">
                <input type="text" class="form-control" name="nom" required>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <label for="capacite" class="col-2 col-form-label text-end">Téléphone:</label>
            <div class="col-4  align-items-center">
                <input type="number" class="form-control" name="telephone" required>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <label for="capacite" class="col-2 col-form-label text-end">E-mail:</label>
            <div class="col-4  align-items-center">
                <input type="text" class="form-control" name="email" required>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <label for="capacite" class="col-2 col-form-label text-end">Nombre personnes:</label>
            <div class="col-4  align-items-center">
                <input type="text" class="form-control" name="nombre_personnes" required>
            </div>
        </div>
        <div class="row">
            <div class="col-2 text-end">
                <!-- Bouton de retour -->
                <a href="listClients.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
            <div class="col-4 text-end">
                <!-- Bouton validation -->
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>

    </form>
    <!-- Parti JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
