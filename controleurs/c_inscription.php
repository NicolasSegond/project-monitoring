<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeInscription';
}

/**
 *  Récupération de l'action dans l'url et en fonction de l'action je lui attribue les actions a réaliser et 
 * les pages a afficher
 */
$action = $_GET['action'];
switch($action){
    case 'demandeInscription':{
        include('vues/register.php');
        break;
    }
    case 'inscriptionValider':{
        $leNom = htmlspecialchars($_POST['nom']);
        $lePrenom = htmlspecialchars($_POST['prenom']);
        $leLogin = htmlspecialchars($_POST['mail']);
        $lePassword = htmlspecialchars($_POST['password']);
        $lePasswordHash = password_hash($lePassword, PASSWORD_DEFAULT);
        
        
        if ($leLogin == $_POST['mail'])
        {
             $loginOk = true;
             $passwordOk=true;
        }
        else{
            $msg = 'tentative d\'injection javascript - login refusé';
             $loginOk = false;
             $passwordOk=false;
        }

        $rempli=false;
        if ($loginOk && $passwordOk){
        //obliger l'utilisateur à saisir login/mdp
        $rempli=true; 
        if (empty($leLogin)==true) {
            $msg = 'Le login n\'a pas été saisi<br/>';
            $rempli=false;
        }
        if (empty($lePassword)==true){
            $msg = 'Le mot de passe n\'a pas été saisi<br/>';
            $rempli=false; 
        }
        
        
        //si le login et le mdp contiennent quelque chose
        // on continue les vérifications
        if ($rempli){
            //supprimer les espaces avant/après saisie
            $leLogin = trim($leLogin);
            $lePassword = trim($lePassword);
            
            //vérification du format du login
           if (!filter_var($leLogin, FILTER_VALIDATE_EMAIL)) {
                $msg = 'le mail n\'a pas un format correct<br/>';
                $loginOk=false;
            }
            
          
            $patternPassword='#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W){12,}#';
            if (preg_match($patternPassword, $lePassword)==false){
                $msg = 'Le mot de passe doit contenir au moins 12 caractères, une majuscule,'
                . ' une minuscule et un caractère spécial<br/>';
                $passwordOk=false;
            }
        }
        }
        if($rempli && $loginOk && $passwordOk){
                $msg = 'tout est ok, nous allons pouvoir créer votre compte...<br/>';
                $executionOK = creeUtilisateur($leNom, $lePrenom, $leLogin,$lePasswordHash);       
               
                if ($executionOK==true){
                    $msg = "c'est bon, votre compte a bien été créé ;-)";
                    include("vues/login.php");
                }   
                else
                     $msg = "ce login existe déjà, veuillez en choisir un autre";
            }
        break;	
    }
    
}
?>