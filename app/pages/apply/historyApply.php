<?php
include(__DIR__ . '../../layouts/header.php');

?>
<?php if (Session::checkLogin()) : ?>
<div>
    <div class="d-flex flex-column align-items-start" style="background: white;height: 100%; padding:2em 5em 0 5em">
        <h3 class="font-weight-bold"> HisTory Applied </h3>
        <p>ITviec provides a service that connects anonymous candidates with suitable job opportunities. Learn more
            about Job Invitation here.</p>
        <ul class="nav mt-3" id="myTab" role="tablist">

            <li class="nav-item font-weight-bold ">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true"> Pending <div class="pending"> 0</div></a>
            </li>
            <li class="nav-item font-weight-bold  ">
                <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Accept <div class="accept"> 0</div></a>
            </li>
            <li class="nav-item font-weight-bold ">
                <a class="nav-link " id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                    aria-controls="contact" aria-selected="false">Expired
                    <div class="Expired"> 0</div>
                </a>
            </li>
        </ul>

    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="container Accept my-5 d-flex py-4 flex-column justify-content-center align-items-center"
                style="background: white;">
                <img width="153"
                    src="https://itviec.com/assets/everything-empty-62c813bcb84be8a092033e40550b6fdc9f6bda05947d60c619b2a74906144f8b.svg"
                    alt="">
                <p>You have 0 Accepted Invitations</p>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">profile tab</div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">contact tab</div>
    </div>

</div>
<?php else : ?>
<?= '<script> alert("You have to login before seeing history") </script>'; ?>
<?= '<script> window.location.href="../Auth/login.php" </script>'; ?> <?php endif ?>
<?php require_once(__DIR__ . "/../layouts/footer.php"); ?>