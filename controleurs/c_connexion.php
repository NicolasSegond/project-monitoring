<?php

if (!isset($_GET['action'])) {
    $_GET['action'] = 'demandeConnexion';
}

/**
 *  Récupération de l'action dans l'url et en fonction de l'action je lui attribue les actions a réaliser et 
 * les pages a afficher
 */
$action = $_GET['action'];
switch ($action) {
    case 'demandeConnexion': {
            include('vues/login.php');
            break;
        }
    case 'valideConnexion': {
            $mail = $_POST['mail'];
            $mdp = $_POST['password'];
            $hashMdp = recupererMDP($mail);
            if ($hashMdp == true) {
                $connexionOK = password_verify($mdp, $hashMdp[0]);
                if (!$connexionOK) {
                    $msg = 'Login ou mot de passe incorrect !';
                    include('vues/login.php');
                } else {
                    $infosUtilisateur = donneUtilisateurByMail($mail);
                    $id = $infosUtilisateur['id'];
                    $nom =  $infosUtilisateur['nom'];
                    $prenom = $infosUtilisateur['prenom'];
                    connecter($id, $nom, $prenom);
                    header('Location: index.php?uc=tableauBord&action=afficherTableau');
                }
            } else{
                $msg = 'Login incorrect';
                include('vues/login.php');
            }
            break;
        }
    case 'deconnexion':{
        session_destroy();
        include('vues/login.php');
        break;
    }
}
