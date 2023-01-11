<?php
include_once('DB.class.php');
class task implements task_int{

	public function __construct()
	{
		
	}
 
    public function getTask (){
        $req = "SELECT * from tasks
                INNER JOIN usersteamstasks ON tasks.Id = usersteamstasks.IdTask
                WHERE usersteamstasks.IdUser = ?
                ORDER BY Id";
        $pdo = new DB();
        $array = array($_SESSION['Id']);
		$result = $pdo->selectQuery($req,$array);
        return $result;
    }

    public function getAllTask(){
        $req = "SELECT * from tasks";
        $pdo = new DB();
        $result = $pdo->selectQuery($req);
        return $result;
    }

    public function createTask (){
        $pdo = new DB();

        if ($_POST["Team"] == '' && $_POST["User"] == ''){
            include_once ('../tools/erreur.php');
        }
        else {
            $array1 = array($_POST["Name"],$_POST["Detail"],$_POST["State"]);
            $req1 = "INSERT INTO tasks (Name,Detail,State)
            VALUES (?,?,?)";
            $pdo->nonSelectQuery($req1,$array1);

            $req2 = "SELECT Id FROM tasks WHERE Id=(SELECT max(Id) FROM tasks)";
            $idtask = $pdo->selectQuery($req2);

            if ($_POST["Team"] != '' && $_POST["User"] != ''){
                $array2 = array($_POST["Team"],$_POST["User"],(int) $idtask[0]["Id"]);
                $req3 = "INSERT INTO usersteamstasks (IdTeam,IdUser,IdTask)
                VALUES (?,?,?)";
                $pdo->nonSelectQuery($req3,$array2);
                header('Location: ./taskList.php');
            }
            else {
                if ($_POST["Team"] == '' && $_POST["User"] != ''){
                    $array2 = array($_POST["User"],(int) $idtask[0]["Id"]);
                    $req3 = "INSERT INTO usersteamstasks (IdUser,IdTask)
                    VALUES (?,?)";
                    $pdo->nonSelectQuery($req3,$array2);
                    header('Location: ./TaskList.php');
                } else {
                    $array2 = array($_POST["Teamr"],(int) $idtask[0]["Id"]);
                    $req3 = "INSERT INTO usersteamstasks (IdTeam,IdTask)
                    VALUES (?,?)";
                    $pdo->nonSelectQuery($req3,$array2);
                    header('Location: ./taskList.php');
                }
            }
        }
    }

    public function ModifTask(){
        if(isset($_POST['modif'])){
            $req = "UPDATE tasks SET Name=? , Detail=? , State=? WHERE Id = ?";
            $pdo = new DB();
            $array = array($_POST['NomTask'],$_POST['DetailTask'],$_POST['StateTask'],$_SESSION['idtache']);
            $pdo->nonSelectQuery($req,$array);
            if ($_SESSION['last'] == "team") header('Location: ./TeamTasks.php');
            if ($_SESSION['last'] == "user") header('Location: ./taskList.php');
            if ($_SESSION['last'] == "admin") header('Location: ./TaskList.php');
        }
        else {
            $req = "SELECT * from tasks WHERE tasks.Id = ?";
            $pdo = new DB();
            $array = array($_SESSION['idtache']);
            $result = $pdo->selectQuery($req,$array);
            return $result;
        }
    }

    public function delTask(){
        $pdo = new DB();
        $array = array((int) $_SESSION['idtache']);
        $req = "DELETE FROM usersteamstasks WHERE IdTask=?";
        $pdo->nonSelectQuery($req,$array);
        $req = "DELETE FROM comments WHERE IdTask=?";
        $pdo->nonSelectQuery($req,$array);
        $req = "DELETE FROM tasks WHERE Id=?";
        $pdo->nonSelectQuery($req,$array);
        header('Location: ./TaskList.php');
    }

    public function giveTask(){
        $pdo = new DB();
        if (isset($_POST['Usersadd'])){
            $req ="INSERT INTO usersteamstasks (IdUser,IdTask) VALUES (?,?)";
            $array = array($_SESSION['usertoadd'],$_SESSION['idtask']);
            $pdo->nonSelectQuery($req,$array);
            header('Location: ./AttributeTask.php');
        }
        if (isset($_POST['Teamsadd'])){
            $req ="INSERT INTO usersteamstasks (IdTeam,IdTask) VALUES (?,?)";
            $array = array($_SESSION['teamtoadd'],$_SESSION['idtask']);
            $pdo->nonSelectQuery($req,$array);
            header('Location: ./AttributeTask.php');
        }
    }

    public function remove_givenTask(){
        $pdo = new DB();
        if (isset($_POST['Usersdel'])){
            $req = "DELETE FROM usersteamstasks WHERE IdUser = ? AND IdTask = ? ";
            $array = array($_SESSION['usertodel'],$_SESSION['idtask']);
            $pdo->nonSelectQuery($req,$array);
            header('Location: ./AttributeTask.php');
        }
        if (isset($_POST['Teamsdel'])){
            $req = "DELETE FROM usersteamstasks WHERE IdTeam = ? AND IdTask = ? ";
            $array = array($_SESSION['teamtodel'],$_SESSION['idtask']);
            $pdo->nonSelectQuery($req,$array);
            header('Location: ./AttributeTask.php');
        }
    }

    public function getTeamTask (){
        $req = "SELECT * from tasks
                INNER JOIN usersteamstasks ON tasks.Id = usersteamstasks.IdTask
                WHERE usersteamstasks.IdTeam = ?
                ORDER BY Id";
        $pdo = new DB();
        $array = array($_SESSION['team']);
		$result = $pdo->selectQuery($req,$array);
        return $result;
    }

    public function getAllUserTask(){
        $req = "SELECT tasks.Id, tasks.Name from tasks";
        $pdo = new DB();
        $result = $pdo->selectQuery($req);
        $row = count($result);
        for($i=0;$i<$row;$i++){
            $id = (int)$result[$i]['Id'];
            $req1 = "SELECT Id, LastName, FirstName FROM users
                     INNER JOIN usersteamstasks ON users.Id = usersteamstasks.IdUser
                     WHERE usersteamstasks.IdTask = $id";
            $result[$i][] = $pdo->selectQuery($req1);
        }
        return $result;
    }

    public function getAllTeamTask(){
        $req = "SELECT tasks.Id, tasks.Name from tasks";
        $pdo = new DB();
        $result = $pdo->selectQuery($req);
        $row = count($result);
        for($i=0;$i<$row;$i++){
            $id = (int)$result[$i]['Id'];
            $req1 = "SELECT Id, Name FROM teams
                     INNER JOIN usersteamstasks ON teams.Id = usersteamstasks.IdTeam
                     WHERE usersteamstasks.IdTask = $id";
            $result[$i][] = $pdo->selectQuery($req1);
        }
        return $result;
    }

}