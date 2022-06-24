<?php

session_start();
include('includes/config.php');

date_default_timezone_set('Africa/Lagos');
$email = $_POST['email'];
$sql = "SELECT email FROM admin WHERE email='$email'";
$query = mysqli_query($mysqli, $sql);
$num = mysqli_num_rows($query);
if ($num == 0) {
    $updation_date = date('Y-m-d');
    $username = $_POST['username'];
    $contactNo = $_POST['contactNo'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $img = $_FILES['img']['name'];
    move_uploaded_file($_FILES['img']['tmp_name'], './landload_images/' . $img);
    $image = $img;
    $sql = "insert into admin(username,email,contactNo,password,address,image,updation_date) values('$username','$email','$contactNo','$password','$address','$image','$updation_date')";
    $query = mysqli_query($mysqli, $sql);
    echo '<script type="text/javascript">
    alert("Landlord Succssfully registered");
    window.location="index.php";
    </script>';
} else {
    echo '<script type="text/javascript">
    alert("The email address you entered has been registered in our database before");
    window.location="registration.php";
    </script>';
}