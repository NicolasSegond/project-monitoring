<?php

require_once('connexion.php');
$pdo = PdoMonitoring::getPdo();

// Fonction de génération d'une mesure aléatoire
function genererMesure()
{
    return rand(0, 100);
}

function genererEtat()
{
    $etats = array("Actif", "Inactif");
    return $etats[array_rand($etats)];
}

function genererConsommation()
{
    // Puissance aléatoire de l'appareil (on suppose que l'appereil peut varier de puissance selon les conditions)
    $puissanceAleatoire = rand(1, 100);

    // Durée de fonctionnement de l'appareil (15 minutes maximum)
    $dureeMinutes = rand(0, 15);

    // Calcul de la consommation
    $consommation = ($puissanceAleatoire * $dureeMinutes) / 1000;
    return $consommation;
}

function envoyerDonnees()
{
    global $pdo;
    $sql = $pdo->prepare("SELECT ID FROM Modules");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        foreach ($result as $row) {
            $moduleID = $row["ID"];

            $mesure = genererMesure();

            date_default_timezone_set('Europe/Paris');
            $date = date("Y-m-d H:i:s");
            $etat = genererEtat();

            $consommation = genererConsommation();

            $sql = $pdo->prepare("INSERT INTO historique (ID_Module, Date, Mesure, consommation, etat, archiver) VALUES (:id, :date, :mesure, :conso, :etat, :archiver)");
            $sql->bindValue('id', $moduleID);
            $sql->bindValue('date', $date);
            $sql->bindValue('mesure', $mesure);
            $sql->bindValue('conso', $consommation);
            $sql->bindValue('etat', $etat);
            $sql->bindValue('archiver', 0);
            $sql->execute();

            $sql = $pdo->prepare("UPDATE Modules SET DerniereMiseAJour = :maj, Etat = :etat WHERE ID = :id");
            $sql->bindValue('maj', $date);
            $sql->bindValue('etat', $etat);
            $sql->bindValue('id', $moduleID);
            $sql->execute();
        }
    } else {
        echo "Aucun module trouvé.";
    }
}

// Exécuter la fonction initiale immédiatement
envoyerDonnees();
