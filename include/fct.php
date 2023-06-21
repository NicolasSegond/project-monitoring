<?php

require_once('connexion.php');

/**
 * Fonction qui crée un utilisateur à partir de son nom, prénom, mail et mot de passe
 *
 * @param [text] $nom
 * @param [text] $prenom
 * @param [text] $email
 * @param [text] $mdp
 * @return void
 */
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

/**
 * Fonction qui récupère le mot de passe du mail rentré en paramètre
 *
 * @param [text] $login
 * @return void
 */
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

/**
 * fonction qui récupère les informations tel que l'id, le nom, le prénom et le mail de l'utilisateur dont le login est 
 * rentré en paramètre
 *
 * @param [text] $login
 * @return array
 */
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
 * teste si l'utilisateur est connecté ou non
 *
 * @return Boolean
 */
function estConnecte()
{
    return isset($_SESSION['id']);
}

/**
 * Enregistre dans des variables de session les informations de l'utilisateur qui s'est connécté
 *
 * @param [int] $id
 * @param [text] $nom
 * @param [text] $prenom
 * @return void
 */
function connecter($id, $nom, $prenom)
{
    $_SESSION['id'] = $id;
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
}

/**
 * Fonction qui récupère l'ensemble des modules de l'utilisateur dont l'id est rentré en paramètre
 *
 * @param [int] $id
 */
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

/**
 * Fonction qui crée un module à partir des informations rentrés en paramètre
 *
 * @param [text] $nom
 * @param [int] $idUtilisateur
 * @param [text] $description
 * @param [text] $etat
 * @return void
 */
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

/**
 * Fonction qui récupère les infos du modules dont l'id est rentré en paramètre
 *
 * @param [int] $id
 * @return Array
 */
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

/**
 * Fonction qui récupère les 10 dernières températures du modules dont l'id est rentré en paramètre et les stocke 
 * dans un tableau
 *
 * @param [int] $id
 * @return Array
 */
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

/**
 * Fonction qui récupère les modules inactifs de l'utilisateur dont l'id est rentré en paramètre 
 *
 * @param [int] $idUtilisateur
 * @return Object
 */
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

/**
 * Recupère le nombre de données envoyés au total par les modules
 *
 * @return Array
 */
function recupererNombreDonneesEnvoyes($id)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("SELECT Count(Mesure) FROM historique INNER JOIN modules ON modules.ID = historique.ID_Module WHERE ID_utilisateur = :id");
    $monObjPdoStatement->BindValue('id', $id);
    if ($monObjPdoStatement->execute()) {
        $nombreDonnees = $monObjPdoStatement->fetch();
    } else {
        throw new Exception(" Erreur dans la récupération des données");
    }
    return $nombreDonnees;
}

/**
 * Recupère le nombre de modules inactifs
 *
 * @return void
 */
function recupererNombreModulesInactifs($id)
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("SELECT Count(ID) FROM Modules WHERE Etat = 'Inactif' AND ID_utilisateur = :id;");
    $monObjPdoStatement->BindValue('id', $id);
    if ($monObjPdoStatement->execute()) {
        $nombreDonnees = $monObjPdoStatement->fetch();
    } else {
        throw new Exception(" Erreur dans la récupération des données");
    }
    return $nombreDonnees;
}

/**
 * Supprimer la notification en modifiant la colonne archiver à 1 du module dont l'id est entré en paramètre
 *
 * @param [int] $id
 * @return void
 */
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

/**
 * Recupère le nombre de modules inactifs par heure
 *
 * @return Array
 */
function dixDerniersModulesInactifs()
{
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("
    SELECT DATE_FORMAT(date, '%Y-%m-%d') AS jour, DATE_FORMAT(date, '%H:%i') AS heure, COUNT(*) AS nombre_modules_inactifs
    FROM historique
    INNER JOIN modules
    ON modules.ID = historique.ID_Module
    WHERE historique.etat = 'Inactif' AND ID_utilisateur = 1
    GROUP BY jour, heure 
    ORDER BY date DESC
    LIMIT 10;");
    if ($monObjPdoStatement->execute()) {
        $resultats = $monObjPdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $heures = array(); // Tableau pour stocker les heures
        $mesures = array(); // Tableau pour stocker les mesures

        foreach ($resultats as $resultat) {
            $heures[] = $resultat['heure'];
            $etat[] = $resultat['nombre_modules_inactifs'];
        }

        $donneesTemperature = array(
            'heuresEtat' => $heures,
            'etat' => $etat
        );

        return $donneesTemperature;
    } else {
        throw new Exception(" Erreur dans la récupération des données ");
    }
}

/**
 * Recupère la consommation journalière du module dont l'id est entré en paramètre
 *
 * @param [int] $id
 * @return Array
 */
function consommationParJour($id){
    $pdo = PdoMonitoring::getPdo();
    $monObjPdoStatement = $pdo->prepare("
    SELECT ID_Module, DATE_FORMAT(date, '%Y-%m-%d') AS jour, SUM(consommation) AS consommation_journaliere
    FROM historique
    WHERE ID_Module = :id
    GROUP BY jour
    ORDER BY Date;");
    $monObjPdoStatement->BindValue('id',$id);
    if ($monObjPdoStatement->execute()) {
        $resultats = $monObjPdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $jours = array(); // Tableau pour stocker les heures
        $conso = array(); // Tableau pour stocker les mesures

        foreach ($resultats as $resultat) {
            $jours[] = $resultat['jour'];
            $conso[] = $resultat['consommation_journaliere'];
        }

        $donneesTemperature = array(
            'jours' => $jours,
            'conso' => $conso
        );

        return $donneesTemperature;
    } else {
        throw new Exception(" Erreur dans la récupération des données");
    }
}
