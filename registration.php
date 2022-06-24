<?php
session_start();
include('includes/config.php');
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
        <title>Landlord Registration</title>
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
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script type="text/javascript">
            function valid()
            {
                if (document.registration.password.value != document.registration.cpassword.value)
                {
                    alert("Password and Re-Type Password Field do not match  !!");
                    document.registration.cpassword.focus();
                    return false;
                }
                return true;
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

                            <h2 class="page-title">Landlord Registration </h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Note: Do not fill this form if you do not own a villa</div>
                                        <div class="panel-body">
                                            <form action="landlord_reg.php" method="post" class="form-horizontal" name="registration" enctype="multipart/form-data" onSubmit="return valid();">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Full Name : </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="username" id="username"  class="form-control" required="required" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Contact No : </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="contactNo" id="contactNo" maxlength="11" class="form-control" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Email: </label>
                                                    <div class="col-sm-6">
                                                        <input type="email" name="email" id="email"  class="form-control" onBlur="checkAvailability()" required="required">
                                                        <span id="user-availability-status" style="font-size:12px;"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Gender</label>
                                                    <div class="col-sm-6">
                                                        <select name="gender" id="villa_for" class="form-control" required>
                                                            <option value="">Select</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Address: </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="address" id="villa_address"  class="form-control" required="required" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Password: </label>
                                                    <div class="col-sm-6">
                                                        <input type="password" name="password" id="password"  class="form-control" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Confirm Password : </label>
                                                    <div class="col-sm-6">
                                                        <input type="password" name="cpassword" id="cpassword"  class="form-control" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Profile Pic: </label>
                                                    <div class="col-sm-6">
                                                        <input type="file" name="img" id="img"  class="form-control" required="required" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-sm-offset-4">
                                                    <button class="btn btn-default">Cancel</button>
                                                    <input type="submit" name="submit" Value="Register" class="btn btn-primary">
                                                </div>
                                            </form>

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
    <script>
                                                            function checkAvailability() {

                                                                $("#loaderIcon").show();
                                                                jQuery.ajax({
                                                                    url: "check_availability.php",
                                                                    data: 'emailid=' + $("#email").val(),
                                                                    type: "POST",
                                                                    success: function (data) {
                                                                        $("#user-availability-status").html(data);
                                                                        $("#loaderIcon").hide();
                                                                    },
                                                                    error: function ()
                                                                    {
                                                                        event.preventDefault();
                                                                        alert('error');
                                                                    }
                                                                });
                                                            }

                                                            function checkAvailabilityV() {

                                                                $("#loaderIcon").show();
                                                                jQuery.ajax({
                                                                    url: "check_availability.php",
                                                                    data: 'villaname=' + $("#villa_name").val(),
                                                                    type: "POST",
                                                                    success: function (data) {
                                                                        $("#villa-availability-status").html(data);
                                                                        $("#loaderIcon").hide();
                                                                    },
                                                                    error: function ()
                                                                    {
                                                                        event.preventDefault();
                                                                        alert('error');
                                                                    }
                                                                });
                                                            }
    </script>

</html>