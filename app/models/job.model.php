<?php
class JobModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAllJobs($page, $perPage)
    {  

        $offset = ($page - 1) * $perPage;

        $query = "SELECT jobId, jobName,jobDescription,categoryName,locationName ,jobStatus,jobImage  from tbl_job,tbl_category,tbl_location 
        WHERE tbl_job.categoryId=tbl_category.categoryId and tbl_job.locationId=tbl_location.locationId and tbl_Job.jobStatus<>'No longer' AND tbl_job.jobStatus = 'Available'
        ORDER BY tbl_job.jobId ASC limit $offset, $perPage ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getAllJobCounts(){
        $query = "SELECT jobId, jobName,jobDescription,categoryName,locationName ,jobStatus, jobImage from tbl_job,tbl_category,tbl_location 
        WHERE tbl_job.categoryId=tbl_category.categoryId and tbl_job.locationId=tbl_location.locationId and tbl_Job.jobStatus<>'No longer' AND tbl_job.jobStatus = 'Available' ";
        $result = $this->db->select($query);
        return  $result;
    }
    public function getJobById($jobId)
    {
        if (is_array($jobId)) {
            return [];
        } else {
            $jobId = mysqli_real_escape_string($this->db->link, $jobId);
            $query = "SELECT tbl_job.jobId,tbl_job.jobName,tbl_job.jobStatus, tbl_job.jobDescription,tbl_location.locationName,tbl_location.locationId ,tbl_category.categoryName,tbl_category.categoryId
              FROM tbl_job
              INNER JOIN tbl_category ON tbl_job.categoryId = tbl_category.categoryId
              INNER JOIN tbl_location ON tbl_location.locationId= tbl_job.locationId 
              WHERE tbl_job.jobId = '$jobId'";
            $result = $this->db->select($query);
            return $result;
        }
    }

    public function addJob($jobName, $jobDescription, $status, $categoryId, $locationId)
    {
        

        $jobName = mysqli_real_escape_string($this->db->link, $jobName);
        $jobDescription = mysqli_real_escape_string($this->db->link, $jobDescription);
        $status = mysqli_real_escape_string($this->db->link, $status);

        $categoryId = mysqli_real_escape_string($this->db->link, $categoryId);
        $locationId = mysqli_real_escape_string($this->db->link, $locationId);

        $query = "INSERT INTO tbl_job (jobName, jobDescription, jobStatus, categoryId,locationId) 
                VALUES ('$jobName', '$jobDescription', '$status', '$categoryId','$locationId')";

        $insertResult = $this->db->insert($query);
        if ($insertResult) {
          
            return $insertResult; 
        } else {
          
            error_log("Failed to insert job: " . $this->db->error);

            return false;
        }
    }
   
    public function searchInput($searchInput, $location)
    {
        $searchInput = mysqli_real_escape_string($this->db->link, $searchInput);
        $location = mysqli_real_escape_string($this->db->link, $location);
        $query = "SELECT tbl_job.jobId, tbl_job.jobName, tbl_job.jobDescription, tbl_category.categoryName, tbl_location.locationName 
                 FROM tbl_job
                INNER JOIN tbl_category ON tbl_job.categoryId = tbl_category.categoryId
                INNER JOIN tbl_location ON tbl_job.locationId = tbl_location.locationId
                WHERE (tbl_job.jobName LIKE '%$searchInput%'
                OR tbl_job.jobDescription LIKE '%$searchInput%') AND tbl_job.jobStatus = 'Available'
                
            
              ";
        if ($location !== "all_cities" && !empty($location)) {
            $query .= " AND tbl_location.locationId = '$location'   AND tbl_job.jobStatus = 'Available'";
        }
        $result = $this->db->select($query);
        return $result;
    }
    
    public function deleteJobId($jobId)
    {
        $query = "DELETE FROM tbl_job WHERE tbl_job.jobId = '$jobId' ";
        $result = $this ->db->delete($query);
        return $result ;
    }
 
    public function updateJob($jobId,$jobName, $jobDescription, $status, $categoryId, $locationId)
    {
        $jobName = mysqli_real_escape_string($this->db->link, $jobName);
        $jobDescription = mysqli_real_escape_string($this->db->link, $jobDescription);
        $status = mysqli_real_escape_string($this->db->link, $status);

        $categoryId = mysqli_real_escape_string($this->db->link, $categoryId);
        $locationId = mysqli_real_escape_string($this->db->link, $locationId);

        $query = " UPDATE tbl_job SET tbl_job.jobName= '$jobName', tbl_job.jobDescription = '$jobDescription', 
         tbl_job.jobStatus ='$status', tbl_job.categoryId = '$categoryId', tbl_job.locationId = '$locationId' 
         WHERE tbl_job.jobId =  '$jobId' ";

        $updateResult = $this->db->update($query);
        if ($updateResult) {

            return $updateResult;
        } else {

            error_log("Failed to update job: " . $this->db->error);

            return false;
        }
    }
}