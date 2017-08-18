<?php include('../config.php'); ?>

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

<body id="page">

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

$sql = "SELECT count(id) FROM tasks";

$result = mysql_query($sql);

$count = mysql_fetch_assoc($result);

$count = $count['count(id)'];

//print_r($count) ;

$limit = 11;

$page = isset($_GET['page'])?$_GET['page']:1;

$all_page = ceil($count/$limit);

//echo $_GET['page'];

if($page <= 1){

	$page = 1;

}

if($page >= $all_page){

	$page = $all_page;

}

$start = ($page - 1)*$limit;

$sql = "SELECT * FROM tasks INNER JOIN users  ON tasks.user_id=users.id  order by tasks.id desc limit $start, $limit";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)){

	if($row['time'] < 12){

		$time = '上午';

	}else{

		$time = '下午';

	}

	echo "<tr>".'<td>'.'['.$row['calendar'].$time.']'.'</td><td>'.$row['name'].'</td><td>'.$row['username'].'</td>';

	if(isset($_SESSION['user'])){

		echo "<td><a href='$row[download_path]'><button type='button' class='btn btn-default'>下载</button></a></td>"."</tr>";

	}

}

?>

		   </tbody>

		</table>

	</div>

</section>

<div class="clear"></div>

<div class="page-header bg">

	 <form class="Calendar" action="index.php" method="post" accept-charset="utf-8">

	 	<span><b>按时间查询：</b></span>

	 	<input class="Wdate" type="text" name="CalendarStart" onClick="WdatePicker()" placeholder="请输入起始时间">

	 	<span>-</span>

	 	<input class="Wdate" type="text" name="CalendarEnd" onClick="WdatePicker()" placeholder="请输入结束时间">

	 	<input class="btn btn-default btn-sm" type="submit" name="CalendarnName" value="搜索"> 

	</form>

	<ul class="pagemenu">

		<li><a href="index.php"><button type="button" class="btn btn-default">首页</button></a></li>

		<li><a>&nbsp;</a></li>

		<li><a>&nbsp;</a></li>

		<li><a href="page.php?page=<?php echo $page-1; ?>"><button type="button" class="btn btn-default">上一页</button></a></li>

		<li><a href="page.php?page=<?php echo $page+1; ?>"><button type="button" class="btn btn-default">下一页</button></a></li>

		<li><a href="page.php?page=<?php echo $all_page ?>"><button type="button" class="btn btn-default">尾页</button></a></li>

	</ul>

	<select  class="thispage" onchange="location.href='page.php?page='+this.value;">

		<?php for($i=1;$i<=$all_page;$i++){ ?>

		<option value="2" selected="true" disabled="true"><?php if($i){echo $i;}else{echo 1;} ?></option>

		<?php } ?>

	</select>

	<a href="upload.php" class="btn btn-primary btn-default active shangchuang" role="button">提交作品</a>

</div>

<footer class="page-header">

	<p class="copyright">&copy版权所有 星辰工作室 <a href="http://www.gzittc.net">www.gzittc.net</a></p>

</footer>

</body>

</html>



<!-- 时间查询的My97DatePicker控件js链接 -->

<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

