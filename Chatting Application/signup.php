<?php
	include_once('config.php');	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RChat Application</title>
	<link rel="stylesheet" href="./css/signup.css">
	<script type="text/javascript">
		function messagehide() {
			dom=document.getElementById("message").style;
			dom.visibility="hidden";
		}
	</script>
</head>
<body>
	<?php
		if(isset($_POST['submit'])){
			$fname=mysqli_real_escape_string($conn,$_POST['fname']);
			$lname=mysqli_real_escape_string($conn,$_POST['lname']);
			$gender=mysqli_real_escape_string($conn,$_POST['gender']);
			$email=mysqli_real_escape_string($conn,$_POST['email']);
			$password=mysqli_real_escape_string($conn,$_POST['password']);
			$phone=mysqli_real_escape_string($conn,$_POST['phone']);
			
			$image=$_FILES['image']['name'];
			$image_temp_name=$_FILES['image']['tmp_name'];

			$select=mysqli_query($conn,"select * from registration where email='$email' and password='$password'");
			if(mysqli_num_rows($select)>0){
				echo '<div class="message" id="message">User already exist<span onclick="messagehide()">&times;</span></div>';
			}
			else{
				$sql=mysqli_query($conn,"insert into registration(fname,lname,gender,email,password,phone,image) values('$fname','$lname','$gender','$email','$password','$phone','$image')");
				if($sql){
					move_uploaded_file($image_temp_name,'uploads/'.$image);
					echo '<div class="message" id="message">Data uploaded successfully<span onclick="messagehide()">&times;</span></div>';
					header('location:login.php');
				}
			}
		}
	?>
	<section class="container">
		<div class="register">
			<p>RChat SignUp</p>
			<form method="post" action="" enctype="multipart/form-data">
				<div class="name-group">
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="fname" placeholder="Enter FirstName" required>
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="lname" placeholder="Enter LastName" required>
					</div>
				</div>
				<div class="form-group">
					<label>Gender</label>
					<select name="gender" required>
						<option>select gender</option>
						<option>Male</option>
						<option>Female</option>
						<option>Others</option>
					</select>
				</div>
				<div class="form-group">
					<label>Enter Email</label>
					<input type="email" name="email" placeholder="Enter Your Email" required>
				</div>
				<div class="form-group">
					<label>Enter Password</label>
					<input type="password" name="password" placeholder="Enter Your Password" required>
				</div>
				<div class="form-group">
					<label>Enter Phone</label>
					<input type="text" name="phone" placeholder="Enter Your Phone" required>
				</div>
				<div class="form-group">
					<label>Select Image</label>
					<input type="file" name="image" required>
				</div>
				<button name="submit">SignUp</button>
				<h2 style="margin-left:150px;">Already signed up?<a href="login.php">login now</a></h2>
			</form>
		</div>
	</section>
</body>
</html>
	</section>
</body>
</html>	