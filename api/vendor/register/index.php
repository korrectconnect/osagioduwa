<?php

include_once '../../../Db_conn.php';
include_once '../../../clean.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST')
// {
    # code...
    class V_RegClass extends DB
    {
        public function CL_FUN($check)
        {
            $cleanFun = new CleanClass($check);
            $clean_data = $cleanFun->GetData();
            return $clean_data;
        }

        function VendorSQL($Vname, $Vemail, $V_ID, $Vpassword, $VAddress, $V_info, $Vstate, $LGA, $Bosstop, $Open_H)
        {
            $stmt = $this->connect()->prepare("SELECT * FROM `Vendor` WHERE `Vname` = ?  AND `V_ID` = ? OR `Vemail` = ? AND `Vpassword` = ?");
            $stmt->execute([$Vname, $V_ID, $V_ID, $Vpassword]);

            if ($stmt->rowCount() == 0) {
                # code...
                $stmt = $this->connect()->prepare("INSERT INTO `Vendor`
                (`Vname`, `Vemail`, `V_ID`, `Vpassword`, `VAddress`, `V_info`, `Vstate`, `LGA`, `Bosstop`, `Open_H`) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute([
                    $this->CL_FUN($Vname) ,
                    $this->CL_FUN($Vemail) ,
                    $this->CL_FUN($V_ID) ,
                    $this->CL_FUN($Vpassword) ,
                    $this->CL_FUN($VAddress) ,
                    $this->CL_FUN($V_info) ,
                    $this->CL_FUN($Vstate) ,
                    $this->CL_FUN($LGA) ,
                    $this->CL_FUN($Bosstop) ,
                    $this->CL_FUN($Open_H )
                ]);

                echo json_encode(array("Vendor Successfully Added.","vendor id","$V_ID"));
                
            } else {
                echo json_encode(array("Could'n add Vendor."));
            }
        }

        function Reg()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                # code...
                $Vname = $_POST['Vname'];
                $Vemail = $_POST['Vemail'];
                $V_ID = rand(16, 1996);
                $Vpassword = $_POST['Vpassword'];
                $VAddress = $_POST['VAddress'];
                $V_info = $_POST['V_info'];
                $Vstate = $_POST['Vstate'];
                $LGA = $_POST['LGA'];
                $Bosstop = $_POST['Bosstop'];
                $Open_H = $_POST['Open_H'];

                $this->VendorSQL($Vname, $Vemail, $V_ID, $Vpassword, $VAddress, $V_info, $Vstate, $LGA, $Bosstop, $Open_H);
                
            }elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
                # code...
                $Vname = $_GET['Vname'];
                $Vemail = $_GET['Vemail'];
                $V_ID = rand(16, 1996);
                $Vpassword = $_GET['Vpassword'];
                $VAddress = $_GET['VAddress'];
                $V_info = $_GET['V_info'];
                $Vstate = $_GET['Vstate'];
                $LGA = $_GET['LGA'];
                $Bosstop = $_GET['Bosstop'];
                $Open_H = $_GET['Open_H'];

                $this->VendorSQL($Vname, $Vemail, $V_ID, $Vpassword, $VAddress, $V_info, $Vstate, $LGA, $Bosstop, $Open_H);
            }
        }
    }

    $object = new V_RegClass;
    header('Content-Type: applecation/json');
    $object->Reg();
    
// }


?>