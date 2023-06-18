<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring · IOT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="assets/js/script.js"></script>
    <script src="assets/js/dashboard.js"></script>
</head>

<body class="d-flex justify-content-center align-items-center">
    <div class="wrapper w-auto">
        <div class="text-center mt-4 name">
            IOT Monitoring
        </div>
        <form method="POST" action="http://localhost/testMonitoring/index.php?uc=connexion&action=valideConnexion" class="p-3 mt-3">
            <div class="form-field d-flex align-items-center">
                <input type="text" class="w-100" name="mail" id="mail" placeholder="Mail">
            </div>
            <div class="form-field d-flex align-items-center">
                <input type="password" class="w-100" name="password" id="password" placeholder="Mot de passe">
            </div>
            <button type="submit" name="submit" class="btn mt-3 w-100">Se connecter</button>
        </form>
        <div class="text-center fs-6">
            <a href="http://localhost/testMonitoring/index.php?uc=inscription&action=demandeInscription" class="fs-5 text-decoration-none text-info"> S'inscrire </a>
        </div>
    </div>
</body>

</html>