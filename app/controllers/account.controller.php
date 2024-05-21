<?php
include(dirname(__FILE__) . "../../config/config.php");


include_once(dirname(__FILE__) . "../../helpers/format.php");
include(dirname(__FILE__) . " ../../lib/database.php");
include(dirname(__FILE__) . "../../models/user.model.php");

?>

<?php

class AccountController
{
    private $db;
    private $fm;
    public function __construct()
    {

        $this->db =  new Database();
        $this->fm = new Format();
    }

    public function LoginAdmin($adminUser, $adminPass)
    {
        $adminPass = $this->fm->validation($adminPass);
        $adminUser = $this->fm->validation($adminUser);
        $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
        $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);
        if (empty($adminPass) || empty($adminUser)) {
            $alert = "falited to  login";
            return $alert;
        } else {
            $query = "SELECT * from tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
            $result = $this->db->select($query);
            if ($result != false) {
                $value = $result->fetch_assoc();

                Session::set('adminlogin', true);
                Session::set('adminId', $value['adminId']);     
                Session::set('adminUser', $value['adminUser']);
                Session::set('level', $value['level']);
                Session::set('login_stamp_expire', time() + (30 * 60));
                header("Location:../../../app/pages/home.php");
                exit;
            } else {
                $alert = "login fail";
                return $alert;
            }
        }
    }
    public function Registration($adminName, $adminUser, $adminPass, $adminEmail)
    {
        $userModel = new UserModel($this->db);

        $registrationResult = $userModel->register($adminName, $adminUser, $adminPass, $adminEmail);

        if ($registrationResult) {


            echo "Registration successful!";
        } else {
            return;
        }
    }
    public function getAllUser()
    {
        $userModel = new UserModel($this->db);
        $result = $userModel->getAllUser();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}

?>