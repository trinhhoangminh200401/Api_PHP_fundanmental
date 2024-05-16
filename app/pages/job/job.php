<?php
include(__DIR__ . '../../layouts/header.php');
include(__DIR__ . '/../../controllers/job.controller.php');
include(__DIR__ . '/../../controllers/location.controller.php');

if (Session::checkLogin()) {
    if ($_SESSION["level"] == "2") {
        echo "<script>window.location.href = '../404.php'</script>";
        exit();
    }
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 3;
$Location = new LocationController();
$Job = new JobController();
$result = $Job->getAllJobs($page,$perPage);
$countJob =$Job->getCountsAll();
$locationList = $Location->getAllLocations();
$optionLocation = '';

if ($result === false) {

    echo '<div class="d-flex justify-content-center align-items-center" id="main">
    <h1 class="mr-3 pr-3 align-top border-right inline-block align-content-center">404</h1>
    <div class="inline-block align-middle">
    	<h2 class="font-weight-normal lead" id="desc">The page doest has job you need</h2>
    </div>
</div>';
} else {
    $count = mysqli_num_rows($countJob);

    if ($count > 0) {
?>

<div class="main ipx-md-40 bg-grandient-search postition-relative">
    <div class="icontainer-search-form">
        <div class="mx-auto ipt-12 ipb-16 ipy-md-16">
            <?php if (isset($_SESSION["adminId"])) : ?>
            <h1 class="text-white text-center ipb-8 ">
                <?= $count ?> Việc làm IT "Chất" dành cho <?= $_SESSION["adminUser"] ?> </h1>
            <?php endif; ?>
            <div class="search-box d-flex justify-content-center">
                <select class="custom-select w-25" id="inputGroupSelect01">
                    <option value="all_cities">Tất cả thành phố </option>
                    <?php
                            while ($location = mysqli_fetch_assoc($locationList)) {
                                $optionLocation = "<option name='{$location['locationName']}' value = '{$location['locationId']}'>{$location['locationName']}</option>";
                                echo $optionLocation;
                            }
                            ?>
                </select>
                <div class="d-flex flex-grow-1">
                    <div class="search-keyword w-100 mx-2">
                        <input type="text" class="form-control inputsearch h-100" placeholder="Recipient's username"
                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>
                    <div class="flex-shrink-1 h-100">
                        <button class="ibtn ibtn-primary ibtn-search h-100 " type="submit">
                            <span class="d-none d-md-inline">
                                Tìm Kiếm
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center m-5 ">
    <h3 class="count">
        <?= $count ?> việc làm IT tại Việt Nam
    </h3>
    <div class="btn">
        <a href="#" class="btn btn-primary btn-lg disabled " role="button" aria-disabled="true">Filter
        </a>
    </div>
</div>
<div class="d-flex justify-content-between px-5 py-1 w-100 bodyjob ">
    <div class=" d-flex flex-column container-card justify-content-start align-items-start">
        <?php foreach ($result as $results) : ?>
        <div class="card" data-jobid="<?= $results['jobId'] ?>">
            <div class="card-title">
                <p class="heading"><?= $results['jobName'] ?><i class="far fa-compass"></i></p>
            </div>
            <div class="row align-items-center">
                <div class="logo ml-3 mb-3">
                    <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTxDRpxI5gXgaVmnO-VgcVUNOkca91jIpS75Flbzkz5W_5g5_V5&usqp=CAU">
                </div>
                <p class="text-muted">CyberLogitec Vietnam Co., Ltd.</p>
            </div>
            <a class="mutual btn " href="#">
                <i class="fas fa-users"></i>&nbsp;&nbsp;<span>Đăng nhập để xem mức lương</span>
            </a>
            <div class="dashed"></div>
            <div class="location">
                <ul class="list-unstyled">
                    <li>location: <?= $results["locationName"]  ?></li>
                    <li>Hình thức: </li>
                </ul>
            </div>
            <?php
                        $array = explode(",", $results["categoryName"]);
                        ?>
            <div class="row btnrow my-4">
                <?php foreach ($array as $item) : ?>
                <div class="col-1 col-md-3 w-100">
                    <button type="button" class="btn w-100 p-2 btn-outline-success ">
                        <?= $item ?>
                    </button>
                </div>
                <?php endforeach ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <div class="w-75 bg-white container-white" style="position: sticky; top: 0; height: 100vh;">
    </div>
</div>
<?php
    } else {
        echo "No results found.";
    }
}

include(__DIR__ . '../../layouts/footer.php');
?>