<?php

include_once("../modele/conducteurDAO.class.php");
include_once("../modele/connexion.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$identifiants['login'] = isset($_POST['login']) ? $_POST['login'] : null; 
$identifiants['motDePasse'] = isset($_POST['motDePasse']) ? $_POST['motDePasse'] : null; 
$valider = isset($_POST['valider']);

function existeUtilisateur(array $identifiants): bool {
    $conducteurDAO = new ConducteurDAO();
    $user = $conducteurDAO->getByPermis(trim($identifiants['login']));

    if ($user && password_verify(trim($identifiants['motDePasse']), $user->getMDP())) {
        return true;
    } else {
        return false;
    }
}


function admin(array $identifiants){
    if(trim($identifiants['login']) == "ROKA" && trim($identifiants['motDePasse']) == "Zsuzsanna"){return true;}
    if(trim($identifiants['login']) == "BENKERRI" && trim($identifiants['motDePasse']) == "MULLER"){return true;}
    else {return false;}
}

function login(array $identifiants) {
    if (existeUtilisateur($identifiants)) {
        $_SESSION["autorise"] = true;
        $_SESSION['nopermis'] = $identifiants['login'];
        header("location: infractionConducteur.php");
        exit();
    } elseif (admin($identifiants)) {
        $_SESSION["autorise"] = true;
        $_SESSION["admin"] = true;
        header("location: infractions.php");
        exit();
    } else {
    $_SESSION['error'] = "Identification incorrecte, essayez de nouveau"; 
    $identifiants['motDePasse']="";
}

    
}

if ($valider) {
    login($identifiants);
}

function logout() {
    session_destroy();
    header("location: login.php");
    exit();
}

require_once("../vue/login.view.php");
?>
