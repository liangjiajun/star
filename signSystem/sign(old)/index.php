<?php  
require_once 'config/config.php';
if(isset($_POST['sub'])){
	$name = post('username');
	$pass = post('password');
	$err='';
	$user = $db->select('users_data',['id','username','name','password','face_url','show_switch'],['name'=>$name,'password'=>md5($pass)]);
	if(!empty($user)){
		$data_id='';
		$toDay = date('Y-m-d',time());

		/*已当前日期（年日月）为条件搜索数据，作为重复登录不插入多条数据的依据*/
		$date_time = $db->fetch($db->query('
			SELECT * FROM `sign_data` WHERE `user_id` ='.$user[0]['id'].' AND `new_date` ="'.$toDay.'" ORDER BY `new_date` DESC LIMIT 1
		'));
		
		/*$date_time 为空时就插入签到，否则继续引用一天中的第一条签到数据*/
		if(empty($date_time)){
			$db->insert('sign_data',['user_id'=>$user[0]['id'],'start_time'=>time(),'end_time'=>'','new_date'=>date('Y-m-d',time())]);
			$data_id = $db->in_id();
		}else{
			$data_id = $date_time[0]['id'];
		}

		/* 
			$face 用户头像
		*/
		$face = !empty($user[0]['face_url']) ? 'sourcus/face/'.$user[0]['face_url'] : 'sourcus/images/logo_v2.png';
		$userKey = $user[0]['show_switch'];
		$data=$name.'----'.$face.'----'.$userKey;
		$expire=time()+60*60*24*30;
		setcookie("user", $data, $expire);

		$key = $user[0]['id'].'----'.$data_id.'----'.date('Y-m-d',time());
		setcookie("user_key", $key, $expire);
		jump('back.php');
		
	}else{
		$err.='用户名或密码错误';
	}
}


if(isset($_COOKIE['user'])){jump('back.php');}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>签到</title>
	<link rel="stylesheet" href="sourcus/css/main.css">
</head>
<body>
	<section class="wrap position login-width">
		<h1 class="face face-style">
			<img src="sourcus/images/logo_v2.png" alt="logo">
		</h1>
		<form method="post" class="form-data">
			<h2>辰员签到</h2>
			<label>
				<input type="text" required placeholder="用户名" name="username" class="input">
			</label>
			<label>
				<input type="password" required placeholder="密码" name="password" class="input">
			</label>
			<p class="err"><?=isset($err)?$err:'';?></p>
			<button name="sub" type="submit" class="btn">签 到</button>
		</form>
	</section>
</body>
</html>