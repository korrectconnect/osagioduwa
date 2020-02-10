<?php
include_once '../../../../Db_conn.php';
include_once '../../../../clean.php';
include_once '../update/index.php';

class MeunClass extends DB
{
    public function CL_FUN($check)
    {
        $cleanFun = new CleanClass($check);
        $clean_data = $cleanFun->GetData();
        return $clean_data;
    }
    function MeunSQL($name, $V_ID, $pic_url, $decription, $category, $price, $numb_food, $date_add)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM `meun` WHERE `name` = ? AND `V_ID` = ? OR `category` = ? AND `price` = ?");
        $stmt->execute([$name, $V_ID, $category, $price]);

        if ($stmt->rowCount() <= 0) {
            # code...
            $stmt = $this->connect()->prepare("INSERT INTO `meun` (`name`, `V_ID`, `pic_url`, `decription`, `category`, `price`, `numb_food`, `date_add`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $this->CL_FUN($stmt->execute([$name, $V_ID, $pic_url, $decription, $category, $price, $numb_food, $date_add]));

            echo json_encode(array("Added Successfull."));

        } elseif ($stmt->rowCount() >= 1) {
            # code...
            // try {
                //code...
                $GLOBALS['numb_food'] = $stmt->fetch(PDO::FETCH_ASSOC);
                $UpdataClass = new UpdataClass;
                $numb_food = $GLOBALS['numb_food'] + 1;

                $UpdataClass($name, $V_ID, $pic_url, $decription, $category, $price, $numb_food, $date_add);
            // } catch (Exception $e) {
                echo json_encode(array("Error: "));
            // }
            

        } else {
            # code...
            echo json_encode(array("Could'n Add to Meun"));
        }
    }


    function AddMeun()
    {
        if (isset($_SERVER['REQUEST_METHOD']) == 'POST' || 'GET') {
            # code...
            $name = $_GET['name'];
            $V_ID = $_GET['V_ID'];
            $pic_url = $_GET['pic_url'];
            $decription = $_GET['decription'];
            $category = $_GET['category'];
            $price = $_GET['price'];
            $numb_food = $_GET['numb_food'];
            $date_add = date("d:m:y");

            $this->CL_FUN($this->MeunSQL($name, $V_ID, $pic_url, $decription, $category, $price, $numb_food, $date_add));

        } else {
            echo json_encode(array("User POST METHOD ONLY"));
        }
    }
}

$MeunObject = new MeunClass;
header('Content-Type: applecation/json');
$MeunObject->AddMeun();

