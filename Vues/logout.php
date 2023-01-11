<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["FirstName"]);
header("Location:login.php");
?>