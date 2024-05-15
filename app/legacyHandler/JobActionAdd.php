<?php
include_once(__DIR__ . '/../../controllers/job.controller.php');

$jobController = new JobController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['jobName']) && isset($_POST['jobStatus']) && isset($_POST['categoryJob']) && isset($_POST['jobDescription']) && isset($_POST['location'])) {
        $jobName = trim($_POST['jobName']);
        $jobStatus = trim($_POST['jobStatus']);
        $categoryJob = trim($_POST['categoryJob']);
        $jobDescription = trim($_POST['jobDescription']);
        $location = trim($_POST['location']);

        if (empty($jobName) || empty($jobStatus) || empty($categoryJob) || empty($jobDescription) || empty($location)) {
            $response = array(
                'success' => false,
                'message' => 'Missing required data in the request'
            );
            echo json_encode($response);
            exit();
        }

        $result =  $jobController->insertJob($jobName, $jobDescription, $jobStatus, $categoryJob, $location);

        if ($result !== null) {
            $response = array(
                'success' => true,
                'message' => 'Job added successfully',
                'data' => $result
            );
            echo json_encode($response);
            exit();
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to add job. Please try again later.'
            );
            echo json_encode($response);
            exit();
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Missing required data in the request'
        );
        echo json_encode($response);
        exit();
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'Invalid request method'
    );
    echo json_encode($response);
    exit();
}