<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
$aid = $_SESSION['id'];
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
        <title>House Details</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/fileinput.min.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
        <script type="text/javascript" src="js/validation.min.js"></script>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="ts-main-content">
            <?php include('includes/sidebar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <h2 class="page-title">House Details</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">House Details
                                            <a role="button" href="./create-room.php" class="btn btn-primary btn-sm pull-right" style="margin-top: -5px"><i class="fa fa-plus"></i> Add new room</a>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            $id = $_GET['id'];
                                            $ret = "SELECT * FROM `houses` WHERE houseid=?";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->bind_param('i', $id);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            //$cnt=1;
                                            while ($row = $res->fetch_object()) {
                                                ?>
                                                <div class="col-sm-2">
                                                    <img src="../villa_images/<?php echo $row->image; ?>" height="200px" width="100%">
                                                </div>
                                                <div class="col-sm-5">
                                                    <table class="table table-bordered" style="margin-top: 50px">
                                                        <tr>
                                                            <th class="text-right" style="width: 20%">Villa:</th>
                                                            <td><?php echo $row->villa_name ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right" style="width: 20%">Used for:</th>
                                                            <td><?php echo $row->villa_for ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right" style="width: 20%">Address:</th>
                                                            <td><?php echo $row->villa_address ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right" style="width: 20%">Rooms:</th>
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
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-sm-12">
                                                    <h3>Rooms</h3>
                                                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5%">Image</th>
                                                                <th style="width: 9%">Room No.</th>
                                                                <th>Room Info</th>
                                                                <th style="width: 5%">Fees </th>
                                                                <th>House</th>
                                                                <th>Posting Date  </th>
                                                                <th style="width: 8%">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $ret = "SELECT r.*, h.villa_name FROM rooms r JOIN houses h ON r.houseid = h.houseid WHERE r.aid=? and r.houseid=? ORDER BY h.villa_name, room_no ASC";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->bind_param('ii', $aid, $id);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            $cnt = 1;
                                                            while ($row = $res->fetch_object()) {
                                                                ?>
                                                            <tr>
                                                            <td><img src="../rooms_image/<?php echo $row->room_img; ?>" height="45px" width="45px"></td>
                                                            <td><?php echo $row->room_no; ?></td>
                                                            <td><?php echo $row->room_details; ?></td>
                                                            <td><?php echo $row->fees; ?></td>
                                                            <td><?php echo $row->villa_name; ?></td>
                                                            <td><?php echo date('F jS, Y', strtotime($row->posting_date)) ?> at <?php echo date('h:i:A', strtotime($row->posting_date)); ?></td>
                                                            <td style="white-space: nowrap"><a href="edit-room.php?id=<?php echo $row->id; ?>" role="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                                <a href="manage-rooms.php?del=<?php echo $row->id; ?>" role="button" class="btn btn-danger btn-sm" onclick="return confirm('Are sure you want to Delete this room no ?');"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                            <?php
                                                            $cnt = $cnt + 1;
                                                        }
                                                        ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 	


            </div>
        </div>
    </div>
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