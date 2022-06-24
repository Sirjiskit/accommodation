<?php
session_start();
include('includes/configtwo.php');
if (isset($_POST['submit'])) {
    extract($_POST);
    $filename = $_FILES['img']['name'];
    $adn = "INSERT INTO `userregistration` (`admission_no`, `program`, `department`, `level`, `firstName`, `middleName`, `lastName`, `gender`, `img`, `contactNo`, `password`) VALUES ('{$admission_no}', '{$program}', '{$department}', '{$level}', '{$firstname}', '{$middleName}', '{$lastName}', '{$gender}', '{$filename}', '{$contactNo}', '{$password}')";

    $query = mysqli_query($mysqli, $adn);
    if ($query) {
        move_uploaded_file($_FILES['img']['tmp_name'], 'user_images/' . $filename);
        echo "<script>alert('Student Registered Successfull!'); window.location = 'index.php';</script>";
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
        <title>Student Accomodation Registration</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/fileinput.min.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
        <script type="text/javascript" src="js/validation.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>

    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="ts-main-content">
            <?php include('includes/sidebar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <h2 class="page-title" style="margin-top:5%; padding: 15px 15px; text-align:center; color: red; "> Registration Page for Students</h2>
                        <div class="col-md-4 col-md-offset-4 col-lg-4 col-sm-4 col-xs-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">Students Register</div>
                                <div class="panel-body">
                                    <form class="form-group" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="admission_no" placeholder="Admission No" required>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="program" required>
                                                <option value="" selected>--Select Program--</option>
                                                <option value="Bsc">Bsc</option>
                                                <option value="Msc">Msc</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="department" required>
                                                <option value="" selected>--Select Department--</option>
                                                <option value="Computer Science">Computer Science</option>
                                                <option value="Cyber Security">Cyber Security</option>
                                                <option value="Info Tech">Info Tech</option>
                                                <option value="Civil Eng">Civil Eng</option>
                                                <option value="Software Eng">Software Eng</option>
                                                <option value="Economics"> Economics </option>
                                                <option value="Arabic Dept">Arabic Dept</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="level" placeholder="level" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="firstname" placeholder="firstname" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="middleName" placeholder="middlename" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="lastName" placeholder="lastname" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" name="gender" value="male" >Male
                                            <input type="radio" name="gender" value="female" >Female

                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="img" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <input type="tel" maxlength="11" class="form-control" name="contactNo" placeholder="Contact No" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" id="password" class="form-control" name="password" placeholder="password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id="cpassword" onblur="validate()" class="form-control" name="cpassword" placeholder="Confirm password" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit"  name="submit" value="Add Student" class="btn btn-primary" >
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <style>
            .title{color:#f4e9e9;
                   text-shadow:3px 2px 3px black;
                   text-align:center;
            }
        </style>
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
