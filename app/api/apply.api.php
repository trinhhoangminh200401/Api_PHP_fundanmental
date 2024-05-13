<?php 
 include_once(__DIR__.'../../controllers/ApplicationController.php');
 $ApplicationController = new  ApplicationController()
  
?>
<?php 
  if ($_SERVER['REQUEST_METHOD']!=="POST" && $_SERVER['REQUEST_METHOD'] !== "GET"  ){
    $response = array(
            "success" => false,
            "message" => 'Invalid request method'
    );
    echo json_encode($response);
    exit(); 
  }
$action = isset($_GET['action']) ? $_GET['action'] : $_POST["action"];  
switch ($action) {
    case 'postCv':
        if(isset($_REQUEST['applyUserName']) && isset($_REQUEST['file'])&& isset($_REQUEST['applyDescription'])){
              
        }
         
        break;
    
    default:
    
        break;
}
?>