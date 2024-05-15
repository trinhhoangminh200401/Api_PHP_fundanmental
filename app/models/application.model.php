<?php

class ApplicationModel
{
    
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function applyCV($jobId, $fileNameCv, $candidateDescription, $candidateUserName, $adminId)
    {
      $expireDate = date('Y-m-d ', strtotime('+ 10 minutes'));
      $querycheckJob = "SELECT applyId FROM tbl_application WHERE jobId = $jobId";
      $jobExists = $this->db->select($querycheckJob);

      if ($jobExists && mysqli_num_rows($jobExists) > 0) {
         $row = mysqli_fetch_assoc($jobExists);
         $applyId = $row['applyId'];
      } else {
         $createNewRecord = "INSERT INTO tbl_application (jobId, adminId) VALUES ($jobId, $adminId)";
         $this->db->insert($createNewRecord);


         $applyId = $this->db->inserted_id();

      }

      $queryCandidateTbl = "INSERT INTO tbl_application_candidate (applyId, candidateUserName, candidateDescription, fileNameCv, DateApplication, expiryDate,candidateId) 
                      VALUES ($applyId, '$candidateUserName', '$candidateDescription', '$fileNameCv', NOW(), '$expireDate', '$adminId')";

      $resultCandidateTbl = $this->db->insert($queryCandidateTbl);
      return $resultCandidateTbl;
   }

}