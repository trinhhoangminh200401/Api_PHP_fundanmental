<?php
include_once(dirname(__FILE__) . '../../controllers/CategoryController.php');
$categoryController = new CategoryController();



if ($_SERVER["REQUEST_METHOD"] !== 'GET' && $_SERVER["REQUEST_METHOD"] !== 'POST') {
    $response = array(
        "success" => false,
        "message" => 'Invalid request method'
    );
    echo json_encode($response);
    exit(); 
}

$action = isset($_GET['action']) ? $_GET['action'] : $_POST["action"];  

switch ($action) {
    case "getAllCategory":
        $listCategory = $categoryController->getAllCategory();
        while ($rows = mysqli_fetch_assoc($listCategory)) {
            $row[] = $rows;
        }
        $count = count($row);
        $response = array(
            "countData" => $count,
            "data" => $row
        );
        header('Content-Type: application/json');

        echo json_encode($response);
        exit(); 
        break;
    case "add":
          if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['categoryName'])  ){
            $categoryName= isset($_POST['categoryName']) ? $_POST['categoryName'] : null;;
            if(empty($categoryName)){
                $response =array (
                    'success' => false,
                    'message' =>"CategoryName is missing input to add", 
                );
                
            }
            else{
              $addCategory=  $categoryController->addCategory($categoryName);
              if($addCategory){
                $response = array(
                    'success' => true,
                    "message" => "successfully to add!",
                    "data" =>$addCategory
                );
                
              }
              else{
                $response = array(
                    'success' => false,
                    "message" => "fail to add",
                    "data"=> $addCategory
                );
            }
            }
            
          }
        
        echo json_encode($response);
         header("Content-type:application/json");
          exit();
          break;
    case "edit":
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['categoryId'])) {
            $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : null;
            $categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : null;
                
            if (empty($categoryName)) {
                $response = array(
                    'success' => false,
                    'message' => 'Category name is missing or invalid'
                );
            } else {
                $updateCategory = $categoryController->EditCategory($categoryId, $categoryName);
             
                if ($updateCategory != null) {
                    $response = array(
                        "success" => true,
                        "message" => "Category updated successfully!",
                        "data" => $updateCategory
                    );
                } else {
                    $response = array(
                        "success" => false,
                        "message" => "Failed to update category",
                        "data" => null
                    );
                }
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Invalid request. categoryId is missing',
                'categoryId' =>  $categoryId
            );
        }
        header('Content-Type: application/json');

        echo json_encode($response);
        break;
    case "deleteCategoryId":
        if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['categoryId'])) {
            $response = array(
                'success' => false,
                'message' => 'Invalid POST job ID action'
            );
        }
        $categoryId = $_SERVER["REQUEST_METHOD"] === "POST" ? $_POST['categoryId'] : null;
        $result = $categoryController -> deleteCategory($categoryId);
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
            "success" => false,
            "message" => 'Invalid action'
        );
        echo json_encode($response);
}