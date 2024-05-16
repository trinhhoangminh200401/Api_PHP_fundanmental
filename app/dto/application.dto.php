<?php

class ApplicationDto
{
    private $jobId;
    private $fileNameCv;
    private $candidateDescription;
    private $candidateUserName;
    private $adminId;

    public function __construct($jobId, $fileNameCv, $candidateDescription, $candidateUserName, $adminId)
    {
        $this->jobId = $jobId;
        $this->fileNameCv = $fileNameCv;
        $this->candidateDescription = $candidateDescription;
        $this->candidateUserName = $candidateUserName;
        $this->adminId = $adminId;
    }

   
    public function getJobId() {
        return $this->jobId;
    }

    public function getFileNameCv() {
        return $this->fileNameCv;
    }

    public function getCandidateDescription() {
        return $this->candidateDescription;
    }

    public function getCandidateUserName() {
        return $this->candidateUserName;
    }

    public function getAdminId() {
        return $this->adminId;
    }

 
    public function setJobId($jobId) {
        $this->jobId = $jobId;
    }

    public function setFileNameCv($fileNameCv) {
        $this->fileNameCv = $fileNameCv;
    }

    public function setCandidateDescription($candidateDescription) {
        $this->candidateDescription = $candidateDescription;
    }

    public function setCandidateUserName($candidateUserName) {
        $this->candidateUserName = $candidateUserName;
    }

    public function setAdminId($adminId) {
        $this->adminId = $adminId;
    }
}



?>