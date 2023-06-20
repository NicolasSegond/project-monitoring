<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'creerModule';
}

/**
 *  Récupération de l'action dans l'url et en fonction de l'action je lui attribue les actions a réaliser et 
 * les pages a afficher
 */
$action = $_GET['action'];
switch($action){
    case 'creerModule':{
        include("vues/v_creationModule.php");
		break;
    }
    case 'validationModule': {
        $nom = htmlspecialchars($_POST['nom']);
        $description = htmlspecialchars($_POST['description']);
        $etat = $_POST['etat'];

        if ($nom == $_POST['nom'] || $description == $_POST['description'])
        {
             $nomOK = true;
             $descriptionOK = true;
        } else{
            echo 'tentative d\'injection javascript - nom ou description refusé';
            $nomOK = false;
            $descriptionOK=false;
        }

        if ($nomOK && $descriptionOK){
            echo 'tout est ok, nous allons pouvoir enregistrer votre module...<br/>';
            $resultat = creerModule($nom, $_SESSION['id'], $description,$etat);

            if($resultat == true){
                echo "Module crée";
            } else{
                echo 'Impossible de créer le module';
            }
            header('Location: index.php?uc=listeModule&action=listeModules');
        }
        break;
    }
}
?>