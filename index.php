<?php
require_once('include/connexion.php');
require_once('include/fct.php');

date_default_timezone_set('Europe/Paris');
$pdo = PdoMonitoring::getPdo();

// $estConnecte = estConnecte();
if (!isset($_GET['uc'])) {
    $_GET['uc'] = 'connexion';
} else {
    if ($_GET['uc'] == "connexion") {
        $_GET['uc'] = 'connexion';
    }
}

session_start();

$uc = $_GET['uc'];
switch ($uc) {
    case 'connexion':{
        include("controleurs/c_connexion.php");
        break;
    }
    case 'inscription':{
        include("controleurs/c_inscription.php");
        break;
    }
    case 'listeModule': {
            include('vues/dashboard.php');
            include("controleurs/c_listeModules.php");
            break;
        }
    case 'creationModule': {
            include('vues/dashboard.php');
            include("controleurs/c_creationModule.php");
            break;
        }
    case 'tableauBord':{
        include('vues/dashboard.php');
        include("controleurs/c_tableauBord.php");
        break;
    }
}

?>

</div>
</div>
</div>
</div>
<script>
    creerGraphiqueTemperature(<?php echo $data ?>, <?php echo $heures ?>);
</script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>