<?php
require_once(dirname(__FILE__) . " ../../lib/database.php");
require_once(dirname(__FILE__) . "../../models/application.model.php");
require_once(dirname(__FILE__) . "../../config/config.php");
require_once (__DIR__.'/../dto/application.dto.php');
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
         return $this -> applicationModel -> getAllListCv(); 
    }
    public function applyCv(ApplicationDto $dto){
        return $this->applicationModel->applyCV($dto);
    }
    public function softDelete(){
        return $this->applicationModel -> softDeleteExpireDay();
    }
    
 }


?>