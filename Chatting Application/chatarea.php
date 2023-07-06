<?php
	include_once('config.php');
	session_start();
	$senderid=$_SESSION['userid'];
	echo '<script>console.log('.$senderid.');</script>';
	if(!$senderid){
		header('location:login.php');
	}
	$receiverid=$_GET['userid'];
	echo '<script>console.log('.$receiverid.');</script>';
	if(!$receiverid){
		header('location:chathome.php');
	}
	$select=mysqli_query($conn,"select * from registration where sl='$senderid'");
	if(mysqli_num_rows($select)>0){
		$fetch=mysqli_fetch_assoc($select);
	}
	if(isset($_POST['message-btn'])){
		$date=date("Y-m-d H:i:s");
		$message=mysqli_real_escape_string($conn,$_POST['message']);
		$sql=mysqli_query($conn,"insert into message(sender,receiver,message,date) values('$senderid','$receiverid','$message','$date')");
		if($sql){
			echo '<script>
					var form=document.getElementById("form");
					console.log(form.message);
				</script>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RChat Application</title>
	<link rel="stylesheet" href="./css/chatarea.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
	<script type="text/javascript">
		setInterval(()=>{
			let xhr=new XMLHttpRequest();
			xhr.open("GET","getchat.php?userid=<?php echo $receiverid ?>",true);
			xhr.onload=()=>{
				var chatbox=document.getElementById("chat-box");
				let form=document.getElementById("form");
				chatbox.innerHTML=xhr.response;
				console.log(xhr.response);
				chatbox.scrollTop=chatbox.scrollHeight;
			};
			xhr.send();
		},500);
	</script>
</head>
<body>
	<section class="container">
		<div class="chat-home">
			<div class="chat-head">
				<a href="chathome.php"><i class="fas fa-arrow-left"></i></a>
				<?php echo '<img src="./uploads/'.$fetch['image'].'">';?>
				<div class="name-details">
					<?php echo '<p>'.$fetch['fname'].' '.$fetch['lname'].'</p>
					<span>'.$fetch['status'].' now</span>';?>
				</div>
			</div>
			<div class="chat-box" id="chat-box">
				Loading...
			</div>
			<form method="post" action="" class="message-box" enctype="multipart/form-data" id="form">
				<input type="text" name="message" placeholder="Type a message here" required><button name="message-btn"><i class="fas fa-paper-plane"></i></button>
			</form>
		</div>
	</section>
</body>
</html>	