<?php
require_once '../config/db_connect.php';

$conn = openDatabaseConnection();
$stmt = $conn->query("SELECT * FROM clients ORDER BY id");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
closeDatabaseConnection($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>

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
    <h1>Liste des Clients</h1>
    <div class="actions">
    <a href="createClient.php" class="btn btn-success" >Ajouter un client</a>
    </div>

    <table class="table table-striped">
        <tr class="table-primary table-striped">
            <th>ID</th>
            <th>Nom</th>
            <th>Télephone</th>
            <th>E-mail</th>
            <th>Actions</th>
        </tr>
        <?php foreach($clients as $client): ?>
        <tr>
            <td><?= $client['id'] ?></td>
            <td><?= $client['nom'] ?></td>
            <td><?= $client['telephone'] ?></td>
            <td><?= $client['email'] ?></td>
            <td>
                <a href="editClient.php?id=<?= $client['id'] ?>" class="btn btn-primary"><i class="fas fa-pen"></i></a>
                <a href="deleteClient.php?id=<?= $client['id'] ?>" class="btn btn-danger" 
                    onclick="return confirm('Êtes-vous sûr?')"><i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    </div>
        <!-- Parti JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>

