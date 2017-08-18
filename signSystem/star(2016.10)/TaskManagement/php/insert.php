<?php 
include('inc/config.php'); 
$sub = $_POST['sub'];
	if(isset($sub)){
		$m = addslashes($_POST['TaskDescription']);
		$m = strip_tags($m);
		$sql="INSERT INTO  `taskmanagment` (`TaskDescription` ,`StatusId`)VALUES ('$m','B');";
		mysql_query($sql);
		header('location:../index.php');
	}
?>

  