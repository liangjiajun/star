<?php 



session_start();



mysql_connect('localhost','star','gzittc123456')  or die('连接失败1');

mysql_select_db('star') or die('连接失败2');

mysql_query('set names utf8');

date_default_timezone_set('PRC');




if(isset($_SESSION['user'])){ //计算在线时长


	$user = $_SESSION['user'];

	$sql = "SELECT * FROM `sign` WHERE name = '$user' ORDER BY id DESC LIMIT 1";
	$r = mysql_query($sql);
	$row = mysql_fetch_array($r);


	$sql = "UPDATE `sign` SET `datetime2` = '".time()."' WHERE id = '".$row['id']."'";
	mysql_query($sql);

}


 ?>