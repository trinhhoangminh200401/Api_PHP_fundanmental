<?php
include_once(__DIR__ . '../../controllers/application.controller.php');
$ApplicationController = new  ApplicationController()

?>
<?php
if (($_SERVER["REQUEST_METHOD"] === "GET" && !isset($_GET['action'])) || ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['action']))) {
  $response = array(
    "success" => false,
    "message" => 'Invalid request method'
  );
  echo json_encode($response);
  exit();
}


$action = isset($_GET['action']) ? $_GET['action'] : $_POST["action"];



switch ($action) {
  case 'postcv':
    if (
      isset($_REQUEST['candidateUserName']) && isset($_REQUEST['file']) && isset($_REQUEST['candidateDescription'])
      && isset($_REQUEST['jobId']) && isset($_REQUEST['adminId'])
    ) {
      $applyUserName = $_REQUEST['candidateUserName'];
      $fileName  = $_REQUEST['file'];
      $adminId = $_REQUEST['adminId'];
      $jobId = $_REQUEST['jobId'];
      $applyDescription = $_REQUEST['candidateDescription'];
      $result = $ApplicationController->applyCv($jobId, $fileName,$applyDescription,$applyUserName, $adminId);
      if ($result) {
        $response = array(
          "success" => true,
          "message" => "Success to post Cv",
          'data' => $result
        );
      } else {
        $response = array(
          "success" => false,
          "message" => "Fail to post Cv!"
        );
      }
      echo json_encode($response);
      header('Content-type: application/json');
    } else {
      $response = array(
        "success" => false,
        "message" => "You missing some field !"
      );
      header('Content-type: application/json');
      echo json_encode($response);
    }

    break;

  default:
    $response = array(
      "message" => "There is not method please try again !"
    );
    header('Content-type: application/json');
    echo json_encode($response);
    break;
}
?>