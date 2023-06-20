<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'listeModules';
}

/**
 *  Récupération de l'action dans l'url et en fonction de l'action je lui attribue les actions a réaliser et 
 * les pages a afficher
 */
$action = $_GET['action'];
switch($action){
    case 'listeModules':{
        $id = $_SESSION['id'];
        $lesModules = recupererModules($id);
        include("vues/v_listeModules.php");
		break;
    }
    case 'detailsModule':{
        $idModule = $_GET['id'];
        $module = recupererInfosModules($idModule);

        $temp = recupererTemperature($idModule);
        $heures = json_encode(array_reverse($temp['heures']));
        $data = json_encode($temp['mesures']);

        $consommation = consommationParJour($idModule);
        $joursConso = json_encode($consommation['jours']);
        $consommationJournaliere = json_encode($consommation['conso']);
        
        include("vues/detailsModule.php");
        break;
    }
}
?>