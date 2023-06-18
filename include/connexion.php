
<?php

class PdoMonitoring
{
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=monitoring';
    private static $user = 'root';
    private static $mdp = '';
    private static $monPdo;
    private static $monPdoMonitoring = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {

        PdoMonitoring::$monPdo = new PDO(PdoMonitoring::$serveur . ';' . PdoMonitoring::$bdd, PdoMonitoring::$user, PdoMonitoring::$mdp);
        PdoMonitoring::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function __destruct()
    {
        PdoMonitoring::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoMonitoring = PdoMonitoring::getPdoMonitoring();
     * @return l'unique objet de la classe PdoMonitoring
     */
    public static function getPdoMonitoring()
    {
        if (PdoMonitoring::$monPdoMonitoring == null) {
            PdoMonitoring::$monPdoMonitoring = new PdoMonitoring();
        }
        return PdoMonitoring::$monPdoMonitoring;
    }

    public static function getPdo()
    {
        $pdo = self::getPdoMonitoring();
        return $pdo::$monPdo;
    }
}