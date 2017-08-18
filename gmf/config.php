<?php 
$link = mysql_connect('127.0.0.1','root','')or die('数据库链接失败！');
		mysql_query('set names utf8');
		mysql_select_db('gmf',$link);

