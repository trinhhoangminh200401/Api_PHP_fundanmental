<?php

 include_once('../controllers/AccountController.php');
$accountController = new AccountController();

if (($_SERVER["REQUEST_METHOD"] === "GET" && !isset($_GET['action'])) || ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['action']))) {
    $response = array(
        'success' => false,
        'message' => 'No GET OR POST  action specified'
    );
    echo json_encode($response);
    exit();
};
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
switch ($action) {
    case 'getAllUser':
        $result = $accountController -> getAllUser();
         if($result){
            while($rows = mysqli_fetch_assoc($result)){
                $row[]=$rows;
                
            }
            $count = count($row);
            $response = array(
                "countData" => $count,
                "data" => $row
            );
            echo(json_encode($response));
            exit(); 
         }
        break;
    
    default:
    
        break;
}
?>