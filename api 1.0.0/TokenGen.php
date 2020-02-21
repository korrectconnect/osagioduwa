<?php

class TokenClass
{
    function Generator()
    {
        $token = openssl_random_pseudo_bytes(2020 - 2003 + 2020 - 1996);
        $token = bin2hex($token);
        $token = 'Ip~Tec ' . bin2hex(random_bytes(116));
        return $token;
    }

    function Decode($token){
        $data = openssl_decrypt($token, "AES-128-ECB", "Ip~Tec");
        return $data;
    }
}


?>