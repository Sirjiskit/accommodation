<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for add courses
if (isset($_POST['submit'])) {
    $hId = $_POST["houseid"];
    $info = $_POST['info'];
    $roomno = $_POST['rmno'];
    $aid = $_SESSION['id'];
    $fees = $_POST['fee'];
    $sql = "SELECT room_no FROM rooms where room_no=? and aid=? and houseid=?";
    $stmt1 = $mysqli->prepare($sql);
    $stmt1->bind_param('iii', $roomno, $aid, $hId);
    $stmt1->execute();
    $stmt1->store_result();
    $row_cnt = $stmt1->num_rows;
    if ($row_cnt > 0) {
        echo"<script>alert('Room Number already exist');</script>";
    } else {
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], '../rooms_image/' . $img);
        $image = $img;
        $query = "insert into  rooms (aid,houseid,room_no,room_details,room_img,fees) values(?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('iiisss', $aid, $hId, $roomno, $info, $image, $fees);
        $stmt->execute();
        echo"<script>alert('Room has been added successfully');</script>";
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
        <title>Create Room</title>
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
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="ts-main-content">
            <?php include('includes/sidebar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <h2 class="page-title">Add a room</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Add a room to your House</div>
                                        <div class="panel-body">
                                            <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                                <div class="hr-dashed"></div>										
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">House:</label>
                                                    <div class="col-sm-8">
                                                        <select name="houseid" required="" class="form-control">
                                                            <option value="" selected="">Choose....</option>
                                                            <?php
                                                            $aid = $_SESSION['id'];
                                                            $ret = "select * from houses where aid = ?";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->bind_param('i', $aid);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            while ($row = $res->fetch_object()) {
                                                                ?>
                                                                <option value="<?php echo $row->houseid ?>"><?php echo $row->villa_name ?></option>
                                                                <?php
                                                            }
                                                            ?>	
                                                        </select>
                                                    </div>
                                                </div>				
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Room No.</label>
                                                    <div class="col-sm-8">
                                                        <input readonly="" type="text" class="form-control" name="rmno" id="rmno" value="" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Fee(for Room)</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="fee" id="fee" value="" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Room info:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="info" id="info" placeholder="e.g  2 bedroom flat.." value="" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Room Image:</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" name="img" id="img"  class="form-control" required="required" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <input class="btn btn-primary" type="submit" name="submit" value="Create Room ">
                                                </div>
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
    $('[name="houseid"]').change(function () {
        var id = $(this).val();
        $.ajax({
            url: 'check_room_num.php',
            data: {hId: id},
            type: 'POST',
            success: function (data) {
                var res = JSON.parse(data);
                $('#rmno').val(res.room_no);
                $('#fee').val(res.fees);
            }, error: function (err) {
                $('#rmno').val(0);
                $('#fee').val(0);
            }
        });
    });
</script>
</body>

</html>