<?php 
$link = mysql_connect('localhost','star','gzittc123456') or die("链接失败");
mysql_select_db('star');
mysql_query('set names utf8',$link);
