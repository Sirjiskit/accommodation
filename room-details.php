<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
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
        <title>Room Details</title>
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

            function gettConfirmation() {
                var retVal = confirm("Are sure you want to Delete your accommodation registration ?");
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
                        <div class="col-md-12">
                            <h2 class="page-title" style="margin-top:4%">Rooms Details</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php
                                    $aid = $_SESSION['id'];

                                    $qrt = $mysqli->prepare("SELECT id FROM registration WHERE student_id=? ");
                                    $qrt->bind_param('i', $aid);
                                    $qrt->execute();
                                    $qrt->bind_result($aid);
                                    $resulr = $qrt->get_result();
                                    $rows = [];
                                    while ($row = $resulr->fetch_assoc()) {
                                        $rows[] = $row['id'];
                                    }
                                    if (count($rows) > 0) {
                                        $rid = 0;
                                        if (!isset($_GET['id'])) {
                                            if (count($rows) > 0) {
                                                $rid = $rows[0];
                                            }
                                        } else {
                                            $rid = $_GET['id'];
                                        }

                                        $index = array_search($rid, $rows);

                                        if ($index == 0) {
                                            $previousValue = $rows[$index];
                                        } else {
                                            $previousValue = $rows[$index - 1];
                                        }

                                        if ((count($rows) - 1) == $index) {
                                            $nextValue = $rows[$index];
                                        } else {
                                            $nextValue = $rows[$index + 1];
                                        }
                                    }

//                                    echo '<a href="room-details.php?id=' . $previousValue . '" ><< Previous </a>' . '<br />';
//                                    echo '<a href="room-details.php?id=' . $nextValue . '" >Next >></a>' . '<br />';
                                    ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            All Room Details
                                        </div>
                                        <?php if (count($rows) > 0) { ?>
                                            <div class="col-md-6">
                                                <?php
                                                $position = $index + 1;
                                                $info = array(
                                                    1 => "You are in the First Apartment",
                                                    2 => "You are in the Second Apartment",
                                                    3 => "You are in the Third Apartment"
                                                );

                                                echo '<b style="color: #000; font-size: 20px;">' . $info[$position] . '</b>';
                                                ?>
                                            </div>
                                            <div class="col-md-3">
                                                <a class="btn btn-default btn-sm pull-right" href="room-details.php?id=<?php echo $nextValue; ?>">&nbsp;&nbsp;&nbsp; Next <i class="fa fa-arrow-right"></i></a>
                                                <span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <a class="btn btn-default btn-sm pull-right" href="room-details.php?id=<?php echo $previousValue; ?>"><i class="fa fa-arrow-left"></i> Previous </a>
                                            </div>
                                        <?php } ?> 
                                    </div>


                                </div>
                                <div class="panel-body">
                                    <?php
                                    $ret = "select * from registration where id=?";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $rid);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
//                                    $rows = array();
//                                    while ($row = $res->fetch_assoc()){
//                                        $rows[] = $row;
//                                    }
//                                    print_r($rows);
                                    while ($row = $res->fetch_object()) {
                                        ?>

                                        <?php
                                        date_default_timezone_set('Africa/Lagos');
                                        $reg = (strtotime($row->reg_date));
                                        $expiredate = $reg + '604800';
                                        $currdate_a = (new DateTime())->getTimestamp();
                                        $time = date("F d, Y h:i:A", $expiredate);

                                        if ($currdate_a > $expiredate) {
                                            $id = $_SESSION['id'];
                                            $adn = "delete from registration where student_id=?";
                                            $stmt = $mysqli->prepare($adn);
                                            $stmt->bind_param('i', $id);
                                            $stmt->execute();
                                            $stmt->close();
                                        }

                                        $uid = $_SESSION['id'];
                                        $sql = "SELECT * FROM registration WHERE student_id= '" . $uid . "' AND status != 'Paid'";
                                        $query = mysqli_query($mysqli, $sql);
                                        $num = mysqli_num_rows($query);
                                        if ($num != 0) {
                                            echo"
						  <div class='row'>
	                      <div class='col-xs-12 col-xs-offset-1' >
                          <div class='col-xs-10'>
	                      <h5 style='text-align:center; color:green; font-size:13px'>Contact your landloard and make your payment before <span style='color:red;'>" . date('F jS, Y', $expiredate) . " - " . date('h:i:A', $expiredate) . "</span></h5>
                          <div id='demo'></div>
						  <br>
	                      </div>
                          </div>
	                      </div>
						 ";
                                        }
                                        ?>


                                        <table id="zctb" class="table table-bordered " cellspacing="0" width="100%">


                                            <tbody>

                                                <tr>
                                                    <td colspan="4"><h4>Accommodation Related Info</h4></td>
                                                    <td><a href="javascript:void(0);"  onClick="popUpWindow('http://localhost/accommodation/full-profile.php?id=<?php echo $row->student_id; ?>');" title="View Full Details">Print Data</a></td>
                                                    <td><?php
                                                        if ($num != 0) {
                                                            echo "<a href='del.php?id={$row->id}' onclick='return gettConfirmation()' title='Delete Accommodation' style='color:red'>Delete</a>";
                                                        } else {
                                                            echo"<span style='color:green'>Paid</span>";
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"><b>Reg date. :<?php echo date('F jS, Y', strtotime($row->reg_date)) . " at " . date('h:i:A', strtotime($row->reg_date)); ?></b></td>
                                                </tr>



                                                <tr>
                                                    <td><b>Villa name:</b></td>
                                                    <?php
                                                    $landl_id = $row->villa_id;
                                                    $ret = "select h.villa_name,h.villa_address,h.image,a.username,a.contactNo from houses h "
                                                            . "JOIN admin a ON a.id=h.aid where h.houseid=?";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->bind_param('i', $landl_id);
                                                    $stmt->execute();
                                                    $res = $stmt->get_result();
                                                    $cnt = 1;
                                                    while ($ros = $res->fetch_object()) {
                                                        $landl_name = $ros->username;
                                                        $landl_no = $ros->contactNo;
                                                        $villa_name = $ros->villa_name;
                                                        $villa_address = $ros->villa_address;
                                                        $villa_image = $ros->image;
                                                        ?>
                                                        <td><?php echo $villa_name; ?></td>
                                                        <td><b>Landlord name:</b></td>
                                                        <td><?php echo $landl_name; ?></td>
                                                        <td><b>Landlord no:</b></td>
                                                        <td><?php echo $landl_no; ?></td>

                                                    </tr>

                                                    <tr>
                                                        <td><b>Room no:</b></td>
                                                        <td><?php echo $row->roomno; ?></td>
                                                        <td><b>Stay From:</b></td>
                                                        <td><?php echo $row->stayfrom; ?></td>
                                                        <td><b>Duration:</b></td>
                                                        <td>1 years</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"><b>Amount to pay:<?php echo $row->amount; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"><h4>Personal Info</h4></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Admission No. :</b></td>
                                                        <td><?php echo $row->admission_no; ?></td>
                                                        <td><b>Full Name :</b></td>
                                                        <td><?php echo $row->firstname; ?> <?php echo $row->middlename; ?> <?php echo $row->lastname; ?></td>
                                                        <td><b>Gender :</b></td>
                                                        <td><?php echo $row->gender; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Contact No. :</b></td>
                                                        <td><?php echo $row->contactno; ?></td>
                                                        <td><b>Department :</b></td>
                                                        <td><?php echo $row->department; ?></td>
                                                        <td><b>Level :</b></td>
                                                        <td><?php echo $row->level; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Program :</b></td>
                                                        <td colspan="5"><?php echo $row->program; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="6"><h4>Address info</h4></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center"><b><?php echo $villa_name; ?> Address <br><h1><i class="fa fa-arrow-right"></h1></b></td>
                                                        <td colspan="2" style="text-align:center" >
                                                            <img src="villa_images/<?php echo $villa_image; ?>" width="200" height="150" />
                                                            <br>
                                                            <?php echo $villa_address; ?><br />
                                                        </td>
                                                        <td  style="text-align:center"><b>Room <?php echo $row->roomno; ?> Details   <br><h1><i class="fa fa-arrow-right"></h1></b></td>
                                                        <?php
                                                        $sq = "SELECT * FROM rooms WHERE houseid= '" . $landl_id . "' AND room_no = '" . $row->roomno . "' ";
                                                        $stmt2 = $mysqli->prepare($sq);
                                                        $stmt2->execute();
                                                        $res = $stmt2->get_result();
                                                        $img = $res->fetch_object();
                                                        ?>
                                                        <td  colspan="2" style="text-align:center" >
                                                            <img src="rooms_image/<?php echo $img->room_img; ?>" width="200" height="150">
                                                            <br/>
                                                            <?php echo $row->room_details; ?>
                                                        </td>

                                                    </tr>


                                                    <?php
                                                    $cnt = $cnt + 1;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <script>
                                        // Set the date we're counting down to
                                        var countDownDate = new Date("<?php echo $time; ?>").getTime();

                                        // Update the count down every 1 second
                                        var x = setInterval(function () {

                                            // Get today's date and time
                                            var now = new Date().getTime();

                                            // Find the distance between now and the count down date
                                            var distance = countDownDate - now;

                                            // Time calculations for days, hours, minutes and seconds
                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            // Display the result in the element with id="demo"
                                            document.getElementById("demo").innerHTML =
                                                    "<span>" + days + " Days</span>" +
                                                    "<span>" + hours + " Hours</span>" +
                                                    "<span>" + minutes + " Min</span>" +
                                                    "<span>" + seconds + " Sec</span>";

                                            // If the count down is finished, write some text
                                            if (distance < 0) {
                                                clearInterval(x);
                                                document.getElementById("demo").innerHTML = "<section>Accommodation Expired</section>";
                                            }
                                        }, 1000);

                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #demo{
                display:flex;
                width:100%;
                margin:0 auto;
            }
            #demo section{
                position:relative;
                width:100%;
                padding:5px 4px;
                font-weight:bold;
                color:white;
                background: linear-gradient(to right, #df0000 0%,#ff0000  50%, #df0000 100%);
                border:2px solid #c30000;
                text-align:center;
            }
            #demo span{
                position:relative;
                width:50%;
                padding:5px 4px;
                margin:0 5px;
                color:white;
                font-weight:bold;
                background-color:black;
                border:2px solid red;
            }
            #demo span:last-child{
                font-weight:bold;
                background-color:red;
            }
            #demo span:last-child{
                font-weight:bold;
                border:2px solid #ea0000;
            }
            #demo span:before{
                content:'';
                position:absolute;
                background-color:rgba(255,255,255,.2);
            }
            #demo span{
                display:block;
                text-align:center;
            }
        </style>

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

    </body>

</html>
