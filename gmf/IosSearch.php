<?php

	header("Content-type:text/html;charset=utf-8");

	header('Content-type: application/json');



	$conn = mysql_connect('127.0.0.1','gmf','gzittc123456');

	mysql_select_db('gmf');

	mysql_set_charset('utf8');



	if(isset($_GET['name'])){

		$name = $_GET['name'];

	}else{

		$name = '';

	}



	$sql = "select * from students where name='$name'";

	$result = mysql_query($sql);

	$users = array();

	$i=0;

	while($row = mysql_fetch_assoc($result)){

		$users[$row['id']] = $row;

		$i++;

	}



	echo json_encode($users);


