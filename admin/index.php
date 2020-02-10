<?php

include_once '../Db_conn.php';
include_once '../../Chopnow/clean.php';
include_once '../api/user/index.php';
include_once '../api/vendor/vendo.php';
include '../../Chopnow/Db_conn.php';

class AdminClass extends DB
{
    function Admin()
    {}

    function User()
    {
        $object = new SelectClass;
        header('Content-Type: applecation/json');
        $object->Select();
    }

    function Vendor()
    {
        $object = new VendorClass;
        header('Content-Type: applecation/json');
        $object->VLogin();
    }

    function AdminSelect()
    {
        if ($_POST['user']) {
            # code...
            $this->User();
        }
        if ($_POST['vendor']) {
            # code...
            $this->Vendor();
        }
    }
}

$AdminClass = new AdminClass;
header('Content-Type: applecation/json');
$AdminClass->AdminSelect();

?>