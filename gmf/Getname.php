<?php 
header("Content-type:text/html;charset=utf-8");
header('Content-type: application/json');
/*
	姓名、学号、班级
*/
include('config.php');

//获取回调函数名
$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);

// Get 的数据
$Classname = $_GET['Classname'];/*学生姓名*/
$sql ="SELECT * FROM students  WHERE `name` = '$Classname' ";
$rate = 100;
$array = "";
$result =mysql_query($sql); 
while($row = mysql_fetch_array($result)){
	$id =$row['id'];
	$name =$row['name'];
	$number = $row['number'];
	$class = $row['class'];
	$array[] = array('id'=>$id,'name'=>$name,'number'=>$number,'class'=>$class,'rate'=>'未统计');
}




$arr=json_encode($array);
$json_data ="'$arr'";
echo $jsoncallback.'('.$json_data.')';  








