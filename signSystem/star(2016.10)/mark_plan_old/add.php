<?php
	session_start();
	include_once('inc/db.php');
	
	if(!isset($_SESSION['role']) ||  ($_SESSION['role'] != 2 && $_SESSION['role'] != 1)){
		echo "没有权限";
		exit();
	}
	
	if(!empty($_POST)){
		$data['start_date'] = $_POST['start_date'];
		$data['end_date'] = $_POST['end_date'];
		$data['content'] = $_POST['content'];
		$data['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : $_SESSION['id'];
		$data['is_teacher'] = isset($_POST['user_id']) ? 1 : 0;
		
		$db = new db;
		$db->insert('mark_plan',$data);
		exit();
	}
?>