<?php 
error_reporting(0);
session_start();
include('php/inc/config.php');
date_default_timezone_set('PRC');
function select ($v){
		$sql="SELECT * FROM taskmanagment WHERE StatusId = '$v'";
		$result=mysql_query($sql);
		$data=array();
		while($row= mysql_fetch_array($result)){
			$data[]=$row;
		}
		return $data;
	}
$tasks=select('B');
$in_tasks=select('I');
$done=select('D');
$resort=select('R');
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Task Management</title>
	<link rel="stylesheet" href="css/style.css" title="link1">
	<link rel="stylesheet" href="css/blue.css" disabled="disabled" title="link4">
	<link rel="stylesheet" href="css/green.css" disabled="disabled" title="link3">
	<link rel="stylesheet" href="css/orange.css" disabled="disabled" title="link2">
	<script src="javascripts/jquery.js"></script>
	<script src="javascripts/jquery-ui.js"></script>
	<script src="javascripts/jquery.cookie.js"></script>
</head>
<body>
 <?php  include('../top.php') ?>
	<header class="header" id="header">
		<div class="topic">
			<h1>
				<a id="home" href="http://gzittc.net/" title="工作室首页">
					<img src="images/logo.png" alt="logo">
					<div class="text">Task Management</div>
				</a>
			</h1>
			<span class="from">
				<input type="text" placeholder="请输入关键字" name="keywords"/>
				<input class="sub" type="submit" name="submit" value="">
			</span>
			<ul class="top-right">
				<li class="sub-hover"><a href="#" title="主题"></a>
					<ul class="sub-right-nav">
						<li id="link1">默认主题</li>
						<li id="link2">清新主题</li>
						<li id="link3">时尚主题</li>
						<li id="link4">典雅主题</li>
					</ul>
				</li>
				<li><a href="#" title="新建" id="add-task"></a>
				</li>
				<li> 
					<a href="#" title="用户"><img src="images/user.jpg" alt="user"></a><span class="more"></span>
				</li>
			</ul>
		</div>
		<div class="aside-nav">
		<div class="aside-bg">
			<nav>
				<ul>
					<li><a href="http://star.gzittc.net/tasks/" title="主页">主页</a></li>
					<li><a href="index.php" title="看板">看板</a></li>
					<li><a href="#" title="列表">列表</a></li>
					<li><a href="#" title="设置">设置</a></li>
				</ul>
			</nav>
			<footer id="cpoytip"><p>版权所有：</p><p>星辰工作室</p><span>负责人：<p class="name">LJJ</p></span></footer>
		</div>
		</div>
	</header><!-- /header -->
	<article class="content">
		<ul class="task-title task-wrap">
			<li class="one"><span class="fw">待办中</span>任务: <?php echo $B_num = count($tasks);?></li>
			<li class="two"><span class="fw">进行中</span>任务: <?php echo $I_num=count($in_tasks);?></li>
			<li class="three"><span class="fw">已完成</span>任务: <?php echo $D_num=count($done);?></li>
		</ul>
		<ul class="task-conter task-wrap">
			<li>
			<?php foreach ($tasks as $t) { ?>
				<div id="<?php echo $t['TaskId'] ;?>">
					<h4>#<?php echo $t['TaskId'] ;?></h4>
					<p><?php echo $t['TaskDescription'] ?></p>
					<a class="del" href="php/del.php?id=<?php echo $t['TaskId'];?>"title="删除"></a>
				</div>
			<?php }  ?>
			</li>
			<li>
			<?php foreach ($in_tasks as $I) {?>
				<div id="<?php echo $I['TaskId']; ?>">
					<h4>#<?php echo $I['TaskId']; ?></h4>
					<p><?php echo $I['TaskDescription']; ?></p>
					<h4 id="starttime">StartTime</h4>
					<p><?php echo $I['StartTime']; ?></p>
				</div>
				<?php  } ?>
			</li>
			<li>
			<?php foreach($done as $D){ ?>
				<div class="date-up" id="<?php echo  $D['TaskId']; ?>">
					<h4>#<?php echo $D['TaskId'] ?></h4>
					<p class="line-height"><?php echo $D['TaskDescription']; ?></p>
					<h4 id="starttime">StartTime</h4>
					<p><?php echo $D['StartTime']; ?></p>
					<h4 id="endtime">EndTime</h4>
					<p><?php echo $D['EndTime']; ?></p>
					<a class="del" href="php/del.php?id=<?php echo $D['TaskId'];?>"title="删除"></a>
				</div>
				<?php } ?>
			</li>
		</ul>
	</article>
	<section id="update">
		<form id="post" method="post" action="php/insert.php">
			<h4>新建任务</h4>
			<textarea name="TaskDescription" id="content-text" placeholder="请输入任务内容" required autofocus ></textarea>
			<button name="sub" type="submit" class="button">Add Task</button>
			<div class="button" id="hide">Cancel</div>
		</form>
		<div class="black" id="black"></div>
	</section>
</body>
</html>
<script src="javascripts/function.js"></script>