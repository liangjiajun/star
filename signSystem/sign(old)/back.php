<?php  
require_once 'config/config.php';

if (!empty($_COOKIE['user'])){
	$key = explode('----', $_COOKIE['user_key']);
	$user = explode('----', $_COOKIE['user']);
	$new_date = date('Y-m-d',time());
	$start_time = $db->fetch($db->query('SELECT `start_time`,`new_date` FROM `sign_data` WHERE `user_id` ='.$key[0].' AND `new_date`="'.$new_date.'" ORDER BY `start_time` ASC '));


	$allTime =time() - $start_time[0]['start_time']*1;
	// $old =$start_time[0]['new_date'];
	if(strtotime($key[2])!=strtotime($new_date)){
		setcookie("user", "", time()-60*60*24*30);
		jump('index.php');
	}
	if(isset($_POST['sub'])){
		$db->update('sign_data',['end_time'=>time()],['id'=>$key[1]]);
		setcookie("user", "", time()-60*60*24*30);
		jump('index.php');
	}
$userGet =$key[0].'----'.$user[0].'----'.$user[1].'----'.$user[2];
$str ='?key='.base64_encode($userGet);



}




?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>签到成功</title>
	<link rel="stylesheet" href="sourcus/css/main.css">
</head>
<body>
<?php if(!empty($_COOKIE['user'])){ ?>
	<section class="wrap logout-width position">
		<header class="header">
			<h2 class="face face-style" style="background: white url(<?=$user[1]?>);background-size: cover;"></h2>
			<div class="user-data">
				<span class="user-icon"><?=$user[0]?></span>
				<p>Welcome Back</p>
			</div>
			<div class="logout-time">
				<p>签到时间：<?=date('Y-m-d H:i:s',$start_time[0]['start_time'])?></p>
				<p>在线时间：<?=time2string($allTime)?></p>
			</div>
			<form method="post">
				<button class="btnOut" name="sub" type="submit">签 退</button>
			</form>
		</header>
		<ul class="link-data">
			<li>
				<a href="list.php">
					<span class="icon-color" style="background:#ffae00;">考 勤</span>
					<span class="icon-message">考勤数据</span>
				</a>
			</li>
			
			<li>
				<a href="http://192.168.71.57/Typing/index.html<?=$str?>">
					<span class="icon-color" style="background:#ff5745;">打 字</span>
					<span class="icon-message">打字测试</span>
				</a>
			</li>

			<li>
				<a href="http://192.168.71.57/upload/index.html<?=$str?>">
					<span class="icon-color" style="background:#45b4f3;">文 件</span>
					<span class="icon-message">文件分享</span>
				</a>
			</li>
			<li>
				<a href="http://192.168.71.198/traineeV2.0/index.php<?=$str?>">
					<span class="icon-color" style="background:#6895ea;">成 绩</span>
					<span class="icon-message">成绩查询</span>
				</a>
			</li>
			<li>
				<a href="http://192.168.71.198/weeklyPlan/index.php<?=$str?>">
					<span class="icon-color" style="background:#ea6868;">计 划</span>
					<span class="icon-message">一周计划</span>
				</a>
			</li>
			 <li>
				<a href="http://192.168.71.57/upload_exam/index.html<?=$str?>">
					<span class="icon-color" style="background:#68eaa8;">试 卷</span>
					<span class="icon-message">试卷提交</span>
				</a>
			</li>
			 
		</ul>
	</section>
<?php  }else{jump('index.php'); } ?>		
</body>
</html>