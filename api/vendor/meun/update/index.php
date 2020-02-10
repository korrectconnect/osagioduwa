<?php

include_once '../../../../Db_conn.php';
include_once '../../../../clean.php';


class UpdataClass extends DB
{
    public function CL_FUN($check)
    {
        $cleanFun = new CleanClass($check);
        $clean_data = $cleanFun->GetData();
        return $clean_data;
    }

    function UpDataSQL($name, $V_ID, $pic_url, $decription, $category, $price, $numb_food, $date_add)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM `meun` WHERE `name` = ? AND `V_ID` = ? OR `category` = ? AND `price` = ?");
        $stmt->execute([$name, $V_ID, $category, $price]);

        if ($stmt->rowCount() >= 1) {
            # code...
            $stmt = $this->connect()->prepare("UPDATE `meun` WHERE `name`, `V_ID`,  `category`, `price`, `numb_food`, `date_add`)SET(?, ?, ?, ?, ?)");
            $this->CL_FUN($stmt->execute([$V_ID, $category, $price, $numb_food, $date_add]));
            echo json_encode(array("Update Successfull."));
        }
    }

    function VUpdate()
    {
        if (isset($_REQUEST['REQUEST_METHOD']) == 'POST') {
            # code...
            $name = $_POST['name'];
            $V_ID = $_POST['V_ID'];
            $pic_url = $_POST['pic_url'];
            $decription = $_POST['decription'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $numb_food = $_POST['numb_food'];
            $date_add = $_POST['date_add'];

            $this->UpDataSQL($name, $V_ID, $pic_url, $decription, $category, $price, $numb_food, $date_add);
        }else {
            # code...
            echo json_encode(array("User POST METHOD ONLY"));
        }
    }
}

$object = new UpdataClass;
$object->VUpdate();
