<?php

require_once('connexion.php');

function creeUtilisateur($nom, $prenom, $email, $mdp)
{
    $pdo = PdoMonitoring::getPdo();
    $pdoStatement = $pdo->prepare("INSERT INTO utilisateur(id, nom, prenom, mail, motDePasse) "
        . "VALUES (null, :leNom, :lePrenom, :leMail, :leMdp)");
    $pdoStatement->bindValue(':leNom', $nom);
    $pdoStatement->bindValue(':lePrenom', $prenom);
    $pdoStatement->bindValue(':leMail', $email);
    $pdoStatement->bindValue(':leMdp', $mdp);
    $execution = $pdoStatement->execute();
    return $execution;
}

function recupererMDP($login)
{
    $pdo = PdoMonitoring::getPdo();
    $req = $pdo->prepare("SELECT motDePasse FROM utilisateur WHERE mail = :login");
    $req->BindValue(":login", $login);
    if ($req->execute()) {
        $resultat = $req->fetch();
    } else {
        throw new Exception("erreur");
    }
    return $resultat;
}

function donneUtilisateurByMail($login)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("SELECT id, nom, prenom, mail FROM utilisateur WHERE mail= :login");
    $monObjPdoStatement->bindValue(':login', $login, PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser = $monObjPdoStatement->fetch();
    } else
        throw new Exception("erreur dans la requète");
    return $unUser;
}

/**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
 */
function estConnecte()
{
    return isset($_SESSION['id']);
}

/**
 * Enregistre dans une variable session les infos d'un visiteur
 
 * @param $id 
 * @param $nom
 * @param $prenom
 */
function connecter($id, $nom, $prenom)
{
    $_SESSION['id'] = $id;
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
}

function recupererModules($id)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("SELECT id, Nom, Description, DateInstallation, DerniereMiseAJour, Etat FROM modules WHERE ID_utilisateur = :id");
    $monObjPdoStatement->bindValue(':id', $id);
    if ($monObjPdoStatement->execute()) {
        $modules = $monObjPdoStatement;
    } else {
        throw new Exception(" Erreur dans la récupération des données ");
    }
    return $modules;
}

function creerModule($nom, $idUtilisateur, $description, $etat)
{
    $monObjPdoStatement = PdoMonitoring::getPdo()->prepare("INSERT INTO modules(ID, ID_utilisateur, Nom, Description, DateInstallation, DerniereMiseAJour, Etat) "
        . "VALUES (null, :idUtil, :leNom, :laDescription, now(), now(), :etat )");
    $monObjPdoStatement->bindValue(':leNom', $nom);
    $monObjPdoStatement->bindValue(':idUtil', $idUtilisateur);
    $monObjPdoStatement->bindValue(':laDescription', $description);
    $monObjPdoStatement->bindValue(':etat', $etat);
    $execution = $monObjPdoStatement->execute();
    return $execution;
}

function recupererInfosModules($id)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("
    SELECT Nom, DerniereMiseAJour, Modules.Etat, Mesure
    FROM modules
    INNER JOIN historique ON modules.ID = historique.ID_Module
    WHERE Modules.ID = :id
    ORDER BY historique.Date DESC
    LIMIT 1;");
    $monObjPdoStatement->bindValue(':id', $id);
    if ($monObjPdoStatement->execute()) {
        $modules = $monObjPdoStatement->fetch();
    } else {
        throw new Exception(" Erreur dans la récupération des données ");
    }
    return $modules;
}

function recupererTemperature($id)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("
    SELECT DATE_FORMAT(date, '%Y-%m-%d') AS jour, DATE_FORMAT(date, '%H:%i') AS heure, Mesure
    FROM historique
    WHERE ID_Module = :id
    ORDER BY date DESC
    LIMIT 10;");
    $monObjPdoStatement->bindValue(':id', $id);
    if ($monObjPdoStatement->execute()) {
        $resultats = $monObjPdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $heures = array(); // Tableau pour stocker les heures
        $mesures = array(); // Tableau pour stocker les mesures

        foreach ($resultats as $resultat) {
            $heures[] = $resultat['heure'];
            $mesures[] = $resultat['Mesure'];
        }

        $donneesTemperature = array(
            'heures' => $heures,
            'mesures' => $mesures
        );

        return $donneesTemperature;
    } else {
        throw new Exception(" Erreur dans la récupération des données ");
    }
}

function recupererModulesInactif($idUtilisateur)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("SELECT historique.ID, Nom, Date, Mesure, historique.etat FROM historique INNER JOIN modules ON modules.ID = historique.ID_Module WHERE historique.etat = 'Inactif' AND archiver = 0 AND ID_utilisateur = :idUtil ORDER BY Date DESC LIMIT 20;");
    $monObjPdoStatement->bindValue(':idUtil', $idUtilisateur);
    if ($monObjPdoStatement->execute()) {
        $modulesInactifs = $monObjPdoStatement;
    } else {
        throw new Exception(" Erreur dans la récupération des données");
    }
    return $modulesInactifs;
}

function recupererNombreDonneesEnvoyes()
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("SELECT Count(Mesure) FROM historique");
    if ($monObjPdoStatement->execute()) {
        $nombreDonnees = $monObjPdoStatement->fetch();
    } else {
        throw new Exception(" Erreur dans la récupération des données");
    }
    return $nombreDonnees;
}

function recupererNombreModulesInactifs()
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("SELECT Count(ID) FROM Modules WHERE Etat = 'Inactif';");
    if ($monObjPdoStatement->execute()) {
        $nombreDonnees = $monObjPdoStatement->fetch();
    } else {
        throw new Exception(" Erreur dans la récupération des données");
    }
    return $nombreDonnees;
}

function supprimerNotifications($id)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("UPDATE historique SET archiver = 1 WHERE ID = :id");
    $monObjPdoStatement->bindValue(':id', $id);
    if ($monObjPdoStatement->execute()) {
        $nombreDonnees = $monObjPdoStatement;
    } else {
        throw new Exception(" Erreur dans la suppression des données");
    }
    return $nombreDonnees;
}
