
import { SessionStorage } from "./utils/customStorage.js";
import { debounce } from "./utils/debounce.js";
import { clearHTMLTags } from "./utils/removeTagHtml.js";
$(document).ready(function () {
    function renameKeys(obj, newKeys) {
        const keyValues = Object.keys(obj).map(key => {
            const newKey = newKeys[key] || key;
            return { [newKey]: obj[key] };
        });
        return Object.assign({}, ...keyValues);
    }

    const barColors = ["red", "green", "blue", "orange", "brown"];
    $.ajax({
        url: '/app/api/job.api.php',
        type: 'GET',
        data: { action: 'getAll' }

    }).done(data => {
        let yValues = []
        let xValue = []
        const newKeys = { countData: "jobQualiy", data: "work" };
        let newkey = renameKeys(data, newKeys)

        let keyName = Object.keys(newkey)

        xValue.push(keyName[2])
        yValues.push(data.data.length)



        return new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValue,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: "Số lượng công việc hiện có"
                }
            }
        });


    })


    $(window).on("scroll", function () {
        var scrollTop = $(window).scrollTop();
        $(".container-card").scrollTop(scrollTop);
    });

    function fetchJobDetails(jobId) {
        let url = "/app/api/job.api.php";
        if (jobId) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    data: { action: "getJobById", jobId: jobId },
                    success: function (response) {
                        let data;

                        data = response?.map((item) => detailItem(item));

                        $(".bg-white").html(data);

                        resolve(data);


                    },
                    error: function (error) {
                        console.error("Error occurred while fetching job details.", error);
                        reject(error);
                    },
                });
            });
        } else {
            $(".bg-white").html(`<section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
                                <span class="display-1 fw-bold">4</span>
                                <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
                                <span class="display-1 fw-bold bsb-flip-h">4</span>
                            </h2>
                            <h3 class="h2 mb-2">Oops! You're lost.</h3>
                            <p class="mb-5">SO Sorry maybe your job is not exist</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>`)
            return Promise.resolve("");
        }
    }

    const checkloginforHandler = $.ajax({
        url: "/app/views/checkLogin.php",
        type: "GET",
        dataType: "text",
        async: false,
    }).responseText;
    function detailItem(item) {
        let checkLogin = checkloginforHandler == "false";
        return `
                <div class="container-fluid w-100">
                    <div class="card d-flex flex-column shadow-sm">
                        <div>
                            <div class="card-title">
                                <p class="heading">${item?.jobName
            }<i class="far fa-compass"></i></p>
                            </div>
                            <div class="row align-items-center">
                                <div class="logo ml-3 mb-3"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTxDRpxI5gXgaVmnO-VgcVUNOkca91jIpS75Flbzkz5W_5g5_V5&usqp=CAU"></div>
                                <p class="text-muted">CyberLogitec Vietnam Co., Ltd.</p>
                                <a  class="btn btn-secondary text-light btn-lg btn-block" href="/app/views/apply/Apply.php?jobId=${item.jobId}">Apply Now</a>
                            </div>
                            ${checkLogin
                ? '  <a clas    s="mutual btn " href="/app/views/Auth/login.php"><i class="fas fa-users"></i>&nbsp;&nbsp;<span>Đăng nhập để xem mức lương</span></a>'
                : ""
            }
                          
                            <div class="dashed"></div>
                        </div>
                    </div>
                </div>
                <div class="container_description px-4 py-3">
                    <div class="location">
                        <ul class="list-unstyled location">
                            <li>location: ${item.locationName}</li>
                            <li>Hình thức: </li>
                            <li>skills: <span class="list-skill d-inline-block my-4">
                                    <div class="row btnrow ">
                                        ${item.categoryName.split(",").map(
                (category) => `
                        <div class="col-1 col-md-3  ">
                            <button type="button" class="btn   px-2 btn-outline-success ">
                                ${category}
                            </button>
                        </div>`
            ).join("")}
                                    </div>
                                </span>
                            </li>
                        </ul>
                         <ul class="list-unstyled">
                            ${item.jobDescription}
                        </ul>
                    </div>
                </div>
                `;
    }
    function initActive() {
        let clickedJobId = SessionStorage.getSessionStorage("clickedJobId");
        if (clickedJobId) {
            $('.container-card .card[data-jobid="' + clickedJobId + '"]').addClass(
                "active1"
            );

            fetchJobDetails(clickedJobId);
        } else {


            fetchJobDetails("");
        }
    }
    $(window).on('beforeunload', function () {
        let keyword = $(".search-keyword input").val() || '';
        let option = $('#inputGroupSelect01 option:selected').val() || '';

        storeSearchValues(keyword, option);
    });
    const handleDebounceSearch = (keyword, option) => {
        let query = window.location.search
        const urlParams = new URLSearchParams(query);
        const keywordParameter = urlParams.get('keyword')
        const optionParameter = urlParams.get('location')
        let newUrl = window.location.pathname + '?'
        if (urlParams.has('keyword') !== keywordParameter) {
            newUrl += `keyword=${keyword}&`;
        }
        if (urlParams.has('location') !== optionParameter) {
            newUrl += `location=${option}`;
        }
        newUrl = newUrl.endsWith('&') ? newUrl.slice(0, -1) : newUrl;
        window.history.pushState({ path: newUrl }, '', newUrl);
        let textNameOption = $('#inputGroupSelect01 option:selected').text()
        let content = `<section class="min-vh-100 w-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
                            <span class="display-1 fw-bold">4</span>
                            <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
                            <span class="display-1 fw-bold bsb-flip-h">4</span>
                        </h2>
                        <h3 class="h2 mb-2">Oops! You're lost.</h3>
                        <p class="mb-5">Sorry, maybe the job you are looking for does not exist.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>`;


        $.ajax({
            type: "GET",
            url: '/app/views/job/jobActionSearch.php',
            data: {
                keyword: keyword || keywordParameter,
                location: option || optionParameter
            },
            cache: false,

            beforeSend: function () {
                $('.bodyjob').html("..loading")
            },
            success: function (response) {
                console.log(keyword, option)
                let GetDataSearch = response.data;
                console.log(response.data)
                let html = "";
                let count = "";
                if (GetDataSearch && GetDataSearch.length > 0) {
                    console.log(textNameOption)
                    let checkLogin = checkloginforHandler == "false";
                    count = `${response.countData} công việc liên quan đến ${(keywordParameter || optionParameter) ? `<span style="color:red">${keyword || textNameOption}</span>` : "bạn đang cần tìm"}`;
                    html += `<div class="container-card">`;

                    const firstJob = GetDataSearch.shift();
                    html += `<div class="card active1" data-jobid="${firstJob.jobId}">
        <div class="card-title">
            <p class="heading">${firstJob.jobName}<i class="far fa-compass"></i></p>
        </div>
        <div class="row align-items-center">
            <div class="logo ml-3 mb-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTxDRpxI5gXgaVmnO-VgcVUNOkca91jIpS75Flbzkz5W_5g5_V5&usqp=CAU">
            </div>
            <p class="text-muted">CyberLogitec Vietnam Co., Ltd.</p>
        </div>
        <a class="mutual btn " href="#">
          ${checkLogin
                            ? '  <a class="mutual btn" href="/app/views/Auth/login.php"><i class="fas fa-users"></i>&nbsp;&nbsp;<span>Đăng nhập để xem mức lương</span></a>'
                            : ""
                        }
        </a>
        <div class="dashed"></div>
        <div class="location">
            <ul class="list-unstyled">
                <li>location: ${firstJob.locationName}</li>
                <li>Hình thức: </li>
            </ul>
        </div>
        <div class="row btnrow my-4">
            ${firstJob.categoryName.split(",").map(
                            (category) => `
                    <div class="col-1 col-md-3 w-100">
                        <button type="button" class="btn  p-2 btn-outline-success ">
                            ${category}
                        </button>
                    </div>`
                        ).join("")}
        </div>
                        </div>`;

                    html += GetDataSearch.map(job => `
        <div class="card" data-jobid="${job.jobId}">
            <div class="card-title">
                <p class="heading">${job.jobName}<i class="far fa-compass"></i></p>
            </div>
            <div class="row align-items-center">
                <div class="logo ml-3 mb-3">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTxDRpxI5gXgaVmnO-VgcVUNOkca91jIpS75Flbzkz5W_5g5_V5&usqp=CAU">
                </div>
                <p class="text-muted">CyberLogitec Vietnam Co., Ltd.</p>
            </div>
            <a class="mutual btn " href="#">
               ${checkLogin ? '  <a class="mutual btn" href="/app/views/Auth/login.php"><i class="fas fa-users"></i>&nbsp;&nbsp;<span>Đăng nhập để xem mức lương</span>' : ""
                        }
            </a>
            <div class="dashed"></div>
            <div class="location">
                <ul class="list-unstyled">
                    <li>location: ${job.locationName}</li>
                    <li>Hình thức: </li>
                </ul>
            </div>
            <div class="row btnrow my-4">
                ${job.categoryName.split(",").map(
                            (category) => `
                        <div class="col-1 col-md-3 w-100">
                            <button type="button" class="btn w-100 p-2 btn-outline-success ">
                                ${category}
                            </button>
                        </div>`
                        ).join("")}
            </div>
        </div>`

                    ).join("");

                    html += `</div>`;


                    $(".count").html(count);
                    ;

                    $(".bodyjob").html(html).promise().done(function () {
                        let firstJobId = firstJob.jobId;

                        SessionStorage.setSessionStorage("clickedJobId", firstJobId);

                        fetchJobDetails(firstJobId)
                            .then((item) => {


                                $(".bodyjob").append(` <div class="w-75 bg-white container-white" style="position: sticky; top: 0; height: 100vh;">
                                    
                                    ${item} </div>`)
                            })
                            .catch((error) => {
                                console.error("Error:", error);
                            });


                    });
                } else {
                    $(".bodyjob").html(content);
                    $(".count").html("");
                }
            },
            complete: function (txt_status) {
                if (txt_status.status === 404) {
                    $('.bodyjob').html(`<div class=" search-noinfo text-center imt-6 imb-md-8 ipy-10" data-jobs--filter-target="searchNoInfo">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <img class="search-noinfo-image border-radius-large" src="https://itviec.com/assets/robby/robby-oops-cd13e61e958cb387feae4f2276e78d19f123768a672880dca236bc611c591ca9.svg">
                                                        </div>
                                                            </div>
                                                    <div class="ipx-6 ipx-md-8 ipt-5">
                                                    <h2 data-jobs--filter-target="textNoResult">
                                                    Xin lỗi! Việc làm bạn đang tìm kiếm không tồn tại.
                                                        </h2>
                                                                    </div>
                                                                </div>`)
                }

            }
            ,
            error: function (xhr, status, error) {
                console.error("Error:", xhr);
            },
        });

    }

    function storeSearchValues(keyword, option, callback) {
        sessionStorage.setItem('searchKeyword', keyword);
        sessionStorage.setItem('searchOption', option);
        if (callback && typeof callback === 'function') {
            callback();
        }
    }
    const handleSearch = () => {
        let keyword = $(".search-keyword input").val();
        let option = $('#inputGroupSelect01 option:selected').val();

        storeSearchValues(keyword, option, () => {
            handleDebounceSearch(keyword, option);
        });
    };

    $(".ibtn").click(debounce(() => handleSearch()));

    $(".inputsearch").on("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            $(".ibtn").click();
        }
    })
    $("#inputGroupSelect01").on('change', () => {

        let optionValue = $('#inputGroupSelect01 option:selected').val();
        if (optionValue === "all_cities") {
            $(".ibtn").click();
        } else {
            handleSearch()
        }

    })

    let storedKeyword = SessionStorage.getSessionStorage('searchKeyword');
    let storedOption = SessionStorage.getSessionStorage('searchOption');
    $('.list-card').on('click', '.card-item', function () {
        let id = $(this).data('jobid')
        SessionStorage.setSessionStorage("clickedJobId", id)



        if (storedKeyword && storedOption) {
            SessionStorage.clearSessionStorage("searchKeyword")
            SessionStorage.clearSessionStorage("searchOption")
        }
        fetchJobDetails(id)
    })
    function handleinitRedirectSearch() {

        if (
            storedKeyword && storedOption) {
            handleDebounceSearch(storedKeyword, storedOption)
        }

    }

    $(document).on("click", ".container-card .card", function () {
        let jobid = $(this).data("jobid");

        $(".container-card .card").removeClass("active1");
        $(this).addClass("active1");

        SessionStorage.setSessionStorage("clickedJobId", jobid);

        fetchJobDetails(jobid);
    });


    function fetchDataCategory() {
        $.ajax({
            url: '/app/api/category.api.php',
            type: "GET",
            data: { action: 'getAllCategory' },
            success: function (response) {
                if ($('.pagination-category')) {
                    $('.pagination-category').pagination({
                        dataSource: response.data,
                        prevClassName: "page-link",
                        prevText: `Prev`,
                        nextText: `Next`,
                        disableClassName: "bg-none",
                        nextClassName: "page-link",
                        ulClassName: "pagination",
                        pageClassName: "page-link",
                        pageSize: 5,
                        callback: function (data) {
                            renderTableCategory(data);
                        }
                    });

                }

            },
            error: function (error) {
                console.log(error);
            }
        })
    }
    const renderTableCategory = (categories) => {
        let tableBody = $(".categoryTable");
        tableBody.empty();

        categories.forEach(function (category) {
            var row = $("<tr></tr>");
            row.append('<td>' + category.categoryId + '</td>' +
                '<td>' + category.categoryName + '</td>' +

                `
                    <td> <a href="#" class="text-primary mx-2 editdata"  data-category-id="${category.categoryId}" >Edit</a> <a href="#" class="text-danger deleteCategory"   >Delete</a></td>
                    
                    `
            );

            tableBody.append(row);

        });
    }
    function updateCategory(id, categoryName) {

        $('#saveCategoryBtn').addClass('btnUpdate')
        $('#formCategory input').val(categoryName)
        $('#exampleModalCenter').modal('show');
        $('#exampleModalLongTitle').text("Update Category")
        $('.btnUpdate').data('category-id', id);
        if ($('.Create')) {
            $('#saveCategoryBtn').removeClass('create')

        }
    }
    $('#exampleModalCenter').on('click', '.btnUpdate', function () {

        let categoryName = $('#formCategory input').val();
        let categoryId = $(this).data('category-id')

        let formData = {
            action: "edit", categoryId: categoryId, categoryName: categoryName
        }
        $.ajax({
            url: "/app/api/category.api.php",
            type: "POST",
            data: formData,
            success: function (response) {
                console.log(response)
                $('#exampleModalCenter').modal('hide');
                $(".categoryTable").load('/app/api/loadpage.php', function () {
                    fetchDataCategory()
                })

            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        })
    })
    $(document).on('click', '.editdata', function () {
        var categoryId = $(this).data('category-id');
        let attributeName = $(this).closest('tr').find('td:eq(1)').text();

        updateCategory(categoryId, attributeName)

    })
    $('.btnCreate').on('click', function () {
        $(this).addClass("Create")
        $('#exampleModalLongTitle').text("Create Category")
        $('.formCategory input').val('')
        $('#saveCategoryBtn').addClass('btnCreate')
        if ($(".btnUpdate")) {
            $('#saveCategoryBtn').removeClass('btnUpdate')
            $('#formCategory input').val('')
            $('.btnUpdate').data('', '');

        }
    })
    $('#exampleModalCenter').on('click', '.btnCreate', function () {
        let formData = {
            categoryName: $('#formCategory input').val(),
            action: "add"
        }
        $.ajax({
            type: "POST",
            url: "/app/api/category.api.php",
            data: formData,
            success: function (response) {
                console.log(response)
                $('#exampleModalCenter').modal('hide');

            }
        })
    })

    function deleteCategoryId(id) {
        console.log(id)
        let requestData = { action: 'deleteCategoryId', categoryId: id }
        $.ajax({
            url: "/app/api/category.api.php",
            type: 'POST',
            data: requestData,
            dataType: "json",

        }).done(response => {

            console.log(response)
        })
    }
    $('.categoryTable').on('click', '.deleteCategory', function () {
        const categoryId = $(this).closest('tr').find('td:eq(0)').text();
        deleteCategoryId(categoryId)
    })


    function fetchDataJob(pageNumber) {
        $.ajax({
            url: "/app/api/job.api.php",
            type: "GET",
            case: false,
            data: { action: "getAllPageJob", page: pageNumber },
            success: function (response) {
                if (response.countData > 0) {
                    renderTableJob(response.data);
                    renderPagination(response.countData, pageNumber);
                }
                else {
                    renderTableJob(response.data);
                }


            },
            error: function (error) {
                console.error("Error occurred while fetching job details.", error);
            }
        });
    }

    function renderTableJob(Jobs) {
        var tableBody = $(".jobTable");
        tableBody.empty();
        if (Jobs != null) {
            Jobs?.forEach(function (job) {
                var row = $("<tr></tr>");
                row.append('<td>' + job.jobId + '</td>' +
                    '<td>' + job.jobName + '</td>' +
                    '<td>' + clearHTMLTags(job.jobDescription) + '</td>' +
                    '<td>' + job.categoryName + '</td>' +
                    '<td>' + job.locationName + '</td>' +
                    '<td>' + job.jobStatus + '</td>' +
                    `
                <td>
                <a href="#" class="text-primary mx-2 editJob" data-job-id=${job.jobId}>Edit</a> 
                    <a href="#" class="text-danger deleteJob">Delete</a></td>
                    
                `
                );

                tableBody.append(row);
            });
        }
        else {
            tabBody.append('<div>sorry not data</div>')
        }

    }
    if ($('#addJobForm').length && typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace("jobDescription");

        $("#addJobForm").validate({
            ignore: [],
            rules: {
                jobName: "required",
                jobDescription: {
                    required: function () {
                        CKEDITOR.instances.jobDescription.updateElement();
                    },
                    minlength: 10,
                },
            },
            messages: {
                jobName: "Please enter text",
                jobDescription: {
                    required: "Please enter text",
                    minlength: "Please enter at least 10 characters",
                },
            },
        });
        $('.btnCreateJob').on('click', function () {
            $('#saveJobBtn').addClass('btnCreateJobAction')
            $('.jobTitle').text("Create Job")
            if ($('#saveJobBtn').hasClass('btnUpdateJob')) {
                let formData = {}
                $('#saveJobBtn').removeClass('btnUpdateJob')
                $("#addJobForm input, #addJobForm .form-group textarea, #addJobForm select").each(function () {
                    var fieldName = $(this).attr("name");
                    var fieldValue = $(this).val("");
                    formData[fieldName] = fieldValue;
                });
                formData['jobDescription'] = CKEDITOR.instances.jobDescription.setData("")
            }
        })
        $("#exampleModalCenter").on('click', '.btnCreateJobAction', function () {

            var formData = { action: "addJob" };
            $("#addJobForm input, #addJobForm .form-group textarea, #addJobForm select").each(function () {
                var fieldName = $(this).attr("name");
                var fieldValue = $(this).val();
                formData[fieldName] = fieldValue;
            });

            var editorData = CKEDITOR.instances.jobDescription.getData();
            formData["jobDescription"] = editorData;

            let isValid = $("#addJobForm").valid();
            if (isValid) {
                $.ajax({
                    type: "POST",
                    url: "/app/api/job.api.php",
                    data: formData,
                    success: function (response) {
                        notification.notify('success', 'Successfully to add');
                        $('#exampleModalCenter').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                    },
                });
            }
        });
    }

    function updateJob(rest) {
        $('#exampleModalCenter').modal('show');
        $('#saveJobBtn').addClass('btnUpdateJob')

        if ($('.btnCreateJobAction')) {
            $('#saveJobBtn').removeClass('btnCreateJobAction')
        }
        $('#exampleModalLongTitle').hasClass('jobTitle') ? $('#exampleModalLongTitle').text("Update job") : ""
        rest.map(item => {
            $('.btnUpdateJob').data('job-id', item.jobId);

            $('#jobName').val(item.jobName)
            CKEDITOR.instances.jobDescription.setData(item?.jobDescription)
            $('#locationSelect ').val(item?.locationId)
            $('#categoryJob').val(item?.categoryId)
            $('#jobStatus').val(item?.jobStatus)
        })


    }
    $('#exampleModalCenter').on('click', '.btnUpdateJob', function () {
        let JobId = $('.btnUpdateJob').data('job-id')
        let formData = { action: 'editJob', jobId: JobId }
        $('#addJobForm input, #addJobForm .form-group textarea, #addJobForm select').each(function () {
            let fieldName = $(this).attr('name')
            let fieldValue = $(this).val()
            formData[fieldName] = fieldValue
        })
        formData['jobDescription'] = CKEDITOR.instances.jobDescription.getData()
        $.ajax({
            url: '/app/api/job.api.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response?.data) {
                    notification.notify('success', 'Successfully to update Job');
                    $(".editJob").load('/app/api/loadpage.php', function () {
                        fetchDataJob(1)
                    })
                    $('#exampleModalCenter').modal('hide');
                }
            },
            error: function (error) {
                throw new Exception("Something bad happened", error);
            }
        })
    })


    $('.jobTable').on('click', '.editJob', function () {

        const jobId = $(this).closest('tr').find('td:eq(0)').text();

        const requestData = {
            action: 'getJobById',
            jobId: jobId,

        }

        $.ajax({
            url: '/app/api/job.api.php',
            type: 'POST',
            data: requestData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                updateJob(response)



            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    $('.jobTable').on('click', '.deleteJob', function () {


        const jobId = $(this).closest('tr').find('td:eq(0)').text();
        const requestData = {
            action: 'getJobById',
            jobId: jobId,

        }
        $.ajax({
            url: '/app/api/job.api.php',
            type: 'GET',
            data: requestData,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    let data = response?.map(item => item.jobId)
                    deleteJobId(data[0])
                }
            }
        })


    })
    function deleteJobId(id) {
        let request = { action: 'deleteJobId', jobId: id }
        $.ajax({
            url: '/app/api/job.api.php',
            type: 'POST',
            data: request,
            success: function (response) {
                if (response) {
                    $(".jobTable").find(`tr:contains('${id}')`).remove();
                }
            }
        })
    }




    function renderPagination(count, currentPage) {
        var perPage = 3;
        var totalPages = Math.ceil(count / perPage);

        var paginationHtml = '<ul class="pagination">';
        if (currentPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '">Previous</a></li>'


        }
        else {
            paginationHtml += '<li class="page-item disabled"><a class="page-link" href="#" data-page="">Previous</a></li>';

        }
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';

        }
        if (currentPage === totalPages) {
            paginationHtml += '<li class="page-item disabled"><a class="page-link" href="#" data-page="">Next</a></li>';

        }
        else {
            paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + (currentPage + 1) + '">Next</a></li>'

        }
        paginationHtml += '</ul>';
        $('#pagination').html(paginationHtml);

        $('.pagination').on('click', '.page-link', function () {
            var pageNumber = $(this).data('page');
            fetchDataJob(pageNumber);
        });
    }



    $('#exampleModalCenter').find('.closing').on('click', function () {
        $('#exampleModalCenter').modal('hide');
    });

    const jobCard = (job) => {

        return `
        <div class="card mx-2 p-5  my-2 card-item rounded-lg p-4 col-3 shadow-sm"  data-jobid="${job.jobId}">
        <div =class="col-xl-12">
            <div class="card-title">
               <a href="/app/views/job/job.php"> <p class="heading h5 font-weight-bold text-capitalize">${job.jobName}<i class="far fa-compass"></i></p></a>
            </div>
            <div class=" row align-items-center justify-content-center w-100">
                <div class="logo ml-3" style="width: 20%;">
                    <img class="w-100" src=${job?.jobImage}>
                </div>
                <p class="text-muted text-center">CyberLogitec Vietnam Co., Ltd.</p>
            </div>
            
       
            <div class="dashed"></div>
            <div class="location">
                <ul class="list-unstyled">
                    <li>Tại văn phòng</li>
                    <li>location: ${job.locationName}</li>
                    <li>Hình thức: online </li>
                </ul>
            </div>
            <div class="row btnrow my-4">
                ${job.categoryName.split(",").map(
            (category) => `
                       
                            <button type="button" class="btn  p-2 m-2 col-4 col-xl-3 text-left p-2 btn-color btn-outline-success">
                                ${category}
                            </button>
                      `
        ).join("")}
            </div>
            </div>
        </div>`


    }

    function handleLoadMoreJob() {
        $.ajax({
            url: '/app/api/job.api.php',
            data: { action: 'getAll' },
            dataType: 'json',
        }).done(response => {
            console.log(response)
            if (response.success == true) {
                let datas = response.data.map(item => jobCard(item))
                $('.list-card').html(datas)
                if ($('#loadMore').hasClass('loadMore')) {
                    $('.loadMore').simpleLoadMore({
                        item: '.card',
                        count: 3,
                        easing: 'fade',
                        itemsToLoad: 3,
                        btnText: "Xem thêm nhiều công việc khác",
                        btnWrapperClass: "text-center py-4",

                    })

                }
            }
        })


    }


    function getIdJobToApply() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const id = urlParams.get('jobId')

        $.get(`/app/api/job.api.php?action=getJobById&jobId=${id}`, function (data, status) {
            const name = data.map(item => item.jobName)

            $('.titleApplication').text(name)
        });

    }

    function handlePostCv() {
        const adminId = $('.userId').data('user-id')
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const id = urlParams.get('jobId')
        const formData = { action: "postcv", adminId: adminId, jobId: id }
        $("#postCv input, #postCv textarea").each(function () {
            var fieldName = $(this).attr("name");
            var fieldValue = $(this).val();
            formData[fieldName] = fieldValue;
        });
        $.ajax({
            url: '/app/api/apply.api.php',
            type: "POST",
            data: formData,
            dataType: 'json'
            
        }).done(function (response) {
            console.log(response)
        })

    }
    if ($('.titleApplication')) {
        getIdJobToApply()
        $('.btn-post').on("click", function () {
            handlePostCv()
        })
    }
    handleinitRedirectSearch();
    handleLoadMoreJob()
    initActive()
    fetchDataCategory();
    fetchDataJob(1)
});
