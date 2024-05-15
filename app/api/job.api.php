<?php
include_once(dirname(__FILE__) . '../../controllers/job.controller.php');
$Job = new JobController();


if (($_SERVER["REQUEST_METHOD"] === "GET" && !isset($_GET['action'])) || ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['action']))) {
    $response = array(
        'success' => false,
        'message' => 'No GET OR POST  action specified'
    );
    echo json_encode($response);
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : $_POST["action"];

switch ($action) {
    case 'getJobById':

        if ($_SERVER["REQUEST_METHOD"] === "GET" && !isset($_GET['jobId'])) {
            $response = array(
                'success' => false,
                'message' => 'Invalid GET job ID action'
            );
            echo json_encode($response);
            exit();
        }

        $jobId = $_SERVER["REQUEST_METHOD"] === "GET" ? $_GET['jobId'] : $_POST['jobId'];
        $jobDetails = $Job->getJobById($jobId);
        if ($jobDetails && $jobDetails->num_rows > 0) {
            $rows = [];
            while ($row = $jobDetails->fetch_assoc()) {
                $rows[] = $row;
            }
            $json = json_encode($rows);
            header('Content-type: application/json');
            echo $json;
            exit();
        } else {
            $response = array(
                'success' => false,
                'message' => 'No job details found'
            );
            echo json_encode($response);
            exit();
        }
        break;

    case 'getAllPageJob':

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = 3;
        $jobGetAll = $Job->getAllJobs($page, $perPage);
        $jobGetCount = $Job->getCountsAll();
        while ($row = mysqli_fetch_assoc($jobGetAll)) {
            $rows[] = $row;
        }
        $count = mysqli_fetch_all($jobGetCount, MYSQLI_ASSOC);
        $count = count($count);

        $response = array(
            "countData" => $count,
            "data" => $rows
        );
        $responsetoJson = json_encode($response, JSON_PRETTY_PRINT);
        header('Content-type: application/json');
        echo $responsetoJson;
        exit();
        break;
    case "getAll":
        $jobGetAll = $Job->getCountsAll();
        if ($jobGetAll) {
            $response = array(
                "success" => false,
                "message" => "failed to get data"
            );
        }

        while ($row = mysqli_fetch_assoc($jobGetAll)) {
            $rows[]  = $row;
        }
        $response = array(
            "success" => true,
            "message" => "success to get data!",
            "data" => $rows
        );

        $responsetoJson = json_encode($response, JSON_PRETTY_PRINT);
        header('Content-type: application/json');
        echo $responsetoJson;
        exit();

        break;
    case "addJob":

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

                $result =  $Job->insertJob($jobName, $jobDescription, $jobStatus, $categoryJob, $location);

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
        break;
    case "editJob":

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['jobId']) && isset($_POST['jobName']) && isset($_POST['jobStatus']) && isset($_POST['categoryJob']) && isset($_POST['jobDescription']) && isset($_POST['location'])) {

                $jobId = trim($_POST['jobId']);
                $jobName = trim($_POST['jobName']);
                $jobStatus = trim($_POST['jobStatus']);
                $categoryJob = trim($_POST['categoryJob']);
                $jobDescription = trim($_POST['jobDescription']);
                $location = trim($_POST['location']);
                if ((empty($jobName) || empty($jobStatus) || empty($categoryJob) || empty($jobDescription) || empty($location))) {
                    $response = array(
                        "success" => false,
                        "message" => "Missing field field of datas"
                    );
                    echo json_encode($response);
                    exit();
                } else {
                    $result = $Job->updateJob($jobId, $jobName, $jobDescription, $jobStatus, $categoryJob,   $location);
                    if ($result) {
                        $response = array(
                            "success" => true,
                            "message" => "Successfully to update Job!",
                            "data" => $result
                        );
                        echo json_encode($response);
                        exit();
                    } else {
                        $response = array(
                            "success" => false,
                            "message" => "failed to update Job!",
                            "data" => $result
                        );

                        echo json_encode($response);
                        exit();
                    }
                    header('Content-type: application/json');
                }
            } else {
                $response = array(
                    "success" => false,
                    "message" => "not found "
                );
                header('Content-type: application/json');
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Invalid POST action'
            );
            echo json_encode($response);
            exit();
        }

        break;

    case "deleteJobId":
        if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['jobId'])) {
            $response = array(
                'success' => false,
                'message' => 'Invalid POST job ID action'
            );
        }
        $jobId = $_SERVER["REQUEST_METHOD"] === "POST" ? $_POST['jobId'] : null;
        $result = $Job->deleteJob($jobId);
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Success to delete!',
                'data' => $result
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'fail to delete!',
                'data' => $result
            );
        }
        echo json_encode($response);
        exit();


        break;
    default:

        $response = array(
            'success' => false,
            'message' => 'Invalid METHOD action'
        );
        echo json_encode($response);
        exit();
}