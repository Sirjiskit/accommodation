<?php
session_start();
include('includes/config.php');
date_default_timezone_set('Africa/Lagos');
include('includes/checklogin.php');
check_login();

if(isset($_GET['id']))
{
$aid=$_SESSION['id'];
$id = $_GET['id'];

 $aql=mysqli_query($mysqli,"select * from roommate_char where roommate_id='$aid' and roommate='$aid'");
  if(mysqli_num_rows($aql)){
  echo '<script type="text/javascript">
  alert("Oops You can not send request to any room-mate because you have accept request sent by another room-mate");
  window.location="search_result.php";
  </script>'; 
  exit(); 
  
  }else{
  $ql=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' and roommate_id!=''");
  if(mysqli_num_rows($ql)){
  echo '<script type="text/javascript">
  alert("Oops you can`t send another request to a room-mate wait for a respond from the first room-mate you sent a request to");
  window.location="search_result.php";
  </script>'; 
  exit();
}else{
	$aid=$_SESSION['id'];
    $id = $_GET['id'];
    date_default_timezone_set('Africa/Lagos');
    $currdate = date('Y-m-d h:i:s', time());
    $re= mysqli_query($mysqli,"UPDATE roommate_char SET roommate_id = '".$id."', time = '".$currdate."' WHERE student_id='".$aid."'");
    echo '<script type="text/javascript">
    alert("Room-mate request sent Successfully");
    window.location="search_result.php";
	</script>'; 
exit();
}}}

if(isset($_GET['uid']))
{
$aid=$_SESSION['id'];
$id ='0';
$re= mysqli_query($mysqli,"UPDATE roommate_char SET roommate_id = '".$id."' WHERE student_id='".$aid."'");
    echo '<script type="text/javascript">
    alert("Room-mate request has been unsent Successfully");
    window.location="search_result.php";
	</script>'; 
exit();
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
	function getConfirmation(){
		var retVal = confirm('Do you want to send room-mate request to this student ?');
		if (retVal == true){
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function gettConfirmation(){
		var retVal = confirm("Are sure you want to Unsent this room-mate request ?");
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
					<div class="col-md-12">
						<h3 class="page-title">Search Results</h3>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
                                     <a href="room-mate.php"><i class="fa fa-search"></i> Re-Search</a>
                                     </div>
                                     <div class="panel-body">
									 
									 <div class="center">
		                             <div class="posts">
		                             <div class="create-posts">

                                     <?php	
                                     $aid=$_SESSION['id'];
	                                 $re= mysqli_query($mysqli,"SELECT * FROM roommate_char where student_id = '".$aid."'");
                                     $row=mysqli_fetch_array($re);
									 $alcohol=$row['alcohol'];
                                     $smokes=$row['smokes'];
                                     $cook=$row['cook'];
                                     $habit=$row['habit'];
                                     $studies=$row['studies'];
                                     $visitors=$row['visitors'];
                                     $gender=$row['gender'];
                                     $roommate_id="0";
//query of 100% requirements										 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 100% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
//	End query of 100% requirements	

//	Begining query of 83% requirements	
								 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									  echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 83% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 83% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit!='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									  echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 83% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									  echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 83% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 83% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									  echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 83% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
//	End query of 83% requirements	

	 
					//	Begining query of 67% requirements	
								 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook!='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook='$cook' and habit!='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook!='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook='$cook' and habit!='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									  $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit!='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									  $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									  $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									  $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit!='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									   $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit!='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									  $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies!='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 67% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
//	End query of 67% requirements	

//	Begining query of 50% requirements	
								 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes!='$smokes' and cook!='$cook' and habit='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook!='$cook' and habit='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes!='$smokes' and cook='$cook' and habit!='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook='$cook' and habit!='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook!='$cook' and habit!='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook!='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									  $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol!='$alcohol' and smokes='$smokes' and cook='$cook' and habit='$habit' and studies!='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
// 10 query for 50%
//	Begining query of 50% requirements	
								 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook='$cook' and habit!='$habit' and studies!='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										</div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook='$cook' and habit!='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit!='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit!='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit='$habit' and studies!='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes='$smokes' and cook!='$cook' and habit!='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook!='$cook' and habit='$habit' and studies='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook='$cook' and habit='$habit' and studies!='$studies' and visitors!='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									 $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook='$cook' and habit!='$habit' and studies!='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
									 
									  $sql=mysqli_query($mysqli,"select * from roommate_char where alcohol='$alcohol' and smokes!='$smokes' and cook!='$cook' and habit!='$habit' and studies='$studies' and visitors='$visitors' and gender='$gender' and roommate='0' and student_id!='$aid'");
                                     if(mysqli_num_rows($sql)){
                                     while($co=mysqli_fetch_assoc($sql)){
									 
										 $sid=$co['student_id'];
										 $sq=mysqli_query($mysqli,"select * from roommate_char where student_id='$aid' AND roommate_id = $sid");
									 echo'
									 <div class="col-md-6">
										 <div class="panel panel-default">
										 <div style="background-color:#dbdbdb; color:#21299e; height:20px; font-size:14px; text-align:center; ">
									     This Room-mate have 50% of your requirements 
										 </div>
											<div class="panel-body bk-primary text-light">
												
                                                    <div class="stat-panel text-left">
													<div class="stat-panel-number h5 "> '.$co['firstName'].' '.$co['middleName'].' '.$co['lastName'].'
													<img src="user_images/'.$co['img'].'" style="width:190px; height:170px; float:left; padding-right:25px;" alt=""> 
													</div>
													<div class="stat-panel-number h6 ">'.$co['department'].'</div>
													<div class="stat-panel-number h6 ">'.$co['level'].'</div>
													<div class="stat-panel-number h6 ">'.$co['contactNo'].'</div>
													<div style="font-size:13px"><i class="fa fa-circle text-info""></i> Alcohol :'.$co['alcohol'].' <i class="fa fa-circle text-info""></i> Smoking :'.$co['smokes'].' <br> <i class="fa fa-circle text-info""></i> Cook :'.$co['cook'].' <i class="fa fa-circle text-info""></i> Clean :'.$co['habit'].' <br> <i class="fa fa-circle text-info""></i> Studious :'.$co['studies'].' <i class="fa fa-circle text-info""></i> Visitors :'.$co['visitors'].'
												'.(mysqli_num_rows($sq)? "<div style='text-align:center; padding-top:3px; float:right; font-size:11px; color:blue; height:22px; width:90px; background-color:white; border-radius:50%;'><i class='fa fa-check'></i>Request Sent</div>":"" ).' 
												</div>
												</div>
											</div>
											'.(mysqli_num_rows($sq)? '<a href="search_result.php?uid='.$sid.'" title="Unsend Request" onclick="return gettConfirmation()" class="block-anchor panel-footer">Unsend Request <i class="fa fa-arrow-right"></i> </a>':'<a href="search_result.php?id='.$sid.'" title="Send Request" onclick="return getConfirmation()" class="block-anchor panel-footer">Send Request <i class="fa fa-arrow-right"></i> </a>' ).' 
										</div>
									 </div>	
									 ';
									 }}
//	End query of 50% requirements		
									 
									
									 /** echo ' 
									 else{
									            <div class="col-md-12">
 									            <div class="panel panel-default">
									            <div class="panel-body bk-danger text-light">
												<div class="stat-panel text-center">
												
												<div class="stat-panel-number h6 ">The room-mate you search for is not available right now</div>
												</div>
												</div>
												</div>
								                </div> ';
								    exit(); 
									 } **/
									 
                                     ?>
                                     
									
									 </div>
                                     </div>
		                             </div>
			
									
									</div>
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