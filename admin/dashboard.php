<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
?>
<!doctype html>
<html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>DashBoard</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/fileinput.min.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" href="css/style.css">


    </head>

    <body>
        <?php include("includes/header.php"); ?>

        <div class="ts-main-content">
            <?php include("includes/sidebar.php"); ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <h2 class="page-title" style="margin-top:4%">Dashboard</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">

                                                        <?php
                                                        $aid = $_SESSION['id'];
                                                        $result = "SELECT count(r.id) FROM registration r JOIN houses h ON r.villa_id=h.houseid where h.aid =$aid";
                                                        $stmt = $mysqli->prepare($result);
                                                        $stmt->execute();
                                                        $stmt->bind_result($count);
                                                        $stmt->fetch();
                                                        $stmt->close();
                                                        ?>

                                                        <div class="stat-panel-number h1 "><?php echo $count; ?></div>
                                                        <div class="stat-panel-title text-uppercase">Apply Students</div>
                                                    </div>
                                                </div>
                                                <a href="manage-students.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-success text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        $aid = $_SESSION['id'];
                                                        $result1 = "SELECT count(*) FROM houses where aid =$aid";
                                                        $stmt1 = $mysqli->prepare($result1);
                                                        $stmt1->execute();
                                                        $stmt1->bind_result($count1);
                                                        $stmt1->fetch();
                                                        $stmt1->close();
                                                        ?>												
                                                        <div class="stat-panel-number h1 "><?php echo $count1; ?></div>
                                                        <div class="stat-panel-title text-uppercase">Available Houses </div>
                                                    </div>
                                                </div>
                                                <a href="manage-houses.php" class="block-anchor panel-footer text-center">See All &nbsp; <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-info text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        $aid = $_SESSION['id'];
                                                        $ret = "select * from admin where id=?";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->bind_param('i', $aid);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        //$cnt=1;
                                                        while ($row = $res->fetch_object()) {
                                                            ?>										
                                                            <div class="stat-panel-number h1">Edit</div>
                                                            <div class="stat-panel-title text-uppercase">Landlord Profile</div>
                                                        </div>
                                                    </div>
                                                    <a href="admin-profile.php" class="block-anchor panel-footer text-center">See Profile &nbsp; <i class="fa fa-arrow-right"></i></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                            <?php } ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/chartData.js"></script>
        <script src="js/main.js"></script>

        <script>

            window.onload = function () {

                // Line chart from swirlData for dashReport
                var ctx = document.getElementById("dashReport").getContext("2d");
                window.myLine = new Chart(ctx).Line(swirlData, {
                    responsive: true,
                    scaleShowVerticalLines: false,
                    scaleBeginAtZero: true,
                    multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
                });

                // Pie Chart from doughutData
                var doctx = document.getElementById("chart-area3").getContext("2d");
                window.myDoughnut = new Chart(doctx).Pie(doughnutData, {responsive: true});

                // Dougnut Chart from doughnutData
                var doctx = document.getElementById("chart-area4").getContext("2d");
                window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive: true});

            }
        </script>

    </body>

</html>