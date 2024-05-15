<?php
require_once(dirname(__FILE__) . " ../../lib/database.php");
require_once(dirname(__FILE__) . "../../models/application.model.php");
require_once(dirname(__FILE__) . "../../config/config.php");
?>
<?php  
 class ApplicationController {
    private $db;
    private $applicationModel;
    public function __construct()
    {
        $this -> db = new Database();
        $this -> applicationModel = new  ApplicationModel($this -> db);
    }
    public function getListCvApply (){
         
    }
    public function applyCv($jobId, $fileNameCv, $applicationDescription, $appliationUserName, $adminId){
        return $this->applicationModel->applyCV($jobId, $fileNameCv, $applicationDescription, $appliationUserName, $adminId);
    }
    
 }


?>