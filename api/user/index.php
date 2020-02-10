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

    function Select($allowed)
    {
        $allowed = $allowed;
        $stmt = $this->connect()->prepare("SELECT $allowed FROM `User_INFO` ");

        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // echo $result;

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo json_encode(
                    array(
                        "first_name" => $row['first_name'],
                    "last_name" => $row['last_name'],
                        "email" => $row['email'],
                        "password" => $row['password'])
                );
                // return true;
            }
        }else{
            echo json_encode(array("No User in DB"));
        }
    }

    function Chek()
    {
        if (isset($_GET['field'])) {
            # code...
            $field = explode(',', $_GET['field']);
            $allowed = array(
                'first_name',
                'last_name',
                'email',
                'password'
            );

            $user = array();
            
            foreach ($field as $value) {
                # code...
                if (!in_array($value, $allowed)) {
                    # code...
                    echo json_encode(array("Wrond field name."));
                    echo json_encode(array("Use" => $allowed));
                    die;
                }
                if ($value == 'first_name' && 'last_name') {
                    # code...
                    echo "test";
                    $allowed = "`first_name`, `last_name`";
                    $this->Select($allowed);
                    
                }
                // echo json_encode(array($field ."--". $value));
            }
            
        }else {
            # code...
            $allowed = "`first_name`, `last_name`, `email`, `password`, `active`";
            $this->Select($allowed);
        }
    } 
    
}

$object = new SelectClass;
header('Content-Type: applecation/json');
$object->Chek();


?>