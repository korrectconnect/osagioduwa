<?php
include_once './Db_conn.php';
include_once './vondor.php';
include_once './TokenGen.php';

class MeunClass extends DB
{
    function Message($msg)
    {
        $object = new VendorClass;
        $object->Message($msg);
    }
    function _splitter($data, $token)
    {
        if (!isset($token)) {
            # code...
            $this->Message(["Error" => ["Token not given"]]);
            exit;
        }else{
            if (empty(strtolower(trim(htmlspecialchars($token))))) {
                # code...
                echo $token;
                $this->Message(["Error" => ["Empty token"]]);
                exit;
            }else {
                $TokenExpload = explode("&&", $token);

                $Tstmt = $this->connect()->prepare("SELECT * FROM `Vendor`  WHERE `V_ID` = ? AND	`Vemail` = ? AND `Vpassword` = ?");
                $tokenGen = new TokenClass();
                echo $tokenGen->Decode($TokenExpload[3]);
                $Tstmt->execute([$tokenGen->Decode($TokenExpload[1]), $tokenGen->Decode($TokenExpload[2]), $tokenGen->Decode($TokenExpload[3])]);
                if ($Tstmt->rowCount() == 1) {
                    # code...
                    $expload = explode('=', $data);
                    if (strtolower($expload[0]) == "add") {
                        # code...
                        $add = explode(',', $expload[1]);

                        if (count($add) == 8) {
                            # code...
                            foreach ($add as $value) {
                                # code...
                                if (empty($value)) {
                                    # code...
                                    $this->Message(["Add" => ["Error" => "Found empty values"]]);
                                    exit;
                                }
                            }
                            $this->Add($add);
                        } else {
                            if (count($add) == 7) {
                                # code...
                                foreach ($add as $value) {
                                    # code...
                                    if (empty($value)) {
                                        # code...
                                        $this->Message(["Add" => ["Error" => "Found empty values"]]);
                                        exit;
                                    }
                                }
                                $this->Add($add);
                            }
                        }
                    } else {
                        if (strtolower($expload[0]) == "remove") {
                            # code...
                            $remove = explode(',', $expload[1]);
                            if (count($remove) == 3) {
                                # code...
                                foreach ($remove as $value) {
                                    # code...
                                    if (empty($value)) {
                                        # code...
                                        $this->Message(["Remove" => ["Error" => "Found empty values"]]);
                                        exit;
                                    }
                                }
                                $this->Remove($remove);
                            }
                            // $this->Message(["INFO" => $remove]);
                        }
                    }
                }else{
                    $this->Message(["Error" => ["Invelid token"]]);
                    exit;
                }

                
            }
        }
    }

    /* Add item to Meun */

    function Add($data)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM `meun`  WHERE `name`=? AND	`V_ID`=? AND `price`=?");
        $stmt->execute([$data[0], $data[1], $data[5]]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() == 1) {
            # code...
            $stmt = $this->connect()->prepare("UPDATE `meun` SET `numb_food` = ? WHERE `name` = ? AND `V_ID` = ? AND `price` = ?");
            $stmt->execute([$row['numb_food'] + $data[5], $data[0], $data[1], $data[4]]);
            $this->Message(["Success" => ["Adds" => ["Updated" => [$row['numb_food']+ $data[5]]]]]);
            /* while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    # code...
            } */
        }else{
            $stmt = $this->connect()->prepare("INSERT INTO `meun`
            (`name`, `V_ID`, `pic_url`, `decription`, `category`, `price`, `numb_food`, `date_add`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([$data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7]]);
            $this->Message(["Success" => ["Adds" => $data[5]]]);
        }
        
    }

    /* Remove item from Meun */

    function Remove($data)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM `meun`  WHERE `name`=? AND	`V_ID`=? AND `price`=?");
        $stmt->execute([$data[0], $data[1], $data[5]]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            # code...
            $stmt = $this->connect()->prepare("DELETE FROM `meun`  WHERE `name`=? AND	`V_ID`=? AND `price`=?");
            $stmt->execute([$data[0], $data[1], $data[5]]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                # code...
                $this->Message(["Remove" => $data]);
            } else {
                $this->Message(["Error" => ["Can't remove Meun"]]);
            }
        }else{
            $this->Message(["Error" => ["Can't fine Meun"]]);
        }
    }
    
}


?>