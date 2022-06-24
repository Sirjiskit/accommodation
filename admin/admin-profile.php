<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for update email id
error_reporting(0);
if (isset(($_POST['update']))) {
    $address = $_POST['address'];
    $username = $_POST['username'];
    $aid = $_SESSION['id'];
    $udate = date('Y-m-d');
    $query = "update admin set username=?,address=?,updation_date=? where id=?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssi', $username, $address, $udate, $aid);
    $stmt->execute();
    echo"<script>alert('Profile successfully updated');</script>";
}
// code for change password
if (isset($_POST['changepwd'])) {
    $op = $_POST['oldpassword'];
    $np = $_POST['newpassword'];
    $ai = $_SESSION['id'];
    $udate = date('Y-m-d');
    $sql = "SELECT password FROM admin where password=?";
    $chngpwd = $mysqli->prepare($sql);
    $chngpwd->bind_param('s', $op);
    $chngpwd->execute();
    $chngpwd->store_result();
    $row_cnt = $chngpwd->num_rows;
    ;
    if ($row_cnt > 0) {
        $con = "update admin set password=?,updation_date=?  where id=?";
        $chngpwd1 = $mysqli->prepare($con);
        $chngpwd1->bind_param('ssi', $np, $udate, $ai);
        $chngpwd1->execute();
        $_SESSION['msg'] = "Password Changed Successfully !!";
    } else {
        $_SESSION['mssg'] = "Old Password not match !!";
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
        <title>Admin Profile</title>
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
        <script type="text/javascript">
            function valid()
            {

                if (document.changepwd.newpassword.value != document.changepwd.cpassword.value)
                {
                    alert("Password and Re-Type Password Field do not match  !!");
                    document.changepwd.cpassword.focus();
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

                            <h2 class="page-title">LandLord Profile</h2>
                            <?php
                            $aid = $_SESSION['id'];
                            $ret = "select * from admin where id=?";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->bind_param('i', $aid);
                            $stmt->execute(); //ok
                            $res = $stmt->get_result();
//$cnt=1;
                            while ($row = $res->fetch_object()) {
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">LandLord profile details</div>
                                            <div class="panel-body">
                                                <form method="post" class="form-horizontal">

                                                    <div class="hr-dashed"></div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Email:</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" name="emailid" id="emailid" value="<?php echo $row->email; ?>" disabled>
                                                            <span class="help-block m-b-none">email can't be changed.</span> 
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Name: </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="username" value="<?php echo $row->username; ?>" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Address</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="address" id="villa" value="<?php echo $row->address; ?>" required="required">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Reg Date</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="<?php echo $row->reg_date; ?>" disabled >
                                                        </div>
                                                    </div>



                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <button class="btn btn-default" type="submit">Cancel</button>
                                                        <input class="btn btn-primary" type="submit" name="update" value="Update Profile">
                                                    </div>
                                            </div>

                                            </form>

                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Change Password</div>
                                        <div class="panel-body">
                                            <form method="post" class="form-horizontal" name="changepwd" id="change-pwd" onSubmit="return valid();">

                                                <?php if (isset($_POST['changepwd'])) {
                                                    ?>

                                                    <p style="color: green; font-weight:bold;"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></p>
                                                    <p style="color: red; font-weight:bold;"><?php echo htmlentities($_SESSION['mssg']); ?><?php echo htmlentities($_SESSION['mssg'] = ""); ?></p>
                                                <?php } ?>
                                                <div class="hr-dashed"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">old Password </label>
                                                    <div class="col-sm-8">
                                                        <input type="password" value="" name="oldpassword" id="oldpassword" class="form-control" onBlur="checkpass()" required="required">
                                                        <span id="password-availability-status" class="help-block m-b-none" style="font-size:12px;"></span> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">New Password</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control" name="newpassword" id="newpassword" value="" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Confirm Password</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control" value="" required="required" id="cpassword" name="cpassword" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-sm-offset-4">
                                                    <button class="btn btn-default" type="submit">Cancel</button>
                                                    <input type="submit" name="changepwd" Value="Change Password" class="btn btn-primary">
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
<script>
                                                            function checkAvailability() {
                                                                $("#loaderIcon").show();
                                                                jQuery.ajax({
                                                                    url: "check_availability.php",
                                                                    data: 'emailid=' + $("#emailid").val(),
                                                                    type: "POST",
                                                                    success: function (data) {
                                                                        $("#user-availability-status").html(data);
                                                                        $("#loaderIcon").hide();
                                                                    },
                                                                    error: function () {}
                                                                });
                                                            }
</script>
<script>
    function checkpass() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'oldpassword=' + $("#oldpassword").val(),
            type: "POST",
            success: function (data) {
                $("#password-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function () {}
        });
    }
</script>
</body>

</html>