<?php
// UserModel.php

class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAllUser(){
         $query ="SELECT * FROM  tbl_admin";
         $result = $this -> db ->select($query);
         return $result;
    }
    public function register($adminName, $adminUser, $adminPass, $adminEmail)
    {
        if (empty($adminName) || empty($adminUser) || empty($adminPass) || empty($adminEmail) ) {
            return false;
        }
        $adminEmail = "'" . mysqli_real_escape_string($this->db->link, $adminEmail) . "'";
        $adminName = "'" . mysqli_real_escape_string($this->db->link, $adminName) . "'";
        $adminPass = "'" . mysqli_real_escape_string($this->db->link, $adminPass) . "'";
        $adminUser = "'" . mysqli_real_escape_string($this->db->link, $adminUser) . "'";
        $CheckRegister= "SELECT * FROM tbl_admin where tbl_admin.adminUser = $adminUser Or tbl_admin.adminEmail = $adminEmail ";
        $ischeckRegister = $this ->db ->select($CheckRegister);
        if ($ischeckRegister){
            echo"This account is already has email or user name";
        }
       else{    
            $query = "INSERT INTO tbl_admin (adminEmail, adminName, adminPass, adminUser, level) VALUES ($adminEmail, $adminName, $adminPass, $adminUser, 1)";

            $result = $this->db->insert($query);

            return $result;
       }
     
    }

}

?>