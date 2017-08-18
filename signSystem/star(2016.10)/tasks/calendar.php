<?php include('config.php'); ?>

<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>作品提交平台</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">

	<link href="css/index.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.min.js"></script>

	<script src="js/bootstrap.min.js"></script>

	<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

</head>

<body id="calendar">

	<nav class="navbar navbar-inverse">

		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

		  <span class="sr-only"></span>

		  <span class="icon-bar"></span>

		  <span class="icon-bar"></span>

		  <span class="icon-bar"></span>

		</button>

		<div class="navleft">

			<a href="http://www.gzittc.net">星辰工作室</a>

			<a href="index.php">作品提交平台</a>

		</div>

		  <div id="navbar" class="navbar-collapse collapse">

		    <ul class="nav navbar-nav navbar-right">

		    <!-- 登录注册页面start -->

		    <?php if(isset($_SESSION['user'])){ ?>

				<li><a href="#"><?php echo $_SESSION['user']; ?></a></li>

				<li><a href="logout.php">退出</a></li>

			<?php }else{ ?>

				<li><a href="login.php">登录</a></li>

				<li><a href="reg.php">注册</a></li>

			<?php } ?>

			<!-- 登录注册页面end -->

		    </ul>

		  </div>

	</nav>

	<div class="page-header">

	<h1><a href="index.php"><img class="logo" src="img/logo.png"/></a></h1>

		 <form class="fuzzy" action="index.php" method="post" class="navbar-form navbar-left" role="search">

			 <div class="form-group">

			     <input type="text" class="form-control"  name="fuzzyText" placeholder="请输入想要查找的作品名称 如：一   二">

		 	     <button type="submit"  class="btn btn-default"  name="fuzzyName">搜索</button>

			 </div>	

	 	</form>

	</div>

<section class="cont">

	<div class="left">

			<h2 class="sub-header">作品分类</h2>

				<div class="list-group">

				

				<!-- 作品分类页start -->

				<?php 

					$sql = "SELECT * FROM task_types";

					$result = mysql_query($sql); 

					$task_types = array();

					while($user = mysql_fetch_array($result)){

						$task_types[] = $user;

					} 

				?>

				<?php foreach ($task_types as $key => $value) { ?>

					<button type="button" class="list-group-item"><a class="displayblock" href="sections.php?id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></button>

				<?php } ?>

				<!-- 作品分类页end -->

				</div>

		</div>

	<div class="right">

			<table class="table table-hover table-striped">

			  <thead>

			    <tr>

			      <th>时间</th>

			      <th>作品名称</th>

			      <th>用户名</th>

			      <?php 

			         if(isset($_SESSION['user'])){

			      		echo "<th>下载</th>";

			      		}

			       ?>

			    </tr>

			  </thead>

			  <tbody>

<?php 



$limit = 11;

$page = isset($_GET['page'])?$_GET['page']:1;



$start = ($page - 1)*$limit;



if(isset($_POST['CalendarStart']) && !empty($_POST['CalendarStart']) && !empty($_POST['CalendarEnd'])){/*如果有CalendarStart就显示遍历tasks数据库calendar字段的数据*/

	//isset($_GET['page']);

	if(isset($_GET['s']) && isset($_GET['x'])){

		$CalendarStart = $_POST['CalendarStart'];

		$CalendarEnd = $_POST['CalendarEnd'];

		$sql = "SELECT * FROM tasks INNER JOIN users  ON tasks.user_id=users.id  WHERE calendar  between '$CalendarStart' and '$CalendarEnd' ORDER BY `tasks`.`calendar` DESC limit $start, $limit";

		$result = mysql_query($sql); 

		if($user['time'] < 12){

			$time = '上午';

		}else{

			$time = '下午';

		}

		while($Calendarn = mysql_fetch_assoc($result)){/*38行*/

			echo "<tr>".'<td>'.'['.$Calendarn['calendar'].$time.']'.'</td><td>'.$Calendarn['name'].'</td><td>'.$Calendarn['username'].'</td>';

			if(isset($_SESSION['user'])){

				echo " <td><a href='$user[download_path]'><button type='button' class='btn btn-default'>下载</button></a></td>"."</tr>";

			}

		}

	}else{

		$CalendarStart = $_POST['CalendarStart'];

		$CalendarEnd = $_POST['CalendarEnd'];

		$sql = "SELECT * FROM tasks INNER JOIN users  ON tasks.user_id=users.id  WHERE calendar  between '$CalendarStart' and '$CalendarEnd' ORDER BY `tasks`.`calendar` DESC limit $start, $limit";

		$result = mysql_query($sql); 

		if($user['time'] < 12){

			$time = '上午';

		}else{

			$time = '下午';

		}

		while($Calendarn = mysql_fetch_assoc($result)){/*38行*/

			echo "<tr>".'<td>'.'['.$Calendarn['calendar'].$time.']'.'</td><td>'.$Calendarn['name'].'</td><td>'.$Calendarn['username'].'</td>';

			if(isset($_SESSION['user'])){

				echo " <td><button type='button' class='btn btn-default'><a href='$user[download_path]'>下载</a></button></td>"."</tr>";

			}

		}

	}

	

}else{

	$err =  "请输入查询时间！";

}

?>

		   </tbody>

		</table>

	</div>

</section>

<div class="clear"></div>

<div class="page-header bg">

	 <form class="Calendar" action="calendar.php" method="post" accept-charset="utf-8">

	 	<span><b>按时间查询：</b></span>

	 	<input class="Wdate" type="text" name="CalendarStart" onClick="WdatePicker()" placeholder="请输入起始时间">

	 	<span>-</span>

	 	<input class="Wdate" type="text" name="CalendarEnd" onClick="WdatePicker()" placeholder="请输入结束时间">

	 	<input class="btn btn-default btn-sm" type="submit" name="CalendarnName" value="搜索"> 

	 	<span class='err'><?php if(isset($err)){echo $err;} ?></span>

	</form>

	<form action="calendar.php" method="get" accept-charset="utf-8">

		<ul class="pagemenu">

			<li><a href="index.php"><button type="button" class="btn btn-default">首页</button></a></li>

			<li><a>&nbsp;</a></li>

			<li><a>&nbsp;</a></li>

			<li><a name="s" href="calendar.php?page=<?php echo $page-1; ?>"><button type="button" class="btn btn-default">上一页</button></a></li>

			<li><a name="x" href="calendar.php?page=<?php echo $page+1; ?>"><button type="button" class="btn btn-default">下一页</button></a></li>

			<li><a href="calendar.php?page=<?php echo $all_page ?>"><button type="button" class="btn btn-default">尾页</button></a></li>

		</ul>

		<select  class="thispage" onchange="location.href='page.php?page='+this.value;">

			<?php for($i=1;$i<=$all_page;$i++){ ?>

			<option ><?php if($i){echo $i;}else{echo $i;} ?></option>

			<?php } ?>

		</select>

	</form>



	<a href="upload.php" class="btn btn-primary btn-default active shangchuang" role="button">提交作品</a>

</div>

<footer class="page-header">

	<p class="copyright">&copy版权所有 星辰工作室 <a href="http://www.gzittc.net">www.gzittc.net</a></p>

</footer>

</body>

</html>