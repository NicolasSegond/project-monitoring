<div class="rounded-4 bg-white m-4 shadow d-flex justify-content-center align-items-center">
    <div class="rounded-4 bg-danger w-25 h-75 shadow m-4 d-flex flex-column justify-content-center align-items-center p-4">
        <p class=" text-white fs-5 mb-0"> Nom du module</p>
        <p class=" text-white fs-2 mb-0"> <?php echo $module['Nom'] ?> </p>
    </div>
    <div class="rounded-4 bg-success w-25 h-75 shadow m-4 d-flex flex-column justify-content-center align-items-center p-4">
        <p class=" text-white fs-5 mb-0"> Etat du module </p>
        <p class=" text-white fs-2 mb-0"> <?php echo $module['Etat'] ?> </p>
    </div>
    <div class="rounded-4 bg-warning w-25 h-75 shadow m-4 d-flex flex-column justify-content-center align-items-center p-4">
        <p class=" text-white fs-5 mb-0"> Température actuelle </p>
        <p class=" text-white fs-2 mb-0"> <?php echo $module['Mesure'] ?> </p>
    </div>
    <div class="rounded-4 bg-info w-25 h-75 shadow m-4 d-flex flex-column justify-content-center align-items-center p-3">
        <p class=" text-white text-center fs-5 mb-0"> Dernière mise à jour du module </p>
        <p class=" text-white fs-5 mb-0"> <?php echo $module['DerniereMiseAJour'] ?> </p>
    </div>
</div>
<div class="d-flex justify-content-center align-items-center mb-2">
    <div class="rounded-4 bg-white w-50 h-75 m-4 shadow d-flex justify-content-center align-items-center">
        <canvas id="myChart" class="w-100 h-100 p-4"></canvas>
    </div>
    <div class="rounded-4 bg-white w-50 h-100 m-4 shadow d-flex justify-content-center align-items-center">
        test
    </div>
</div>

<div class="d-flex justify-content-center align-items-center mb-2">
    <div class="rounded-4 bg-white w-50 h-75 m-4 shadow d-flex justify-content-center align-items-center">
        <canvas id="myChart" class="w-100 h-100 p-4"></canvas>
    </div>
    <div class="rounded-4 bg-white w-50 h-75 m-4 shadow d-flex justify-content-center align-items-center">
        
    </div>
</div>



