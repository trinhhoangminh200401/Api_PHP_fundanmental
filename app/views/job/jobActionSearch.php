<?php
include_once(__DIR__ . '/../../controllers/JobController.php');

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location']:'';
$jobController = new JobController();


if($_SERVER['REQUEST_METHOD'] !== "GET" || !$keyword && !$location ){
    $response= array(
        "success"=>false,
        "message"=> "Invalid Method"
    
    );
    $responsetoJson = json_encode($response);
    echo $responsetoJson;
 
} else {
    $searchResults = $jobController->searchInput($keyword, $location);
    if (!empty($searchResults)) {
        $rows = [];
        while ($row = $searchResults->fetch_assoc()) {
            $rows[] = $row;
        }
        $count = count($rows);


        $response = array(
            "countData" => $count,
            "data" => $rows
        );
        $responsetoJson = json_encode($response);
        header('Content-type: application/json');
        echo $responsetoJson;


        exit();
    }
    $response = array(
        "message" => "not found"
    );
   
}