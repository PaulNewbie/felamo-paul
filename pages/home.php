<?php
include("components/header.php");

$isSuperAdmin = $user['role'] === 'super_admin';
?>

<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">
<input type="hidden" id="hidden_is_super_admin" value="<?= $isSuperAdmin ? 'true' : 'false' ?>">

<style>
    .card {
        background-color: white;
    }
</style>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center">
        <h2 class="text-main mb-4">Hello, <?= $user['name'] ?>!</h2>

        <div>
            <button class="btn btn-sm btn-main text-light" id="btnDownload"><i class="bi bi-box-arrow-down"></i> Download</button>
            <button class="btn btn-sm btn-main text-light" id="btnDownloadStudentData"><i class="bi bi-box-arrow-down"></i> Download Student Data</button>
        </div>
    </div>

    <?php if ($user['role'] == "teacher") { ?>
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-1-circle-fill"></i> Unang Markahan</h6>
                    <hr class="mt-1">
                    <div class="d-flex justify-content-between gap-1">
                        <div class="card py-2 px-3 text-main w-50">
                            <div style="font-size: 13px;">Failed</div>
                            <h5 class="text-center"><i class="bi bi-people"></i> <span id="unang-markahan-no-of-failed-student">0</span></h5>
                        </div>
                        <div class="card py-2 px-3 text-main w-50">
                            <div style="font-size: 13px;">Passed</div>
                            <h5 class="text-center"><i class="bi bi-people"></i> <span id="unang-markahan-no-of-passed-student">0</span></h5>
                        </div>
                    </div>

                    <a id="link-unang-markahan" class="btn btn-main text-light my-2 d-flex align-items-center justify-content-center" style="height: 20px; font-size: 11px;">
                        <span>
                            View Details
                        </span>
                    </a>

                    <div class="card py-2 px-3 text-main mt-1">
                        <div class="card-label" style="font-size: 13px;">Students Completed All Videos</div>
                        <h5 class="text-center">
                            <i class="bi bi-people"></i>
                            <span id="unang-markahan-student-video-completion-count">0</span>
                        </h5>
                    </div>

                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-2-circle-fill"></i> Pangalawang Markahan</h6>
                    <hr class="mt-1">
                    <div class="d-flex justify-content-between gap-1">
                        <div class="card py-2 px-3 text-main w-50">
                            <div style="font-size: 13px;">Failed</div>
                            <h5 class="text-center"><i class="bi bi-people"></i> <span id="pangalawang-markahan-no-of-failed-student">0</span></h5>
                        </div>
                        <div class="card py-2 px-3 text-main w-50">
                            <div style="font-size: 13px;">Passed</div>
                            <h5 class="text-center"><i class="bi bi-people"></i> <span id="pangalawang-markahan-no-of-passed-student">0</span></h5>
                        </div>
                    </div>

                    <a id="link-pangalawang-markahan" class="btn btn-main text-light my-2 d-flex align-items-center justify-content-center" style="height: 20px; font-size: 11px;">
                        <span>
                            View Details
                        </span>
                    </a>

                    <div class="card py-2 px-3 text-main mt-1">
                        <div class="card-label" style="font-size: 13px;">Students Completed All Videos</div>
                        <h5 class="text-center">
                            <i class="bi bi-people"></i>
                            <span id="pangalawang-markahan-student-video-completion-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-3-circle-fill"></i> Pangatlong Markahan</h6>
                    <hr class="mt-1">
                    <div class="d-flex justify-content-between gap-1">
                        <div class="card py-2 px-3 text-main w-50">
                            <div style="font-size: 13px;">Failed</div>
                            <h5 class="text-center"><i class="bi bi-people"></i> <span id="pangatlong-markahan-no-of-failed-student">0</span></h5>
                        </div>
                        <div class="card py-2 px-3 text-main w-50">
                            <div style="font-size: 13px;">Passed</div>
                            <h5 class="text-center"><i class="bi bi-people"></i> <span id="pangatlong-markahan-no-of-passed-student">0</span></h5>
                        </div>
                    </div>

                    <a id="link-pangatlong-markahan" class="btn btn-main text-light my-2 d-flex align-items-center justify-content-center" style="height: 20px; font-size: 11px;">
                        <span>
                            View Details
                        </span>
                    </a>

                    <div class="card py-2 px-3 text-main mt-1">
                        <div class="card-label" style="font-size: 13px;">Students Completed All Videos</div>
                        <h5 class="text-center">
                            <i class="bi bi-people"></i>
                            <span id="pangatlong-markahan-student-video-completion-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-4-circle-fill"></i> Ika-apat Markahan</h5>
                        <hr class="mt-1">
                        <div class="d-flex justify-content-between gap-1">
                            <div class="card py-2 px-3 text-main w-50">
                                <div style="font-size: 13px;">Failed</div>
                                <h5 class="text-center"><i class="bi bi-people"></i> <span id="ika-apat-na-markahan-no-of-failed-student">0</span></h5>
                            </div>
                            <div class="card py-2 px-3 text-main w-50">
                                <div style="font-size: 13px;">Passed</div>
                                <h5 class="text-center"><i class="bi bi-people"></i> <span id="ika-apat-na-markahan-no-of-passed-student">0</span></h5>
                            </div>
                        </div>

                        <a id="link-ika-apat-na-markahan" class="btn btn-main text-light my-2 d-flex align-items-center justify-content-center" style="height: 20px; font-size: 11px;">
                            <span>
                                View Details
                            </span>
                        </a>

                        <div class="card py-2 px-3 text-main mt-1">
                            <div class="card-label" style="font-size: 13px;">Students Completed All Videos</div>
                            <h5 class="text-center">
                                <i class="bi bi-people"></i>
                                <span id="ika-apat-na-markahan-student-video-completion-count">0</span>
                            </h5>
                        </div>
                </div>
            </div>

        </div>

        <hr>

        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-person-lines-fill"></i> Total Sections</h6>
                    <hr class="mt-1">
                    <div class="card py-2 px-3 text-main mt-1">
                        <div class="card-label" style="font-size: 13px;">Number of Assign Section</div>
                        <h5 class="text-center">
                            <i class="bi bi-people"></i>
                            <span id="dashboard-my-section-count-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-person-lines-fill"></i> Total Students</h6>
                    <hr class="mt-1">
                    <div class="card py-2 px-3 text-main mt-1">
                        <div class="card-label" style="font-size: 13px;">Number Assign Students</div>
                        <h5 class="text-center">
                            <i class="bi bi-people"></i>
                            <span id="dashboard-my-student-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <canvas id="passed-failed-student-chart"></canvas>

    <?php } ?>


    <?php if ($user['role'] == "super_admin") { ?>

        <div class="row">
            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-1-circle-fill"></i> Unang Markahan</h6>
                    <hr class="mt-1">

                    <div class="card py-2 px-3 text-main">
                        <div class="card-label" style="font-size: 13px;">Videos Uploaded</div>
                        <h5 class="text-center">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            <span id="unang-markahan-videos-uploaded-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-2-circle-fill"></i> Pangalawang Markahan</h6>
                    <hr class="mt-1">

                    <div class="card py-2 px-3 text-main">
                        <div class="card-label" style="font-size: 13px;">Videos Uploaded</div>
                        <h5 class="text-center">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            <span id="pangalawang-markahan-videos-uploaded-count"></span>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-3-circle-fill"></i> Pangatlong Markahan</h6>
                    <hr class="mt-1">

                    <div class="card py-2 px-3 text-main">
                        <div class="card-label" style="font-size: 13px;">Videos Uploaded</div>
                        <h5 class="text-center">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            <span id="pangatlong-markahan-videos-uploaded-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-4-circle-fill"></i> Ika-apat Markahan</h5>
                        <hr class="mt-1">

                        <div class="card py-2 px-3 text-main">
                            <div class="card-label" style="font-size: 13px;">Videos Uploaded</div>
                            <h5 class="text-center">
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                <span id="ika-apat-na-markahan-videos-uploaded-count">0</span>
                            </h5>
                        </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-person-lines-fill"></i> Total App Users</h6>
                    <hr class="mt-1">
                    <div class="card py-2 px-3 text-main mt-1">
                        <div class="card-label" style="font-size: 13px;">Number of Registered Users</div>
                        <h5 class="text-center">
                            <i class="bi bi-people"></i>
                            <span id="dashboard-total-users-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="card p-3 text-main">
                    <h6 class=""><i class="bi bi-person-lines-fill"></i> Total Web Users</h6>
                    <hr class="mt-1">
                    <div class="card py-2 px-3 text-main mt-1">
                        <div class="card-label" style="font-size: 13px;">Number of Registered Users</div>
                        <h5 class="text-center">
                            <i class="bi bi-people"></i>
                            <span id="dashboard-total-web-users-count">0</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <canvas id="videos-uploaded-chart"></canvas>

    <?php } ?>
</div>


<?php
include("components/footer-scripts.php");
?>

<!-- script here -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {

        const hidden_user_id = $("#hidden_user_id").val();
        const is_super_admin = $("#hidden_is_super_admin").val();

        const loadDashBoard = () => {

            var teacherChart = null;
            var superAdminChart = null;

            var unangMarkahanPassedCount = 0;
            var pangalawangMarkahanPassedCount = 0;
            var pangatlongMarkahanPassedCount = 0;
            var ikaApatNaMarkahanPassedCount = 0;

            var unangMarkahanFailedCount = 0;
            var pangalawangMarkahanFailedCount = 0;
            var pangatlongMarkahanFailedCount = 0;
            var ikaApatNaMarkahanFailedCount = 0;


            console.log(hidden_user_id);
            console.log(is_super_admin);

            $.ajax({
                type: "POST",
                url: "../backend/api/web/home.php",
                data: {
                    requestType: "LoadDashboard",
                    hidden_user_id,
                    is_super_admin
                },
                success: function(response) {
                    let res = JSON.parse(response);


                    if (is_super_admin == "true") {
                        // -------
                        let unangMarkahanVideosUploadedCount = res.data.vid_uploaded_count[0].video_count;
                        let pangalawangMarkahanVideosUploadedCount = res.data.vid_uploaded_count[1].video_count;
                        let pangatlongMarkahanVideosUploadedCount = res.data.vid_uploaded_count[2].video_count;
                        let ikaApatNaMarkahanVideosUploadedCount = res.data.vid_uploaded_count[3].video_count;

                        $("#unang-markahan-videos-uploaded-count").text(unangMarkahanVideosUploadedCount);
                        $("#pangalawang-markahan-videos-uploaded-count").text(pangalawangMarkahanVideosUploadedCount);
                        $("#pangatlong-markahan-videos-uploaded-count").text(pangatlongMarkahanVideosUploadedCount);
                        $("#ika-apat-na-markahan-videos-uploaded-count").text(ikaApatNaMarkahanVideosUploadedCount);
                        // -------

                        // -------
                        $("#dashboard-total-users-count").text(res.data.users_count.count);
                        $("#dashboard-total-web-users-count").text(res.data.web_users_count.count);
                        // -------

                        // cchart
                        var vidUploadedCtx = document.getElementById('videos-uploaded-chart').getContext('2d');

                        if (superAdminChart) {
                            myChart.destroy();
                        }

                        superAdminChart = new Chart(vidUploadedCtx, {
                            type: 'line',
                            data: {
                                labels: ['Unang Markahan', 'Pangalawang Markahan', 'Pangatlong Markahan', 'Ika-apat Markahan'],
                                datasets: [{
                                    label: 'Uploaded Videos',
                                    // data: [12, 19, 3, 5],
                                    data: [unangMarkahanVideosUploadedCount, pangalawangMarkahanVideosUploadedCount, pangatlongMarkahanVideosUploadedCount, ikaApatNaMarkahanVideosUploadedCount],
                                    borderColor: 'blue',
                                    backgroundColor: 'rgba(0, 0, 255, 0.1)',
                                    fill: true
                                }]
                            }
                        });


                    } else {
                        // 
                        $("#link-unang-markahan").attr("href", "taken_assessments.php?level=" + res.data.level_stats[0].id);
                        $("#link-pangalawang-markahan").attr("href", "taken_assessments.php?level=" + res.data.level_stats[1].id);
                        $("#link-pangatlong-markahan").attr("href", "taken_assessments.php?level=" + res.data.level_stats[2].id);
                        $("#link-ika-apat-na-markahan").attr("href", "taken_assessments.php?level=" + res.data.level_stats[3].id);


                        // teacher
                        unangMarkahanFailedCount = res.data.level_stats[0].failed_count;
                        unangMarkahanPassedCount = res.data.level_stats[0].passed_count;
                        $("#unang-markahan-no-of-failed-student").text(unangMarkahanFailedCount);
                        $("#unang-markahan-no-of-passed-student").text(unangMarkahanPassedCount);

                        pangalawangMarkahanFailedCount = res.data.level_stats[1].failed_count;
                        pangalawangMarkahanPassedCount = res.data.level_stats[1].passed_count;
                        $("#pangalawang-markahan-no-of-failed-student").text(pangalawangMarkahanFailedCount);
                        $("#pangalawang-markahan-no-of-passed-student").text(pangalawangMarkahanPassedCount);

                        pangatlongMarkahanFailedCount = res.data.level_stats[2].failed_count;
                        pangatlongMarkahanPassedCount = res.data.level_stats[2].passed_count;
                        $("#pangatlong-markahan-no-of-failed-student").text(pangatlongMarkahanFailedCount);
                        $("#pangatlong-markahan-no-of-passed-student").text(pangatlongMarkahanPassedCount);

                        ikaApatNaMarkahanFailedCount = res.data.level_stats[3].failed_count;
                        ikaApatNaMarkahanPassedCount = res.data.level_stats[3].passed_count;
                        $("#ika-apat-na-markahan-no-of-failed-student").text(ikaApatNaMarkahanFailedCount);
                        $("#ika-apat-na-markahan-no-of-passed-student").text(ikaApatNaMarkahanPassedCount);


                        // ------
                        var unangMarkahanVideoCompletionCount = res.data.completed_stats[0].count;
                        $("#unang-markahan-student-video-completion-count").text(unangMarkahanVideoCompletionCount);

                        var pangalawangMarkahanVideoCompletionCount = res.data.completed_stats[1].count;
                        $("#pangalawang-markahan-student-video-completion-count").text(pangalawangMarkahanVideoCompletionCount);

                        var pangatlongMarkahanVideoCompletionCount = res.data.completed_stats[2].count;
                        $("#pangatlong-markahan-student-video-completion-count").text(pangatlongMarkahanVideoCompletionCount);

                        var ikaApatNaMarkahanVideoCompletionCount = res.data.completed_stats[3].count;
                        $("#ika-apat-na-markahan-student-video-completion-count").text(ikaApatNaMarkahanVideoCompletionCount);



                        $("#dashboard-my-section-count-count").text(res.data.section_count);
                        $("#dashboard-my-student-count").text(res.data.total_students);



                        // chart

                        var passFailedCtx = document.getElementById('passed-failed-student-chart').getContext('2d');

                        if (teacherChart) {
                            myChart.destroy();
                        }

                        teacherChart = new Chart(passFailedCtx, {
                            type: 'line',
                            data: {
                                labels: ['Unang Markahan', 'Pangalawang Markahan', 'Pangatlong Markahan', 'Ika-apat Markahan'],
                                datasets: [{
                                    label: 'Passed',
                                    // data: [12, 19, 3, 5],
                                    data: [unangMarkahanPassedCount, pangalawangMarkahanPassedCount, pangatlongMarkahanPassedCount, ikaApatNaMarkahanPassedCount],
                                    borderColor: 'blue',
                                    backgroundColor: 'rgba(0, 0, 255, 0.1)',
                                    fill: true
                                }, {
                                    label: 'Failed',
                                    // data: [4, 15, 10, 15],
                                    data: [unangMarkahanFailedCount, pangalawangMarkahanFailedCount, pangatlongMarkahanFailedCount, ikaApatNaMarkahanFailedCount],
                                    borderColor: 'green',
                                    backgroundColor: 'rgba(0, 255, 21, 0.1)',
                                    fill: true
                                }]
                            }
                        });
                    }

                }
            });

        }



        $("#btnDownload").click(function() {
            $.ajax({
                type: "POST",
                url: "../backend/api/web/home.php",
                data: {
                    requestType: "LoadDashboard",
                    hidden_user_id,
                    is_super_admin
                },
                success: function(response) {
                    let res = JSON.parse(response);

                    if (is_super_admin == "true") {

                        var vidUploaded = res.data.vid_uploaded_count;

                        var usersCount = res.data.users_count.count;
                        var webUsersCount = res.data.web_users_count.count;

                        var unang = vidUploaded.find(x => x.level == 1)?.video_count ?? 0;
                        var pangalawa = vidUploaded.find(x => x.level == 2)?.video_count ?? 0;
                        var pangatlo = vidUploaded.find(x => x.level == 3)?.video_count ?? 0;
                        var ikaapat = vidUploaded.find(x => x.level == 4)?.video_count ?? 0;

                        let headers = [
                            "unang_markahan_uploaded_video",
                            "pangalawang_markahan_uploaded_video",
                            "pangatlong_markahan_uploaded_video",
                            "ikaapat_markahan_uploaded_video",
                            "total_app_users",
                            "total_web_users"
                        ];

                        let row = [unang, pangalawa, pangatlo, ikaapat, usersCount, webUsersCount];

                        let csvContent = "data:text/csv;charset=utf-8," +
                            headers.join(",") + "\n" +
                            row.join(",");

                        const encodedUri = encodeURI(csvContent);
                        const link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", "dashboard_data_super_admin.csv");
                        document.body.appendChild(link);
                        link.click();
                    } else {
                        var unangFailed = res.data.level_stats[0].failed_count;
                        var unangPassed = res.data.level_stats[0].passed_count;

                        var pangalawaFailed = res.data.level_stats[1].failed_count;
                        var pangalawaPassed = res.data.level_stats[1].passed_count;

                        var pangatloFailed = res.data.level_stats[2].failed_count;
                        var pangatloPassed = res.data.level_stats[2].passed_count;

                        var ikaapatFailed = res.data.level_stats[3].failed_count;
                        var ikaapatPassed = res.data.level_stats[3].passed_count;

                        var unangVideoComplete = res.data.completed_stats[0].count;
                        var pangalawaVideoComplete = res.data.completed_stats[1].count;
                        var pangatloVideoComplete = res.data.completed_stats[2].count;
                        var ikaapatVideoComplete = res.data.completed_stats[3].count;

                        var sectionCount = res.data.section_count;
                        var totalStudents = res.data.total_students;

                        let headers = [
                            "unang_failed", "unang_passed", "unang_video_complete",
                            "pangalawa_failed", "pangalawa_passed", "pangalawa_video_complete",
                            "pangatlo_failed", "pangatlo_passed", "pangatlo_video_complete",
                            "ikaapat_failed", "ikaapat_passed", "ikaapat_video_complete",
                            "total_sections", "total_students"
                        ];

                        let row = [
                            unangFailed, unangPassed, unangVideoComplete,
                            pangalawaFailed, pangalawaPassed, pangalawaVideoComplete,
                            pangatloFailed, pangatloPassed, pangatloVideoComplete,
                            ikaapatFailed, ikaapatPassed, ikaapatVideoComplete,
                            sectionCount, totalStudents
                        ];

                        let csvContent = "data:text/csv;charset=utf-8," +
                            headers.join(",") + "\n" +
                            row.join(",");

                        const encodedUri = encodeURI(csvContent);
                        const link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", "dashboard_data_teacher.csv");
                        document.body.appendChild(link);
                        link.click();
                    }
                }
            });
        });

        $("#btnDownloadStudentData").click(function() {

            $.ajax({
                type: "POST",
                url: "../backend/api/web/students.php",
                data: {
                    requestType: "GetStudents",
                    auth_user_id: hidden_user_id,
                    is_super_admin,
                    section_id: ""
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    const data = res.data;

                    if (!Array.isArray(data) || data.length === 0) {
                        console.error("No data found to export.");
                        return;
                    }

                    const headers = Object.keys(data[0]);

                    const rows = data.map(obj =>
                        headers.map(h => JSON.stringify(obj[h] ?? "")).join(",")
                    );

                    const csvContent = [headers.join(","), ...rows].join("\n");

                    const blob = new Blob([csvContent], {
                        type: "text/csv;charset=utf-8;"
                    });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement("a");
                    link.setAttribute("href", url);
                    link.setAttribute("download", "data.csv");
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });

        });



        setInterval(loadDashBoard, 3000);

        loadDashBoard();
    });
</script>

<?php
include("components/footer.php");
