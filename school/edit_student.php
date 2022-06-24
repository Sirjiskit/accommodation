<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_POST['submit'])){
	extract($_POST);
	$id= intval($_GET['id']);
        $password = base64_encode($password);
	$adn="UPDATE `userregistration` SET `admission_no` = '{$admission_no}', `department`='{$department}', `level` = '{$level}', `firstName` = '{$firstname}', `middleName`='{$middleName}', `lastName` = '{$lastName}', `gender`='{$gender}', `contactNo`='{$contactNo}', `password`='{$password}' WHERE `id` = '{$id}'";
	$query = mysqli_query($mysqli, $adn);	  
    if ($query) {
     	 echo "<script>alert('Student Record Updated Successfull!'); window.location = 'manage-students.php';</script>" ;
     } 
}

if(isset($_GET['id']))
{
	$id= intval($_GET['id']);
	$ret="SELECT * FROM `userregistration` WHERE `id`='{$id}'";
	$query = mysqli_query($mysqli, $ret);
	$row = mysqli_fetch_array($query);
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
	<title>Manage Students</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+510+',height='+430+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
function getConfirmation(){
		var retVal = confirm("Are sure you want to change this student status to Paid ?");
		if (retVal == true){
			return true;
		}
		else{
			return false;
		}
	}
function gettConfirmation(){
		var retVal = confirm("Are sure you want to change this student status to Not Paid ?");
		if (retVal == true){
			return true;
		}
		else{
			return false;
		}
	}
</script>

</head>
<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
			<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<h2 class="page-title" style="margin-top:5%; padding: 15px 15px;">Edit Student Information</h2>
					<div class="col-md-6 col-md-offset-3">
						<div class="panel panel-default">
							<div class="panel-heading">Edit Student</div>
							<div class="panel-body">
								<form class="form-group" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<input type="text" value="<?php echo $row['admission_no']; ?>" class="form-control" name="admission_no" placeholder="Admission No">
									</div>
									<div class="form-group">
										<input type="text" value="<?php echo $row['department']; ?>" class="form-control" name="department" placeholder="department">
									</div>
									<div class="form-group">
										<input type="text" value="<?php echo $row['level']; ?>" class="form-control" name="level" placeholder="level">
									</div>
									<div class="form-group">
										<input type="text" value="<?php echo $row['firstName']; ?>" class="form-control" name="firstname" placeholder="firstname">
									</div>
									<div class="form-group">
										<input type="text" value="<?php echo $row['middleName']; ?>" class="form-control" name="middleName" placeholder="middlename">
									</div>
									<div class="form-group">
										<input type="text" value="<?php echo $row['lastName']; ?>" class="form-control" name="lastName" placeholder="lastname">
									</div>
									<div class="form-group">
										<input type="radio" <?php if($row['gender'] == "Male") echo 'checked'; ?> name="gender" value="Male" >Male
										<input type="radio" <?php if($row['gender'] == "Female") echo 'checked'; ?> name="gender" value="Female" >Female
									</div>

									<div class="form-group">
										<input type="text" value="<?php echo $row['contactNo']; ?>" class="form-control" name="contactNo" placeholder="Contact No">
									</div>

									<div class="form-group">
                                                                            <input type="text" value="<?php echo base64_decode($row['password']); ?>" class="form-control" name="password" placeholder="password">
									</div>
									

									<div class="form-group">
										<input type="submit"  name="submit" value="Update Student" class="btn btn-primary" >
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>

			

			</div>
		</div>
	</div>

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
