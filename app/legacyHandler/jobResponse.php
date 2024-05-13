<?php
include(__DIR__ . '/../../controllers/JobController.php');
$Job = new JobController();

if (isset($_GET['jobId'])) {
    $jobId = $_GET['jobId'];
    $jobDetails = $Job->getJobById($jobId);
    $rows = [];
    while ($row = $jobDetails->fetch_assoc()) {
        $rows[] = $row;
    }

    $json = json_encode($rows);
    header('Content-type: text/javascript');
    echo $json;
}
?>