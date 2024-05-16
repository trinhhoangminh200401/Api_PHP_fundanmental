<?php

include(__DIR__ . '../../layouts/header.php');

include(__DIR__ . '/../../controllers/account.controller.php');


?>
<?php
if (Session::checkLogin()) {
    header('Location:/app/pages/home.php');
}

?>
<?php
$register = new AccountController();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminName = $_POST['adminName'];
    $adminUser = $_POST['adminUser'];
    $adminPass = $_POST['adminPass'];
    $adminEmail = $_POST['adminEmail'];
    $registercheck = $register->Registration($adminName, $adminUser, $adminPass, $adminEmail);
}

?>
<section class="">
    >
    <div class="px-4 py-5 px-md-5 text-lg-start" style="background-color: hsl(0, 0%, 96%)">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">

                    <div class="card  p-4">
                        <h3 class="fs-5 mb-0 text-it-black">
                            Welcome to
                            <img class="px-1" src="https://itviec.com/assets/logo_black_text-04776232a37ae9091cddb3df1973277252b12ad19a16715f4486e603ade3b6a4.png" width="80" height="30">
                        </h3>
                        <div class="card-body py-5 px-md-5">

                            <form action="register.php" method="post">
                                <h2 class="text-center"> Register</h2>
                                <span>
                                    <?php
                                    if (isset($registercheck)) {
                                        header("Location:'/app/pages/Auth/login.php'");
                                    }
                                    ?>
                                </span>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" name="adminUser" class=" form-label">User</label>
                                    <input class="form-control" id="exampleInputEmail1" name="adminUser" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" name="adminPass" class=" form-label">Password</label>
                                    <input type="password" class="form-control" name="adminPass" id="exampleInputPassword1">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" type="email" name="adminEmail" class=" form-label">Email</label>
                                    <input class="form-control" id="exampleInputEmail1" name="adminEmail" type="email" aria-describedby="emailHelp">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" namme="adminName" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="adminName" id="exampleInputPassword1">
                                </div>
                                <button type="submit" class="btn btn-danger w-100">Register</button>

                            </form>

                        </div>


                    </div>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="my-5 display-3 fw-bold ls-tight">
                        The best offer <br />
                        <span class="text-primary">for your business</span>
                    </h1>
                    <p style="color: hsl(217, 10%, 50.8%)">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                        quibusdam tempora at cupiditate quis eum maiores libero
                        veritatis? Dicta facilis sint aliquid ipsum atque?
                    </p>
                </div>


            </div>
        </div>
    </div>
    </div>

</section>