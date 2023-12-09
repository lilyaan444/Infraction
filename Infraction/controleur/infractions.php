<?php
require_once('../modele/infractionDAO.class.php');
require_once('../modele/conducteurDAO.class.php');
require_once('../modele/delitByInfractionDAO.class.php');
error_reporting(E_ALL);
ini_set("display_errors",1);

    $infractionDAO = new infractionDAO();
    $conducteurDAO = new ConducteurDAO();
    $delitByInfrDAO = new DelitByInfractionDAO();
    

    session_start();
    if($_SESSION["admin"]){
        $lesInfractions = $infractionDAO->getAllAsc();
    }else{
            header("location: login.php");
        }
        


    $lignes = [];
    foreach($lesInfractions as $uneInfraction){
        $ch = '';
        $nom = $conducteurDAO->getByPermis($uneInfraction->getPermis())->getNom();
        $prenom=$conducteurDAO->getByPermis($uneInfraction->getPermis())->getPrenom();
        $ch .='<td>'. $uneInfraction->getId() .'</td>';
        $ch .='<td>'. $uneInfraction->getDate() .'</td>';
        $ch .='<td>'. $uneInfraction->getImmat() .'</td>';
        $ch .='<td>'. $uneInfraction->getPermis().' '.$nom .' '.$prenom .'</td>';
        $ch .='<td>'. $delitByInfrDAO->totalByInfraction($uneInfraction->getId()). ' €'.'</td>';
        $ch .= '<td><a href="infractionDelit.php?id_inf=' . urlencode($uneInfraction->getId()) . '"><img src="../vue/style/visu.png"></a></td>';

            $ch .= '<td><a href="editInfraction.php?op=m&id_inf=' . urlencode($uneInfraction->getId()) . '"><img src="../vue/style/modification.png"></a></td>';
$ch .= '<td><a href="editInfraction.php?op=s&id_inf=' . urlencode($uneInfraction->getId()) . '"><img src="../vue/style/corbeille.png"></a></td>';
         
        $lignes[] = "<tr>$ch</tr>";
    }
    unset($lesInfractions);

    if (isset($_POST["logout"]) && $_POST["logout"]) {
        session_destroy();
        header("location : login.php");
        exit();
    }
    require_once("../vue/infractions.view.php");
