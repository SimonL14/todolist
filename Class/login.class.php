<?php
class login implements login_int{

	public function __construct()
	{
		
	}

    public function login($pdo)
	{
		try {
			$login = array($_POST["Email"],hash('sha256',$_POST["Password"]));
			$req = "SELECT * from users where Email=? AND Password=?";
			$result = $pdo->selectQuery($req,$login);
			if($result != null) {
				$_SESSION["Id"] = $result[0]["Id"];
				$_SESSION["FirstName"] = $result[0]["FirstName"];
				$_SESSION["type"] = $result[0]["Type"];
                var_dump($_SESSION);
				header('Location: ./accueil.php');
				}
			else {
				?>
				<script>
					alert('Identifiants incorects');
				</script>
				<?php
			}


		} catch(PDOException $e){
            log::directWriteLog("./logs/LogDB.txt",$e->getMessage());
            die();
        } catch(Exception $e){
            log::directWriteLog("./logs/Log.txt",$e->getMessage());
            die();
        }
	}
}