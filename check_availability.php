<?php

require_once("includes/config.php");
if (!empty($_POST["emailid"])) {
    $email = $_POST["emailid"];
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

        echo "error : You did not enter a valid email.";
    } else {
        $result = "SELECT count(*) FROM admin WHERE email=?";
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
if (!empty($_POST["villaname"])) {
    $villa = $_POST["villaname"];
    if (is_numeric($villa)) {
        echo "error : Please enter a villa name not a numeric number.";
    } else {
        $result = "SELECT count(*) FROM admin WHERE villa=?";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('s', $villa);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        if ($count > 0) {
            echo "<span style='color:red'> Villa name already exist .</span>";
        } else {
            echo "<span style='color:green'> Villa name is available .</span>";
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
    $id = $_POST["roomno"];
    $query = "SELECT * FROM houses where houseid = '" . $id . "'";
    $stmt2 = $mysqli->prepare($query);
    $stmt2->execute();
    $res = $stmt2->get_result();
    $row = $res->fetch_object();
    $for = $row->villa_for;
    echo "<span style='color:green'>$for.</span>";
}