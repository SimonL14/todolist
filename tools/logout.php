<?php
session_start();
unset($_SESSION["Id"]);
unset($_SESSION["FirstName"]);

header("Location: ../index.php");
?>