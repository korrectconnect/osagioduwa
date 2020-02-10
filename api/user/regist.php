<?php
include_once '../../Db_conn.php';
include_once '../../clean.php';


class UserClass extends DB
{
    public function CL_FUN($check)
    {
        $cleanFun = new CleanClass($check);
        $clean_data = $cleanFun->GetData();
        return $clean_data;
    }

    /* function SelectUser($check)
    {
        $check = $allowed = array(
            'name',
            'email',
            'password',
            'date',
            'city',
            'LGA',
            'vendor_name',
            'vendor_address',
            'vendor_cont_info',
            'vendor_cont_info',
            'closest_busstop',
            'opening_hours',

        );
    } */

    function UserSQL($first_name, $last_name, $email, $password)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM `User_INFO` WHERE `first_name` = ? AND `last_name` = ? AND `email` = ?");
        $stmt->execute([$this->CL_FUN($first_name), $this->CL_FUN($last_name), $this->CL_FUN($email)]);

        if ($stmt->rowCount() == 0) {
            # code...
            $stmt = $this->connect()->prepare("INSERT INTO `User_INFO`
                (`first_name`, `last_name`, `email`, `password`) VALUES (?, ?, ?, ?)");

            $stmt->execute([
                $this->CL_FUN($first_name),
                $this->CL_FUN($last_name),
                $this->CL_FUN($email),
                $this->CL_FUN($password)
            ]);

            return json_encode(array("Registion Successfull."));
            
        } else {
            echo json_encode(array("Email have been used."));
        }
    }


    function AddUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            # code...

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $this->UserSQL($first_name, $last_name, $email, $password);
        
            
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'GET') 
        {
            # code...

            $first_name = $_GET['first_name'];
            $last_name = $_GET['last_name'];
            $email = $_GET['email'];
            $password = $_GET['password'];
            $this->UserSQL($first_name, $last_name, $email, $password);

        }
        else
        {
            # code...
            echo json_encode(array("User a POST OR A GET METHOD"));
        }
    }
}

$object = new UserClass;
header('Content-Type: applecation/json');
$object->AddUser();




?>