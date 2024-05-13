<?php

include(__DIR__ . '/../../controllers/JobController.php');
include(__DIR__ . '/../../controllers/LocationController.php');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$perPage = 3;
$Location = new LocationController();
$Job = new JobController();

$result = $Job->getAllJobs($page, $perPage);
$quality = $Job->getCountsAll();
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
    $count = mysqli_num_rows($quality);

    if ($count > 0) {
?>
<div class="main  bg-grandient-search postition-relative">
    <div class="icontainer-search-form">
        <div class="mx-auto ipt-12 ipb-16 ipy-md-16">
            <?php if (isset($_SESSION["adminId"])) : ?>
            <h1 class="text-white text-center ipb-8 ">
                <?= $count ?> Việc làm IT "Chất" dành cho <?= $_SESSION["adminUser"]  ?> </h1>
            <?php else : ?>
            <h1 class="text-white text-left ipb-8 ">
                <?= $count ?> Việc làm IT "Chất" dành cho developer</h1>
            <?php endif; ?>
            <form action="/app/views/job/job.php" method="get">
                <div class="search-box d-flex justify-content-center">
                    <select class="custom-select w-25" id="inputGroupSelect01" name='location'>
                        <option value="all_cities" selected>Tất cả thành phố </option>
                        <?php
                                while ($location = mysqli_fetch_assoc($locationList)) {
                                    $optionLocation = "<option name='{$location['locationName']}' value = '{$location['locationId']}'>{$location['locationName']}</option>";
                                    echo $optionLocation;
                                }
                                ?>
                    </select>

                    <div class="d-flex flex-grow-1">
                        <div class="search-keyword w-100 mx-2">
                            <input type="text" class="form-control inputsearch h-100" name='keyword'
                                placeholder="Recipient's username" aria-label="Recipient's username"
                                aria-describedby="basic-addon2">
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
            </form>
        </div>
    </div>
</div>
<div class="container-fluid mx-auto my-4 container-userpage" style="background-color: white;">

    <h3 class="text-center font-weight-bold">
        <?= Session::checkLogin() ? $count . ' Việc làm IT "Chất" dành cho '  . Session::get('adminUser') : $count . ' Việc làm IT "Chất" dành cho developer và các ứng viên tiềm năng' ?>
    </h3>
    <div id="loadMore" class="loadMore">
        <div class="row justify-content-center list-card  ">



        </div>
    </div>
</div>
<?php
    } else {
        echo "No results found.";
    }
}