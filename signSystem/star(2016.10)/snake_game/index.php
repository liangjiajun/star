<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>

	<?php include('../top.php'); ?>

	<div class="copy text_center">&copy; 2015 版权所有 星辰工作室 - 项目负责人( Jim Ming )</div>
	
	<div class="section section_active section_1 text_center">
		<div class="middle">
			<h1 class="m_b_40">
				<img src="logo.png" alt="" width="300">
				<span class="block fs_80">Snake</span>
			</h1>
			<div class="game">
				<button class="btn play">Play Game</button>
			</div>
		</div>
	</div>

	<div class="section section_2">
		<div class="center text_center">
			<div>
				<canvas id="canvas" width="800" height="500"></canvas>
				<div class="dialog">
					<h2>Game Over</h2>
				</div>
			</div>
		</div>
		<div class="menu clearfix">
			<div>
				<h1><img alt="" src="logo.png"></h1>
				<ul class="oper">
					<li><button class="btn start">Start</button></li>
					<li><button class="btn restart" style="display: none;">Restart</button></li>
				</ul>
				<ul class="info clearfix">
					<li class="col_sm">分数：<b class="scores"></b></li>
					<li class="col_sm">时间：<b class="time"></b></li>
					<li class="col_sm">长度：<b class="length"></b></li>
				</ul>
			</div>
		</div>
	</div>

<script src="script/jquery-1.11.3.min.js"></script>
<script src="script/snake.js"></script>

</body>
</html>