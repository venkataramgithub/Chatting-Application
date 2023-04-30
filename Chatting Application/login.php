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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<script>
		function messagehide() {
			dom=document.getElementById("message").style;
			dom.visibility="hidden";
		}
		function showpassword() {
			var eyeopen=document.getElementById("eyeopen").style;
			var eyeclose=document.getElementById("eyeclose").style;
			var password=document.getElementById("password");
			if(password.type=="password"){
				password.type="text";
				eyeclose.display="none";
				eyeopen.display="block";
			}
			else{
				password.type="password";
				eyeclose.display="block";
				eyeopen.display="none";
			}

		}
	</script>
</head>
<body>
	<?php
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
				echo '<div class="message" id="message">Status Not updated<span onclick="messagehide()">&times;</span></div>';
			}
			
		}
		else{
			echo '<div class="message" id="message">Entered details are incorrect<span onclick="messagehide()">&times;</span></div>';
		}
	}
	?>
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
					<input type="email" name="email" placeholder="Enter Your Email" required>
				</div>
				<div class="form-group">
					<label>Enter Password</label>
					<input type="password" name="password" id="password" placeholder="Enter Your Password" required>
					<span id="eyeopen" onclick="showpassword()"><i class="fas fa-eye"></i></span><span id="eyeclose" onclick="showpassword()"><i class="fas fa-eye-slash"></i></span>
				</div>
				<button name="submit">Login</button>
				<span style="margin-left:100px;">Don't hava an account?<a href="signup.php">signup now</a></span>
			</form>
		</div>
	</section>
</body>
</html>	