<?php
	include_once('config.php');
	session_start();
	$senderid=$_SESSION['userid'];
	if(!$senderid){
		header('location:login.php');
	}
	$receiverid=$_GET['userid'];
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
</head>
<body>
	<section class="container">
		<div class="header">
			<img src="./css/ramlogo.png" alt="logo">
			<p>RChat<span>App</span></p>
		</div>
		<div class="chat-home">
			<div class="chat-head">
				<a href="chathome.php"><i class="fas fa-arrow-left"></i></a>
				<?php echo '<img src="./uploads/'.$fetch['image'].'">';?>
				<div class="name-details">
					<?php echo '<p>'.$fetch['fname'].' '.$fetch['lname'].'</p>
					<p>'.$fetch['status'].' now</p>';?>
				</div>
			</div>
			<div class="chat-box">
				<?php
					$sql=mysqli_query($conn,"select * from message where (sender='$senderid' and receiver='$receiverid') or (sender='$receiverid' and receiver='$senderid') order by date");
					if(mysqli_num_rows($sql)>0){
						while($row=mysqli_fetch_assoc($sql)){
							if($row['sender']==$senderid){
								echo '<div class="sender-msg"><p>'.$row['message'].'</p></div>';
							}
							elseif($row['sender']==$receiverid){
								echo '<div class="receiver-msg"><p>'.$row['message'].'</p></div>';
							}
						}
					}
					else{
						echo "data not gathered";
					}


				?>
			</div>
			<form method="post" action="" class="message-box" enctype="multipart/form-data">
				<input type="text" name="message" placeholder="Type a message here" required><button name="message-btn"><i class="fas fa-paper-plane"></i></button>
			</div>
		</div>
	</section>
</body>
</html>	