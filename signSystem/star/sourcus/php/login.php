<?php 
require_once 'config.php';

if(isset($_POST['sub'])){
	$name = $_POST['username'];
	$pass = $_POST['userpass'];
	$err='';
	
	$sql = "SELECT * FROM `users_data` WHERE `name` = ? AND `password` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($name,md5($pass)));
	$user = $preObj->fetch(PDO::FETCH_ASSOC);
	$gip =$user['id']==9 || $user['id']==14 || $user['id']==15  ? null : GetIP();

	if(!empty($user)){	
		if(isset($gip) && $user['ip_plane']=="" && $user['id']!=9&& $user['id']!=14&& $user['id']!=15){
			$db->prepare("UPDATE users_data SET ip_plane = ? WHERE id = ?")->execute(array($gip, $user['id']));
		}
		if($user['show_switch']>1 && $user['ip_plane']==$gip){
			setcookie("user", " ", time()-60*60*24*30);
			$start_time_id='';
			$time = time();
			$toDay = date('Y-m-d',$time);

			/*已当前日期（年日月）为条件搜索数据，作为重复登录不插入多条数据的依据*/
			
			$sql = "SELECT * FROM `sign_data` WHERE `user_id` = ? AND `new_date` = ?  ORDER BY `new_date` DESC LIMIT 1";
			$preObj = $db->prepare($sql);
			$preObj->execute(array($user['id'],$toDay));
			$date_time = $preObj->fetch(PDO::FETCH_ASSOC);

			/*$date_time 为空时就插入签到，否则继续引用一天中的第一条签到数据*/
			if(empty($date_time)){
				$sql    = "INSERT INTO `sign_data` (user_id,start_time,end_time, new_date) VALUES (?,?,?,?)";
				$preObj = $db->prepare($sql);
				$res    = $preObj->execute(array($user['id'], $time,0,$toDay));
			}

			/*
				$face => 用户头像
				$userKey => 用户级别
			*/
			$face = !empty($user['face_url']) ? 'sourcus/Photo/face/'.$user['face_url'] : 'sourcus/Images/logo_v2.png';
			$userRoot = $user['show_switch'];

			/*set user login cookie*/
			$data=$user['id'].'----'.$name.'----'.$face.'----'.$userRoot.'----'.$toDay;
			$expire=time()+60*60*24*30;
			setcookie("user", $data, $expire);
			header('location:../../index.html');
		}else{
			header('location:../../login.html?err=ipErr');
		}
	}else{
		header('location:../../login.html?err=error');
	}
}


/*reg compoment*/
if(isset($_POST['reg'])){
	$name = $_POST['username'];
	$pass = $_POST['password'];
	$check = $_POST['againpass'];
	if($pass==$check){
		$sql = "INSERT INTO `users_data` (`name`,`password`) VALUES (:name,:pass)";
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':name' => $name,':pass'=>md5($pass)));
		header('location:../../login.html');
	}else{
		header('location:../../login.html?err=reg');
	}
}

/*logout compoment*/
if(isset($_POST['logout'])){
	$id = $_POST['usersignid'];
	$sql = "UPDATE `sign_data` SET `end_time` = ? WHERE id = ?";
	$preObj = $db->prepare($sql);
	$preObj->execute(array(time(), $id));
	setcookie("user", " ", time()-60*60*24*30);
	header('location:../../login.html');
}