<?php
require_once (__DIR__."/../dto/application.dto.php");
class ApplicationModel
{

    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAllListCv(){
        $query = "SELECT * FROM tbl_application";
        $result = $this -> db ->select($query);
        return $result;
    }
    public function applyCV(ApplicationDto $dto)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $now = new DateTime();
        $expireDate = $now->modify('+5 minutes')->format('Y-m-d H:i:s');
        $querycheckJob = "SELECT applyId FROM tbl_application WHERE jobId = '" . $dto->getJobId() . "'";
        $jobExists = $this->db->select($querycheckJob);

        if ($jobExists && mysqli_num_rows($jobExists) > 0) {
            $row = mysqli_fetch_assoc($jobExists);
            $applyId = $row['applyId'];
        } else {
            $createNewRecord = "INSERT INTO tbl_application (jobId, adminId) VALUES ('" . $dto->getJobId() . "','" . $dto->getAdminId() . "')";
            $this->db->insert($createNewRecord);
            $applyId = $this->db->insert_id;
        }

        $queryCandidateTbl = "INSERT INTO tbl_application_candidate (applyId, candidateUserName, candidateDescription, fileNameCv, DateApplication, expiryDate,candidateId) 
                           VALUES ($applyId, '" . $dto->getCandidateUserName() . "', '" . $dto->getCandidateDescription() . "', '" . $dto->getFileNameCv() . "', NOW(), '$expireDate', '" . $dto->getAdminId() . "' )";

        $resultCandidateTbl = $this->db->insert($queryCandidateTbl);
        return $resultCandidateTbl;
    }
    public function softDeleteExpireDay()
    {
        $query =  "UPDATE  tbl_application_candidate  SET tbl_application_candidate.isDeleted = 1 
        Where tbl_application_candidate.expiryDate < NOW()  ";
        $result = $this->db->update($query);
        return $result;
    }
}