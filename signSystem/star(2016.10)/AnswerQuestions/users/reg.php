<?php 
include('../config.php');

if(isset($_POST['reg'])){
	$u = $_POST['u'];
	$p = $_POST['p'];
	$pp = $_POST['pp'];
	$yzm = $_POST['yzm'];

	if(empty($u)){
		$err = "账户不能为空";
	}else if(empty($p)){
		$err1 = "密码不能为空";
	}else if(empty($pp)){
		$err2 = "二次密码不能为空";
	}else if($p != $pp){
		$err3 = "重复密码不一致";
	}else if( $_SESSION["yzm_code"] != $yzm){
		$erryaz = "验证码错误！";
	}else{
		$sql = "SELECT * FROM `users` WHERE username = '$u'";
		$result = mysql_query($sql);
		$user = mysql_fetch_assoc($result);

		if($user){
			$err4 = "用户已注册，请返回登录！";

		}else{
			die();
			$star = 0;
			$role = 1;
			$sql = "INSERT INTO `users`(`username`, `password`, `role`, `star`) VALUES ('$u','$p','$star','$role')";
			mysql_query($sql);
			header('location:./login.php');
		}
	}
}

 ?>
 <!DOCTYPE html>
 <html id="reg">
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>注册页面</title>
 	<link href="css/bootstrap.min.css" rel="stylesheet">
 	<link href="css/index.css" rel="stylesheet">
 	<script src="js/jquery-1.9.1.min.js"></script>
 	<script src="js/bootstrap.min.js"></script>
 	<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
 </head>
 <body id="reg.php">
	  <div id="wrap"class="blur">
	     <div class="center-block" > 
			<h1 class="loginh1"><a href="../index.php">欢迎成为我们的一员</a></h1>
	            <form class="form-horizontal" method="post" action="reg.php"accept-charset="utf-8">
				  <span class='loginspan'>帐号:</span>
				  <input type="text"  name="u" maxlength="20" class="loginwidth" placeholder="请输入帐号" value="<?php if(isset($_POST['u'])) echo $_POST['u'] ?>">
                  <span class="err"><?php if(isset($err)){echo '*'.$err;}  ?></span>
                  <br>
                  <span class='loginspan'>密码:</span>
                  <input type="password"  name="p" maxlength="20"  class="loginwidth" placeholder="请输入密码" value="<?php if(isset($_POST['p'])) echo $_POST['p'] ?>">
                  <span class="err"><?php if(isset($err1)){echo '*'.$err1;}  ?></span>
                  <br>
                  <span class='loginspan'>二次密码:</span>
                  <input type="password"  name="pp" maxlength="20"  class="loginwidth" placeholder="请二次输入密码" value="<?php if(isset($_POST['pp'])) echo $_POST['pp'] ?>">
                  <span class="err"><?php if(isset($err2)){echo '*'.$err2;}  ?><?php if(isset($err3)) echo $err3 ?></span>
                  <br>
                  <span class='loginspan'>验证码:</span>
                  <input type="text"  name="yzm"  maxlength="4" id="srand" class="loginwidth" placeholder="请输入验证码">
                  <span class="err"><?php if(isset($erryaz)){echo '*'.$erryaz;}  ?></span>
                  <br>
                  <div class="yzm">
                  	<img  id="code" name="code" src="verification.php"  onclick="create_code()" title="点击图片刷新验证码" onclick="change_rand();">
                  	<a href="javascript:" onclick="create_code();">看不清？换图片</a><br />
                  </div>
                  <br/>
                  <button type="submit" name="reg" class="btn btn-default btn-block loginbtn">注册</button>
                  <span class="err"><?php if(isset($err4)){echo '*'.$err4;}  ?></span>
	           	<div class="loginbottom"> 
	                <a href="../index.php" class="lbleft" >返回首页</a>
	                <a href="./login.php" class="lbright" >返回登录</a>
	            </div>

	           </form>
	       </div>
	</div>
 </body>
 </html>
<script type="text/javascript">
 	function create_code(){
    	document.getElementById('code').src = 'verification.php?n='+Math.random()*10000;
	}
</script>
