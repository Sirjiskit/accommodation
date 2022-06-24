<?php

session_start();
include('includes/config.php');
if (!empty($_POST["rid"]) && !empty($_POST["hid"])) {
    $id = $_SESSION['id'];
    $sid = $_POST["hid"];
    $query1 = "SELECT * FROM registration where student_id = {$id} AND id={$sid}";
    $stmt1 = $mysqli->prepare($query1);
    $stmt1->execute();
    $res1 = $stmt1->get_result();
    while ($row = $res1->fetch_object()) {
        $aid = $row->villa_id;
    }
    $rid = $_POST['rid'];
    $query = "SELECT * FROM rooms where houseid = {$aid} AND  room_no = {$rid} ";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();
    $res = $stmt2->get_result();

    while ($ro = $res->fetch_object()) {
        echo json_encode(array("fees" => $ro->fees, "details" => $ro->room_details));
    }
}
