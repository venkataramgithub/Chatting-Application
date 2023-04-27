<?php
	include_once('config.php');
	session_start();
	if(isset($_POST['submit'])){
		$email=mysqli_real_escape_string($conn,$_POST['email']);
		$password=mysqli_real_escape_string($conn,$_POST['password']);

		$select=mysqli_query($conn,"select * from registration where email='$email' and password='$password'");
		if(mysqli_num_rows($select)>0){
			$row=mysqli_query($conn,"update registration set status='Active' where email='$email'");
			if($row){
				$result=mysqli_fetch_assoc($select);
				$_SESSION['userid']=$result['sl'];
				header('location:chathome.php');
			}
			else{
				echo 'status not updated';
			}
			
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RChat Application</title>
	<link rel="stylesheet" href="./css/login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
	<section class="container">
		<div class="header">
			<img src="./css/ramlogo.png" alt="logo">
			<p>RChat<span>App</span></p>
		</div>
		<div class="register">
			<p>RChat Login</p>
			<form method="post" action="" enctype="multipart/form-data">
				<div class="form-group">
					<label>Enter Email</label>
					<input type="email" name="email" required>
				</div>
				<div class="form-group">
					<label>Enter Password</label>
					<input type="password" name="password" required>
					<p><input type="checkbox" name="check">show password</p>
				</div>
				<button name="submit">Login</button>
				<span>Don't hava an account?<a href="signup.php">signup now</a></span>
			</form>
		</div>
	</section>
</body>
</html>	