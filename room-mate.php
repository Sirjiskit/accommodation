<?php
session_start();
include('includes/config.php');
date_default_timezone_set('Africa/Lagos');
include('includes/checklogin.php');
check_login();

if(isset($_POST['update']))
{

$uid=$_SESSION['id'];
$stmt=$mysqli->prepare("SELECT student_id FROM roommate_char WHERE student_id=? ");
$stmt->bind_param('i',$uid);
$stmt->execute();
$stmt -> bind_result($uid);
$rs=$stmt->fetch();
$stmt->close();
if(!$rs){
$uid=$_SESSION['id'];
$ret= mysqli_query($mysqli,"SELECT * FROM userregistration where id = '".$uid."'");
$ro=mysqli_fetch_array($ret);

$firstName = $ro['firstName'];
$middleName = $ro['middleName'];
$lastName = $ro['lastName'];
$img = $ro['img'];
$department = $ro['department'];
$level = $ro['level'];
$contactNo = $ro['contactNo'];
$gender = $ro['gender'];

$roommate_id='0';
$uid=$_SESSION['id'];
$alcohol=$_POST['alcohol'];
$smokes=$_POST['smokes'];
$cook=$_POST['cook'];
$habit=$_POST['habit'];
$studies=$_POST['studies'];
$visitors=$_POST['visitors'];

$sql = "insert into roommate_char (student_id,roommate_id,roommate,alcohol,smokes,cook,habit,studies,visitors,gender,firstName,middleName,lastName,img,department,level,contactNo) values('$uid','$roommate_id','$roommate_id','$alcohol','$smokes','$cook','$habit','$studies','$visitors','$gender','$firstName','$middleName','$lastName','$img','$department','$level','$contactNo')";
$mysqli->query($sql);

header("location:search_result.php");
}
else
{
$uid=$_SESSION['id'];
$ret= mysqli_query($mysqli,"SELECT * FROM userregistration where id = '".$uid."'");
$ro=mysqli_fetch_array($ret);

$firstName = $ro['firstName'];
$middleName = $ro['middleName'];
$lastName = $ro['lastName'];
$img = $ro['img'];
$department = $ro['department'];
$level = $ro['level'];
$contactNo = $ro['contactNo'];

$aid=$_SESSION['id'];
$alcohol=$_POST['alcohol'];
$smokes=$_POST['smokes'];
$cook=$_POST['cook'];
$habit=$_POST['habit'];
$studies=$_POST['studies'];
$visitors=$_POST['visitors'];
$re= mysqli_query($mysqli,"UPDATE roommate_char SET alcohol = '".$alcohol."', smokes = '".$smokes."', cook = '".$cook."', habit = '".$habit."', studies = '".$studies."', visitors = '".$visitors."', firstName = '".$firstName."', middleName = '".$middleName."', lastName = '".$lastName."', img = '".$img."', department = '".$department."', level = '".$level."', contactNo = '".$contactNo."' WHERE student_id='".$uid."'");
header("location:search_result.php");
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
	<title>Search room-mate</title>
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
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
function valid()
{
if(document.registration.password.value!= document.registration.cpassword.value)
{
alert("Password and Re-Type Password Field do not match  !!");
document.registration.cpassword.focus();
return false;
}
return true;
}
</script>
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
			
	<?php	
    $aid=$_SESSION['id'];
	$ret= mysqli_query($mysqli,"SELECT * FROM userregistration where id = '".$aid."'");
    $rw=mysqli_fetch_array($ret);
    ?>	
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Hello&nbsp;<?php echo $rw['firstName'];?> </h2>

						<div class="row">
							<div class="col-md-8">
								<div class="panel panel-primary">
									<div class="panel-heading">
FIND A ROOM MATE THAT MATCH
</div>
<?php	
$aid=$_SESSION['id'];
$re= mysqli_query($mysqli,"SELECT * FROM roommate_char where student_id = '".$aid."'");
$row=mysqli_fetch_array($re);
if(mysqli_num_rows($re) > 0){
$alcohol=$row['alcohol'];
$smokes=$row['smokes'];
$cook=$row['cook'];
$habit=$row['habit'];
$studies=$row['studies'];
$visitors=$row['visitors'];
}else{
	$alcohol="No";
	$smokes="No";
	$cook="No";
	$habit="No";
	$studies="No";
	$visitors="No";
}
?>									 

<div class="panel-body">
<form method="post" action="" name="registration" class="form-horizontal" onSubmit="return valid();">
								

<div class="form-group">
<label class="col-sm-4 ">Can you live with a roommate who consumes alcohol?</label>
<div class="col-sm-4">
<select name="alcohol" class="form-control" required="required">
<?php 
if($row){
	if($alcohol == 'Yes'){
		echo"
		<option value='Yes' selected>Yes</option>
        <option value='No'>No</option>
		";
	}else{
		echo"
		<option value='Yes'>Yes</option>
        <option value='No' selected>No</option>
		";
	}
}else{
echo"
<option value=''>Select</option>
<option value='Yes'>Yes</option>
<option value='No'>No</option>
";
}
?>

</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-4">Can you live with a roommate who smokes? </label>
<div class="col-sm-4">
<select name="smokes" class="form-control" required="required">
<?php 
if($row){
	if($smokes == 'Yes'){
		echo"
		<option value='Yes' selected>Yes</option>
        <option value='No'>No</option>
		";
	}else{
		echo"
		<option value='Yes'>Yes</option>
        <option value='No' selected>No</option>
		";
	}
}else{
echo"
<option value=''>Select</option>
<option value='Yes'>Yes</option>
<option value='No'>No</option>
";
}
?>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-4">Can you live with a roommate that cannot cook? </label>
<div class="col-sm-4">
<select name="cook" class="form-control" required="required">
<?php 
if($row){
	if($cook == 'Yes'){
		echo"
		<option value='Yes' selected>Yes</option>
        <option value='No'>No</option>
		";
	}else{
		echo"
		<option value='Yes'>Yes</option>
        <option value='No' selected>No</option>
		";
	}
}else{
echo"
<option value=''>Select</option>
<option value='Yes'>Yes</option>
<option value='No'>No</option>
";
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-4">Can you live with a roommate with a poor cleaning habit? </label>
<div class="col-sm-4">
<select name="habit" class="form-control" required="required">
<?php 
if($row){
	if($habit == 'Yes'){
		echo"
		<option value='Yes' selected>Yes</option>
        <option value='No'>No</option>
		";
	}else{
		echo"
		<option value='Yes'>Yes</option>
        <option value='No' selected>No</option>
		";
	}
}else{
echo"
<option value=''>Select</option>
<option value='Yes'>Yes</option>
<option value='No'>No</option>
";
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-4">Can you live with a roommate who is not studious? </label>
<div class="col-sm-4">
<select name="studies" class="form-control" required="required">
<?php 
if($row){
	if($studies == 'Yes'){
		echo"
		<option value='Yes' selected>Yes</option>
        <option value='No'>No</option>
		";
	}else{
		echo"
		<option value='Yes'>Yes</option>
        <option value='No' selected>No</option>
		";
	}
}else{
echo"
<option value=''>Select</option>
<option value='Yes'>Yes</option>
<option value='No'>No</option>
";
}
?>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-4">Can you live with a roommate who is likely to bring visitors that would spend one or more night? </label>
<div class="col-sm-4">
<select name="visitors" class="form-control" required="required">
<?php 
if($row){
	if($visitors == 'Yes'){
		echo"
		<option value='Yes' selected>Yes</option>
        <option value='No'>No</option>
		";
	}else{
		echo"
		<option value='Yes'>Yes</option>
        <option value='No' selected>No</option>
		";
	}
}else{
echo"
<option value=''>Select</option>
<option value='Yes'>Yes</option>
<option value='No'>No</option>
";
}
?>
</select>
</div>
</div>



<div class="col-sm-5 col-sm-offset-5">

<input type="submit" name="update" Value="Search Room-mate" class="btn btn-primary">
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