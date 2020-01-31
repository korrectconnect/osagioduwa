<?php

class CleanClass 
{
    public function __construct($data)
    {
        # code...
        $clean = trim($data);
        $clean = stripslashes($clean);
        $clean =  htmlspecialchars($clean);
        $clean =  filter_var($clean, FILTER_SANITIZE_STRING);
        echo $data . "<br>";
        return $data;
    }
}

?>
