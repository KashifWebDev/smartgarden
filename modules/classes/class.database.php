<?php

class dbConnection{
    protected $db_con;
    protected $db_name = "project_smartgarden";
    protected $db_user = "root";
    protected $db_pass = "";
    protected $db_host = "localhost";


/*
    protected $db_con;
    protected $db_name = "turkvjwp_zenit";
    protected $db_user = "turkvjwp_fingerprinttest";
    protected $db_pass = "fingerprinttest";
    protected $db_host = "server127.web-hosting.com";
*/

    function connect(){
        try{
            $this->db_con = new PDO("mysql:host=$this->db_host;dbname=$this->db_name",$this->db_user,$this->db_pass);
            return $this->db_con;
        }
        catch (PDOException $exception){
            echo $exception->getMessage();
        }

    }
}