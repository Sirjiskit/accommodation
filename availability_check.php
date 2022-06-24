<?php

session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (!empty($_POST["emailid"])) {
    $email = $_POST["emailid"];
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

        echo "error : You did not enter a valid email.";
    } else {
        $result = "SELECT count(*) FROM userRegistration WHERE email=?";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        if ($count > 0) {
            echo "<span style='color:red'> Email already exist .</span>";
        } else {
            echo "<span style='color:green'> Email available for registration .</span>";
        }
    }
}

if (!empty($_POST["oldpassword"])) {
    $pass = $_POST["oldpassword"];
    $result = "SELECT password FROM userregistration WHERE password=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('s', $pass);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $opass = $result;
    if ($opass == $pass)
        echo "<span style='color:green'> Password  matched .</span>";
    else
        echo "<span style='color:red'> Password Not matched</span>";
}


if (!empty($_POST["roomno"])) {
    $id = $_SESSION['id'];

    $query = "SELECT * FROM registration where student_id = '" . $id . "' ";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();
    $res = $stmt2->get_result();
    while ($row = $res->fetch_object()) {
        $villa_id = $row->villa_id;
    }

    $roomno = $_POST["roomno"];
    $stmt = $mysqli->prepare("SELECT villa_id,roomno FROM registration WHERE villa_id=? AND roomno=?");
    $stmt->bind_param('ii', $villa_id, $roomno);
    $stmt->execute();
    $stmt->bind_result($villa_id, $roomno);
    $rs = $stmt->fetch();
    $stmt->close();
    if (!$rs)
        echo "<span style='color:green'>Room is available</span>";
    else
        echo "<span style='color:red'>Room has been booked</span>";
}
?>