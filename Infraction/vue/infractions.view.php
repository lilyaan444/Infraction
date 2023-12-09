<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$titre = 'Liste des Infractions';
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Liste des infractions</title>
    <link rel="stylesheet" href="../vue/style/infraction.css">

</head>

<body>
    <?php require_once('../vue/header.php'); ?>
    <section id="bouton">

        <section class="button-container">
            <form action="../scripts/import_infractions.php" method="post" enctype="multipart/form-data">
                <label for="jsonFile">Uploader un fichier JSON:</label>
                <input type="file" name="jsonFile" id="jsonFile" accept=".json">
                <button type="submit">Importer</button>
            </form>
        </section>

        <section class="logout-container">
            <form action="../controleur/deconnexion.php" method="post">
                <input type="hidden" name="action" value="logout">
                <button type="submit">Déconnexion</button>
            </form>
        </section>
    </section>
    <section>
        <label></label>
        <table border="1" class='table_infractions'>
            <tr>
                <th>Numéro</th>
                <th>Le</th>
                <th>Véhicule</th>
                <th>Conducteur</th>
                <th>Montant</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>

            <?php
            foreach ($lignes as $ligne) {
                echo $ligne;
            }
            ?>

            <tr>
                <td colspan="8" style="text-align:right"><a href="editInfraction.php?op=a" class="ajout"><img src="../vue/style/add.png"></a></td>
            </tr>

        </table>
    </section>

</body>

</html>