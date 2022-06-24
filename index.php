<?php
//die(base64_decode("YWRtaW4x"));
session_start();
include('includes/config.php');
if (isset($_POST['login'])) {
    $admission = $_POST['admission'];
    $password = $_POST['password'];
    $stmt = $mysqli->prepare("SELECT admission_no,password,id FROM userregistration WHERE admission_no=? and password=? ");
    $stmt->bind_param('ss', $admission, $password);
    $stmt->execute();
    $stmt->bind_result($admission, $password, $id);
    $rs = $stmt->fetch();
    $stmt->close();
    $_SESSION['id'] = $id;
    $_SESSION['login'] = $admission;
    $_SESSION['type'] = "student";
    $uip = $_SERVER['REMOTE_ADDR'];
    $ldate = date('d/m/Y h:i:s', time());
    if ($rs) {
        $uid = $_SESSION['id'];
        $uemail = $_SESSION['login'];

        header("location:dashboard.php");
    } else {
        $username = $_POST['admission'];
        $password = $_POST['password'];
        $stmt = $mysqli->prepare("SELECT email,password,id FROM admin WHERE email=? and password=? ");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $stmt->bind_result($username, $password, $id);
        $rs = $stmt->fetch();
        $_SESSION['id'] = $id;
        $_SESSION['type'] = "admin";
        $uip = $_SERVER['REMOTE_ADDR'];
        $ldate = date('d/m/Y h:i:s', time());
        if ($rs) {

            header("location:admin/dashboard.php");
        } else {

            $username = $_POST['admission'];
            $password = $_POST['password'];
            $stmt = $mysqli->prepare("SELECT id,username,password FROM schoollog WHERE username=? and password=? ");
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            $stmt->bind_result($id, $username, $password);
            $rs = $stmt->fetch();
            $_SESSION['id'] = $id;
            $_SESSION['type'] = "school";
            $uip = $_SERVER['REMOTE_ADDR'];
            $ldate = date('d/m/Y h:i:s', time());
            if ($rs) {

                header("location:school/dashboard.php");
            } else {
                echo "<script>alert('Invalid Admission Number or password');</script>";
            }
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

            <div class="login-page bk-img" style="background-image: url(img/hostel.jpg);">
                <div class="form-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <h3 class="text-center text-bold text-black mt-4x" style="color:#89CFF0;">Accomodation Management System</h3>


                                <form action="" class="mt" method="post">
                                    <div class="form-area">
                                        <div style="line-height: 1; padding-top:10px; color:#1e8b09; text-shadow:1px 1px 1px black; " class="text-center">

                                            <h4 style="color:black">
                                                Log-in
                                            </h4>

                                        </div>
                                        <div class="inp" style="text-align:left">
                                            <label for="" class="">Admission No.</label>
                                            <input type="text" placeholder="Enter you admission no..." name="admission" class="form-control mb" required>
                                            <label for="" class="">Password</label>
                                            <input type="password" placeholder="Enter your password..." name="password" class="form-control mb" required>


                                            <input type="submit" name="login" class="btn btn-primary btn-block" value="login" >
                                        </div>
                                    </div>
                                </form>

                                <div class="text-center text-light" style="color:red;">
                                    <a href="forgot-password.php" style="color:red;">Forgot password?</a>
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