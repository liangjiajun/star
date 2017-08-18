<?php 
/*
	信息推送页面
*/

include('config.php');

if(isset($_GET['information'])){
	header("Content-type:text/html;charset=utf-8");
	header('Content-type: application/json');
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	$num = $_GET['information'];
	$sql = 'SELECT * FROM `gmf`.`information` ORDER BY `create_time` DESC LIMIT '.$num.'';
	$r = mysql_query($sql);
	$data=array();
	while($row = mysql_fetch_assoc($r)){
		$data = array('id'=>$row['id'],'content_info'=>$row['content_info'],'open'=>$row['open'],'create_time'=>$row['create_time']);
	}
	$data=json_encode($data);
	echo $jsoncallback.'('.$data.')';  
}
 