<?php
include(__DIR__ . '../../layouts/header.php');
include(__DIR__ . '/../../controllers/category.controller.php');


?>
<?php


if (Session::get('level')!= "2") {

    echo "<script>window.location.href='/app/views/404.php'</script>";
    exit();
}

?>

<?php
$addCategory = new CategoryController();

$result = $addCategory->getAllCategory();


?>


<div class="container table-responsive py-5">
    <div class="modal-container d-flex justify-content-end my-2">

        <button type="button" class="btn btn-primary btnCreate" data-toggle="modal" data-target="#exampleModalCenter">
            Create Category
        </button>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create category</h5>
                        <button type="button" class="close closing" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="w-75 mx-auto my-5 " id="formCategory">
                            <label for="exampleInputEmail1">CategoryJob</label>
                            <input type="text" class="form-control my-3" name="categoryName" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Enter Category">

                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closing" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveCategoryBtn">Save changes</button>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover categoryTableContainer ">
        <thead class="thead-dark">

            <tr>
                <?php

                $firstRow = mysqli_fetch_assoc($result);
                foreach ($firstRow as $field => $value) {
                    echo "<th scope='col'>$field</th>";
                }
                ?>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="categoryTable">


        </tbody>
    </table>
    <div class="pagination-category"></div>
</div>


<?php

include(__DIR__ . '../../layouts/footer.php');
?>