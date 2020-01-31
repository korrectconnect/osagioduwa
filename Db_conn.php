<?php

class DB
{
    private $servername;
    private $username;
    private $password;
    private $dbname;



    public function connect()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "kocots";

        try {

            // Connection to DataBss
            $conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->dbname, $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            // echo "Connected to Bot Database successfully<br>";
        } catch (PDOException $e) {
            echo "CONNECT FAILED: " . $e->getMessage() . " is not validate";
        }
    }
}
