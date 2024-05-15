<?php
require_once(dirname(__FILE__) . " ../../lib/database.php");
require_once(dirname(__FILE__) . "../../models/location.model.php");
require_once(dirname(__FILE__) . "../../config/config.php");



?>

<?php 
 class LocationController {
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllLocations()
    {
        $LocationModel = new LocationModel($this->db);
        $result = $LocationModel->getAllLocation();
        return $result;
    }
 }


?>