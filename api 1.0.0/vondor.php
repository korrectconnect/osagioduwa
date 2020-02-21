<?php
include_once './Db_conn.php';
include_once './TokenGen.php';

class VendorClass extends DB
{
    public function Message($msg)
    {
        header("Content-Type: applecation/json");
        echo json_encode($msg);
    }

    public function TokenGen()
    {
        $token = openssl_random_pseudo_bytes(2020 - 2003 + 2020 - 1996);
        $token = bin2hex($token);
        $token = 'Ip~Tec ' . bin2hex(random_bytes(116));
        return $token;
    }

    function _splitter($data, $token=null)
    {

        $expload = explode('=', $data);

        $what = strtolower($expload[0]);

        if ($what == "login") {
            # code...
            $login = explode(',', $expload[1]);
            $this->Login($login);
        } elseif ($what ==  "register") {

            $register = explode(',', $expload[1]);
            $this->Register($register); exit;

            if (count($register) == 7) {
                # code...
                $this->Register($register);

            } else {

                if (count($register) == 9) {
                    # code...
                    $this->Register($register);
                    
                }else{
                    $this->Message(["Error" => "values not compleat"]);
                }
            }
        } else {
            $this->Message("Can't work with " . $expload[0]);
        }
        // $this->Message($expload[0]);
        // $this->Message($login);
        // $this->Login($login);



    }

    function Login($data)
    {
        $Vid = $data[0];
        $vpassword = $data[1];
        if (empty($data[0]) or empty($data[1]) or empty($data[2])) {
            # code...
            $this->Message(["Error" => " Empty fields"]);
            exit;
        } else {
            // echo json_encode(array($this->TokenGen(), "working "=>array($data)));

            $stmt = $this->connect()->prepare("SELECT * FROM `Vendor`  WHERE `Vname`=? AND	`V_ID`=? AND `Vpassword`=?");
            $stmt->execute([$data[0], $data[1], $data[2]]);

            if ($stmt->rowCount() > 0) {
                # code...
                // echo "working";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    # code...

                    if ($row['active'] == 1) {
                        # code...
                        // use Defuse\Crypto\Crypto;
                        // use Defuse\Crypto\Crypto;
                        $object = new TokenClass;
                        $V_ID = openssl_encrypt($row['V_ID'],"AES-128-ECB", "Ip~Tec");
                        $Vemail = openssl_encrypt($row['Vemail'],"AES-128-ECB", "Ip~Tec");
                        $Vpassword = openssl_encrypt($row['Vpassword'],"AES-128-ECB", "Ip~Tec");
                        $token = trim($object->Generator() . "&&" . $V_ID . "&&" . $Vemail. "&&" . $Vpassword);
                        // $token = md5($token);
                        $token_decrypt = openssl_decrypt($token,"AES-128-ECB", "Ip~Tec");
                        $this->Message([
                            'Token' => [$token],
                            "User info" => [
                                'first_name' => $row['Vname'],
                                'V_ID' => $row['V_ID'],
                                'email' => $row['Vemail']
                            ]
                        ]);

                        return true;
                        exit;
                    } else {
                        # code...
                        $this->Message(["Error" => "Account is disable"]);
                        return false;
                        exit;
                    }
                }
            } else {
                # code...
                $this->Message(["Error" => "User not found."]);
                exit;
            }
        }

        $this->Message(["Info" => ["Vendor ID" => $data[0], "vendor password" => $data[1]]]);
        $this->Message($data);
        // $this->Message($Vid);
        // $this->Message($vpassword);
    }
    function Register($data)
    {
        $t = md5(rand(2003, 2003*1996), FALSE);
        $V_ID = rand(2003 + 1996, 2003 * 1996);
        
        $data[7] = "null";
        $data[8] = "06:00:00";
        try {
            //code...
            $stmt = $this->connect()->prepare("SELECT * FROM `Vendor` WHERE `Vname` = ? AND `Vemail` = ? AND `Vpassword` = ?");
            $stmt->execute([$data[0], $data[1], $data[2]]);
        } catch (PDOException $th) {
            //throw $th;
            $this->Message(["Error" => $th->getMessage()]);
        }

        if ($stmt->rowCount() == 0) {
            # code...
            $stmt = $this->connect()->prepare("INSERT INTO `Vendor`
            (`Vname`, `Vemail`, `V_ID`, `Vpassword`, `VAddress`, `V_info`, `Vstate`, `LGA`, `Bosstop`, `Open_H`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([$data[0], $data[1], $V_ID, $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]]);
            $this->Message(["Success" => "Registion Successfull."]);
            // }
        } else {
            $this->Message(["Error" => ["Email in used", "Vendor name is used"]]);
        }
    }
}
