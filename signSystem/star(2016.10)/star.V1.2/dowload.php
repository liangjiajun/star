<?php 
include('config/config.php');
include('config/functions.php');


$id=$_GET['id'];
$sql="SELECT * FROM `task_works` WHERE id ='$id'";
$task_rusult = mysql_query($sql);
$row_task = mysql_fetch_array($task_rusult);
$path = $row_task['path'];
$taskId  = $row_task['task_title_id'];
$userId = $row_task['user_id'];
$gs=get_extension($row_task['path']);

/*
	获取文件名
*/
	$sql = "SELECT * FROM  task_title WHERE id ='$taskId'";
	$result = mysql_query($sql);
	$r=mysql_fetch_array($result);
	$title_name = $r['title'];	
/*
	获取用户名
*/
	$sql = "SELECT * FROM  users WHERE id ='$userId'";
	$nameResult = mysql_query($sql);
	$n=mysql_fetch_array($nameResult);
	$username=$n['username'];


$name = $title_name.'_'.$username.'.'.$gs;


$file = fopen ( $path, "r" );    

Header ( "Content-type: application/octet-stream" );    
Header ( "Accept-Ranges: bytes" );    
Header ( "Accept-Length: " . filesize ($path) );    
Header ( "Content-Disposition: attachment; filename=".$name);   
echo fread ( $file, filesize ($path) );    
fclose ( $file );    
exit (); 

