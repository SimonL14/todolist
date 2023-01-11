<?php
include_once('DB.class.php');
class user implements user_int{

	public function __construct()
	{
		
	}

    public function getUser (){
        $req = "SELECT * from users";
        $pdo = new DB();
        $result = $pdo->selectQuery($req);
        return $result;
    }

    public function createUser (){
        $req = "INSERT INTO users (FirstName, LastName, Email, Password, State, Type) VALUES (?,?,?,?,?,?)";
        $pdo = new DB();
        $pdo->nonSelectQuery($req,$_SESSION['add']);
        header('Location: ./UserList.php');
    }

    public function ModifUser(){
        if(isset($_POST['modif'])){
            $pdo = new DB();
            if ($_POST['OldPassword'] != "" && $_POST['OldPassword'] != null && $_POST['NewPassword'] != "" && $_POST['NewPassword'] != null){
                $req = "SELECT Id FROM users WHERE Id=? AND Password=?";
                $array = array($_SESSION['iduser'],hash('sha256',$_POST['OldPassword']));
                $testmdp = $pdo->selectQuery($req,$array);
                if ($testmdp != "" && $testmdp != null){
                    $req = "UPDATE users SET FirstName=?, LastName=?, Email=?, Password=?, State=?, Type=? WHERE Id=?";
                    $array = array($_POST['PrenomUser'],$_POST['NomUser'],$_POST['Mail'],hash('sha256',$_POST['NewPassword']),$_POST['StateUser'],$_POST['TypeUser'],$_SESSION['iduser']);
                    $pdo->nonSelectQuery($req,$array);
                    header('Location: ./UserList.php');
                }
                else {
                    $_SESSION['erreurmdp'] = 1;
                    header('Location: ./ModifyUser.php');
                }
            }
            else {
                $req = "UPDATE users SET FirstName=?, LastName=?, Email=?, State=?, Type=? WHERE Id=?";
                $array = array($_POST['PrenomUser'],$_POST['NomUser'],$_POST['Mail'],$_POST['StateUser'],$_POST['TypeUser'],$_SESSION['iduser']);
                $pdo->nonSelectQuery($req,$array);
                header('Location: ./UserList.php');
            }
            
        }
        else {
            $req = "SELECT * from users WHERE users.Id = ?";
            $pdo = new DB();
            $array = array($_SESSION['iduser']);
            $result = $pdo->selectQuery($req,$array);
            return $result;
        }
    }

    public function delUser(){
        $pdo = new DB();
        $array = array((int) $_SESSION['iduser']);
        $req = "DELETE FROM comments WHERE IdUser = ?";
        $pdo->nonSelectQuery($req,$array);
        $req = "DELETE FROM usersteams WHERE IdUser = ?";
        $pdo->nonSelectQuery($req,$array);
        $req = "DELETE FROM usersteamstasks WHERE IdUser = ?";
        $pdo->nonSelectQuery($req,$array);
        $req = "DELETE FROM users WHERE Id = ?";
        $pdo->nonSelectQuery($req,$array);
        header('Location: ./UserList.php');
    }

}