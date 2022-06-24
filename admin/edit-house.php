<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for add courses
if (isset($_POST['submit'])) {
    $villa_name = $_POST['villa_name'];
    $villa_for = $_POST['villa_for'];
    $villa_address = $_POST['villa_address'];
    $aid = $_SESSION['id'];
    $id = $_GET['id'];
    $sql = "SELECT villa_name FROM houses where villa_name=? and aid=? AND houseid !=?";
    $stmt1 = $mysqli->prepare($sql);
    $stmt1->bind_param('sii', $villa_name, $aid, $id);
    $stmt1->execute();
    $stmt1->store_result();
    $row_cnt = $stmt1->num_rows;
    if ($row_cnt > 0) {
        echo"<script>alert('Villa name already exist');</script>";
    } else {
        $image = $_POST["file_image"];
        if (isset($_FILES) && isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) :
            $img = $_FILES['img']['name'];
            move_uploaded_file($_FILES['img']['tmp_name'], '../villa_images/' . $img);
            $image = $img;
        endif;
        $query = "UPDATE houses SET `villa_name`=?, `villa_for`=?, `villa_address`=?, `image`=? WHERE houseid=?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssssi', $villa_name, $villa_for, $villa_address, $image, $id);
        $stmt->execute();
        echo"<script>alert('House has been updated successfully');</script>";
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
        <title>Edit House</title>
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

                            <h2 class="page-title">Edit House</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Edit house
                                            <a role="button" href="./manage-houses.php" class="btn btn-primary btn-sm pull-right" style="margin-top: -5px"><i class="fa fa-list"></i> View List</a>
                                        </div>
                                        <div class="panel-body">
                                            <form method="post" action="./edit-house.php?id=<?php echo $_GET['id'] ?>" class="form-horizontal" enctype="multipart/form-data">
                                                <?php
                                                $id = $_GET['id'];
                                                $ret = "SELECT * FROM `houses` WHERE houseid=?";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->bind_param('i', $id);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                //$cnt=1;
                                                while ($row = $res->fetch_object()) {
                                                    ?>
                                                    <div class="hr-dashed"></div>	
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Villa Name: </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="villa_name" value="<?php echo $row->villa_name ?>" id="villa_name" onBlur="checkAvailabilityV()"  class="form-control" required="required" >
                                                            <span id="villa-availability-status" style="font-size:12px;"></span>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Accommodation for?</label>
                                                        <div class="col-sm-6">
                                                            <select name="villa_for" id="villa_for" class="form-control" required>
                                                                <option value="">Select</option>
                                                                <option <?php echo $row->villa_for == 'Accommodation for Boys Only' ? 'selected' : '' ?> value="Accommodation for Boys Only">Accommodation for Boys Only</option>
                                                                <option <?php echo $row->villa_for == 'Accommodation for Girls Only' ? 'selected' : '' ?> value="Accommodation for Girls Only">Accommodation for Girls Only</option>
                                                                <option <?php echo $row->villa_for == 'Accommodation for Both Boy and Girls' ? 'selected' : '' ?> value="Accommodation for Both Boy and Girls">Accommodation for Both Boys and Girls</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Villa Address: </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" value="<?php echo $row->villa_address ?>" name="villa_address" id="villa_address"  class="form-control" required="required" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10" style="margin-bottom: 10px">
                                                            <img src="../villa_images/<?php echo $row->image; ?>" height="45px" width="45px">
                                                        </div>
                                                        <label class="col-sm-2 control-label"> Villa Image: </label>
                                                        <input type="hidden" name="file_image" value="<?php echo $row->image; ?>">
                                                        <div class="col-sm-6">
                                                            <input type="file" name="img" id="img" class="form-control" >
                                                        </div>
                                                    </div>										

                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <input class="btn btn-primary" type="submit" name="submit" value="Update House ">
                                                    </div>
                                            </div>
                                        <?php } ?>
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
</script>
</body>
<script>
                                                            function checkAvailabilityV() {

                                                                $("#loaderIcon").show();
                                                                jQuery.ajax({
                                                                    url: "../check_availability.php?edit=<?php echo $_GET['id'] ?>",
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