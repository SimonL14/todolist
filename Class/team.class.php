<?php
include_once('DB.class.php');
class team implements team_int{

	public function __construct()
	{
		
	}

    public function getTeam (){
        $req = "SELECT * from teams";
        $pdo = new DB();
        $result = $pdo->selectQuery($req);
        return $result;
    }

    public function createTeam (){
        $req = "INSERT INTO teams (Name,State) VALUES (?,?)";
        $pdo = new DB();
        $pdo->nonSelectQuery($req,$_SESSION['add']);
        header('Location: ./TeamList.php');
    }

    public function ModifTeam(){
        if(isset($_POST['modif'])){
            $pdo = new DB();
            $req = "UPDATE teams SET Name=?,State=? WHERE Id=?";
            $array = array($_POST['NomTeam'],$_POST['StateTeam'],$_SESSION['idteam']);
            $pdo->nonSelectQuery($req,$array);
            header('Location: ./TeamList.php');
        }
        else {
            $req = "SELECT * from teams WHERE teams.Id = ?";
            $pdo = new DB();
            $array = array($_SESSION['idteam']);
            $result = $pdo->selectQuery($req,$array);
            return $result;
        }
    }

    public function delTeam(){
        $pdo = new DB();
        $array = array((int) $_SESSION['idteam']);
        $req = "DELETE FROM usersteamstasks WHERE IdTeam=?";
        $pdo->nonSelectQuery($req,$array);
        $req = "DELETE FROM usersteams WHERE IdTeam=?";
        $pdo->nonSelectQuery($req,$array);
        $req = "DELETE FROM teams WHERE Id=?";
        $pdo->nonSelectQuery($req,$array);
        header('Location: ./TeamList.php');
    }

    public function AddUser_Team(){
        $req = "INSERT INTO usersteams(IdUser,IdTeam) VALUES (?,?)";
        $pdo = new DB();
        $array = array($_SESSION['usertoadd'],$_SESSION['idteam']);
        $pdo->nonSelectQuery($req,$array);
        header('Location: ./TeamMember.php');
    }

    public function DelUser_Team(){
        $req = "DELETE FROM usersteams WHERE IdUser = ? AND IdTeam = ? ";
        $pdo = new DB();
        $array = array($_SESSION['usertodel'],$_SESSION['idteam']);
        $pdo->nonSelectQuery($req,$array);
        header('Location: ./TeamMember.php');
    }

    public function getUserTeam(){
        $req = "SELECT teams.Id, teams.Name from teams";
        $pdo = new DB();
        $result = $pdo->selectQuery($req);
        $row = count($result);
        for($i=0;$i<$row;$i++){
            $id = (int)$result[$i]['Id'];
            $req1 = "SELECT Id, LastName, FirstName FROM users
                     INNER JOIN usersteams ON users.Id = usersteams.IdUser
                     WHERE usersteams.IdTeam = $id";
            $result[$i][] = $pdo->selectQuery($req1);
        }
        return $result;
    }

}
