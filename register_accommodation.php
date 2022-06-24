<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for registration
$lastId = filter_input(INPUT_GET, "sid", FILTER_SANITIZE_NUMBER_INT);
if (!$lastId):
    ?>
    <script>
        alert('An error occurred please try again later');
        window.location = "./book-accommodation.php";
    </script>
    <?php
endif;
if (isset($_POST['submit'])) {
    $aid = $_SESSION['id'];
    $roomno = $_POST['room'];
    $room_details = $_POST['room_details'];
    $need_roomate = $_POST['need_roomate'];
    $fees = $_POST['fees'];
    $query = "SELECT * FROM registration where student_id = '" . $aid . "' and id = {$lastId}";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();
    $res = $stmt2->get_result();
    while ($row = $res->fetch_object()) {
        $villa_id = $row->villa_id;
    }
    $stmt = $mysqli->prepare("SELECT villa_id,roomno FROM registration WHERE villa_id=? AND roomno=?");
    $stmt->bind_param('ii', $villa_id, $roomno);
    $stmt->execute();
    $stmt->bind_result($villa_id, $roomno);
    $rs = $stmt->fetch();
    $stmt->close();
    if (!$rs) {
        $aid = $_SESSION['id'];
        $roomno = $_POST['room'];
        $room_details = $_POST['room_details'];
        $need_roomate = $_POST['need_roomate'];
        $fees = $_POST['fees'];

        $sql = "UPDATE registration SET roomno = '" . $roomno . "', room_details = '" . $room_details . "', need_roomate = '" . $need_roomate . "', "
                . "amount = '" . $fees . "' WHERE student_id = '" . $aid . "' AND id={$lastId}";
        $mysqli->query($sql);
        echo '<script type="text/javascript">
  alert("Your accommodation registeration is successful");
  window.location="room-details.php";
  </script>';
        exit();
    } else {
        echo"<script>alert('The room number you enter has been booked before');</script>";
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
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/fileinput.min.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
        <script type="text/javascript" src="js/validation.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script>
    function getRoomid(val) {
        var hid = "<?php echo $lastId; ?>";
        $.ajax({
            type: "POST",
            url: "get_roomno.php",
            data: {rid: val, hid: hid},
            success: function (data) {
                var res = JSON.parse(data);
                $('#fees').val(res.fees);
                $('#room_details').val(res.details);
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

                            <h2 class="page-title">Room Registration </h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Fill all Info</div>
                                        <div class="panel-body">
                                            <form method="post" action="?sid=<?php echo $lastId; ?>" class="form-horizontal">

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><h4 style="color: green" align="left">Room Related info </h4> </label>
                                                </div>
                                                <?php
                                                $id = $_SESSION['id'];
                                                $query = "SELECT * FROM registration where student_id = '" . $id . "' AND id={$lastId}";
                                                $stmt2 = $mysqli->prepare($query);
                                                $stmt2->execute();
                                                $res = $stmt2->get_result();
                                                while ($row = $res->fetch_object()) {
                                                    $villa = $row->villa;
                                                    $villa_id = $row->villa_id;
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Villa Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="villa" id="villa" value="<?php echo $villa ?>" class="form-control" disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Room no. </label>
                                                    <div class="col-sm-8">
                                                        <select name="room" id="room" class="form-control"  onChange="getRoomid(this.value);" onBlur="checkAvailability()" required> 
                                                            <option value="">Select Room</option>
                                                            <?php
                                                            $query = "SELECT * FROM rooms r where r.houseid = {$villa_id} AND "
                                                                    . "NOT EXISTS (SELECT * FROM registration rg WHERE rg.villa_id = r.houseid AND rg.roomno=r.room_no)"
                                                                    . " ORDER BY room_no ASC";
                                                            $stmt2 = $mysqli->prepare($query);
                                                            $stmt2->execute();
                                                            $res = $stmt2->get_result();
                                                            while ($row = $res->fetch_object()) {
                                                                ?>
                                                                <option value="<?php echo $row->room_no; ?>"> <?php echo $row->room_no; ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                        <span id="room-availability-status" style="font-size:12px;"></span>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Room info</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="room_details" name="room_details"  class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Need room-mate?</label>
                                                    <div class="col-sm-8">
                                                        <select name="need_roomate" id="need_roomate" class="form-control" required>
                                                            <option value="">Select</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Duration</label>
                                                    <div class="col-sm-8">
                                                        <select name="duration" id="duration" class="form-control" disabled>
                                                            <option value="">1 Years</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Amount to pay</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="fees" id="fees" class="form-control" readonly>
                                                    </div>
                                                </div>


                                                <div class="col-sm-6 col-sm-offset-4">
                                                    <button class="btn btn-default" type="submit">Cancel</button>
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
                                                                    url: "availability_check.php",
                                                                    data: 'roomno=' + $("#room").val(),
                                                                    type: "POST",
                                                                    success: function (data) {
                                                                        $("#room-availability-status").html(data);
                                                                        $("#loaderIcon").hide();
                                                                    },
                                                                    error: function () {}
                                                                });
                                                            }
</script>


</html>