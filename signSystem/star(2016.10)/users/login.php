<?php 
//登陆

include('../config.php');?>

<!DOCTYPE html>
<html id ="login">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>签到页面</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<?php 
if(isset($_SESSION["user"])){
	header("location:http://www.gzittc.net");
}

//登陆判断
if(isset($_POST['sub'])){



	$u = $_POST['username'];
	$p = $_POST['userpassword'];
	$referUrl  = $_POST['referUrl'];

	$sql = "SELECT * FROM users WHERE username = '$u'";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);



	if(isset($row['username'])){
		if(	 $p == $row['password'] ){
			$_SESSION['user'] = $row['username'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['role'] = $row['role'];
			// header('location:../index.php');
			header("location:../star.V1.2/");
			// header('location:'.$referUrl); //跳回上一页
		}else{
			$err1 =  "密码错误";
		}
	}else{
		$err = "账户不存在";
	}



	/*如果签到了就向服务器插入登录的时间节点*/

	if(isset($_SESSION['user'])){
		$name = $_SESSION['user'];
		$time = time();
		$id = $_SESSION['id'];

	$sql = "INSERT INTO `sign`(`datetime1`,`name`,`user_id`) VALUES ( '$time','$name','$id')";
	mysql_query($sql);
	$getID=mysql_insert_id();
	$_SESSION['sign_id'] = $getID;

	// $_SESSION['sign_id'];
	}

	/*如果签到了就向服务器插入登录的时间节点*/

}

?>

<body>

	  <div id="wrap"class="blur">

	     <div class="center-block" > 

			<h1 class="loginh1"><a href="../index.php">辰员签到</a></h1>

	            <form class="form-horizontal" method="post" >

				  <span class='loginspan'>帐号:</span>

			      <input type="text"  name="username" maxlength="20"  class="loginwidth" placeholder="请输入帐号" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>">

                  <span class="err"><?php if(isset($err)){echo '*'.$err;}  ?></span>

                  <br>

                  <span class='loginspan'>密码:</span>

                  <input type="password"  name="userpassword" maxlength="20"  class="loginwidth" placeholder="请输入密码">
                  <input type="hidden" name="referUrl" value="<?=getenv("HTTP_REFERER");?>">

                  <span class="err"><?php if(isset($err1)){echo '*'.$err1;}  ?></span>

                  <br>

                  <button type="submit" name="sub" class="btn btn-default btn-block loginbtn">签到</button>

	           	<div class="loginbottom"> 

	                <a href="../index.php" class="lbleft" >返回首页</a>

	                <!-- <a href="./reg.php" class="lbright"  >注册账号</a> -->

	            </div>

	           </form>

	       </div>

	</div>

</body>

</html>

<script>

 	document.getElementsByName('type')[0].onchange = function(){

 		document.getElementsByName('task_type')[0].value = this.value; 

 	}

</script>