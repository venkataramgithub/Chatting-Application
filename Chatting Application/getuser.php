<?php
include_once('config.php');
session_start();
$userid=$_SESSION['userid'];
$username=$_POST['username'];
$sql=mysqli_query($conn,"select * from registration where fname='$username' or lname='$username' and sl!='$userid'");
if(mysqli_num_rows($sql)>0){
	$output='';
	while($fetch=mysqli_fetch_assoc($sql)){
		$sender=$fetch['sl'];
		$sql1=mysqli_query($conn,"select * from message where sender='$sender'");
		if(mysqli_num_rows($sql1)){
			$fetch1=mysqli_fetch_assoc($sql1);
		}
		$output.='<div class="list">
			<a href="chatarea.php?userid='.$fetch['sl'].'"><img src="./uploads/'.$fetch['image'].'" alt="logo image">
				<div class="details">
					<p>'.$fetch['fname'].' '.$fetch['lname'].'</p>
					<span>'.$fetch1['message'].'</span>
				</div>
				<div class="status">
					<h6>'.$fetch['time'].'</h6>
					<i class="fas fa-circle"></i>
				</div>
			</a>
			</div>';	
	}
	echo $output;
}

?>