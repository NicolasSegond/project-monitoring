<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'afficherTableau';
}
$action = $_GET['action'];
switch($action){
    case 'afficherTableau':{
        $lesModulesInactifs = recupererModulesInactif($_SESSION['id']);
        $nombreModules = recupererModules($_SESSION['id'])->rowCount();
        $nombreDonnees = recupererNombreDonneesEnvoyes();
        $nombreModulesInactifs = recupererNombreModulesInactifs();
        include("vues/v_tableauBord.php");
		break;
    }
    case 'supprimerNotification':{
        supprimerNotifications($_GET['idNotification']);
        header('Location: index.php?uc=tableauBord&action=afficherTableau');
        break;
    }
}
?>