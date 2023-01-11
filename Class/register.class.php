<?php

class register implements register_int{
    public function __construct(){

    }

    public function register($pdo){
        try{
            if(isset($_POST['submit'])){
                if(isset($_POST['FirstName']) AND isset($_POST['LastName']) AND isset($_POST['Email']) AND isset($_POST['Password'])){
                    $FirstName = htmlspecialchars($_POST['FirstName']);
                    $LastName = htmlspecialchars($_POST['LastName']);
                    $Email = htmlspecialchars($_POST['Email']);
                    $Password =  hash('sha256',$_POST['Password']);
                    $register = array($FirstName, $LastName, $Email, $Password);
                    $request = 'INSERT INTO users(FirstName, LastName, Email, Password)VALUES(?, ?, ?, ?)';
                    $result = $pdo->selectQuery($request, $register);    
                    $_SESSION["Id"] = $result[0]["Id"];
                    $_SESSION["FirstName"] = $result[0]["FirstName"];
                    $_SESSION["Type"] = $result[0]["Type"];   
                    header('Location: ./login.php');           
                    
                }else{
                    ?>
                    <script>
                        alert("Remplissez tous les champs");
                    </script>
                    <?php
                }
            }
        } catch(PDOException $e){
            log::directWriteLog("./Logs/LogBDD.txt", $e->getMessage());
            die();
        } catch(Exception $e){
            log::directWriteLog("./Logs/Log.txt", $e->getMessage());
            die();
        }
    }
}
?>