<?php

/**
 * Classe d'accÃ¨s aux donnÃ©es. 

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */
class PdoGsb
{

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gsbExtranet2';
    private static $user = 'gsb';
    private static $mdp = 'gsb';
    private static $monPdo;
    private static $monPdoGsb = null;

    /**
     * Constructeur privÃ©, crÃ©e l'instance de PDO qui sera sollicitÃ©e
     * pour toutes les mÃ©thodes de la classe
     */
    private function __construct()
    {

        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function _destruct()
    {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crÃ©e l'unique instance de la classe

     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();

     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb()
    {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * vÃ©rifie si le login et le mot de passe sont corrects
     * renvoie true si les 2 sont corrects
     * @param type $lePDO
     * @param type $login
     * @param type $pwd
     * @return bool
     * @throws Exception
     */
    function checkUser($login, $pwd): bool
    {
        //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
        $user = false;
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT motDePasse FROM medecin WHERE mail= :login AND token IS NULL");
        $bvc1 = $monObjPdoStatement->bindValue(':login', $login, PDO::PARAM_STR);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
            if (is_array($unUser)) {
                if ($pwd == $unUser['motDePasse'])
                    $user = true;
            }
        } else
            throw new Exception("erreur dans la requÃªte");
        return $user;
    }

    function donneLeMedecinByMail($login)
    {

        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT id, nom, prenom,mail FROM medecin WHERE mail= :login");
        $bvc1 = $monObjPdoStatement->bindValue(':login', $login, PDO::PARAM_STR);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
        } else
            throw new Exception("erreur dans la requÃªte");
        return $unUser;
    }

    public function tailleChampsMail()
    {
        $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'medecin' AND COLUMN_NAME = 'mail'");
        $execution = $pdoStatement->execute();
        $leResultat = $pdoStatement->fetch();

        return $leResultat[0];
    }

    public function creeMedecin($email, $mdp)
    {

        $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse,dateCreation,dateConsentement) "
            . "VALUES (null, :leMail, :leMdp, now(),now())");
        $bv1 = $pdoStatement->bindValue(':leMail', $email);

        $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
        $execution = $pdoStatement->execute();
        return $execution;
    }

    function testMail($email)
    {
        $pdo = PdoGsb::$monPdo;
        $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM medecin WHERE mail = :leMail");
        $bv1 = $pdoStatement->bindValue(':leMail', $email);
        $execution = $pdoStatement->execute();
        $resultatRequete = $pdoStatement->fetch();
        if ($resultatRequete['nbMail'] == 0)
            $mailTrouve = false;
        else
            $mailTrouve = true;

        return $mailTrouve;
    }

    function connexionInitiale($mail)
    {
        $pdo = PdoGsb::$monPdo;
        $medecin = $this->donneLeMedecinByMail($mail);
        $id = $medecin['id'];
        $this->ajouteConnexionInitiale($id);
    }

    function ajouteConnexionInitiale($id)
    {
        $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(), null)");
        $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
        $execution = $pdoStatement->execute();
        return $execution;
    }

    function donneinfosmedecin($id)
    {

        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT id,nom,mail,prenom FROM medecin WHERE id= :lId");
        $bvc1 = $monObjPdoStatement->bindValue(':lId', $id, PDO::PARAM_INT);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
        } else {
            throw new Exception("erreur");
        }
        return $unUser;
    }

    function changeinfosmedecin($nouveauEmail, $nouveauNom, $prenom, $motdepasse)
    {
        $sql = "UPDATE medecin SET mail = :email, nom = :nom, prenom = :prenom, motdepasse = :motdepasse WHERE id = :id";
        $query = PdoGsb::$monPdo->prepare($sql);
        $execution = $query->execute(array(
            'email' => $nouveauEmail,
            'nom' => $nouveauNom,
            'prenom' => $prenom,
            'motdepasse' => $motdepasse,
            'id' => $_SESSION['id']
        ));
        return $execution;
    }

    function verificationValeurs()
    {
        $sql = "SELECT mail, nom, prenom, motdepasse FROM medecin WHERE id = :id";
        $query = PdoGsb::$monPdo->prepare($sql);
        $execution = $query->execute(array(
            'id' => $_SESSION['id']
        ));
        $unUser = $query->fetch();
        return $unUser;
    }

    function ajouteDeconnexion($id)
    {
        $sql = "UPDATE historiqueconnexion SET dateFinLog = now() WHERE idMedecin = :id AND dateFinLog IS NULL";
        $query = PdoGsb::$monPdo->prepare($sql);
        $query->execute(array(
            'id' => $id
        ));
    }

    function supprimerMedecin($id)
    {
        $pdoStatement1 = PdoGsb::$monPdo->prepare("DELETE FROM historiqueconnexion WHERE idMedecin = :id");
        $bv1 = $pdoStatement1->bindValue(':id', $id);
        $pdoStatement2 = PdoGsb::$monPdo->prepare("DELETE FROM medecinvisio WHERE idMedecin = :id");
        $bv2 = $pdoStatement2->bindValue(':id', $id);
        $pdoStatement3 = PdoGsb::$monPdo->prepare("DELETE FROM medecinproduit WHERE idMedecin = :id");
        $bv3 = $pdoStatement3->bindValue(':id', $id);
        $pdoStatement4 = PdoGsb::$monPdo->prepare("DELETE FROM medecin WHERE id = :id");
        $bv4 = $pdoStatement4->bindValue(':id', $id);
        $executionOk1 = $pdoStatement1->execute();
        $executionOk2 = $pdoStatement2->execute();
        $executionOk3 = $pdoStatement3->execute();
        $executionOk4 = $pdoStatement4->execute();
    }

    function recupererIDArchivage(){
        $pdoStatement = PdoGsb::$monPdo->prepare("SELECT MAX(id) FROM archivagemedecin");
        $pdoStatement->execute();
        $id = $pdoStatement->fetch();
        return $id[0];
    }

    function archivageMedecin($id){
        $pdoStatement1 = PdoGsb::$monPdo->prepare("SELECT dateNaissance, dateCreation FROM medecin WHERE id=:id");
        $pdoStatement1->BindValue(':id', $id);
        $pdoStatement1->execute();
        $informations = $pdoStatement1->fetch();


        $pdoStatement2 = PdoGsb::$monPdo->prepare("INSERT INTO archivagemedecin VALUES(null, :dateNaiss, :dateCreation, now())");
        $pdoStatement2->BindValue(":dateNaiss", $informations[0]);
        $pdoStatement2->BindValue(":dateCreation", $informations[1]);
        $pdoStatement2->execute();
    }

   function archivageMedecinProduit($id){
        $req = PdoGsb::$monPdo->prepare("SELECT idProduit, Date, Heure FROM medecinproduit WHERE idMedecin = :id");
        $req->BindValue(':id', $id);
        $req->execute();
        $infos = $req->fetchAll();

        foreach($infos as $infosProduit){
            $pdoStatement2 = PdoGsb::$monPdo->prepare("INSERT INTO archivagemedecinproduit VALUES(:idMedecin, :idProduit, :Date, :Heure)");
            $pdoStatement2->BindValue(":idMedecin",$this->recupererIDArchivage());
            $pdoStatement2->BindValue(":idProduit", $infosProduit[0]);
            $pdoStatement2->BindValue(":Date", $infosProduit[1]);
            $pdoStatement2->BindValue(":Heure", $infosProduit[2]);
            $pdoStatement2->execute();   
        }
   }

   function archiverMedecinVisio($id){
        $req = PdoGsb::$monPdo->prepare("SELECT idVisio, dateInscription FROM medecinvisio WHERE idMedecin=:id");
        $req->BindValue(':id', $id);
        $req->execute();
        $infos = $req->fetchAll();

        foreach($infos as $infosVisio){
            $pdoStatement2 = PdoGsb::$monPdo->prepare("INSERT INTO archivagemedecinvisio VALUES(:idMedecin, :idVisio, :dateInscription)");
            $pdoStatement2->BindValue(":idMedecin",$this->recupererIDArchivage());
            $pdoStatement2->BindValue(":idVisio", $infosVisio[0]);
            $pdoStatement2->BindValue(":dateInscription", $infosVisio[1]);
            $pdoStatement2->execute();   
        }
   }

   function archivageHistoriqueConnexion($id){
        $req = PdoGsb::$monPdo->prepare("SELECT dateDebutLog, dateFinLog FROM historiqueconnexion WHERE idMedecin=:id");
        $req->BindValue(':id', $id);
        $req->execute();
        $infos = $req->fetchAll();

        foreach($infos as $infosHistoriqueConnexion){
            $pdoStatement2 = PdoGsb::$monPdo->prepare("INSERT INTO archivagehistoriqueconnexion VALUES(:idMedecin, :dateDebutLog, :dateFinLog)");
            $pdoStatement2->BindValue(":idMedecin",$this->recupererIDArchivage());
            $pdoStatement2->BindValue(":dateDebutLog", $infosHistoriqueConnexion[0]);
            $pdoStatement2->BindValue(":dateFinLog", $infosHistoriqueConnexion[1]);
            $pdoStatement2->execute();   
        }
   }

   function recupererMDP($login){
        $req = PdoGsb::$monPdo->prepare("SELECT motDePasse FROM medecin WHERE mail = :login");
        $req->BindValue(":login",$login);
        if($req->execute()){
            $resultat = $req->fetch();
        } else {
            throw new Exception("erreur");
        }
        return $resultat;
   }

   function recupererDonnees($id){
        $req = PdoGsb::$monPdo->prepare("SELECT nom, prenom, mail, dateNaissance, dateCreation, rpps, token, dateDiplome, dateConsentement FROM medecin WHERE id = :id");
        $req->BindValue(":id",$id);
        if($req->execute()){
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("erreur");
        }
        return $resultat;
   }
}
