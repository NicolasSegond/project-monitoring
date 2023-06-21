<?php
require_once('include/connexion.php');
require_once('include/fct.php');

date_default_timezone_set('Europe/Paris');
$pdo = PdoMonitoring::getPdo();

$estConnecte = estConnecte();

if (!isset($_GET['uc'])) {
    $_GET['uc'] = 'connexion';
} else {
    if ($_GET['uc'] == "connexion" && !estConnecte()) {
        $_GET['uc'] = 'connexion';
    }
}

session_start();

/**
 * Je récupère l'uc à partir de l'url puis grâce au switch j'affiche les pages correspondante 
 * (dashboard.php étant le menu avec la partie <head></head> comprises dedans j'évite alors de le réécrire dans chaque page)
 */
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
<!-- Fermeture des balises du <body></body> ect... de dashboard.php -->
            </div>
        </div>
    </div>
</div>

<!-- intégration du javascript afin d'afficher les graphiques -->
<script>
    creerGraphiqueEtat(<?php echo $etat ?>, <?php echo $heuresEtat ?>);
</script>
<script>
    creerGraphiqueTemperature(<?php echo $data ?>, <?php echo $heures ?>, <?php echo $joursConso ?>, <?php echo $consommationJournaliere ?>);
</script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>