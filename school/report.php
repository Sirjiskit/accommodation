<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
error_reporting(E_ALL);
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
        <title>Manage Landlord</title>
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
                        <h2 class="page-title" style="margin-top:5%; padding: 15px 15px;">Report</h2>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <form action="" method="post">
                                        <div class="input-group">
                                            <div class="input-group-addon">Filter</div>
                                            <div class="form-group col-2 col-sm-2 col-md-2">
                                                <input class="form-control" name="from" required="" type="date">
                                            </div>
                                            <div class="form-group col-3 col-sm-2 col-md-2">
                                                <input class="form-control" name="to" required="" type="date">
                                            </div>
                                            <div class="form-group col-3 col-sm-3 col-md-3">
                                                <select class="form-control" name="type">
                                                    <option value="1" selected="">Students</option>
                                                    <option value="2" >Landlord</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-3 col-sm-3 col-md-3">
                                                <select class="form-control" name="gender">
                                                    <option value="" selected="">All</option>
                                                    <option value="male" >Male</option>
                                                    <option value="female" >Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-2 col-sm-2 col-md-2">
                                                <button class="btn btn-primary" name="submit">Filter</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="panel-body table-responsive">
                                    <?php
                                    if (isset($_POST['submit'])) {
                                        extract($_POST);
                                        if ((int) $type == 1):
                                            ?>
                                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Sno.</th>
                                                        <th>Image</th>								
                                                        <th>Admission no</th>
                                                        <th>Department</th>
                                                        <th>Level</th>
                                                        <th>Student Name</th>
                                                        <th>Gender</th>
                                                        <th>Contact N0</th>
                                                        <th>Password</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $ret = "SELECT * FROM `userregistration` WHERE gender LIKE '%" . $gender . "%' and ((regDate between '{$from}' and '{$to}') or (regDate >= '{$from}' and regDate<='{$to}' )) order by lastName asc";
                                                    $query2 = mysqli_query($mysqli, $ret);
                                                    $cnt = 0;
                                                    while ($row = mysqli_fetch_array($query2)) {
                                                        $cnt += 1;
                                                        ?>
                                                        <tr>
                                                            <td><?php
                                                                echo $cnt;
                                                                ?></td>
                                                            <td><img src="../user_images/<?php echo $row['img']; ?>" width="35" height="35"></td>
                                                            <td><?php echo $row['admission_no']; ?></td>
                                                            <td><?php echo $row['firstName'] . " " . $row['middleName'] . " " . $row['lastName']; ?></td>
                                                            <td><?php echo $row['department']; ?></td>
                                                            <td><?php echo $row['level']; ?></td>
                                                            <td><?php echo $row['gender']; ?></td>
                                                            <td><?php echo $row['contactNo']; ?></td>
                                                            <td><?php echo base64_decode($row['password']); ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>


                                                </tbody>
                                            </table>
                                            <?php
                                        else:
                                            ?>
                                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Sno.</th>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>contact</th>

                <!--                                                <th>Address</th>-->
                                                        <th>Total Houses</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $ret = "SELECT * FROM `admin` WHERE gender LIKE '%" . $gender . "%' and ((reg_date between '{$from}' and '{$to}') or (reg_date >= '{$from}' and reg_date<='{$to}' )) order by username asc";
                                                    $query2 = mysqli_query($mysqli, $ret);
                                                    $cnt = 0;
                                                    while ($row = mysqli_fetch_array($query2)) {
                                                        $aid = $row['id'];
                                                        $result1 = "SELECT count(*) FROM houses WHERE aid='$aid'";
                                                        $stmt1 = $mysqli->prepare($result1);
                                                        $stmt1->execute();
                                                        $stmt1->bind_result($count1);
                                                        $stmt1->fetch();
                                                        $stmt1->close();
                                                        $cnt += 1;
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $cnt; ?>
                                                            </td>
                                                            <td><img src="<?php echo $row['image'] ? '../landload_images/' . $row['image'] : '../admin/img/ts-avatar.jpg'; ?>" width="35" height="35"></td>
                                                            <td><?php echo $row['username']; ?></td>
                                                            <td><?php echo $row['email']; ?></td>
                                                            <td><?php echo $row['contactNo']; ?></td>

                                            <!--                                                    <td><?php //echo $row['address'];        ?></td>-->
                                                            <td><?php echo $count1; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>


                                                </tbody>
                                            </table>

                                        <?php
                                        endif;
                                    }
                                    ?>

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