<?php 
session_start();
date_default_timezone_set('PRC');
require_once 'inc/db.php';
require_once 'inc/fun.php';

$config=[
	'user'=>'root',
	'pass'=>'',
	'dbsn'=>'star2'
];

$db = new db;


