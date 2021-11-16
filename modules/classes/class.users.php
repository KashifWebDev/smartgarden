<?php

include_once('class.database.php');

class Users{
    public $link;

    function __construct(){
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    function registerUser($name, $email, $pass, $ip){
        $query = $this->link->prepare("INSERT INTO users (fullname, email, pass, ip)
        VALUE (?, ?, ?, ?)
        ");
        //$values = array($name, $email, $pass, $ip);
        $query->bind_param("s", $name, $email, $pass, $ip);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

    function logIn($email, $password){
        try{
            $query = $this->link->prepare("SELECT * FROM users WHERE email = :email AND password = :pass");
            $query->bindParam(':email', $email);
            $query->bindParam(':pass', $password);
            //$query->execute(array($email, $password));
            $query->execute();
            $user_details = $query->fetchAll();
            $counts = count($user_details);
            if($counts){
                return $user_details;
            }if(!$counts){
                return false;
            }
        }
        catch (PDOException $exception){
            echo $exception;
            die();
            exit();
        }
    }

    function getUserInfo($email){
        $query = $this->link->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute(array($email));
        $rowcount = $query->rowCount();
        if($rowcount){
            return $query->fetchAll();
        }else{
            return $rowcount;
        }
    }

    function getUserInfoById($id){
        $query = $this->link->prepare("SELECT * FROM users WHERE id = ?");
        $query->execute(array($id));
        $rowcount = $query->rowCount();
        if($rowcount){
            return $query->fetchAll();
        }else{
            return $rowcount;
        }
    }

    function getDeviceInfoById($id){
        $query = $this->link->prepare("SELECT * FROM user_and_devices WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $rowcount = $query->rowCount();
        if($rowcount){
            return $query->fetchAll();
        }else{
            return $rowcount;
        }
    }

    function chk_user($email){
        $query = $this->link->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $rowcount = $query->rowCount();
        if($rowcount){
            return 1;
        }else{
            return 0;
        }
    }

    function change_pass($pass, $userid){
        $query = $this->link->prepare("UPDATE users SET password=:pass WHERE id=:id");
        $query->bindParam(':pass', $pass);
        $query->bindParam(':id', $userid);
        $query->execute();
        if($query->rowCount()){
            return 1;
        }else{
            return 0;
        }
    }

    function add_device($uid, $device_name, $device_mac, $location){
        try{
            $sql = "INSERT INTO user_and_devices (user_id, mac, device_name, location) 
                VALUES (:uid, :device_mac, :device_name, :location)";
            $query = $this->link->prepare($sql);
            $query->bindParam(':uid', $uid);
            $query->bindParam(':device_mac', $device_mac);
            $query->bindParam(':device_name', $device_name);
            $query->bindParam(':location', $location);
            $query->execute();
            $counts = $query->rowCount();
           if($counts){
                return true;
            }if(!$counts){
                return false;
            }
        }
        catch (PDOException $e){
            handle_sql_errors($sql, $e->getMessage());
        }
    }

    function add_user($fullname, $email, $pass){
        //CHECK IF EMAIL EXISTES
        if($this->chk_user($email)){
            js_alert("Email Already Exists!");
            js_redirect("admin_dashboard.php");
            die();
        }
        //INSERT New User
        try {
            $sql = "INSERT INTO users (username, email, password) VALUE (:fullname, :email, :password)";
            $query = $this->link->prepare($sql);
            $query->bindParam(':fullname', $fullname);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $pass);
            $query->execute();
            $counts = $query->rowCount();
            if($counts){
                return true;
            }if(!$counts){
                return false;
            }
        }
        catch (PDOException $e){
            handle_sql_errors($sql, $e->getMessage());
        }
    }

    function handle_sql_errors($query, $error_message)
    {
        echo '<pre>';
        echo $query;
        echo '</pre>';
        echo $error_message;
        die;
    }

    function updateEmailAddress($id, $email){
        $query = $this->link->prepare("UPDATE user_and_devices SET mailing_address=:email WHERE id=:id");
        //$values = array($name, $email, $pass, $ip);
        $query->bindParam(":email", $email);
        $query->bindParam(":id", $id);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

    function updateDeviceDetails($id, $name, $mac, $loc){
        $query = $this->link->prepare("UPDATE user_and_devices SET device_name=:d_name, mac=:mac, location=:loc WHERE id=:id");
        //$values = array($name, $email, $pass, $ip);
        $query->bindParam(":d_name", $name);
        $query->bindParam(":mac", $mac);
        $query->bindParam(":loc", $loc);
        $query->bindParam(":id", $id);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

    function updateDate($id, $date){
        $date = secure_parameter($date);
        $query = $this->link->prepare("UPDATE user_and_devices SET calibration_date=:new_date WHERE id=:id");
        $query->bindParam(":new_date", $date);
        $query->bindParam(":id", $id);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }



    //END OF USER CLASS
}