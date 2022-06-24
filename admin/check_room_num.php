<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
$aid = $_SESSION['id'];
require_once("includes/config.php");
$houseId = filter_input(INPUT_POST, "hId", FILTER_SANITIZE_NUMBER_INT);
if (!$houseId):
    die(json_encode(array("fees" => 0, "room_no" => 0)));
endif;
$ret = "select * from rooms where aid = ? AND houseid=? ORDER BY room_no DESC";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('ii', $aid, $houseId);
$stmt->execute(); //ok
$res = $stmt->get_result();
//$cnt=1;
while ($row = $res->fetch_object()) {
    die(json_encode(array("fees" => $row->fees, "room_no" => (int) $row->room_no + 1)));
}
die(json_encode(array("fees" => 0, "room_no" => 1)));
