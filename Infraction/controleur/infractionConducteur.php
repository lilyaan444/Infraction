<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


require_once '../modele/connexion.php';
require_once '../modele/infractionDAO.class.php';
require_once '../modele/conducteurDAO.class.php';
require_once('../modele/delitByInfractionDAO.class.php');
require_once('../modele/delitDAO.class.php');


$connexion = new Connexion();
$db = $connexion->getDb();

$infractionDAO = new InfractionDAO();
$conducteurDAO = new ConducteurDAO();
$delitByInfrDAO = new DelitByInfractionDAO();

session_start();
if(isset($_SESSION['autorise']) && isset($_SESSION['nopermis'])){
    $noPermis = $_SESSION['nopermis'];
    $lesInfractions = $infractionDAO->getByPermis($noPermis);
}else{
        header("location: login.php");
    }

$lesInfractions = $infractionDAO->getInfractionsByConducteur($_SESSION['nopermis']);

$lignes = [];

foreach ($lesInfractions as $uneInfraction) {
    $ch = '';
    $nom = $conducteurDAO->getByPermis($uneInfraction->getPermis())->getNom();
    $prenom = $conducteurDAO->getByPermis($uneInfraction->getPermis())->getPrenom();
    $ch .= '<td>' . $uneInfraction->getId() . '</td>';
    $ch .= '<td>' . $uneInfraction->getDate() . '</td>';
    $ch .= '<td>' . $uneInfraction->getImmat() . '</td>';
    $ch .= '<td>' . $uneInfraction->getPermis() . ' ' . $nom . ' ' . $prenom . '</td>';
    $ch .= '<td>' . $delitByInfrDAO->totalByInfraction($uneInfraction->getId()) . ' €' . '</td>';
    $ch .= '<td><a href="infractionDelit.php?id_inf=' . urlencode($uneInfraction->getId()) . '"><img src="../vue/style/visu.png"></a></td>';
    $lignes[] = "<tr>$ch</tr>";
}

require_once('../vue/infractionConducteur.view.php');
?>
