<?php
	session_start();
	include_once('inc/config.php');
	
	if(!isset($_SESSION['role']) ||  ($_SESSION['role'] != 2 && $_SESSION['role'] != 1)){ //判断登录权限。
		echo "无权限";
		exit();
	}
	
	$id = $_GET['id'];
	$db = new db;
	$plan = $db->select_one('mark_plan',array('id'=>$id));
	
	if($plan['user_id'] != $_SESSION['id'] && $_SESSION['role'] != 2){ //项目如果不是本人，并且不是教师访问，跳回index。
		echo "不是自己是项目不允许修改";
		exit();
	}
	
	if($plan['is_teacher'] == 1 && $_SESSION['role'] != 2){ //判断是否为教师指派任务，如果是则不允许本人修改。
		echo "教师指定的项目不允许学生修改";
		exit();
	}
	
	$db->delete('mark_plan',array('id'=>$id));
	
?>