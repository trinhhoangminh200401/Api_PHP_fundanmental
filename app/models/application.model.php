<?php
class ApplicationModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

 
    public  function applyCV($jobId, $fileNameCv, $applicationDescription, $appliationUserName,$adminId)
    {
        $query = "INSERT INTO tbl_application (jobId, fileNameCv, DateApplication, applicationDescription, appliationUserName) 
        VALUES ('$jobId', '$fileNameCv', NOW(), '$applicationDescription', '$appliationUserName')";
        $result= $this -> db -> insert($query);
        if($result){
            $applyId = $this->db->inserted_id;
            $queryCandidateTbl= "INSERT INTO tbl_application_candidate(applyId,adminId) VALUES($applyId,$adminId)";
            $queryCandidateTbl ? 'success to add tbl_application_candidate!' :" failed to add!";    
        
        }      
        else{
            return;
        }
    }

}