<?php 

include('../config/config.php'); 
date_default_timezone_set('PRC');


if(!isset($_SESSION['user'])){
	header("Location:index.php");
}

if(isset($_SESSION['sign_id'] )){
	$getID = $_SESSION['sign_id'];
}


$time = time();	
$sql="UPDATE `sign` SET  `content` = '' , `datetime2` = '$time'  WHERE  `sign`.`id` ='$getID' ";
mysql_query($sql);
session_unset('user');		


$url = getenv("HTTP_REFERER");
header("Location:".$url);


 ?>



