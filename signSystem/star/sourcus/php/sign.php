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
	$sql = "SELECT `id`,`name`,`show_switch` FROM `users_data` WHERE  `show_switch` = ? ORDER BY `show_switch` DESC";
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
				/*根据用户数据搜索用户签到的数据*/
				$sql = "SELECT * FROM `sign_data` WHERE `new_date` = ? AND `user_id` = ? ";
				$preObj = $db->prepare($sql);
				$preObj->execute(array($v,$u['id']));
				$signs = $preObj->fetch(PDO::FETCH_ASSOC);

				$startActive = "未签到";

				if($signs){
					if(strTime($signs['end_time']) < '16:30:00' && $signs['new_date']==$dateDay){
						
						$endActive =" ";
					
					}else if(strTime($signs['end_time']) < '16:30:00' || $signs['end_time'] ==0 ){
						$endActive = "未签退";
					}else{
						$endActive = strTime($signs['end_time']);
					}

					$signs['start_time']= $signs['start_time']!=0 ? strTime($signs['start_time']) : $startActive;
					$signs['end_time']= $endActive;


				}
				$userAll[$u['name']][$v] = $signs;

		}
	}

	$arrAll['sign'][] = $userAll;

echo json_encode($arrAll);



}



















