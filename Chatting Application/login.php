<?php
	include_once('config.php');
	session_start();
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
		function refreshform(){
			let form=document.getElementById("form");
			if(form.submit()){
				form.reset();
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
				$message="Status Not updated";
			}
			
		}
		else{
			$message="Entered details are incorrect";
		}
	}
	?>
	<section class="container">
		<div class="register">
			<p>Login</p>
			<?php
				if(isset($message)){
					echo '<h4 style="color:red;margin:5px 0px;text-align:center;">'.$message.'</h4>';
				}
			?>
			<form method="post" action="" enctype="multipart/form-data" id="form">
				<div class="form-group">
					<label>Enter Email</label>
					<input type="email" name="email" placeholder="Enter Your Email" required>
				</div>
				<div class="form-group">
					<label>Enter Password</label>
					<input type="password" name="password" id="password" placeholder="Enter Your Password" required>
					<span id="eyeopen" onclick="showpassword()"><i class="fas fa-eye"></i></span><span id="eyeclose" onclick="showpassword()"><i class="fas fa-eye-slash"></i></span>
				</div>
				<button name="submit" onclick="refreshform()">Login</button>
				<h2>Don't hava an account?<a href="signup.php">signup now</a></h2>
			</form>
		</div>
	</section>
</body>
</html>	