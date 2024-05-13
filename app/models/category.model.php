<?php
class CategoryModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAllCategories()
    {
    $query  = "SELECT * FROM tbl_category ";
    $result = $this->db->select($query);
    return $result;
  }
    
    public function addCategory($categoryName)
    {
          
      $categoryName = "'".mysqli_real_escape_string($this->db->link,$categoryName) ."'";
      $query  = "INSERT INTO tbl_category(categoryName) VALUES ($categoryName) ";
      $result = $this ->db->insert($query);
      return $result;
 
    }
    public function updateCategory($categoryId,$categoryName){
      $categoryName = "'".mysqli_real_escape_string($this->db->link,$categoryName) ."'";
      $query = "UPDATE tbl_category SET tbl_category.categoryName=$categoryName where tbl_category.categoryId='$categoryId'  ";
      $result = $this -> db -> update($query);
      return $result;
    }
    public function deleteCategory($categoryId){
    $dependencyQuery = "SELECT COUNT(*) AS total FROM tbl_job WHERE categoryId='$categoryId'";
    $dependencyResult = $this->db->select($dependencyQuery);
    $dependencyCount = $dependencyResult->fetch_assoc()['total'];
    
    if ($dependencyCount > 0) {
   
      return "Cannot delete category. It is referenced by $dependencyCount job(s).";
    } else {
      $query = "DELETE FROM tbl_category WHERE categoryId='$categoryId'";
      $result = $this->db->delete($query);
      return $result;
    }
    }

}
?>