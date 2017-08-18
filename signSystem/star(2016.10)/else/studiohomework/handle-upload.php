<?php
include("config.php");

if(isset($_FILES["file"]["name"])){
	$subject_id  = $_GET['subject_id'];
	$name = explode('.',$_FILES["file"]["name"]);
	// print_r($name);
	$gs = $name[count($name)-1];
	$newname = time().'.'.$gs;
	$path = "./upload/" . $newname;
	$time = time();
	if(move_uploaded_file($_FILES["file"]["tmp_name"],$path)){
		$sql = "INSERT INTO studio_homework_jobs VALUES (NULL,'$subject_id','".$_FILES["file"]["name"]."','$path','$time')";
		mysql_query($sql);
				
	}
	
}
