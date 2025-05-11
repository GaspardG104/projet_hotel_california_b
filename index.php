<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion d'Hôtel</title>
    <!-- Partie Font-Aweson-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"rel="stylesheet">

    <!-- Partie Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

     <style>
        body {
            background-image: url('hotel-california.jpg');
            background-size: cover; 
            background-repeat: no-repeat; 
            }
        /*parti générer par IA pour le titre par ce que j'avais un peu la flemme de tout chercher he he he. Mais j'ai quand même remodifier des trucs pck c'était nul*/
            .titre-custom {
                font-size: 4rem; /* Agrandir le texte */ /*je connaissais pas cette unité de mesure*/
                color: rgb(204, 109, 25); /* Couleur du texte */
                text-shadow: 5px 5px 4px black;
                padding: 10px; /* Espacement intérieur */
    
            }


    </style>
</head>
<body>
        <h1 class="text-center titre-custom">Système de Gestion de l'Hôtel California</h1>
    <div class="container mt-3 col-2">
        <div class="row mb-3 align-items-center">
            <a href="chambres/listChambres.php" class="btn btn-secondary btn-lg">Gestion des Chambres</a>
        </div>
        <div class="row mb-3 align-items-center">
            <a href="clients/listClients.php" class="btn btn-secondary btn-lg">Gestion des Clients</a>
        </div>
        <div class="row mb-3 align-items-center">
            <a href="reservations/listReservations.php" class="btn btn-secondary btn-lg">Gestion des Réservations</a>
        </div>

        <!--Malheuresement, la musique automatique est bloquer mtn sur les navigateurs webs... -->
        <div class="row mb-3 align-items-center">
            <a href="https://youtu.be/dLl4PZtxia8?si=MFFo9x_qfVu1FcHg" class="btn btn-dark"><i class="fa-solid fa-music"></i></a>
        </div>
    </div>
    
</body> 

<!-- Parti JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</html>
