<?php
	include_once('config.php');
	session_start();
	$userid=$_SESSION['userid'];
	if(!$userid){
		header('location:login.php');
	}
	$select=mysqli_query($conn,"select * from registration where sl='$userid'");
	if(mysqli_num_rows($select)>0){
		$result=mysqli_fetch_assoc($select);
	}
	if(isset($_POST['logout'])){
		$row=mysqli_query($conn,"update registration set status='inactive' where sl='$userid'");
		if($row){
			unset($userid);
			session_destroy();
			header('location:login.php');
		}
		else{
			echo 'user not logouted';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RChat Application</title>
	<link rel="stylesheet" href="./css/chathome.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
	<section class="container">
		<div class="header">
			<img src="./css/ramlogo.png" alt="logo">
			<p>RChat<span>App</span></p>
		</div>
		<div class="chat-home">
			<div class="chat-head">
				<?php
				echo '<img src="./uploads/'.$result['image'].'">
				<div class="name-details">
					<p>'.$result['fname'].' '.$result['lname'].'</p>
					<span>'.$result['status'].' now</span>
				</div>'?>
				<form method="post" action=""><button name="logout">Logout</button></form>
			</div>
			<form method="post" action="" class="search-user" enctype="multipart/form-data">
				<input type="search" name="search" placeholder="Search here to start chat"><button name="search-btn"><i class="fas fa-search"></i></button>
			</form>
			<div class="chat-users">
			<?php
				if(isset($_POST['search-btn'])){
					$search=mysqli_real_escape_string($conn,$_POST['search']);

					$sql=mysqli_query($conn,"select * from registration where fname='$search' or lname='$search'");
					if(mysqli_num_rows($sql)>0){
						while($fetch=mysqli_fetch_assoc($sql)){
							$sender=$fetch['sl'];
							$sql1=mysqli_query($conn,"select * from message where sender='$sender'");
							if(mysqli_num_rows($sql1)){
								$fetch1=mysqli_fetch_assoc($sql1);
							}
							echo '<div><a href="chatarea.php?userid='.$fetch['sl'].'"><img src="./uploads/'.$fetch['image'].'" alt="logo image">
										<div class="details">
											<p>'.$fetch['fname'].' '.$fetch['lname'].'</p>
											<span>'.$fetch1['message'].'</span>
										</div><h6>'.$fetch['time'].'</h6><i class="fas fa-circle"></i>
										</a></div>';	
						}
					}
				}
				else{
					$sql=mysqli_query($conn,"select * from registration where sl!='$userid'");
					if(mysqli_num_rows($sql)>0){
						while($fetch=mysqli_fetch_assoc($sql)){
							$sender=$fetch['sl'];
							$sql1=mysqli_query($conn,"select * from message where sender='$sender'");
							if(mysqli_num_rows($sql1)){
								$fetch2=mysqli_fetch_assoc($sql1);
							}
							echo '<div><a href="chatarea.php?userid='.$fetch['sl'].'"><img src="./uploads/'.$fetch['image'].'" alt="logo image">
										<div class="details">
											<p>'.$fetch['fname'].' '.$fetch['lname'].'</p>
											<span>'.$fetch2['message'].'</span>
										</div><h6>'.$fetch['time'].'</h6><i class="fas fa-circle"></i>
										</a></div>';	
						}
					}
				}
			?>
			</div>
		</div>
	</section>
</body>
</html>	
