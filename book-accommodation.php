<?php
session_start();
include('includes/config.php');
include('includes/pdoconfig.php');
include('includes/checklogin.php');
check_login();
//code for registration
if (isset($_POST['submit'])) {
    $student_id = $_SESSION['id'];

    $villa_id = $_POST['villa'];
    $query = "SELECT * FROM houses where houseid = '" . $villa_id . "' ";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();
    $res = $stmt2->get_result();
    while ($row = $res->fetch_object()) {
        $villa = $row->villa_name;
    }

    $villa_address = $_POST['villa_address'];
    $stayfrom = $_POST['stayfrom'];

    $roomno = "0";
    $need_roomate = "";
    $room_details = "";
    $amount = "";
    $status = "Not Paid";

    $admission_no = $_POST['admission_no'];
    $department = $_POST['dpt'];
    $level = $_POST['level'];
    $firstname = $_POST['fname'];
    $middlename = $_POST['mname'];
    $lastname = $_POST['lname'];
    $gender = $_POST['gender'];
    $img = $_POST['img'];
    $contactno = $_POST['contactno'];
    $gname = $_POST['gname'];
    $program = $_POST['program'];

    $uid = $_SESSION['id'];
    $stmt = $mysqli->prepare("SELECT student_id FROM registration WHERE student_id=? ");
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $stmt->bind_result($uid);
    $resulr = $stmt->get_result();
    $rows = array();
    while ($row = $resulr->fetch_assoc()) {
        $rows[] = $row;
    }
    $rs = $stmt->fetch();
    $stmt->close();
    if (count($rows) < 1 || (count($rows) > 0 && count($rows) < 3)) {
        $query = "insert into  registration(student_id,villa_id,admission_no,program,department,level,firstname,middlename,lastname,gender,img,contactno,gname,villa,villa_address,roomno,stayfrom,need_roomate,room_details,amount,status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('iisssssssssssssisssss', $student_id, $villa_id, $admission_no, $program, $department, $level, $firstname, $middlename, $lastname, $gender, $img, $contactno, $gname, $villa, $villa_address, $roomno, $stayfrom, $need_roomate, $room_details, $amount, $status);
        $stmt->execute();
        $lastId = $mysqli->insert_id;
        echo '<script type="text/javascript">
		alert("Book a room and complete your registration");
		window.location="register_accommodation.php?sid=' . $lastId . '";
		</script>';
        exit();
    } else {
        echo"<script>alert('Oops you have already booked 3 available accommodation slot');</script>";
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
        <title>Student Accommodation Registration</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/fileinput.min.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
        <script type="text/javascript" src="js/validation.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script>
            function getVillaid(val) {
                $.ajax({
                    type: "POST",
                    url: "get_seater.php",
                    data: 'roomid=' + val,
                    success: function (data) {
                        $('#seater').val(data);
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "get_seater.php",
                    data: 'hid=' + val,
                    success: function (data) {
                        var json = JSON.parse(data);
                        $('#hInfo').fadeIn();
                        $('#house_img').attr('src', 'villa_images/' + json.image);
                        $('#villa_address').val(json.villa_address);
                        $('#villa_address2').html(json.villa_address);
                        $('#nRoom').html(json.totalRoom);
                        $('#roomList').html(json.roomList);
                        $('#villa_name2').html(json.villa_name);
                    }
                });
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

                            <h2 class="page-title">Accommodation Registration </h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Fill all Info</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <form method="post" action="" class="form-horizontal">
                                                        <?php
                                                        $uid = $_SESSION['id'];

                                                        $stmt = $mysqli->prepare("SELECT student_id FROM registration WHERE student_id=? ");
                                                        $stmt->bind_param('i', $uid);
                                                        $stmt->execute();
                                                        $stmt->bind_result($uid);
                                                        $resulr = $stmt->get_result();
                                                        $rows = array();
                                                        while ($row = $resulr->fetch_assoc()) {
                                                            $rows[] = $row;
                                                        }
                                                        $rs = $stmt->fetch();
                                                        $stmt->close();
                                                        if (count($rows) > 0 && count($rows) < 3) {
                                                            ?>
                                                            <h3 style="color: red" align="left">You already booked  <?php echo count($rows) . " Apartment Now you can still apply " . (3 - count($rows)) . " more Apartment To Reach Maximum"; ?></h3>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <h3 style="color: red" align="left">You cannot Apply More than 3 Apartment</h3>
                                                            <?php
                                                        }
                                                        ?>			
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label"><h4 style="color: green" align="left">Lodge Related info </h4> </label>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Villa Name </label>
                                                            <div class="col-sm-8">
                                                                <select name="villa" id="villa" class="form-control"  onChange="getVillaid(this.value);" onBlur="checkAvailability()" required> 
                                                                    <option value="">Select Villa</option>
                                                                    <?php
                                                                    $query = "SELECT * FROM houses ORDER BY villa_name ASC";
                                                                    $stmt2 = $mysqli->prepare($query);
                                                                    $stmt2->execute();
                                                                    $res = $stmt2->get_result();
                                                                    while ($row = $res->fetch_object()) {
                                                                        ?>
                                                                        <option value="<?php echo $row->houseid; ?>"> <?php echo $row->villa_name; ?></option>
                                                                    <?php } ?>
                                                                </select> 
                                                                <span id="villa-availability-status" style="font-size:12px;"></span>

                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Villa Address</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="villa_address" id="villa_address" class="form-control" readonly>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Stay From</label>
                                                            <div class="col-sm-8">
                                                                <input type="date" name="stayfrom" id="stayfrom"  class="form-control" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label"><h4 style="color: green" align="left">Personal info </h4> </label>
                                                        </div>

                                                        <?php
                                                        $aid = $_SESSION['id'];
                                                        $ret = "select * from userregistration where id=?";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->bind_param('i', $aid);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
//$cnt=1;
                                                        while ($row = $res->fetch_object()) {
                                                            ?>

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Admission No : </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="admission_no" id="admission_no" value="<?php echo $row->admission_no; ?>" class="form-control" readonly >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Program</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="program" id="dpt" value="<?php echo $row->program; ?>" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Department</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="dpt" id="dpt" value="<?php echo $row->department; ?>" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Level</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="level" id="level" value="<?php echo $row->level; ?>" class="form-control" readonly>
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">First Name : </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="fname" id="fname"  class="form-control" value="<?php echo $row->firstName; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Middle Name : </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="mname" id="mname"  class="form-control" value="<?php echo $row->middleName; ?>"  readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Last Name : </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="lname" id="lname"  class="form-control" value="<?php echo $row->lastName; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Gender : </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="gender" value="<?php echo $row->gender; ?>" class="form-control" readonly>
                                                                    <input type="hidden" name="img" value="<?php echo $row->img; ?>" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Mobile No: </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="contactno" value="<?php echo $row->contactNo; ?>" id="contactno"  maxlength="11" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                        <?php } ?>


                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Guardian  Name : </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="gname" id="gname"  class="form-control" required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-sm-offset-4">
                                                            <button class="btn btn-default" type="submit">Cancel</button>
                                                            <input type="submit" name="submit" Value="Continue" class="btn btn-primary">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-4">
                                                    <h3>House Information</h3>
                                                    <div class="row" id="hInfo" style="display: none;">
                                                        <div class="col-md-12" style="margin-bottom: 5%;">
                                                            <img id="house_img" style="width: 300px; height: 300px;" />
                                                        </div>
                                                        <div class="col-md-10 col-sm-10 col-lg-10">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <label class="col-md-4 control-label">Villa Name: </label>
                                                                        <div class="col-md-8">
                                                                            <h6 id="villa_name2"></h6>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-md-4 control-label">Villa Address: </label>
                                                                        <div class="col-md-8">
                                                                            <h6 id="villa_address2"></h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div id="roomList">

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
    <script type="text/javascript">
                                                                    $(document).ready(function () {
                                                                        $('input[type="checkbox"]').click(function () {
                                                                            if ($(this).prop("checked") == true) {
                                                                                $('#paddress').val($('#address').val());
                                                                                $('#pcity').val($('#city').val());
                                                                                $('#pstate').val($('#state').val());
                                                                                $('#ppincode').val($('#pincode').val());
                                                                            }

                                                                        });
                                                                    });
    </script>
    <script>
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'roomno=' + $("#villa").val(),
                type: "POST",
                success: function (data) {
                    $("#villa-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function () {}
            });
        }
    </script>


    <script type="text/javascript">

        $(document).ready(function () {
            $('#duration').keyup(function () {
                var fetch_dbid = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: "ins-amt.php?action=userid",
                    data: {userinfo: fetch_dbid},
                    success: function (data) {
                        $('.result').val(data);
                    }
                });


            })
        });
    </script>

</html>