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

            echo json_encode(array("Registion Successfull."));
            
        } else {
            echo json_encode(array("Email have been used."));
        }
    }

    function ISSET_EMPTY($first_name, $last_name, $email, $password)
    {
        try {
            //code...
            if (isset($first_name,$last_name, $email) && isset($password)) {
                # code...
                echo json_encode(array("Empty filed"));

                die();
            } elseif (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {
                # code...
                echo json_encode(array("Empty filed"));

                die();
            }
        } catch (\Exception $th) {
            //throw $th;
            echo json_encode(array("Empty or not set field"));
        }
        
    }


    function AddUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            # code...
            
            if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'])) {
                # code...

                if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                    # code...
                    echo json_encode(array("Empty filed"));
                    die();
                } else {
                    # code...
                    $this->UserSQL($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_GET['password']);
                }
            } else {
                # code...
                echo json_encode(array("Field not set"));

                die();
            }
        
            
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'GET') 
        {
            # code...
          
            if (isset($_GET['first_name'], $_GET['last_name'], $_GET['email'], $_GET['password'])) {
                # code...

                if (empty($_GET['first_name']) && empty($_GET['last_name']) && empty($_GET['email']) && empty($_GET['password'])) {
                    # code...
                    echo json_encode(array("Empty filed"));
                    die();

                }else {
                    # code...
                    $this->UserSQL($_GET['first_name'], $_GET['last_name'], $_GET['email'], $_GET['password']);
                }
               
            }else {
                # code...
                echo json_encode(array("Field not set"));

                die();
            }

            /* $first_name = $_GET['first_name'];
            $last_name = $_GET['last_name'];
            $email = $_GET['email'];
            $password = $_GET['password']; */

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