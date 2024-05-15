<?php
require_once(dirname(__FILE__) . " ../../lib/database.php");
require_once(dirname(__FILE__) . "../../models/category.model.php");
require_once(dirname(__FILE__) . "../../config/config.php");


?><?php

    class CategoryController
    {
        
        private $db;
        public function __construct()
        {
            $this->db = new Database();
        
        }
        public function addCategory($categoryName)
        {
            if (empty($categoryName)) {
                echo "please write something before ";
            } else {
                $categoryModel = new CategoryModel($this->db);
                $result = $categoryModel->addCategory($categoryName);
                if ($result) {
                     return $result;
                }
            }
        }
        
        public function getAllCategory()
        {
            $categoryModel = new CategoryModel($this->db);
          
            $result = $categoryModel->getAllCategories();
            return $result;
        }
        
        public function EditCategory($categoryId,$categoryName){
            $categoryModel = new CategoryModel($this->db);
            $result = $categoryModel ->updateCategory($categoryId,$categoryName);
            if($result){
                return $result;
            }
            else{
                echo"failed";
            }
            
        }
        public function deleteCategory($categoryId){
            $categoryModel = new CategoryModel($this -> db);
             $result = $categoryModel -> deleteCategory($categoryId);
             return $result;
        }
    }

 ?>
<?php 

 ?>