<?php 
header("Content-type:text/html;charset=utf-8");
header('Content-type: application/json');
/*
	扣分类型
*/
include('config.php');




//获取回调函数名
$jsoncallback = htmlspecialchars($_REQUEST['jsoncallback']);

// Get 的数据
//if(isset($_GET['number'])){
$number = $_GET['number'];/*学生学号*/

echo $number;



echo $sql ="SELECT * FROM conduct WHERE `number` = '$number'";
$array = "";
$result =mysql_query($sql); 
while($row = mysql_fetch_array($result)){

	$array[]= array('number'=>$number);
}

$arr=json_encode($array);/*格式化json数据*/
$json_data ="'$arr'";
echo $jsoncallback.'('.$json_data.')';  

}


	
