<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notification-js@1.1.1/build/notification.min.css" integrity="sha256-bITg4oAKRumITLOD4MoklLwPRh6cVyoPkja9zN5MjnY=" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="https://itviec.com/assets/favicon-32x32-d43a09e697f5031d66cd29775069d94075d407571b2312f0058a680fa9e03ca5.png">
    <link rel="stylesheet" href="/public/css/constraint.css">
    <link rel="stylesheet" href="/public/css/responsive.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/reset.css">
    <?php include_once(__DIR__ . '../../../helpers/format.php');    ?>
    <title>
        <?php

        $format = new Format();
        echo $format->title();

        ?>
    </title>
</head>

<body>

    <?php
    include_once(__DIR__ . '../../../lib/session.php');

    Session::init();
    if (isset($_SESSION["adminUser"])) {
        if (time() > Session::get("login_stamp_expire")) {
            session_unset();
            Session::destroy();
        }
    }

    ?>




    <nav class="navbar  navbar-expand-lg navbar-dark  align-items-center">
        <div class="nav-brand ">
            <a data-controller="utm-tracking" href="/vi"><img class="logo-itviec" alt="logo-itviec" src="https://itviec.com/assets/logo-itviec-4492a2f2577a15a0a1d55444c21c0fa55810822b3b189fc689b450fb62ce0b5b.png" width="108" height="40">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse align-items-center px-5" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION["adminId"], $_SESSION["level"]) && $_SESSION["level"] != "2" || !isset($_SESSION["adminId"], $_SESSION["level"])) : ?>

                    <li class="nav-item ">
                        <a class="nav-link h5" href="/app/pages/job/job.php">Job</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link h5" href="/app/pages/apply/historyApply.php">History Apply</a>
                    </li>
                <?php endif; ?>


                <?php if (isset($_SESSION["adminId"], $_SESSION["level"]) && $_SESSION["level"] == "2") : ?>
                    <li class="nav-item">
                        <a class="nav-link h5" href="/app/pages/category/addcategory.php">TypeJob</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link h5" href="/app/pages/job/listJob.php">ManageJob</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["adminId"])) : ?>
                    <li class="nav-item">
                        <a class="nav-link h5" href="/app/pages/User/userdetail.php">UserInfo</a>
                    </li>
                <?php endif; ?>

            </ul>


            <span class="text-light mx-2 h5">
                <?php if (isset($_SESSION["adminId"])) { ?>
                    <span class="text-light mx-2">
                        Welcome <?php echo Session::get('adminUser'); ?>
                    </span>
                    <span class="text-light mx-2">
                        <a class="text-light" href="../../../app/pages/Auth/logout.php">Logout</a>
                    </span>
                <?php } else { ?>
                    <span class="text-light mx-2">
                        <a class="text-light" href="/app/pages/Auth/login.php">Login</a>
                    </span>

                <?php } ?>
            </span>

        </div>
    </nav>





    <main class="mx-auto w-100 d-flex flex-column " data-user-id=<?= Session::get("adminId"); ?>>