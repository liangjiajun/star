<?php 
header("Content-type:text/html;charset=utf-8");
header('Content-type: application/json');

include('config.php');

//获取回调函数名
$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);

/*
	扣分类型
*/

if(isset($_GET['Classnum'])){

	$where_type = '';
	$where_attendance = '';
	if(isset($_GET['type'])){
		$get_type = $_GET['type'];
		if($get_type <= 3){
			$where_type = "AND `type` = ".$_GET['type']." ";
			$where_attendance = " AND 1=2 ";
		}else if($get_type == 4){
			$where_type = "AND 1 = 2 ";
			$where_attendance = "AND `attendance` = '病假' ";
		}else if($get_type == 5){
			$where_type = "AND 1 = 2 ";
			$where_attendance = "AND `attendance` = '迟到' ";
		}else if($get_type == 6){
			$where_type = "AND 1 = 2 ";
			$where_attendance = "AND `attendance` = '事假' ";
		}else if($get_type == 7){
			$where_type = "AND 1 = 2 ";
			$where_attendance = "AND `attendance` = '旷课' ";
		}else if($get_type == 8){
			$where_type = "AND 1 = 2 ";
			$where_attendance = "AND `attendance` = '早退' ";
		}
	}

	$where_date = "AND `date` > '2016-03-01' ";
	$where_teaching_date = "AND `teaching_date` > '2016-03-01' ";
	if(isset($_GET['date']) && isset($_GET['semester'])){
		if($_GET['semester'] == 1){
			$get_date = $_GET['date'].'-9-1';
			$get_date_end = ((integer)$_GET['date']+1).'-3-1';
			$where_date = "AND `date` > '$get_date' AND `date` < '$get_date_end' ";
			$where_teaching_date = "AND `teaching_date` > '$get_date' AND `teaching_date` < '$get_date_end' ";
		}else{
			$get_date = ((integer)$_GET['date']+1).'-3-1';
			$get_date_end = ((integer)$_GET['date']+1).'-9-1';
			$where_date = "AND `date` > '$get_date' AND `date` < '$get_date_end' ";
			$where_teaching_date = "AND `teaching_date` > '$get_date' AND `teaching_date` < '$get_date_end' ";
		}		
	}

$Classnum = $_GET['Classnum'];/*学生学号*/
$sql ="SELECT * FROM conduct WHERE `number` = '$Classnum' AND `end_auditing_state` = 2 AND `repeal_state` = 0 $where_date $where_type ORDER BY 'date' DESC";

$array = array();
$result =mysql_query($sql); 



$sql = "INSERT INTO `log` VALUES( NULL,'$Classnum','".time()."')";
mysql_query($sql);



while($row = mysql_fetch_array($result)){
	/*
		$type:违纪类型(1加分2处分3违纪)
		$number:学号
		$record：违纪备注
		$date：处置日期
	*/
	$type =$row['type'];
	$number = $row['number'];
	$record = $row['record'];
	$record=str_replace("\r\n","", $record); 
	$mark=$row['mark'];
	$date = $row['date'];
	$array[]= array('type'=>$type,'number'=>$number,'record'=>$record,'date'=>$date,'mark'=>$mark,'topic'=>0);
}
/*
	考勤类型
*/
$sql ="SELECT * FROM attendance WHERE `attendance`!='公假' and `number` = '$Classnum' $where_teaching_date $where_attendance ORDER BY 'teaching_date' DESC";
$attendance_result =mysql_query($sql); 
while($row = mysql_fetch_array($attendance_result)){
	/*
		number=日期
		week_no=周
		week=星期
		attendance=考勤类型(4:病假、5:事假、6:旷课、7:早退)
		topic=第几课
	*/
	$number = $row['number'];
	$date = $row['teaching_date'];
	$week_no = $row['week_no'];
	$week = $row['week'];
	$attendance = $row['attendance'];
	$topic = $row['topic_hour'];
	if($row['attendance']=="病假"){
		$type=4;
		$rate =0.05;
	}else if($row['attendance']=="迟到"){
		$type=5;
		$rate =0.5;
	}else if($row['attendance']=="事假"){
		$type=6;
		$rate =0.1;
	}else if($row['attendance']=="旷课"){
		$type=7;
		$rate =1.5;
	}else if($row['attendance']=="早退"){
		$type=8;
		$rate =0.5;
	}
	$array[]= array('type'=>$type,'number'=>$number,'record'=>$attendance,'date'=>$date,'mark'=>$rate,'topic'=>$topic);
}

//多维数组排序
if(!empty($array)){
	foreach ($array as $row_array){
		$key_array[] = $row_array['date']; 
	} 
	array_multisort($key_array,SORT_DESC,$array);
}

$arr=json_encode($array);
$json_data ="'$arr'";
echo $jsoncallback.'('.$json_data.')';  

}




	
