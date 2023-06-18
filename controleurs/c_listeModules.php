<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'listeModules';
}
$action = $_GET['action'];
switch($action){
    case 'listeModules':{
        $id = $_SESSION['id'];
        $lesModules = recupererModules($id);
        var_dump($id);
        include("vues/v_listeModules.php");
		break;
    }
    case 'detailsModule':{
        $idModule = $_GET['id'];
        $module = recupererInfosModules($idModule);
        $temp = recupererTemperature($idModule);
        $heures = json_encode($temp['heures']);
        $data = json_encode($temp['mesures']);
        include("vues/detailsModule.php");
        break;
    }
}
?>