<?php

include_once 'Db_conn.php';
include_once 'clean.php';

class KeyClass extends DB
{
    function Select($key)
    {
        $CleanObject = new CleanClass($key);

        $stmt = $this->connect()->prepare("SELECT * FROM `kocots Api`  WHERE `api_key`=? ");
        $stmt->execute([$key]);

        if ($stmt->rowCount() > 0) {
            # code...
            echo "working";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                # code...
                $userID = $row['api_key'];
                $STATE = $row['active'];
                if ($STATE == 1) {
                    # code...
                    echo json_encode(array("api_key" => $userID, "active" => $STATE));
                }else {
                    # code...
                    echo json_encode(array("Key hes been revoke."));
                }                
            }            
        }else {
            # code...
            echo json_encode(array("Key not FOUND."));
        }
    }

    function CheckERROR($key)
    {
        if (empty($key)) {
            # code...
            echo json_encode(array("Empty Key"));
        } else {
            if (strlen($key) != 5) {
                # code...
                echo json_encode(array("Key Not Valied"));
            } else {

                $this->Select($key);
            }
        }
    }

   function GetMethod()
   {
       if (isset($_GET['key'])) {
            # code...
            $this->CheckERROR($_GET['key']);

       }elseif (isset($_POST['key']))
       {
            # code...
            $this->CheckERROR($_POST['key']);

       }else{

           echo json_encode(array("Use a POST or a GET METHOD"));
       }

   }


}

$KeyClassObject = new KeyClass;
header('Content-Type: applecation/json');
$KeyClassObject->GetMethod();

?>