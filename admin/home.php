<?php
include 'db_connect.php';

// Basic counts
$total_alumni = $conn->query("SELECT COUNT(*) as count FROM alumnus_bio WHERE status = 1")->fetch_assoc()['count'];
$total_forum_topics = $conn->query("SELECT COUNT(*) as count FROM forum_topics")->fetch_assoc()['count'];
$total_jobs = $conn->query("SELECT COUNT(*) as count FROM careers")->fetch_assoc()['count'];
$total_events = $conn->query("SELECT COUNT(*) as count FROM events WHERE DATE_FORMAT(schedule, '%Y-%m-%d') >= '" . date('Y-m-d') . "'")->fetch_assoc()['count'];

// Upcoming events
$upcoming_events = $conn->query("SELECT title, schedule FROM events WHERE DATE_FORMAT(schedule, '%Y-%m-%d') >= '" . date('Y-m-d') . "' ORDER BY schedule ASC")->fetch_all(MYSQLI_ASSOC);

// Analytics data
$alumni_by_gender = $conn->query("SELECT gender, COUNT(*) as count FROM alumnus_bio WHERE status = 1 GROUP BY gender")->fetch_all(MYSQLI_ASSOC);
$alumni_by_batch = $conn->query("SELECT batch, COUNT(*) as count FROM alumnus_bio WHERE status = 1 GROUP BY batch")->fetch_all(MYSQLI_ASSOC);
$alumni_by_course = $conn->query("SELECT courses.course as course_name, COUNT(*) as count FROM alumnus_bio 
                                  JOIN courses ON alumnus_bio.course_id = courses.id 
                                  WHERE alumnus_bio.status = 1 GROUP BY courses.course")->fetch_all(MYSQLI_ASSOC);

// Error handling for the new query
$current_employment_status_result = $conn->query("SELECT currentlyEmployed as employment_status, COUNT(*) as count FROM alumnus_bio 
                                                  WHERE status = 1 GROUP BY currentlyEmployed");
if (!$current_employment_status_result) {
    die("Query failed: " . $conn->error);
}
$current_employment_status = $current_employment_status_result->fetch_all(MYSQLI_ASSOC);

// Function to map employment status
function map_employment_status($status) {
    return $status == 1 ? 'Employed' : 'Unemployed';
}

// Map the employment status
foreach ($current_employment_status as &$status) {
    $status['employment_status'] = map_employment_status($status['employment_status']);
}

// Function to safely encode JSON
function safe_json_encode($value){
    return json_encode($value, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Analytics Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        span.float-right.summary_icon {
            font-size: 3rem;
            position: absolute;
            right: 1rem;
            color: #ffffff96;
        }
        .imgs {
            margin: .5em;
            max-width: calc(100%);
            max-height: calc(100%);
        }
        .imgs img {
            max-width: calc(100%);
            max-height: calc(100%);
            cursor: pointer;
        }
        #imagesCarousel, #imagesCarousel .carousel-inner, #imagesCarousel .carousel-item {
            height: 60vh !important;
            background: black;
        }
        #imagesCarousel .carousel-item.active {
            display: flex !important;
        }
        #imagesCarousel .carousel-item-next {
            display: flex !important;
        }
        #imagesCarousel .carousel-item img {
            margin: auto;
        }
        #imagesCarousel img {
            width: auto !important;
            height: auto !important;
            max-height: calc(100%) !important;
            max-width: calc(100%) !important;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome back " . $_SESSION['login_name'] . "!"; ?>
                    <hr>
                    <div class="row">
                        <!-- Basic Metrics -->
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <span class="float-right summary_icon"><i class="fa fa-users"></i></span>
                                    <h4><b><?php echo $total_alumni; ?></b></h4>
                                    <p><b>Alumni</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <span class="float-right summary_icon"><i class="fa fa-comments"></i></span>
                                    <h4><b><?php echo $total_forum_topics; ?></b></h4>
                                    <p><b>Forum Topics</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <span class="float-right summary_icon"><i class="fa fa-briefcase"></i></span>
                                    <h4><b><?php echo $total_jobs; ?></b></h4>
                                    <p><b>Posted Jobs</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <span class="float-right summary_icon"><i class="fa fa-calendar-day"></i></span>
                                    <h4><b><?php echo $total_events; ?></b></h4>
                                    <p><b>Upcoming Events</b></p>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <!-- Advanced Metrics -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Alumni by Gender</h5>
                                    <div class="chart-container">
                                        <canvas id="alumniByGenderChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Alumni by Batch</h5>
                                    <div class="chart-container">
                                        <canvas id="alumniByBatchChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Alumni by Course</h5>
                                    <div class="chart-container">
                                        <canvas id="alumniByCourseChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Currently Employed</h5>
                                    <div class="chart-container">
                                        <canvas id="currentlyEmployedChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Upcoming Events</h5>
                                    <ul class="list-group">
                                        <?php foreach ($upcoming_events as $event): ?>
                                            <li class="list-group-item">
                                                <b><?php echo $event['title']; ?></b> on <?php echo date('M d, Y', strtotime($event['schedule'])); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>              
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Alumni by Gender Chart
    var ctxGender = document.getElementById('alumniByGenderChart').getContext('2d');
    var alumniByGenderData = <?php echo safe_json_encode($alumni_by_gender); ?>;
    var alumniByGenderChart = new Chart(ctxGender, {
        type: 'pie',
        data: {
            labels: alumniByGenderData.map(item => item.gender),
            datasets: [{
                data: alumniByGenderData.map(item => item.count),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            }
        }
    });

    // Alumni by Batch Chart
    var ctxBatch = document.getElementById('alumniByBatchChart').getContext('2d');
    var alumniByBatchData = <?php echo safe_json_encode($alumni_by_batch); ?>;
    var alumniByBatchChart = new Chart(ctxBatch, {
        type: 'bar',
        data: {
            labels: alumniByBatchData.map(item => item.batch),
            datasets: [{
                label: 'Number of Alumni',
                data: alumniByBatchData.map(item => item.count),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Alumni by Course Chart
    var ctxCourse = document.getElementById('alumniByCourseChart').getContext('2d');
    var alumniByCourseData = <?php echo safe_json_encode($alumni_by_course); ?>;
    var alumniByCourseChart = new Chart(ctxCourse, {
        type: 'bar',
        data: {
            labels: alumniByCourseData.map(item => item.course_name),
            datasets: [{
                label: 'Number of Alumni',
                data: alumniByCourseData.map(item => item.count),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Currently Employed Chart
    var ctxEmployed = document.getElementById('currentlyEmployedChart').getContext('2d');
    var currentEmploymentData = <?php echo safe_json_encode($current_employment_status); ?>;
    var currentlyEmployedChart = new Chart(ctxEmployed, {
        type: 'pie',
        data: {
            labels: currentEmploymentData.map(item => item.employment_status),
            datasets: [{
                data: currentEmploymentData.map(item => item.count),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            }
        }
    });
});
</script>
</body>
</html>