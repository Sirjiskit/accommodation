
<?php if (isset($_SESSION['id']))
	
{ ?><div class="brand clearfix">
		<a href="#" class="logo" style="font-size:12px; color: white;">Accommodation portal</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li class="ts-account">
		<?php	include('config.php');
		$id=$_SESSION['id'];
         $query1 = "SELECT * FROM userRegistration WHERE id='$id'";
			     $result1 = mysqli_query($mysqli, $query1);
                $user = mysqli_fetch_assoc($result1);
			    $img = $user['img'];
			 ?>
				<a href="#"><img src="user_images/<?php  echo $img; ?>" class="ts-avatar hidden-side" alt=""> <?php  echo $user['firstName']; ?> <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="my-profile.php">My Account</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>

<?php
} else { ?>
<div class="brand clearfix">
		<a href="#" class="logo" style="font-size:20px; color: white;">Accommodation portal</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		
	</div>
	<?php } ?>
	