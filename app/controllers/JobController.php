<?php
include(dirname(__FILE__) . " ../../lib/database.php");
include(dirname(__FILE__) . "../../models/job.model.php");
include(dirname(__FILE__) . "../../config/config.php");


?>
<?php
class JobController
{
    private $db;
    public function __construct()
    {
        
        $this->db = new Database();
    }
    public function getCountsAll(){
        $JobGetAll = new JobModel($this->db);
        $result = $JobGetAll -> getAllJobCounts();
        return $result;
    }
    public function getAllJobs($offset, $perPage)
    {
        $Jobmodel = new JobModel($this -> db);
        $result = $Jobmodel -> getAllJobs($offset, $perPage);
        return $result;
    }
    public function getJobById($jobId){
        $JobId = new JobModel($this -> db);
        $result = $JobId -> getJobById($jobId);
        return $result;
        
    }
    public function insertJob ($jobName, $jobDescription, $status, $categoryName,$locationId){
        $jobAdd = new JobModel($this->db);
        $result = $jobAdd->addJob($jobName, $jobDescription, $status, $categoryName,$locationId);
       if ($result){
            return $result;
       }
       else{
        echo 'false';
       }
        
    }
    public function deleteJob($jobId){
        $jobModel = new JobModel($this->db);
        $result = $jobModel -> deleteJobId($jobId);
        return $result;
    }
    
    public function searchInput($searchInput,$location){
        $searchInputModel = new JobModel($this -> db);
        $result = $searchInputModel -> searchInput($searchInput,$location);
        if ($result){
            return $result;     
        }
       return [];
    }
    public function updateJob($jobId, $jobName, $jobDescription, $status, $categoryId, $locationId){
        $updateJob= new JobModel($this->db);
        $result = $updateJob -> updateJob($jobId, $jobName, $jobDescription, $status, $categoryId, $locationId);
        if ($result){
            return $result;
        }
        else{
            echo 'false';
        }
    }
}

?>