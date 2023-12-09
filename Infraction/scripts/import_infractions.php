<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
require '../modele/connexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['jsonFile'])) {
    $file = $_FILES['jsonFile'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $jsonData = file_get_contents($file['tmp_name']);
        $infractions = json_decode($jsonData, true);

        $jsonData = file_get_contents('../infractions_ext.json');

$infractions = json_decode($jsonData, true);

if ($infractions === null) {
    die("Erreur lors de la lecture du fichier JSON.");
}

try {
    $connexion = new Connexion();
    $db = $connexion->getDb();

    $sql = "SELECT MAX(id_inf) AS max_id FROM infraction";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nextId = ($result['max_id'] ?? 0) + 1; 

    foreach ($infractions as $infraction) {
        $dateInf = DateTime::createFromFormat('d/m/Y', $infraction['date_inf'])->format('Y-m-d'); 
        $numImmat = $infraction['num_immat'];
        $numPermis = $infraction['num_permis'];
        $delits = $infraction['délits'];

        $sql = "INSERT INTO infraction (id_inf, date_inf, no_immat, no_permis) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nextId, $dateInf, $numImmat, $numPermis]);

        $nextId++;

        foreach ($delits as $idDelit) {
            $sql = "INSERT INTO comprend (id_inf, id_delit) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$nextId - 1, $idDelit]);
        }
    }

    header("Location: ../controleur/infractions.php");
    exit();

} catch (Exception $exception) {
    die("Erreur lors de l'insertion des infractions : " . $exception->getMessage());
}
    } else {
        die("Erreur lors de l'upload du fichier JSON.");
    }
} else {
    die("Aucun fichier JSON n'a été uploadé.");
}

require_once('../vue/imp_infraction.view.php');

?>
