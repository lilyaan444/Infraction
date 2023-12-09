<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="../vue/style/login.css">
</head>
<?php $titre = "Authentification"; ?>
<?php require_once("header.php"); ?>

<body>
    <div id="container">
    <?php if (isset($message) && !empty($message)) : ?>
            <p class="error-message"><?= $message ?></p>
        <?php endif; ?>
        <form action="../controleur/login.php" method="post">
            <label>
                <h1>Identifiant : </h1>
            </label>
            <input type="text" name="login" placeholder="Login" value=<?= $identifiants['login'] = "" ?>>
            <br><br>
            <label>
                <h1>Mot de passe : </h1>
            </label>
            <input type="password" name="motDePasse" placeholder="Mot de passe" value=<?= $identifiants['motDePasse'] = "" ?>>

            <br><br>
            <button type="submit" name="valider" value="Valider">Se connecter</button>
        </form>
        <?php
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']); 
}
?>
    </div>
</body>

</html>