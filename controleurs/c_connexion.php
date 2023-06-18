<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeConnexion';
}

$action = $_GET['action'];
switch($action){
    case 'demandeConnexion':{
        include('vues/login.php');
        break;
    }
    case 'valideConnexion':{
        $mail = $_POST['mail'];
        $mdp = $_POST['password'];
        $hashMdp = recupererMDP($mail);
        $connexionOK = password_verify($mdp, $hashMdp[0]);
        if(!$connexionOK){
			echo 'Login ou mot de passe incorrect !';
			include("vues/v_connexion.php");
		}
		else {
            $infosUtilisateur = donneUtilisateurByMail($mail);
			$id = $infosUtilisateur['id'];
			$nom =  $infosUtilisateur['nom'];
			$prenom = $infosUtilisateur['prenom'];
			connecter($id,$nom,$prenom);                       
            header('Location: index.php?uc=tableauBord&action=afficherTableau');
        }

			break;	
    }
}
?>