<?php
session_start();


mysql_connect('127.0.0.1','star','gzittc123456') or die(11111);
// mysql_connect('127.0.0.1','root','') or die(11111);



mysql_select_db('star') or die(222222);
mysql_query('set names utf8');
date_default_timezone_set('PRC');
?>
