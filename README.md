#Ip~Tec
#Innocent Peter

Db_conn.php file is responsible for the connect of the databass

login.php file hand the Login

clean.php clean the data befor to is sand it is called automaticaly

How to Use 

Get All User---
              |~>example{
                    http://127.0.0.1/Web/Chopnow/api/user/index.php
              }

Get All Vendor---
                |~>example{
                    http://127.0.0.1/Web/Chopnow/api/vendor/vendo.php
                }

Regist a user---
                |~>example{
                    http://127.0.0.1/Chopnow/api/user/register.php?
                    first_name=Innocent
                    &
                    last_name=peter
                    &
                    email=GTfood@gmail.com
                    &
                    password=12345
                }
Requirement to Regist a USER {
                              first_name, last_name, email and password.
                  }

Regist a Vendor---
                 |~>example{
                     http://127.0.0.1/Chopnow/api/vendor/register/index.php?Vname=GTl&Vemail=GTfood@gmail.com&Vpassword=12345&VAddress=No 2 off alli streat off then off now off almust donw&V_info=090383745&Vstate=Edo&LGA=Esan south&Bosstop=AAU Gate&Open_H =06:00}

Requirement to Regist a VENDOR {
                    Vname, Vemail, Vpassword, VAddress, V_info, Vstate, Bosstop and Open_H
                    NOTE: V_info is the contact of the vendor (Phone number)



Rules:
     [
        Allways use a POST METHOD
      ]

 Api---- |->admin
         |
         |->api--|
                 |->user--|-index.php
                 |        |
                 |        |-regist.php
                 |
                 |
                 |->vendor--|->login--|-index.php
                            |
                            |->meun--|->add--|-index.php
                            |        |       
                            |        |->remove--|-index.php
                            |        |
                            |        |update--|-index.php
                            |
                            |
                            |->regist--|-index.php
#       
