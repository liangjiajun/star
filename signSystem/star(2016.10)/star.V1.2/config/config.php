<?php
session_start();
date_default_timezone_set('PRC');
$link = mysql_connect('localhost','star','gzittc123456') or die('connect is die!'.mysql_error());
        mysql_query('set names utf8');
        mysql_select_db('star',$link);