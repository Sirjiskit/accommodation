<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    extract($_POST);
    $filename = $_FILES['img']['name'];
    $adn = "INSERT INTO `userregistration` (`admission_no`, `department`, `level`, `firstName`, `middleName`, `lastName`, `gender`, `img`, `contactNo`, `password`) VALUES ('{$admission_no}', '{$department}', '{$level}', '{$firstname}', '{$middleName}', '{$lastName}', '{$gender}', '{$filename}', '{$contactNo}', '{$password}')";
    $query = mysqli_query($mysqli, $adn);
    if ($query) {
        move_uploaded_file($_FILES['img']['tmp_name'], '../user_images/' . $filename);
        echo "<script>alert('Student Registered Successfull!'); window.location = 'manage-students.php';</script>";
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
        <title>Landlord Details</title>
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
                        <h2 class="page-title" style="margin-top:5%; padding: 15px 15px;">Landlord Details</h2>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Landlord Overview</div>
                                <div class="panel-body">
                                    <?php
                                    $id = $_GET['id'];
                                    $ret = "SELECT * FROM `admin` WHERE id=?";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $id);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    //$cnt=1;
                                    while ($row = $res->fetch_object()) {
                                        ?>
                                        <div class="col-sm-2">
                                            <img src="../landload_images/<?php echo $row->image; ?>" height="200px" width="200px">
                                        </div>
                                        <div class="col-sm-5">
                                            <table class="table table-bordered" style="margin-top: 50px; margin-left: 50px">
                                                <tr>
                                                    <th class="text-right" style="width: 20%">Name:</th>
                                                    <td><?php echo $row->username ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right" style="width: 20%">Contact:</th>
                                                    <td><?php echo $row->contactNo ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right" style="width: 20%">Email:</th>
                                                    <td><?php echo $row->email ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right" style="width: 20%">Houses:</th>
                                                    <td>
                                                        <?php
                                                        $result = "SELECT count(*) FROM houses WHERE aid=?";
                                                        $stmt1 = $mysqli->prepare($result);
                                                        $stmt1->bind_param('i', $id);
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
                                            <h3>Houses</h3>
                                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>House Info</th>
                                                        <th>Address </th>
                                                        <th>No. of Rooms </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $aid = $_SESSION['id'];
                                                    $ret = "SELECT * FROM houses WHERE aid=? ORDER BY villa_name ASC";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->bind_param('i', $id);
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
                                                        $stmt1->bind_param('ii', $id, $hId);
                                                        $stmt1->execute();
                                                        $stmt1->bind_result($count);
                                                        $stmt1->fetch();
                                                        $stmt1->close();
                                                        echo $count;
                                                        ?>
                                                    </td>
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

        <script type="text/javascript">
            function deleteRecord(id) {
                if (confirm("Delete this record")) {
                    window.location = 'manage-students.php?id=' + id;
                }
            }
        </script>

    </body>

</html>