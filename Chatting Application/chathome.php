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
	<script type="text/javascript">
		function getuser(event){
			if(event.target.value){
				let form=document.getElementById("searchuser");
				let xhr=new XMLHttpRequest();
				xhr.open("post","getuser.php",true);
				xhr.onload=()=>{
					let chatuser=document.getElementById("chat-users");
					if(xhr.response){
						chatuser.innerHTML=xhr.response;
						console.log(xhr.response);
					}
					else{
						chatuser.innerHTML="No User Found";
					}
					
				}
				let formdata=new FormData(form);
				xhr.send(formdata);
			}
			else{
				let chatuser=document.getElementById("chat-users");
				chatuser.innerText="NO user exist";
				setTimeout(()=>{
					let xhr=new XMLHttpRequest();
					xhr.open("get","getallusers.php",true);
					xhr.onload=()=>{
						let chatuser=document.getElementById("chat-users");
						chatuser.innerHTML=xhr.response;
					}
					xhr.send();

				},1000);
			}
		}
	</script>
</head>
<body>
	<section class="container">
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
			<form method="post" id="searchuser" class="search-user" enctype="multipart/form-data">
				<input type="search" name="username" placeholder="Search here to start chat" onkeyup="getuser(event)"><button name="search-btn"><i class="fas fa-search"></i></button>
			</form>
			<div class="chat-users" id="chat-users">
			
			</div>
		</div>
	</section>
	<script>
		let xhr=new XMLHttpRequest();
		xhr.open("get","getallusers.php",true);
		xhr.onload=()=>{
			let chatuser=document.getElementById("chat-users");
			chatuser.innerHTML=xhr.response;
		}
		xhr.send();
	</script>
</body>
</html>	
