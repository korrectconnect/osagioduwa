<?php

class CleanClass 
{
    public $data;

    public function __construct($data)
    {
        # code...
        $this->data = $data;
        $clean = trim($this->data);
        $clean1 = empty($clean);
        if (empty($clean1)) {
            # code...
            return false;
            exit("EMPTY DATA");
        }else
        {
            $clean2 = stripslashes($clean1);
            $clean3 =  htmlspecialchars($clean2);
            $clean4 =  filter_var($clean3, FILTER_SANITIZE_STRING);
            echo $clean4 . "<br>";
        }
    }

    function GetData()
    {
        /* if (empty($this->data)) {
            # code...
            error_msg(303, "empty filed");
        } */
        return $this->data;
    }
}

?>
