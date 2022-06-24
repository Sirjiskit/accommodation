<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $aid = '0';
    $adn = "UPDATE  roommate_char SET roommate_id=? where id='$id'";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $aid);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Room-mate Request Deleted Successfully');</script>";
}
if (isset($_GET['accept'])) {

    $id = intval($_GET['accept']);
    $sql = mysqli_query($mysqli, "select * from roommate_char where roommate_id='$id' and roommate='$id'");
    if (mysqli_num_rows($sql)) {
        echo "<script>alert('Oops you can only accept 1 room-mate request');</script>";
    } else {
        $gid = intval($_GET['id']);
        $l = mysqli_query($mysqli, "select * from roommate_char where roommate='$gid'");
        if (mysqli_num_rows($l)) {
            echo "<script>alert('You can not accept this room-mate request because he/she has gotten a room-mate');</script>";
        } else {
            $id = intval($_GET['accept']);
            $lid = intval($_GET['id']);
            $re = mysqli_query($mysqli, "UPDATE roommate_char SET roommate_id = '" . $lid . "',roommate = '" . $lid . "' WHERE student_id='" . $id . "'");
            $adn = "UPDATE roommate_char SET roommate=? where student_id='$lid'";
            $stmt = $mysqli->prepare($adn);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('Room-mate Request Accepted Successfully');</script>";
        }
    }
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
        <title>Roommate Request</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/fileinput.min.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript">
            function getConfirmation() {
                var retVal = confirm('Are you sure you want to accept this room-mate request ?');
                if (retVal == true) {
                    return true;
                } else
                {
                    return false;
                }
            }

            function gettConfirmation() {
                var retVal = confirm("Are you sure you want to Delete this room-mate request ?");
                if (retVal == true) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php include('includes/sidebar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="page-title" style="margin-top: 5%">Roommate Request</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">Note: you can only accept 1 room-mate</div>
                                <div class="panel-body">
                                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Full Name</th>
                                                <th>Department</th>
                                                <th>Level</th>
                                                <th>Mobile No</th>
                                                <th>Sent Since</th>
                                                <th>Actions</th>


                                            </tr>
                                        </thead>

                                        <?php
                                        $aid = $_SESSION['id'];
                                        $ret = "select * from roommate_char where roommate_id= {$aid}";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        $cnt = 1;
                                        while ($row = $res->fetch_object()) {
                                            ?>

                                            <tr><td><?php
                                                    echo $cnt;
                                                    ;
                                                    ?></td>
                                                <td><img src="user_images/<?php echo $row->img; ?>" style="width:40px; height:40px;" class="ts-avatar hidden-side" alt=""> <?php echo $row->firstName; ?> <?php echo $row->middleName; ?> <?php echo $row->lastName; ?></td>
                                                <td><?php echo $row->department; ?></td>
                                                <td><?php echo $row->level; ?></td>
                                                <td><?php echo $row->contactNo; ?></td>
                                                <td style="font-size:11px;"><?php echo date('F jS, Y', strtotime($row->time)) ?> at <?php echo date('h:i:A', strtotime($row->time)); ?></td>
                                                <td><?php
                                                    if ($row->roommate == '0') {
                                                        echo"
<a href='roommate_request.php?accept=" . $row->roommate_id . "&&id=" . $row->student_id . "' title='Accept Request' onclick='return getConfirmation()'><span style='color:green;'>Accept <i class='fa fa-cloud-download'></i></span></a>&nbsp;&nbsp;
<a href='roommate_request.php?delete=" . $row->id . "' title='Delete Request' onclick='return gettConfirmation()'><span style='color:red;'>Delete <i class='fa fa-trash'></i></span></a>";
                                                    } else
                                                        echo "<span style='font-size:12px; color:green'>you have accepted this request</span>";
                                                    ?>
                                                </td>

                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
                                        }
                                        ?>


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
