<?php 
/*
	用户的答题分数
*/
include('../config/config.php');
$score = $_POST['score'];
$username = $_POST['usernames'];
$type = $_POST['type'];
$time =time();


if(isset($username,$type)){
$sql="INSERT INTO `answer_results`(`respondents` ,`answer_type` ,`score` ,`answer_time`) VALUES('$username',  '$type',  '$score',  '$time')";
mysql_query($sql);
}

 
