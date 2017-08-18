<?php 

//清除POST的多余空格
function post($param)
{
	return trim($_POST[$param]);
}

//页面跳转
function jump($u)
{
	header('location:'.$u);
}

//时间戳相减后的总时长运算 ($second时间戳相减后的结果)
function time2string($second){
	$second = $second%(3600*24);
	$hour = floor($second/3600);
	$second = $second%3600;
	$minute = floor($second/60);
	$second = $second%60;

	return $hour.'小时'.$minute.'分'.$second.'秒';

}
