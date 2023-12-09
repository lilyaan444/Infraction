<?php
require_once('../modele/infractionDAO.class.php');
require_once('../modele/delitByInfractionDAO.class.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);

$infractionDAO = new InfractionDAO();
$delitByInfrDAO = new DelitByInfractionDAO();


session_start();

$isConnectedAsAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];
$isConnectedWithPermis = isset($_SESSION['nopermis']);

if (($isConnectedAsAdmin || $isConnectedWithPermis) && isset($_GET['id_inf'])) {
    if (($isConnectedWithPermis) && isset($_GET['id_inf'])) {
        $noPermis = $_SESSION['nopermis'];
    }$infractionId = $_GET['id_inf'];

    $infraction = $infractionDAO->getById($infractionId);

    if ($isConnectedAsAdmin || ($isConnectedWithPermis && $infraction->getPermis() == $noPermis)) {

        $delitsByInfraction = $delitByInfrDAO->getByInfraction($infractionId);

        $lignes = [];
        foreach ($delitsByInfraction as $delitByInf) {
            $idDelit = $delitByInf->getDelit()->getId();
            $natureDelit = $delitByInf->getDelit()->getNature();
            $tarifDelit = $delitByInf->getDelit()->getTarif();

            $ch = '<tr>';
            $ch .= '<td>' . $idDelit . '</td>';
            $ch .= '<td>' . $natureDelit . '</td>';
            $ch .= '<td>' . $tarifDelit . ' €</td>';
            $ch .= '</tr>';
            $lignes[] = $ch;
        }

        $totalTarif = $delitByInfrDAO->totalByInfraction($infractionId);

        $totalRow = '<tr><td colspan="3"> <h1> Total : ' . $totalTarif . ' € </h1></td></tr>';
        $lignes[] = $totalRow;
        $listeDelitsAjoutes = $delitByInfrDAO->getByInfraction($infractionId);

        require_once("../vue/infractionDelit.view.php");
    } else {
        header("location: login.php");
        exit;
    }
} else {
    header("location: login.php");
    exit;
}
?>
