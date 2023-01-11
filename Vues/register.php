<?php
include_once('../tools/autoload.php');
session_start();
$pdo = new DB();
$reg = new register();
if(isset($_POST["submit"])){
    $reg->register($pdo);
}
include_once('../tools/header.php');
?>
<h1 class="text-center">Inscription</h1>
<div class="but">
    <div class="mx-auto" style="width: 400px;">
    <form method="post" >
            <div class="form-group">
                <input class="form-control" type="text" required="required" name="LastName" placeholder="Votre nom" value="" />
            </div>
            <div class="form-group">
                <input class="form-control" type="text" required="required" name="FirstName" placeholder="Votre prénom" value="" />
            </div>
            <div class="form-group">
                <input class="form-control" type="email" required="required" name="Email" placeholder="Votre email" value="" />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" required="required" name="Password" placeholder="Votre mot de passe" value="" />
            </div>
            <input type="submit" id="submit" name="submit" value="Inscription" class="btn btn-primary">
            <a class="btn btn-primary" href="./login.php" role="button">J'ai déjà un compte</a>
        </form>
    </div></div>
</body>
</html>