<?php
	include_once('config.php');
	session_start();
	$senderid=$_SESSION['userid'];
	$receiverid=$_GET['userid'];
	$output='';
	$sql=mysqli_query($conn,"select * from message where (sender='$senderid' and receiver='$receiverid') or (sender='$receiverid' and receiver='$senderid') order by date");
	if(mysqli_num_rows($sql)>0){
		while($row=mysqli_fetch_assoc($sql)){
			if($row['sender']==$senderid){
				$output.='<div class="sender-msg">'.$row['message'].'</div>';
			}
			elseif($row['sender']==$receiverid){
				$output.='<div class="receiver-msg">'.$row['message'].'</div>';
			}
		}
		echo $output;
	}
	else{
		echo "data not present";
	}
?>