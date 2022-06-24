<?php

include('includes/pdoconfig.php');

function getRoomCount($id) {
    $stmt = $DB_con->prepare("SELECT * FROM rooms WHERE aid = :aid");
    $stmt->execute(array(':aid' => $id));
    return $stmt->rowCount();
}

if (!empty($_POST["aid"])) {
    $id = $_POST['aid'];
    $stmt = $DB_con->prepare("SELECT * FROM admin WHERE villa = :id");
    $stmt->execute(array(':id' => $id));
?>
    <?php

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <?php echo htmlentities($row['address']); ?>
        <?php

    }
}


if (!empty($_POST["hid"])) {
    $id = $_POST['hid'];
    $stmt = $DB_con->prepare("SELECT * FROM houses WHERE houseid = :id");
    $stmt->execute(array(':id' => $id));
    $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtt = $DB_con->prepare("SELECT r.* FROM rooms r JOIN houses h ON r.houseid = h.houseid AND r.aid=h.aid "
            . "WHERE NOT EXISTS (SELECT * FROM registration rg WHERE rg.villa_id = h.houseid AND rg.roomno=r.room_no) AND r.houseid = :houseid");
    $stmtt->execute(array(':houseid' => $id));
    $roomList = $stmtt->fetchAll(PDO::FETCH_ASSOC);
    $totalRoom = $stmtt->rowCount();

    $rs = '';
    $rs .= '<table class="table">';
    $rs .= '<caption>Available Rooms</caption>';
    $rs .= '<tr>';
    $rs .= '<th>Room No</th>';
    $rs .= '<th>Details</th>';
    $rs .= '<th>Price</th>';
    $rs .= '</tr>';
    foreach ($roomList as $v) {
        $rs .= '<tr>';
        $rs .= '<td>' . $v['room_no'] . '</td>';
        $rs .= '<td>' . $v['room_details'] . '</td>';
        $rs .= '<td>' . $v['fees'] . '</td>';
        $rs .= '</tr>';
    }
    $rs .= '</table>';

    foreach ($rec as $key => $value) {
        $rec[$key]['totalRoom'] = $totalRoom;
        $rec[$key]['roomList'] = $rs;
    }

    die(json_encode($rec[0]));
        ?>
    <?php

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <?php echo htmlentities($row['address']); ?>
        <?php

    }
}