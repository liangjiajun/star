<?php 
/*
	题目判断对错页面
*/
include('../config/config.php');

$getId = $_GET['answerId'];
// 当前问题的ID
$iss = htmlspecialchars($_GET['issue']);
// 当前点击的那个选项的内容

$sql = "SELECT * FROM answer_question";
$result = mysql_query($sql);
$answer = array();
while($row = mysql_fetch_array($result)){
	$answer[$row['id']] = $row['rightIssue'];
}

if($answer[$getId] == $iss){
	echo '1-'.$answer[$getId];
}else{
	echo '0-'.$answer[$getId];
}










