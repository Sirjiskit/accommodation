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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $adn = "delete from `userregistration` where `id`='{$id}'";
    $query = mysqli_query($mysqli, $adn);
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
                        <h2 class="page-title" style="margin-top:5%; padding: 15px 15px;">Manage Registred Students</h2>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">List Of All Registred Students</div>
                                <div class="panel-body table-responsive">
                                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>contact</th>
                                                <th>Address</th>
                                                <th>Houses</th>
                                                <th>Total Rooms</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $ret = "SELECT *, (select count(*) from houses h where h.aid=a.id) hourses FROM `admin` a";
                                            $query2 = mysqli_query($mysqli, $ret);
                                            $cnt = 0;
                                            while ($row = mysqli_fetch_array($query2)) {
                                                $aid = $row['id'];
                                                $result1 = "SELECT count(*) FROM rooms WHERE aid='$aid'";
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
                                                    <td><img src="../landload_images/<?php echo $row["image"];?>" width="35" height="35"></td>
                                                    <td>
                                                        <a href="landlord_detail.php?id=<?php echo $aid ?>"><?php echo $row['username']; ?></a>
                                                    </td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['contactNo']; ?></td>
                                                    <td><?php echo $row['address']; ?></td>
                                                    <td><?php echo $row['hourses']; ?></td>
                                                    <td><?php echo $count1; ?></td>
                                                </tr>
                                                <?php
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

        <script type="text/javascript">
            function deleteRecord(id) {
                if (confirm("Delete this record")) {
                    window.location = 'manage-students.php?id=' + id;
                }
            }
        </script>

    </body>

</html>