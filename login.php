<?php
include_once "Db_conn.php";
include_once "clean.php";

// $object = new DB;
// $object->connect();


class LoginClass extends DB
{
    function Select($check)
    {
        // check if the DATA is an array
        // $check = is_array($check);
        if (is_array($check)) {
            # code...
            foreach ($check as $value) 
            {
                $cleanFun = new CleanClass($value);
            }
            if(!empty($check))
            {
                $stmt = $this->connect()->prepare("SELECT * FROM `kocots` WHERE `Email`=? AND `Password`=? ");
                $stmt->execute([$check[0], $check[1]]);
            }            
        }else {
            # code...
        }
    }
    
}

$object = new LoginClass;
$object->Select(['peter','otakhorpeter@gmail.com', 'peter123']);


?>