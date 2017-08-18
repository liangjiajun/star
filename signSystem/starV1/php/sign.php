<?php
require_once 'config.php';

function strTime($time){
	return date('H:i:s',$time);
}




if(isset($_POST['signListData'])){
	$arrAll=[];//总数据
	$data = [];//一周内的所有时间
	$userAll=[];//签到数据

	/*
		用户数据
	*/
	$sql = "SELECT `id`,`name`,`show_switch` FROM `users_data` WHERE  `show_switch` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array(2));
	$users = $preObj->fetchAll(PDO::FETCH_ASSOC);

	/*获取一周的数据*/

	$day = isset($_POST['week']) ? $_POST['week']*1 : date('N')*1;//获取一周星期几
	$isdate = isset($_POST['day']) ? $_POST['day'] : date('Y-m-d');//获取当前日期

	for($i=$day-1;$i>0;$i--){//获取一周内当前星期数之前的日期
	    $today = date_create($isdate);
	    date_sub($today,date_interval_create_from_date_string($i.'days'));
	    array_push($data, date_format($today,"Y-m-d"));
	}

	for($f=0;$f<8-$day;$f++){//获取一周内当前星期数之后的日期
	    $today = date_create($isdate);
	    date_add($today,date_interval_create_from_date_string($f.'days'));
	    array_push($data, date_format($today,"Y-m-d"));
	}



	$arrAll['time'] = $data;
	$dateDay = date('Y-m-d',time());
		foreach ($users as $k => $u) {
			foreach ($data as $v) {
				/*根据用户id搜索用户签到的数据*/
				$sql = "SELECT * FROM `sign_data` WHERE `new_date` = ? AND `user_id` = ? ";
				$preObj = $db->prepare($sql);
				$preObj->execute(array($v,$u['id']));
				$signs = $preObj->fetch(PDO::FETCH_ASSOC);
				/*监测数据是否存在，存在才输出*/
				if($signs){
					$signs['start_time'] = strTime($signs['start_time']);
					$signs['end_time'] = $signs['end_time']!=0 ? strTime($signs['end_time']) : "未签退";
				}
				$userAll[$u['name']][$v] = $signs;
		}
	}
	$arrAll['sign'][] = $userAll;
	echo json_encode($arrAll);
}




/*考勤数据的统计*/

if(isset($_POST['signData'])){
	$data=[];
	$today = date('Y-m-d',time());
	$time = time();
	/*今天签到人数*/
	$sign = $db->query('SELECT count(*) AS num FROM `sign_data` WHERE   `new_date` = "'.$today.'" ');
	$sign->setFetchMode(PDO::FETCH_ASSOC);
	$signNum = $sign->fetch();
	$data['signNum'] = $signNum['num'];

	/*今天迟到人数*/
	$last = $db->query('SELECT count(*) AS num FROM `sign_data` WHERE  `new_date` = "'.$today.'" AND `sign_description` = 4 ');
	$last->setFetchMode(PDO::FETCH_ASSOC);
	$lastNum = $last->fetch();
	$data['lastNum'] = $lastNum['num'];


	/*最早签到*/
	$sign1 = $db->query('SELECT * FROM `sign_data`   WHERE `new_date` = "'.$today.'" ORDER BY `start_time` ASC LIMIT 1 ');
	$sign1->setFetchMode(PDO::FETCH_ASSOC);
	$signEarly = $sign1->fetch();
	$uid = $signEarly['user_id'];
	$user =  $db->query('SELECT id,name FROM `users_data`   WHERE `id` = "'.$uid.'"  ');
	$user->setFetchMode(PDO::FETCH_ASSOC);
	$userEarly = $user->fetch();
	$data['signEarly'] = $userEarly['name'];

	/*最晚签退的人*/
	$end_time_last = "16:30:00";
	$last_time = strtotime($today.' '.$end_time_last);
	$sign2 = $db->query('SELECT * FROM `sign_data`   WHERE`end_time` > '.$last_time.'  AND`new_date` = "'.$today.'" ORDER BY `end_time` DESC LIMIT 1 ');
	$sign2->setFetchMode(PDO::FETCH_ASSOC);
	$signEarly = $sign2->fetch();
	$uid1 = $signEarly['user_id'];
	$user =  $db->query('SELECT id,name FROM `users_data`   WHERE `id` = "'.$uid1.'"  ');
	$user->setFetchMode(PDO::FETCH_ASSOC);
	$userLast = $user->fetch();
	$data['signLast'] = $userLast['name'];

	echo json_encode($data);

}

if(isset($_POST['signMonthDate'])){
	$signDur = [];
	/*获取最早的一个月份*/
	$sql = "SELECT start_time FROM `sign_data` LIMIT 1";
	$preObj = $db->query($sql);
	$signEarly = $preObj->fetch(PDO::FETCH_ASSOC);
	$signDur['early'] = $signEarly['start_time'];

	/*获取最新的一个月份*/
	$sql = "SELECT start_time FROM `sign_data` ORDER BY `start_time` DESC LIMIT 1";
	$preObj = $db->query($sql);
	$signLast = $preObj->fetch(PDO::FETCH_ASSOC);
	$signDur['last'] = $signLast['start_time'];

	/*获取从开始月份到结束月份的月份*/
	function monthList($start,$end){
		if(!is_numeric($start)||!is_numeric($end)||($end<=$start)) return '';
		$start=date('Y-m',$start);
		$end=date('Y-m',$end);

		$start=strtotime($start.'-01');
		$end=strtotime($end.'-01');
		$i=0;
		$d=array();
		while($start<=$end){
			$d[$i]=trim(date('Y-m',$start),' ');
			$start+=strtotime('+1 month',$start)-$start;
			$i++;
		}
		return $d;
	}
	echo json_encode(monthList($signDur['early'],$signDur['last']));
}


if(isset($_GET['signMonthDateExprot'])){
	$data=[];
	$today_y_m = $_GET['date'];
	$octMonthDays = getMonthDays($today_y_m);
	// 拉取相关考勤数据
	$sql = "SELECT id,name,show_switch FROM `users_data` WHERE `show_switch` = 2 ";
	$preObj = $db->query($sql);
	$userAll = $preObj->fetchAll(PDO::FETCH_ASSOC);
	foreach ($userAll as $k => $v) {
		$sql = "SELECT * FROM `sign_data` WHERE  `new_date` LIKE '".$today_y_m."%' ";
		$preObj = $db->query($sql);
		$signALL = $preObj->fetchAll(PDO::FETCH_ASSOC);
		foreach ($signALL as $sv) {
			if($v['id']==$sv['user_id']){
				foreach ($octMonthDays as $m) {
					$date_m = explode(' ',$m)[0];
					if($date_m==$sv['new_date']){
						$data[$v['name']][$m][][] = $sv;
					}
				}
			}
		}

	}
	/*设置csv格式*/
	$str = "姓名,工作日期,签到时间,签退时间,出勤状态\n";
	$str = iconv('UTF-8','GBK', $str);
	foreach ($data as $key => $value) {
		foreach ($value as $d => $date) {
			foreach ($date as $k) {
				foreach ($k as $v) {
					$name = iconv('UTF-8','GBK', $key);//姓名
					$day = iconv('UTF-8','GBK', $d);//时间
					$start_time = date('H:i:s',$v['start_time']);
					$end_time = $v['end_time']==0 ? "------" : date('H:i:s',$v['end_time']);
					$active = '正常';
					switch ($v['sign_description']) {
						case '1':
							$active = '未签退';
							break;
						case '2':
							$active = '早退';
							break;
						case '3':
							$active = '请假';
							break;
						case '4':
							$active = '迟到';
							break;
						case '5':
							$active = '假日';
							break;
					}
					$active = iconv('UTF-8','GBK', $active);
					$str.=$name.",".$day.",".$start_time.",".$end_time.",".$active."\n";
				}
			}
		}
	}
	$csvname = $today_y_m."月份考勤数据".'.csv';
	// echo $str;
	csv($csvname,$str);
}














