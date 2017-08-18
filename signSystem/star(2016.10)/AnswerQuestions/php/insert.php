<?php  
	include('../config/config.php');
// 添加题库
	$sql ="SELECT * FROM answer_question ";
	mysql_query($sql);
	$issueContent =htmlspecialchars($_POST['issueContent']);
	$issue1 =htmlspecialchars($_POST['issue1']);
	$issue2 =htmlspecialchars($_POST['issue2']);
	$issue3 =htmlspecialchars($_POST['issue3']);
	$rightIssue =htmlspecialchars($_POST['rightIssue']);
	$type = $_POST['type'];
	$sub = $_POST['sub'];

// print_r($rightIssue);

	if(isset($sub,$issueContent,$issue1,$issue2,$issue3,$rightIssue)){
		$sql="INSERT INTO `answer_question` (`issueContent` ,`issue1` ,`issue2` ,`issue3` ,`issue4` ,`rightIssue` ,`askType`)VALUES 
			('$issueContent','$issue1','$issue2','$issue3','$rightIssue','$rightIssue',  '$type')";
		mysql_query($sql);
		// print_r($sql);
		header('location:../view/addquestion.php');
	}else{
		header('location:../view/index.php');
	}


  