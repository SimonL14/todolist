<?php
    interface DB{
        public function construct($Server, $DBName, $user, $pass);
        public function destruct();
        public function nonSelectQuery($sql, $param);
        public function SelectQuery($sql, $param=null);
    }

?>