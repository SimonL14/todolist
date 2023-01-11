<?php
include_once('../tools/autoload.php');
session_start();
$pdo = new DB();
$log = new login();
if(isset($_POST["submit"])){
    $log->login($pdo);
}
include_once('../tools/header.php');
?>
<h1 class="text-center">Connexion</h1>
<div class="but">
    <div class="mx-auto" style="width: 400px;">
    <form method="post" >
            <div class="form-group">
                <input class="form-control" type="email" required="required" name="Email" placeholder="Votre email" value="" />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" required="required" name="Password" placeholder="Votre mot de passe" value="" />
            </div>
            <input type="submit" id="submit" name="submit" value="Connexion" class="btn btn-primary">
            <a class="btn btn-primary" href="./register.php" role="button">Créer un compte</a>
        </form>
    </div></div>
</body>
</html>