<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "delete from houses where houseid=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data Deleted');</script>";
}
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
        <title>Manage Houses</title>
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
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php include('includes/sidebar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="page-title" style="margin-top: 4%">
                                Manage Houses 
                            </h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">All Houses Details
                                    <a role="button" href="./create-house.php" class="btn btn-primary btn-sm pull-right" style="margin-top: -5px"><i class="fa fa-plus"></i> Add new</a>
                                </div>
                                <div class="panel-body">
                                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>House Info</th>
                                                <th>Address </th>
                                                <th>No. of Rooms </th>
                                                <th style="width: 11%">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $aid = $_SESSION['id'];
                                            $ret = "SELECT * FROM houses WHERE aid=? ORDER BY villa_name ASC";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->bind_param('i', $aid);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            $cnt = 1;
                                            while ($row = $res->fetch_object()) {
                                                ?>
                                            <td><img src="../villa_images/<?php echo $row->image; ?>" height="45px" width="45px"></td>
                                            <td><?php echo $row->villa_name; ?></td>
                                            <td><?php echo $row->villa_for; ?></td>
                                            <td><?php echo $row->villa_address; ?></td>
                                            <td>
                                                <?php
                                                $hId = $row->houseid;
                                                $result = "SELECT count(*) FROM rooms WHERE aid=? AND houseid=?";
                                                $stmt1 = $mysqli->prepare($result);
                                                $stmt1->bind_param('ii', $aid, $hId);
                                                $stmt1->execute();
                                                $stmt1->bind_result($count);
                                                $stmt1->fetch();
                                                $stmt1->close();
                                                echo $count;
                                                ?>
                                            </td>
                                            <td>
                                                <a href="edit-house.php?id=<?php echo $row->houseid; ?>" role="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                <a href="house_details.php?id=<?php echo $row->houseid; ?>" role="button" class="btn btn-info btn-sm"><i class="fa fa-list"></i></a>
                                                <a href="manage-houses.php?del=<?php echo $row->houseid; ?>" role="button" class="btn btn-danger btn-sm" onclick="return confirm('Deleting this house may affect all rooms associated with it; Are sure?');"><i class="fa fa-trash"></i></a>
                                            </td>
                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
                                        }
                                        ?>


                                        </tbody>
                                    </table>


                                </div>
                            </div>


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
    </body>

</html>
