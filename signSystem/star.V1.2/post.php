<?php 
include('config/config.php');

if(isset($_FILES["file"]["name"])){
	$taskId  = $_GET['id'];/*类型ID*/
	$userId= $_GET['userId'];/*用户ID*/

	$name = explode('.',$_FILES["file"]["name"]);
	$gs = $name[count($name)-1];
	$newname =time().'.'.$gs;
	$path = "./upload/" . $newname;
	$time = time();// 存入时间

	if(move_uploaded_file($_FILES["file"]["tmp_name"],$path)){
		$sql = "INSERT INTO `task_works` (`task_title_id`, `user_id`, `time`, `path`) VALUES ('$taskId', '$userId', '$time', '$path')";
		mysql_query($sql);
	}
}


