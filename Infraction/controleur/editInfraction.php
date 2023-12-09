<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$op = (isset($_GET['op']) ? $_GET['op'] : null);
$ajout = ($op == 'a');
$modif = ($op == 'm');
$suppr = ($op == 's');
$id_inf = (isset($_GET['id_inf']) ? $_GET['id_inf'] : null);



if (($id_inf != null && $ajout) || (($id_inf == null) && $modif || $suppr)) {
    header("location: infraction.php");
}

require_once("../modele/infractionDAO.class.php");
require_once("../modele/vehiculeDAO.class.php");
require_once("../modele/conducteurDAO.class.php");
require_once("../modele/delitDAO.class.php");
require_once("../modele/delitByInfractionDAO.class.php");
$uneInfractionDAO = new InfractionDAO();
$vehiculeDAO = new VehiculeDAO();
$conducteurDAO = new ConducteurDAO();
$delitDAO = new DelitDAO();
$delitByInfractionDAO = new DelitByInfractionDAO();

$valeurs = [];
$listePermis = $conducteurDAO->getAllPermis();
$listeDelits = $delitDAO->getAll();


if ($modif) {
    $valeurs["id_inf"] = $id_inf;
    $uneInfraction = $uneInfractionDAO->getById($valeurs["id_inf"]);
} elseif ($ajout) {
    $valeurs["id_inf"] = $uneInfractionDAO->newId();
}

$titre = (($ajout) ? 'Nouvelle Infraction' : (($modif) ? "Infraction - édition des informations" : null));

$erreurs = ['immat' => "", 'permis' => ""];
$valeurs['immat'] = (isset($_POST['immat']) ? trim($_POST['immat']) : null);
$valeurs['permis'] = (isset($_POST['permis']) ? trim($_POST['permis']) : null);
$valeurs["date"] = (isset($_POST["date"]) ? trim($_POST["date"]) : null);
$valeurs["delits"] = (isset($_POST["delits"]) ? $_POST["delits"] : []);
$valeurs["delitSuppr"] = (isset($_POST["delitSuppr"]) ? $_POST["delitSuppr"] : []);
$retour = false;

if (isset($_POST["valider"])) {
    if (!$vehiculeDAO->immatExiste($valeurs["immat"])) {
        $erreurs["immat"] = "Ce numéro d'immatriculation n'existe pas";
    } else {
        $erreurs["immat"] = "";
        $unVehicule = $vehiculeDAO->getByImmat($valeurs["immat"]);
        $unConducteur = $conducteurDAO->getByPermis($unVehicule->getPermis());
    }

    if (!$conducteurDAO->permisExiste($valeurs["permis"])) {
        $erreurs["permis"] = "Ce numéro de permis n'existe pas";
    } else {
        $erreurs["permis"] = "";
        $unConducteur = $conducteurDAO->getByPermis($valeurs["permis"]);
    }

    $nbErreurs = 0;
    foreach ($erreurs as $uneErreur) {
        if ($uneErreur != "") $nbErreurs++;
    }

    if ($nbErreurs == 0) {
        $uneInfraction = new Infraction($valeurs["id_inf"], $valeurs["date"], $valeurs["immat"], $valeurs["permis"]);
        $retour = true;

        if ($ajout) {
            $uneInfractionDAO->insert($uneInfraction);
            $id_inf = $uneInfractionDAO->getLastInsertId();
        } elseif ($modif) {
            $uneInfractionDAO->update($uneInfraction);
            $id_inf = $valeurs["id_inf"];
        }


        foreach ($valeurs["delits"] as $id_delit) {
            $delitByInfractionDAO->insert(new DelitByInfraction($id_inf, new Delit($id_delit, "", 0)));
        }
        foreach ($valeurs["delitSuppr"] as $id_delit) {
            $delitByInfractionDAO->delete($id_inf, $id_delit);
        }
    }
} elseif (isset($_POST['annuler'])) {
    $retour = true;
} elseif ($suppr) {
    echo "<br />à supprimer $id_inf <br />";
    $uneInfractionDAO->delete($id_inf);
    $retour = true;
} elseif ($modif) {
    $uneInfraction = $uneInfractionDAO->getById($id_inf);
    $valeurs["id_inf"] = $uneInfraction->getId();
    $valeurs["date"] = $uneInfraction->getDate();
    $valeurs["immat"] = $uneInfraction->getImmat();
    $valeurs["permis"] = $uneInfraction->getPermis();
}

if ($retour) {
    header("location: ../controleur/infractions.php");
}

require_once("../vue/editInfraction.view.php");
