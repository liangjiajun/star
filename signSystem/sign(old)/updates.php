<?php  
	require_once 'config/config.php';
	$user = $db->select('users_data');
	if(isset($_POST['sub'])){
		$id = $_POST['user'];
		$pass = $_POST['pass'];
		$rpass = $_POST['rpass'];
		if($pass===$rpass){
			$db->update('users_data',['password'=>md5($pass)],['id'=>$id]);
			jump('index.php');
		}else{
			echo '重复密码错误';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改密码</title>
</head>
<body>
<form method="post">
	<select name="user" >
		<?php foreach ($user as $k => $v) { ?>
			<option value="<?=$v['id']?>"><?=$v['name']?></option>
		<?php } ?>
	</select>
	<input type="password" name="pass" placeholder="密码">
	<input type="password" name="rpass" placeholder="确认密码">
	<button type="submit" name="sub">提交</button>
</form>	
</body>
</html>