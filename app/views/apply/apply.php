<?php
require_once(__DIR__ . '../../../lib/session.php');
include_once(__DIR__ . '../../layouts/header.php');
if (!Session::checkLogin()) {
    header("Location:/app/views/Auth/login.php");
}


?>
<div>
    <section class="">

        <div class="px-4 py-5 px-md-5 text-lg-start">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-11 mb-5 mb-lg-0">
                        <div class="card  p-4">
                            <h3 class="fs-5 mb-0 text-center title ">
                                <span class="titleApplication">TITLE</span>

                                <img class="px-1"
                                    src="https://itviec.com/assets/logo_black_text-04776232a37ae9091cddb3df1973277252b12ad19a16715f4486e603ade3b6a4.png"
                                    width="80" height="30">
                            </h3>
                            <div class="card-body py-5 px-md-5">

                                <form method="post">

                                    <div class="mb-3">
                                        <label>Your Name </label>
                                        <input class="form-control" id="exampleInputEmail1" name="applyUserName"
                                            aria-describedby="emailHelp">

                                    </div>
                                    <div class="mb-3">
                                        <label for="formFileLg" class="form-label">Your CV *</label>
                                        <input class="form-control form-control-lg" id="formFileLg" name="file"
                                            type="file">

                                    </div>
                                    <div class="mb-3">
                                        <h5>Cover Letter (Optional)</h5>
                                        <label for="formFileDisabled" class="form-label">write here</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                            name="applyDescription" rows="3"></textarea>
                                    </div>

                            </div>


                            </form>
                            <button type="submit" class="btn btn-danger">Send to CV</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>

</section>

</div>
<?php

include_once(__DIR__ . '../../layouts/footer.php');

?>