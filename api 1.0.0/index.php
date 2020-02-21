<?php
include_once './Db_conn.php';
include_once './clean.php';
include_once './vondor.php';
include_once './meun.php';
include_once './other.php';

session_start();


class AuthClass extends DB
{
    public function CL_FUN($check)
    {
        $cleanFun = new CleanClass($check);
        $clean_data = $cleanFun->GetData();
        return $clean_data;
    }
    /* public function Message($msg)
    {
        echo json_encode(["Error" => $msg]);
    } */

    public function Message($msg)
    {
        header("Content-Type: applecation/json");
        echo json_encode($msg);
    }


    function TokenGen()
    {
        $token = openssl_random_pseudo_bytes(2020-2003 + 2020-1996);
        $token = bin2hex($token);
        $token = 'Ip~Tec ' . bin2hex(random_bytes(116));
        return $token;
    }

    function DesSESSION()
    {
        session_unset();
        // session_unregister($_SESSION['key']);
        session_destroy();
        echo json_encode(array("Token: "));
        // die;
    }

    
    /* Login Start Here */
    function Login($expload)
    {
        // $datas = "";
        // $this->TokenGen();
        $stmt = $this->connect()->prepare("SELECT * FROM `User_INFO`  WHERE `email`=? AND `password`=?");
        $stmt->execute([$expload[0], $expload[1]]);
        
        if ($stmt->rowCount() > 0) {
            # code...
            // echo "working";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                # code...                    
                
                if ($row['active'] == 1) {
                    # code...
                    $nu = strlen(md5($this->TokenGen(), false));
                    $numb = $nu / 2;
                    $token0 = "==" . openssl_encrypt($row['id'], "AES-128-ECB", "Ip~Tec");
                    $token1 = openssl_encrypt($row['first_name'], "AES-128-ECB", "Ip~Tec");
                    $token2 = openssl_encrypt($row['last_name'], "AES-128-ECB", "Ip~Tec");
                    $token3 = openssl_encrypt($row['email'], "AES-128-ECB", "Ip~Tec");
                    
                    $tokenGENs = $this->TokenGen().$token0.$token1.$token2.$token3;
                    $tokenGEN = str_replace("==", "&&", $tokenGENs);
                    
                    $this->Message([
                        'Token' => $tokenGEN,
                        "User info" => [
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'email' => $row['email']
                        ]]);
                        exit;
                } else {
                    # code...
                    $this->Message(["Error" => "Key hes been revoke"]);
                    exit;
                }
            }
        } else {
            # code...
            $this->Message(["Error" => "User not found."]);
            exit;
        }
    }

    /* Register Stara Here */
    function Reg($expload)
    {
        // echo $expload[0]."<br>", $expload[1]."<br>". $expload[2]."<br>". $expload[3];
        /* if ($this->Login([$expload[2], $expload[3]]) == true) {
            # code...
            $this->Message("Email userd");
            exit;
        } else { */
        $stmt = $this->connect()->prepare("SELECT * FROM `User_INFO` WHERE `first_name` = ? AND `last_name` = ? AND `email` = ?");
        $stmt->execute([$this->CL_FUN($expload[0]), $this->CL_FUN($expload[1]), $this->CL_FUN($expload[2])]);

        if ($stmt->rowCount() == 0) {
            # code...
            $stmt = $this->connect()->prepare("INSERT INTO `User_INFO`
            (`first_name`, `last_name`, `email`, `password`) VALUES (?, ?, ?, ?)");

            $stmt->execute([$expload[0], $expload[1], $expload[2], $expload[3]]);
            $this->Message(["Succes" => ["Registion Successfull."]]);
        // }
        }else{
            $this->Message(["Error" => "Email in used"]);
        }

        /* foreach ($expload as $datas) {
            # code...
            if (empty($datas)) {
                # code...
                $this->Message("empty fileds");
            }else
            {
                
            }
        } */
        // $first_name = $expload[0];
        // $last_name = $expload[1];search
        //  $email = $expload[2];
        // $password = $expload[3];
    }

    /* Search Stara Here */
    function search($data)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM `meun`  WHERE `name` LIKE ? OR `category` LIKE ? OR `price` LIKE ? OR `date_add` LIKE ? LIMIT 10");
        $stmt->execute([$data[0], $data[0], $data[0], $data[0]]);

        if ($stmt->rowCount() > 0) {
            # code...
            // echo "working";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        # code...
                        $this->Message(['Meun' => $row]);
            }
        }else{
            $this->Message(["Error" => ["Can't fine"]]);
        }
    }

    /* Meun Stara Here */
    function meun($expload)
    {
        if ($this->Login([$expload[2], $expload[3]]) == true) {
            # code...
            $this->Message("Email userd");
            exit;
        } else {
            $stmt = $this->connect()->prepare("SELECT * FROM `User_INFO` WHERE `first_name` = ? AND `last_name` = ? AND `email` = ?");
            $stmt->execute([$this->CL_FUN($expload[0]), $this->CL_FUN($expload[1]), $this->CL_FUN($expload[2])]);

            if ($stmt->rowCount() == 0) {
                # code...
                $stmt = $this->connect()->prepare("INSERT INTO `User_INFO`
                (`first_name`, `last_name`, `email`, `password`) VALUES (?, ?, ?, ?)");

                $stmt->execute([$expload[0], $expload[1], $expload[2], $expload[3]]);
                $this->Message("Registion Successfull.");
            }
        }
    }

    function check($info, $num, $where)
    {
        $expload = explode(',', $info);
        if (count($expload) == $num) {
            if (empty(array_values($expload)) && array_values($expload) == '' && array_values($expload) == '/') {
                # code...
                $this->Message("Empty values");
                exit;
            } else {
                
                $this->$where($expload);
                // exit;
            }
        } else {
            $this->Message(["Note" => "Required " . $num . " values", "Given" => $expload]);
            exit;
        }
    }

    function __construct()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            # code...            
            // $this->Message("key", $_SESSION['key']);
            /* $login = $_POST['login'];
            $reg = $_POST['reg'];
            $search = $_POST['search'];
            $meun = $_POST['meun'];
            $vendor = $_POST['vendor']; */

            if (isset($_POST['login'])) {
                # code...
                $expload = explode(',', $_POST['login']);
                
                $this->check($_POST['login'], 2, 'Login');
                                
            }elseif (isset($_POST['reg'])) {
                # code...
                $expload = explode(',', $_POST['reg']);
                // print_r($expload);
                $this->check($_POST['reg'], 4, 'Reg');

            }elseif (isset($_POST['search'])) {
                # code...
                $expload = explode(',', $_POST['search']);
                $this->check($_POST['search'], 1, 'search');
            } elseif (isset($_POST['meun'])) {
                # code...
                $object = new MeunClass;
                $token = $_POST['token'];
                $expload = explode('=', $_POST['meun']);
                if (count($expload) == 2) {
                    # code...
                    // $this->Message($expload);
                    $object->_splitter($_POST['meun'], $token);
                } else {
                    $object->_splitter($expload, $token);
                }

            }elseif (isset($_POST['vendor'])) {
                # code...
                $object = new VendorClass;
                $expload = explode('=', $_POST['vendor']);
                if (count($expload) == 2) {
                    # code...
                    if (isset($_POST['token'])) {
                        # code...
                        $object->_splitter($_POST['vendor'], $_POST['token']);
                    }else{
                        $object->_splitter ($_POST['vendor']);
                }
                }else{
                    if (isset($_POST['token'])) {
                        # code...
                        $object->_splitter($_POST['vendor'], $_POST['token']);
                    } else {
                        $object->_splitter($_POST['vendor']);
                    }
                }
                // $this->check($_POST['Lvendor'], 1, 'Rvendor');
            }elseif (isset($_POST['other'])) {
                # code...
                if (isset($_POST['token'])) {
                    # code...
                    $object = new OtherClass($_POST['other'], $_POST['token']);
                } else {
                    $object = new OtherClass($_POST['other']);
                }
                /* $expload = explode('=', $_POST['other']);
                if (count($expload) == 2) {
                    # code...
                    // $this->Message($expload);
                    $object();
                } else {
                    $object();
                } */
            }

            // $fields = explode(',', $_POST['login']);
            // $this->Message("Good 2", $fields);
        }
        else{
            $this->Message("User POST METHOD");
        }
    }
}


$object = new AuthClass;
// $object->DesSESSION();
