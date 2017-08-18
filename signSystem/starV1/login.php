<?php
require_once 'php/config.php';

$reg = false;/*注册的权限 false（无法注册） true（正常注册）*/

/*签到*/
if(isset($_POST['sub'])){

	$err="";
	$name = $_POST['username'];
	$pass = md5($_POST['userpass']);
	$time = time();
	$rootId = [9,14,15,38];//管理组
	$toDay = date('Y-m-d',$time);
	/*用户登录*/
	$preObj = $db->prepare("SELECT id,name,password,face_url,show_switch,ip_plane FROM `users_data` WHERE `name` = ? AND `password` = ? AND `show_switch` >=? ");
	$preObj->execute(array($name,$pass,2));
	$user = $preObj->fetch(PDO::FETCH_ASSOC);

	/*获取用户id做判断*/
	$gip =!in_array($user['id'], $rootId) ? null : GetIP();


	/*判断条件*/
	if(empty($user)){
		$err.='用户名或密码错误/用户不存在,脱产使用';
	}else if($user['ip_plane']==$gip){
		$err.='登录异常，不在常登录地址登录';
	}else{
		setcookie("user", " ", time()-60*60*24*30);
		/*插入Ip地址*/
		if(isset($gip) && $user['ip_plane']=="" && !in_array($user['id'], $rootId)){
			$db->prepare("UPDATE users_data SET ip_plane = ? WHERE id = ?")->execute(array($gip, $user['id']));
		}

		/*已当前日期（年日月）为条件搜索数据，作为重复登录不插入多条数据的依据*/

		$sql = "SELECT * FROM `sign_data` WHERE `user_id` = ? AND `new_date` = ?  ORDER BY `new_date` DESC LIMIT 1";
		$preObj = $db->prepare($sql);
		$preObj->execute(array($user['id'],$toDay));
		$date_time = $preObj->fetch(PDO::FETCH_ASSOC);
		/*今天的签到数据为空时就签到，否则继续引用一天中的第一条签到数据*/
		if(empty($date_time)){

			$active = 0;
			if(date('w')==0){
				$active = 5;
			}else if(date('w')==1){
				if(date('H:i:s',$time) > "08:30:00"){
					$active = 4;
				}
			}

			$sql = "INSERT INTO `sign_data` (user_id,start_time,end_time, new_date, sign_description) VALUES (?,?,?,?,?)";
			$preObj = $db->prepare($sql);
			$res    = $preObj->execute(array($user['id'], $time,0,$toDay,$active));
		}
		$face = !empty($user['face_url']) ? 'Photo/face/'.$user['face_url'] : 'Images/logo.png';
		$data=$user['id'].'----'.$user['name'].'----'.$face.'----'.$user['show_switch'].'----'.$toDay;
		$expire=time()+60*60*24*30;
		setcookie("user", $data, $expire);
		header('location:index.html');
	}
}
/*注册*/
if($reg && isset($_POST['reg'])){
	$err="";
	$name = $_POST['username'];
	$pass = $_POST['password'];
	$check = $_POST['againpass'];
	if($pass==$check){
		$preObj = $db->prepare("SELECT id,name FROM `users_data` WHERE `name` = ? ");
		$preObj->execute(array($name));
		$user = $preObj->fetch(PDO::FETCH_ASSOC);
		if(empty($user)){
			$sql = "INSERT INTO `users_data` (`name`,`password`) VALUES (:name,:pass)";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':name' => $name,':pass'=>md5($pass)));
			header('location:login.php?rs');
		}else{
			$err.="用户已存在";
		}
	}else{
		$err.="二次密码输入错误";
	}
}

/*修改密码*/
if(isset($_POST['update'])){
	$err="";
	$name = $_POST['username'];
	$pass = $_POST['password'];
	$check = $_POST['againpass'];
	if($pass==$check){
		$preObj = $db->prepare("SELECT id,name FROM `users_data` WHERE `name` = ? ");
		$preObj->execute(array($name));
		$user = $preObj->fetch(PDO::FETCH_ASSOC);
		if(!empty($user)){
			$db->prepare("UPDATE users_data SET `password` = ? WHERE id = ?")
				->execute(array(md5($check), $user['id']));
			header('location:login.php?ru');
		}else{
			$err.="用户不存在";
		}
	}else{
		$err.="二次密码输入错误";
	}
}

/*logout*/
if(isset($_GET['logout'])){
	$sid = $_GET['sid'];
	$time = time();
	$active = 0;
	$active = date('H:i:s',$time)>"16:30:00" ? 0 : 2;
	
	/*修改未签到用户*/
	if(date('H:i:s',$time)>"16:30:00"){
		$sd = "SELECT id,end_time,new_date,sign_description FROM `sign_data` WHERE `new_date` = ? ";
		$preObj = $db->prepare($sd);
		$preObj->execute(array(date('Y-m-d',$time)));
		$sign = $preObj->fetchAll(PDO::FETCH_ASSOC);
		foreach ($sign as $v) {
			$sql = "UPDATE `sign_data` SET  `sign_description` = ? WHERE `id` = ? AND `end_time` = ?";
			$preObj = $db->prepare($sql);
			$preObj->execute(array(1,$v['id'],0));
		}
	}

	setcookie("user", " ", time()-60*60*24*30);
	$sql = "UPDATE `sign_data` SET `end_time` = ? , `sign_description` = ? WHERE `id` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($time,$active,$sid));
	header('location:login.php?out');
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>星辰平台</title>
	<link rel="stylesheet" href="Style/reset.css">
	<link rel="stylesheet" href="Style/login.css">
</head>
<body>
	<div class="flex-box wrap flex-direction">
		<header class="flex-box">
			<h1>
				<img src="Images/logo.png" alt="logo">
			</h1>
			<ul class="clear">

				<li class="<?= isset($_GET['reg']) ? 'nav_active' : ''  ?>"><a href="login.php?reg">Register</a></li>
				<li class="<?= !isset($_GET['reg']) ? 'nav_active' : ''  ?>"><a href="login.php">Login</a></li>
			</ul>
		</header>
<?php if(!isset($_GET['reg']) && !isset($_GET['edit'])){ ?>
		<p class="right"><?= isset($_GET['rs']) ? '注册成功' : ''  ?></p>
		<p class="right"><?= isset($_GET['ru']) ? '密码修改成功' : ''  ?></p>
		<p class="right"><?= isset($_GET['out']) ? '签退成功' : ''  ?></p>
		<section class="login-wrap">
			<h2>Welcome<span> back!</span></h2>
			<form method="post">
				<label>
					<span class="user-name-icon"></span>
					<input type="text" placeholder="Username" name="username">
				</label>
				<label>
					<span class="user-password-icon"></span>
					<input type="password" placeholder="Password" name="userpass">
				</label>
				<button type="submit" name="sub">Enter</button>
				<a href="login.php?reg" class="reg">注册账号</a>
				<a href="login.php?edit" class="reg">忘记密码</a>
				<p class="error"><?=!empty($err) ? $err : ''; ?></p>
			</form>
		</section>

<?php } if(isset($_GET['reg'])){ ?>

		<section  class="reg-wrap">
			<h2>Register<span> users!</span></h2>
			<?php if($reg){ ?>
			<form method="post" >
				<label>
					<span class="user-name-icon"></span>
					<input type="text" placeholder="Username" name="username">
				</label>
				<label>
					<span class="user-password-icon"></span>
					<input type="password" placeholder="Password" name="password">
				</label>
				<label>
					<span class="user-password-icon"></span>
					<input type="password" placeholder="Chick password again" name="againpass">
				</label>
				<button type="submit" name="reg">Enter</button>
				<p class="error"><?=!empty($err) ? $err : ''; ?></p>
			</form>

			<?php }else{ ?>
			<h2>注册权限尚未开放</h2>
			<a href="login.php" class="reg">返回登录</a>
			<?php } ?>
		</section>

<?php } if(isset($_GET['edit'])){  ?>
		<section class="update-password">
			<h2>修改密码</h2>
			<form method="post">
				<label>
					<span class="user-name-icon"></span>
					<input type="text" placeholder="填写用户名" name="username">
				</label>
				<label>
					<span class="user-password-icon"></span>
					<input type="password" placeholder="输入新密码" name="password">
				</label>
				<label>
					<span class="user-password-icon"></span>
					<input type="password" placeholder="确认新密码" name="againpass">
				</label>
				<button type="submit" name="update">Enter</button>
				<p class="error"><?=!empty($err) ? $err : ''; ?></p>
			</form>
		</section>
<?php }  ?>
	</div>
</body>
</html>
<script>
	window.onload=function() {
		localStorage.removeItem('userMeagess');
	}
</script>