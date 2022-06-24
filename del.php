<?php

session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
if (!isset($_GET["id"])):
    echo '<script type="text/javascript">
  alert("An error occured please try again later");
  window.location="room-details.php";
  </script>';
endif;
$id = $_SESSION['id'];
$rid = $_GET["id"];
$adn = "delete from registration where student_id=? AND id=?";
$stmt = $mysqli->prepare($adn);
$stmt->bind_param('ii', $id, $rid);
$stmt->execute();
$stmt->close();
echo '<script type="text/javascript">
  alert("Accommodataion Registration Deleted Succefully");
  window.location="room-details.php";
  </script>';
