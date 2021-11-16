<?php

include_once('class.database.php');

class logger{
    public $link;

    function __construct(){
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    function device_added($device_name, $cat){
        $data = "New Device '$device_name' was Added";
        $query = $this->link->prepare("INSERT INTO logs (message, cat) VALUE (:device_name, :cat)");
        $query->bindParam(":device_name", $data);
        $query->bindParam(":cat", $cat);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

    function user_added($username, $cat){
        $data = "New User '$username' was Added";
        $query = $this->link->prepare("INSERT INTO logs (message, cat) VALUE (:username, :cat)");
        $query->bindParam(":username", $data);
        $query->bindParam(":cat", $cat);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

    function device_removed($device_name, $cat){
        $data = "Device '$device_name' was removed";
        $query = $this->link->prepare("INSERT INTO logs (message, cat) VALUE (:device_name, :cat)");
        $query->bindParam(":device_name", $data);
        $query->bindParam(":cat", $cat);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

}