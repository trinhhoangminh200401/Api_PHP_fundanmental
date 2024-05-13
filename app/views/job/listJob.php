<?php
include(__DIR__ . '/../../controllers/JobController.php');

include_once(__DIR__ . '/../../controllers/CategoryController.php');
include_once(__DIR__ . '/../../controllers/LocationController.php');

include(__DIR__ . '../../../helpers/format.php');
include_once("../layouts/header.php");
?>
<?php
Session::init();

if ($_SESSION["level"] != "2") {

    echo "<script>window.location.href='/app/views/404.php'</script>";
    exit();
}

?>


<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 3;

$JobList = new JobController();
$Category  = new CategoryController();
$Location = new LocationController();

$result  = $JobList->getAllJobs($page, $perPage);
$categories = $Category->getAllCategory();
$Locations = $Location->getAllLocations();
$JobCount = $JobList->getCountsAll();
$option = "  <select  name='categoryJob' id='categoryJob' class='form-control'>";

while ($category = mysqli_fetch_assoc($categories)) {

    $option .= "<option value='{$category['categoryId']}'>{$category['categoryName']}</option>";
}
$option .= "</select>";
$locationOption = "  <select  name='location' class='form-control' id='locationSelect'>";

while ($location = mysqli_fetch_assoc($Locations)) {
    $locationOption .= "<option  value='{$location['locationId']}'>{$location['locationName']}</option>";
}
$locationOption .= "</select>";
if ($JobCount) {
    $rows = mysqli_fetch_all($JobCount, MYSQLI_ASSOC);
}


?>
<div class="container table-responsive py-5">
    <div class="modal-container d-flex justify-content-end my-2">
        <button type="button" class="btn btn-primary btnCreateJob " data-toggle="modal"
            data-target="#exampleModalCenter ">
            Create Job
        </button>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title jobTitle" id="exampleModalLongTitle">Create Job</h5>
                        <button type="button" class="close closing" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addJobForm" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jobName">Job Name</label>
                                    <input type="text" class="form-control" id="jobName" name="jobName"
                                        placeholder="Enter job name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jobDescription">Job Description</label>
                                <textarea class="form-control" id="jobDescription" name="jobDescription"></textarea>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jobStatus">Job Status</label>
                                    <select id="jobStatus" name="jobStatus" class="form-control">
                                        <option value="Available">Available</option>
                                        <option value="No longer">No longer </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="categoryJob">Category Job</label>
                                    <?php
                                    echo $option;
                                    ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="location">Location</label>
                                    <?php
                                    echo $locationOption;
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary closing" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveJobBtn">Save changes</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-hover ">
        <thead class="thead-dark">

            <tr>
                <?php
                if ($JobCount && count($rows) > 0) {
                    $firstRow = mysqli_fetch_assoc($result);
                    foreach ($firstRow as $field => $value) {
                        echo "<th scope='col'>$field</th>";
                    }
                    echo '<th scope="col">Action</th>';
                } else {
                    echo 'ko có';
                }

                ?>

            </tr>
        </thead>
        <tbody class="jobTable">


        </tbody>
    </table>
    <nav id="pagination" aria-label="Pagination">

    </nav>
    <!-- /<ul class="pagination"> -->
    <?php
    // $rows = mysqli_fetch_all($JobCount, MYSQLI_ASSOC);
    // $totalPages = ceil(count($rows) / $perPage);

    // if ($page > 1) {
    //     echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
    // } else {
    //     echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
    // }

    // for ($i = 1; $i <= $totalPages; $i++) {
    //     if ($i == $page) {
    //         echo '<li class="page-item "><span class="page-link">' . $i . '<span class="sr-only">(current)</span></span></li>';
    //     } else {
    //         echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    //     }
    // }

    // if ($page < $totalPages) {
    //     echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
    // } else {
    //     echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    // }
    ?>
    <!-- </ul> -->
</div>
<?php

include(__DIR__ . '../../layouts/footer.php');
?>