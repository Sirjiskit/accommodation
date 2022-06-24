<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "delete from registration where id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data Deleted');</script>";
}
if (isset($_GET['paid'])) {
    $id = intval($_GET['paid']);
    $adn = "UPDATE registration SET status = 'Paid' where id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Student Status has been change to Paid');</script>";
}
if (isset($_GET['Notpaid'])) {
    $id = intval($_GET['Notpaid']);
    $adn = "UPDATE registration SET status = 'Not Paid' where id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Student Status has been change to Not Paid');</script>";
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
        <title>Manage Students</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/fileinput.min.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" href="css/style.css">
        <script language="javascript" type="text/javascript">
            var popUpWin = 0;
            function popUpWindow(URLStr, left, top, width, height)
            {
                if (popUpWin)
                {
                    if (!popUpWin.closed)
                        popUpWin.close();
                }
                popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 510 + ',height=' + 430 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
            }
            function getConfirmation() {
                var retVal = confirm("Are sure you want to change this student status to Paid ?");
                if (retVal == true) {
                    return true;
                } else {
                    return false;
                }
            }
            function gettConfirmation() {
                var retVal = confirm("Are sure you want to change this student status to Not Paid ?");
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
                            <h2 class="page-title" style="margin-top:4%">Manage Registred Students</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">List Of All Registred Students</div>
                                <div class="panel-body">
                                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Student Name</th>
                                                <th>Admission no</th>
                                                <th>Contact no </th>
                                                <th>Room no  </th>
                                                <th>Staying From </th>
                                                <th>Status </th>
                                                <th>Action</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $aid = $_SESSION['id'];
                                            $ret = "select r.* from registration r JOIN houses h ON r.villa_id=h.houseid where h.aid =?";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->bind_param('i', $aid);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            $cnt = 1;
                                            while ($row = $res->fetch_object()) {
                                                ?>
                                                <tr><td><?php echo $cnt;
                                            ;
                                                ?></td>
                                                    <td><img src="../user_images/<?php echo $row->img; ?>" width="35" height="35"> <?php echo $row->firstname; ?> <?php echo $row->middlename; ?> <?php echo $row->lastname; ?></td>
                                                    <td><a href="javascript:void(0);"  onClick="popUpWindow('http://localhost/accommodation/admin/full-profile.php?id=<?php echo $row->id; ?>');" title="View Full Details"><?php echo $row->admission_no; ?></A></td>
                                                    <td><?php echo $row->contactno; ?></td>
                                                    <td><?php echo $row->roomno; ?></td>
                                                    <td><?php echo $row->stayfrom; ?></td>
                                                    <td><?php echo $row->status; ?></td>

                                                    <td>
                                                        <?php
                                                        if ($row->status != 'Paid') {
                                                            echo"<a href='manage-students.php?paid=" . $row->id . "' onclick='return getConfirmation()' title='Change Status to Paid' style='color:green'>Change <i class='fa fa-check'></i></a>";
                                                        } else {
                                                            echo"<a href='manage-students.php?Notpaid=" . $row->id . "' onclick='return gettConfirmation()' title='Change Status to Not Paid' style='color:green'>Change <i class='fa fa-check'></i></a> ";
                                                        }
                                                        ?>&nbsp;&nbsp;
                                                    </td>
                                                    <td>
                                                        <a href="manage-students.php?del=<?php echo $row->id; ?>" title="Delete Record" onclick="return confirm('Are sure you want to Delete this student ?');" style="color:red">Delete <i class="fa fa-close"></i></a></td>
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
