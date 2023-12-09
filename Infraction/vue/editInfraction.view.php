<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo $titre ?></title>
</head>
<link rel="stylesheet" href="../vue/style/editinfractions.css">

<body>
    <?php require_once('../vue/header.php'); ?>

    <form name="add" action="" method="post">

        <h1>Identification</h1>
        <section>

            <div>
                <label for="num">Id Infraction : <?php echo ($valeurs['id_inf']);
                                                    ?></label>
            </div>
            <br>
            <label for="date">
                <h1>Date :</h1>
            </label>
            <div>
                <?php
                $dateFormatted = !empty($valeurs['date']) ? date('Y-m-d', strtotime($valeurs['date'])) : date('Y-m-d');
                ?>
                <input id="date" name="date" type="date" size="10" maxlength="10" value="<?= $dateFormatted ?>">
                <span class="erreur"></span>
            </div>

        </section>

        <h1>Véhicule</h1>
        <section>
            <label for="immat">n°immat :</label>
            <div>
                <div>
                    <input id="immat" name="immat" type="text" size="7" maxlength="7" value="<?= $valeurs['immat'] ?>">
                    <span class="erreur"><?= $erreurs['immat'] ?></span>
                </div>
        </section>

        <h1>Conducteur</h1>
        <section>
            <label for="permis">n°permis :</label>
            <div>
                <select id="permis" name="permis">
                    <?php foreach ($listePermis as $permis) : ?>
                        <option value="<?= $permis ?>" <?= ($valeurs['permis'] == $permis) ? 'selected' : '' ?>>
                            <?= $permis ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="erreur"><?= $erreurs['permis'] ?></span>
            </div>
        </section>
        <section>
            <label for="delits">
                <h1>Délits à ajouter:</h1>
            </label>
            <div class="div_colonne_delit">
                <?php foreach ($listeDelits as $delit) : ?>
                    <?php
                    $isChecked = in_array($delit->getId(), $valeurs["delits"]);
                    $isAssociated = $delitByInfractionDAO->existe($valeurs["id_inf"], $delit->getId());
                    ?>
                    <div>
                        <input type="checkbox" id="delit<?= $delit->getId() ?>" name="delits[]" value="<?= $delit->getId() ?>" <?= ($isChecked && !$isAssociated) ? 'checked' : '' ?> <?= $isAssociated ? 'disabled' : '' ?>>
                        <label for="delit<?= $delit->getId() ?>"><?= $delit->getNature() ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <br>
        <section>
            <?php if ($modif) : ?>
                <label for="delitSuppr">
                    <h1>Délits à supprimer:</h1>
                </label>
                <div class="div_colonne_delit">
                    <?php foreach ($listeDelits as $delitS) : ?>
                        <?php
                        $isChecked = in_array($delitS->getId(), $valeurs["delits"]);
                        $isAssociated = $delitByInfractionDAO->existe($valeurs["id_inf"], $delitS->getId());
                        ?>
                        <div>
                            <input type="checkbox" id="delit<?= $delitS->getId() ?>" name="delitSuppr[]" value="<?= $delitS->getId() ?>" <?= ($isChecked && !$isAssociated) ? 'checked' : '' ?> <?= $isAssociated ? '' : 'disabled' ?>>
                            <label for="delit<?= $delitS->getId() ?>"><?= $delitS->getNature() ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section>
            <label>&nbsp;</label>
            <div>
                <input type="submit" id="valider" name="valider" value="Valider" />
                &emsp;
                <input type="submit" id="annuler" name="annuler" value="Annuler" />
            </div>
        </section>

    </form>

</body>

</html>