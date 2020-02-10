<?php

include_once '../../../Db_conn.php';
include_once '../../../clean.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    # code...
    class VendorClass extends DB 
    {
        public function CL_FUN($check)
        {
            $cleanFun = new CleanClass($check);
            $clean_data = $cleanFun->GetData();
            return $clean_data;
        }

        function VSQL($Vname, $V_ID, $password)
        {
            $stmt = $this->connect()->prepare("SELECT * FROM `Vendor` WHERE `Vname` = ?  AND `V_ID` = ? OR `Vemail` = ? AND `Vpassword` = ?");
            $stmt->execute([$Vname, $V_ID, $V_ID, $password]);

            if ($stmt->rowCount() > 0) {
                # code...
                // echo $email;
                // echo $pwd;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo json_encode(
                        array($row)                        
                    );
                }
            } else {
                # code...
                echo json_encode(array("User dont exit"));
            }
        }

        function VLogin ()
        {
            if (isset($_REQUEST['REQUEST_METHOD']) == 'POST') {
                # code...
                $Vname = $this->CL_FUN($_POST['Vname']);
                $V_ID = $this->CL_FUN($_POST['V_ID']);
                $password = $this->CL_FUN($_POST['password']);

                echo $Vname, $V_ID, $password;

                $this->VSQL($Vname, $V_ID, $password);
            }
            
        }
        
    }

    $object = new VendorClass;
    header('Content-Type: applecation/json');
    $object->VLogin();
}

?>