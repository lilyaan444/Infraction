<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$titre = 'Liste des Infractions';
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Liste des infraction</title>
    <link rel="stylesheet" href="../vue/style/infraction.css">

</head>

<body>
    <?php require_once('../vue/header.php'); ?>

    <section class="logout-container">
        <form action="../controleur/deconnexion.php" method="post">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Déconnexion</button>
        </form>
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

            </tr>

            <?php
            foreach ($lignes as $ligne) {
                echo $ligne;
            }
            ?>

        </table>
    </section>

</body>

</html>