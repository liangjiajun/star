<?php 
include('inc/config.php');
	date_default_timezone_set('PRC');
	$StartTime = $_POST['StartTime'];
	$StatusId = $_POST['StatusId'];
	$TaskId = $_POST['TaskId'];
	$date = date("Y-m-d H:i:s");
	if($StatusId == 'B'){
		echo $sql = "UPDATE taskmanagment SET `StartTime`='$StartTime',`StatusId`='I' WHERE `TaskId` = $TaskId";
		mysql_query($sql);
	}else{
		echo $sql = "UPDATE taskmanagment SET `EndTime`='$date',`StatusId`='D' WHERE `TaskId` = $TaskId";
		mysql_query($sql);
	}
?>


 