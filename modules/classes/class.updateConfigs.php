<?php

include_once('class.database.php');

class updateConfigs{
    public $link;

    function __construct(){
        $db_connection = new dbConnection();
        $this->link = $db_connection->connect();
        return $this->link;
    }

    function updateEmail($email){
        $query = $this->link->prepare("UPDATE configs SET mailing_address=:email");
        //$values = array($name, $email, $pass, $ip);
        $query->bindParam(":email", $email);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

    function updateDate($date){
        $date = secure_parameter($date);
        $query = $this->link->prepare("UPDATE configs SET calibration_date=:new_date");
        $query->bindParam(":new_date", $date);
        $query->execute();
        $counts = $query->rowCount();
        if($counts){
            return true;
        }if(!$counts){
            return false;
        }
    }

    function getConfigs(){
        $query = $this->link->prepare("SELECT * FROM configs");
        $query->execute();
        $rowcount = $query->rowCount();
        if($rowcount){
            return $query->fetchAll();
        }else{
            return $rowcount;
        }
    }

    function del_row($table_name, $id){
        try{
            $id = secure_parameter($id);
            $sql = "DELETE FROM $table_name WHERE id=:id";
            $query = $this->link->prepare($sql);
            $query->bindParam(":id", $id);
            $query->execute();
            if($query->rowCount()){
                js_alert("Record Deleted!");
                js_redirect("admin_dashboard.php");
            }
            else{
                js_alert("Error whlile Deleting Record !");
                js_redirect("admin_dashboard.php");
            }
        }
        catch (PDOException $e){
            handle_sql_errors($sql, $e);
        }

    }
}