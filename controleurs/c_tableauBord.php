<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'afficherTableau';
}

/**
 *  Récupération de l'action dans l'url et en fonction de l'action je lui attribue les actions a réaliser et 
 * les pages a afficher
 */
$action = $_GET['action'];
switch($action){
    case 'afficherTableau':{
        $lesModulesInactifs = recupererModulesInactif($_SESSION['id']);
        $nombreModules = recupererModules($_SESSION['id'])->rowCount();
        $nombreDonnees = recupererNombreDonneesEnvoyes();
        $nombreModulesInactifs = recupererNombreModulesInactifs();

        $graphiqueEtat = dixDerniersModulesInactifs();
        $heuresEtat = json_encode(array_reverse($graphiqueEtat['heuresEtat']));
        $etat = json_encode($graphiqueEtat['etat']);

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