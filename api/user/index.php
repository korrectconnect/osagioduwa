<?php

include_once '../../Db_conn.php';
include_once '../../clean.php';

class SelectClass extends DB
{
    public function CL_FUN($check)
    {
        $cleanFun = new CleanClass($check);
        $clean_data = $cleanFun->GetData();
        return $clean_data;
    }

    function Select()
    {
        $stmt = $this->connect()->prepare("SELECT `first_name`, `last_name`, `email`, `password`, `active` FROM `User_INFO` ");

        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // echo $result;

        if ($stmt->rowCount() > 0) {
            while ($GLOBALS['row'] = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo json_encode(
                    array($GLOBALS['row'])
                );
                // return true;
            }
        }else{
            echo json_encode(array("No User in DB"));
        }
    }
    
}

$object = new SelectClass;
header('Content-Type: applecation/json');
$object->Select();


?>