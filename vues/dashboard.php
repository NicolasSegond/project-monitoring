<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Monitoring · IOT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="assets/js/script.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0 bg-primary position-fixed h-100 responsive-fixed">
                <div class="d-flex justify-content-center align-items-center p-4 border-bottom border-light border-opacity-50">
                    <h5 class="mb-0 text-light">IOT Monitoring</h5>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="http://localhost/projet-monitoring/index.php?uc=tableauBord&action=afficherTableau" class="nav-link text-light">
                            <i class="bi bi-card-text"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="http://localhost/projet-monitoring/index.php?uc=listeModule&action=listeModules"> <i class="bi bi-pie-chart"></i> Liste modules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="http://localhost/projet-monitoring/index.php?uc=creationModule&action=creerModule"><i class="bi bi-plus-circle"></i> Ajouter un module</a>
                    </li>

                </ul>
            </div>

            <!-- Contenu principal -->
            <div class="col-md-10 content p-1 h-100 position-absolute end-0 responsive-absolute">
                <nav class="navbar navbar-expand-lg bg-light w-100" style="height: 73px; border-bottom: 1px solid rgba(0,0,0,.1);">
                    <div class="container-fluid d-flex justify-content-center align-items-center">
                        <span class="fs-5 text-secondary">Dashboard</span>
                        <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarCollapse">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="link-dark" href="#">Deconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>