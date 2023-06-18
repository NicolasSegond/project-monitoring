<div class="d-flex h-100 max-height">
    <div class="d-flex flex-column w-75 m-4">
        <div class="rounded-4 bg-white shadow d-flex justify-content-center align-items-center w-100 h-25">
            <div class="rounded-4 bg-danger w-25 h-75 shadow m-4 d-flex flex-column justify-content-center align-items-center py-2">
                <p class=" text-white fs-6 mb-0 text-center"> Nombre de modules </p>
                <p class=" text-white fs-2 mb-0"> <?php echo $nombreModules ?> </p>
            </div>
            <div class="rounded-4 bg-success w-25 h-75 shadow m-4 d-flex flex-column align-items-center py-2">
                <p class=" text-white fs-6 mb-0 text-center"> Nombre de données envoyés </p>
                <p class=" text-white fs-2 mb-0"> <?php echo $nombreDonnees[0] ?> </p>
            </div>
            <div class="rounded-4 bg-warning w-25 h-75 shadow m-4 d-flex flex-column align-items-center py-1">
                <p class=" text-white fs-6 mb-0 text-center"> Nombre de modules inactifs actuellement </p>
                <p class=" text-white fs-2 mb-0"> <?php echo $nombreModulesInactifs[0] ?> </p>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center w-100 h-75">
            <div class="rounded-4 bg-light w-50 h-75 shadow me-3 d-flex flex-column align-items-center p-2">
                <span> test</span>
            </div>
            <div class="rounded-4 bg-light w-50 h-75 shadow ms-3 d-flex flex-column align-items-center p-2">

            </div>
        </div>
    </div>
    <div class="rounded-4 bg-white m-4 shadow w-auto h-100 overflow-auto">
        <p class="text-primary fw-bolder fs-3 m-2 text-start"> Notifications </p>
        <?php if ($lesModulesInactifs->rowCOunt() > 0) {
            while ($modulesInactifs = $lesModulesInactifs->fetch()) { ?>
                <div class="rounded-4 bg-primary mb-4 mx-3 shadow d-flex flex-column w-80 h-25 alert alert-dismissible fade show">
                    <div class="d-flex">
                        <p class="text-white fs-6 m-2 text-start"> <?php echo $modulesInactifs['Nom'] ?></p>
                        <p class="text-white fs-6 m-2 text-end"> <?php echo $modulesInactifs['Date'] ?> </p>
                    </div>
                    <p class="text-white fs-6 ms-2 mb-0 text-start"> Température : <?php echo $modulesInactifs['Mesure'] ?> °C</p>
                    <div class="d-flex align-items-center mb-2">
                        <div class="rond rouge ms-2" id='boule1'></div>
                        <p class="text-white fs-6 ms-1 mb-0 text-start"> <?php echo $modulesInactifs['etat'] ?> </p>
                    </div>
                    <form method="POST" action="http://localhost/projet-monitoring/index.php?uc=tableauBord&action=supprimerNotification&idNotification=<?php echo $modulesInactifs['ID'] ?>">
                        <button type="submit" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </form>
                </div>
                
        <?php }
        } else {
            echo "<h4 class='m-2'> Vous n'avez plus de notifications </h4>";
        }
        ?>
    </div>
</div>