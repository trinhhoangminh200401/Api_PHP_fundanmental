<?php 
 class LocationModel{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function  getAllLocation(){
        $query  = "SELECT * FROM tbl_location ";
        $result = $this->db->select($query);
        return $result;
    }
 }

?>