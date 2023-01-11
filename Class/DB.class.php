<?php 
class DB{

    private $connexion;
   

    function __construct()
    {
        try{
            $this->connexion = new PDO('mysql:host=localhost:3307;dbname=todolist','root','');
            return $this->connexion;
        }catch(PDOException $e){
            Log::directWriteLog("./Logs/LogDB.txt",$e->getMessage());
            die();
        }catch(Exception $e){
            Log::directWriteLog("./Logs/Log.txt",$e->getMessage());
            die();
        }
    }

    function destruct()
    {
        $this->connexion = null;
    }
    function nonSelectQuery($sql,$param){
        $conn = $this->connexion;
        try{
            $res = $conn->prepare($sql);
            $res->execute($param);
        }catch(PDOException $e){
            Log::directWriteLog("./Logs/LogDB.txt",$e->getMessage());
            die();
        }catch(Exception $e){
            Log::directWriteLog("./Logs/Log.txt",$e->getMessage());
            die();
        }
    }

        function selectQuery($sql,$param=null){
        $conn = $this->connexion;
        try{
            $res = $conn->prepare($sql);
            if ($param === null || $param === ""){
                $res->execute();
                $data = $res->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            }
            else {

                $res->execute($param);
                $data = $res->fetchAll(PDO::FETCH_ASSOC);
                return $data;

            }
        }catch(PDOException $e){
            Log::directWriteLog("./Logs/LogDB.txt",$e->getMessage());
            die();
        }catch(Exception $e){
            Log::directWriteLog("./Logs/Log.txt",$e->getMessage());
            die();
        }
    }

}


?>