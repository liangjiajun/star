<?php 
header("Content-type:text/html;charset=utf-8");
header('Content-type: application/json');
/*
	考勤类型
*/
include('config.php');

//获取回调函数名
$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);

// Get 的数据
if(isset($_GET['Classnum'])){
$Classnum = $_GET['Classnum'];/*学生学号*/
$sql ="SELECT * FROM attendance WHERE `number` = '$Classnum'  ORDER BY `teaching_date` DESC  LIMIT 5";
$array = "";
$result =mysql_query($sql); 
while($row = mysql_fetch_array($result)){
	$number = $row['number'];
	$date = $row['teaching_date'];/*日期*/
	$week_no = $row['week_no'];/*周*/
	$week = $row['week'];/*星期*/
	$attendance = $row['attendance'];/*考勤类型*/

	$topic = $row['topic_hour'];/*第几课*/
	if($row['attendance']=="病假"){
			$rate =0.05;
		}else if($row['attendance']=="迟到"){
			$rate =0.5;
		}else if($row['attendance']=="事假"){
			$rate =0.1;
		}else if($row['attendance']=="旷课"){
			$rate =1.5;
		}

	/*$sql ="SELECT * FROM conduct WHERE `number` = '$Classnum' AND `end_auditing_state` = 2 AND repeal_state = 0   ORDER BY `date` DESC LIMIT 5 ";
	$c_result = mysql_query($sql);
	$rate = '';
	while($r = mysql_fetch_array($c_result)) {
		$mark = $r['mark'];
		if($row['attendance']=="病假"){
			$rate =$mark-0.05;
		}else if($row['attendance']=="迟到"){
			$rate =$mark-0.5;
		}else if($row['attendance']=="事假"){
			$rate =$mark-0.1;
		}else if($row['attendance']=="旷课"){
			$rate =$mark-1.5;
		}

	}	*/
	$array[] = array('number'=>$number,'date'=>$date,'week_no'=>$week_no,'week'=>$week,'attendance'=>$attendance,'rate'=>$rate);
}

$arr=json_encode($array);/*格式化json数据*/
$json_data ="'$arr'";
echo $jsoncallback.'('.$json_data.')';  

}


	
