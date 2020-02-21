<?php
include_once './Db_conn.php';

class OtherClass extends DB
{
    function __construct($data, $token = null)
    {
        if (strtolower($data) == "view=") {
            # code...
            $this->View();
            exit;
        } elseif (strtolower($data) == 'view') {
            $this->View();
            exit;
        } else {
            $expload = explode(':', $data);
            if (count($expload) != 1) {
                # code...
                $this->Message(["Error" => ["input not valid"]]);
                exit;
            } else {
                $other = explode('=', $expload[0]);
                // $token = explode('=', $expload[1]);
            }
        }

        if (strtolower($other[0]) == "other") {
            # code...
            // print_r ($token);
            if (strtolower($token) != null) {
                # code...
                $field = explode('&&', $token);

                if (count($field) == 6) {
                    # code...
                    $expload = explode(',', $other[1]);
                    if (count($expload) == 3) {
                        # code...
                        foreach ($expload as $value) {
                            # code...
                            if (empty($value)) {
                                # code...
                                $this->Message(["Error" => "Empty field."]);
                                exit;
                            }
                        }
                        $this->Other($expload, $token);
                        exit;
                    } else {
                        $this->Message(["Error" => "Field must be 4."]);
                        exit;
                    }
                } else {
                    $this->Message(["Error" => "Field must be 1."]);
                    exit;
                }
            } else {
                $this->Message(["Error" => "Token must be given."]);
                exit;
            }
        } elseif (strtolower($other[0]) == "other") {
            # code...
            $this->View();
        }
    }


    public function Message($msg)
    {
        header("Content-Type: applecation/json");
        echo json_encode($msg);
    }

    function Other($data, $token)
    {
        $userID = $token;
        $meun_id = intval($data[0]);
        $V_ID = intval($data[1]);
        $quent = intval($data[2]);
        $token = explode("&&", $userID);
        // $Dencrypt = openssl_decrypt($expload[0], "AES-128-ECB", "Ip~Tec");
        $id = intval(openssl_decrypt($token[1], "AES-128-ECB", "Ip~Tec"));
        $first_name = openssl_decrypt($token[2], "AES-128-ECB", "Ip~Tec");
        $last_name = openssl_decrypt($token[3], "AES-128-ECB", "Ip~Tec");
        $email = openssl_decrypt($token[4], "AES-128-ECB", "Ip~Tec");
        // print_r([$id, $meun_id, $V_ID, $quent]);
        // print_r([$id, $first_name, $last_name, $email]);
        echo $id;

        $stmt = $this->connect()->prepare("SELECT * FROM `User_INFO` WHERE `id` = ? AND `first_name` = ? AND `last_name` = ? AND	`email` = ?");
        $stmt->execute([$id, $first_name, $last_name, $email]);
        if ($stmt->rowCount() == 1) {
            # code...
            $stmt = $this->connect()->prepare("INSERT INTO `Other` (`user_id`, `meun_id`, `V_ID`, `Quantity`) 
            VALUES (?, ?, ?, ?)");
            $stmt->execute([$id, $meun_id, $V_ID, $quent]);
            $this->Message(["Success" => "Other Placest."]);
            exit;
        } else {
            $this->Message(["Error" => ["Wrong token"]]);
            exit;
        }
    }

    function RemoveOther()
    {
    }

    function View($nu = null, $V_ID = null, $price = null)
    {
        // WHERE `V_ID` = ? AND `price` = ? 
        $stmt = $this->connect()->prepare("SELECT * FROM `meun`   LIMIT 10");
        $stmt->execute([]);
        if ($stmt->rowCount() > 0) {
            # code...
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                # code...
                $this->Message([
                    "Other" => [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'V_ID' => $row['V_ID'],
                        'price' => $row['price']
                    ]
                ]);
            }
            // exit;
        }
    }
}
