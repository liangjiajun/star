<?php  
if (!session_id()) session_start();
	include('../config/config.php');
	echo '<link rel="stylesheet" href="../style/header.css">';
	require '../../top2.php';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AnswerQuestions</title>
</head>
<body>
		<header class="header" id="header">
			<h1>
				<a id="home" href="http://gzittc.net/" title="工作室首页">
					<img src="../images/logo.png" alt="logo">
					<div class="text">Answer Questions</div>
				</a>
			</h1>
			<nav>
				<ul>
					<li><a href="index.php" title="首页">首页</a></li>
					<li><a href="results.php" title="成绩">成绩</a></li>
					<li><a href="addquestion.php" title="添加题库">添加题库</a></li>
					<li><a href="aboutus.php" title="关于我们">关于我们</a></li>
				</ul>
			</nav>

			<ul class="top-right">
			<?php if(isset($_SESSION['user'])){ ?>
				<li> 
					<a href="#" title="<?php echo $_SESSION['user'] ?>"><img src="../images/user.jpg" alt="user"></a>
					<span class="more"></span>
				</li>
				<?php }else{ ?>
				<li> 
					<a href="#" title=""><img src="../images/favicon.png" alt="user"></a>
					<span class="more"></span>
				</li>
			<?php } ?>
			</ul>
	</header>
