<?php
include_once "../../Db_conn.php";

class VendorClass extends DB
{
    function VLogin()
    {

        $stmt = $this->connect()->prepare("SELECT * FROM `Vendor` ORDER BY `id` ASC LIMIT 10");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            # code...
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo json_encode(
                    array(
                        "Vname" => $row["Vname"],
                        "Vemail" => $row["Vemail"],
                        "V_ID" => $row["V_ID"],
                        "Vpassword" => $row["Vpassword"],
                        "VAddress" => $row["VAddress"],
                        "V_info" => $row["V_info"],
                        "Vstate" => $row["Vstate"],
                        "LGA" => $row["LGA"],
                        "Bosstop" => $row["Bosstop"],
                        "Open_H" => $row["Open_H"]
                    )
                );
            }
        } else {
            # code...
            echo json_encode("There's no Vendor in DB");
        }
    }

}
/* function VRegister($Vname, $email, $password, $VADdress, $V_info, $Vstate, $LGA, $Bosstop, $Open_H)
    {
        /* echo $Vname . "<br>";
        echo $email . "<br>";
        echo $VADdress . "<br>";
        echo $password . "<br>";
        echo $Vstate . "<br>";
        echo $V_info . "<br>";
        echo $LGA . "<br>";
        echo $Bosstop . "<br>";
        echo $Open_H . "<br>";
        print_r(array($Vname, $email, $password, $VADdress, $V_info, $Vstate, $LGA, $Bosstop, $Open_H)); */
/* $cha = $this->VLogin($Vname, $email, $password);
        if ($cha == "User dont exit") { */
# code...
/*  echo json_encode("<br>{message:person they  Use the in info you give me}");
            exit();
        }else { */
# code...
/* $V_ID = random_int(2003,19962003);
            if (strlen($V_ID) <=> 7 ) {
                # code...
                $V_ID = random_int(9, 19962003);
            }
            $stmt = $this->connect()->prepare("INSERT INTO `Vendor` 
            (`Vname`, `Vemail`, `V_ID`, `Vpassword`, `VAddress`, `V_info`, `Vstate`, `LGA`, `Bosstop`, `Open_H`) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$Vname, $email, $V_ID, $password, $VADdress, $V_info, $Vstate, $LGA, $Bosstop, $Open_H]);
            echo $this->VLogin($Vname, $email, $password);

        }
    } */

$object = new VendorClass;
header('Content-Type: applecation/json');
$object->VLogin();
