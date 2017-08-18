<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>留言板</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php
		session_start();
		include('config.php');

		if(isset($_POST['content'])){

			$m = addslashes($_POST['content']);
			$m = strip_tags($m);

			$sql="INSERT INTO messages (content)VALUES('$m')";	
 			mysql_query($sql);
 		header("location:index.php");
 		#跳转页面，必须写在这里
		}

		$sql= "SELECT * FROM messages order by id desc";
								     #  倒序

		$result=mysql_query($sql);
	
		 $message=array();
		 while ($row = mysql_fetch_array($result)) {
			$message[] =$row;
		}

	?>


<?php
include('../top.php');
?>




	<div class="header_logo">
		<h1>
			<a href="index.php">
				<img id="logo" src="img/logo.png">
			</a>
		</h1>
	</div>
	<div id="form">
	<div class="form_l">
		<form method="post">
			<textarea name="content" class="bbs" 
			placeholder="如果你有一个很好的idea，或者发现我们平台的小BUG

 那么就在这里告诉我 (￣▽￣)

 我都会反馈给攻城狮们 .




" required></textarea> 
			<br>
			<input id="input" type="submit" name="sub" value="提交">
			
		</form>
		<div class="form_l_c">
			<span style="text-align:center; display: block; margin-top: 100px;"> ( \^o^/ 欢迎大家来提建议，你们的建议就是我们的动力）</span>
		</div>
	</div>
	<!--    concent       -->
		<div class="form_r">
			<div id="title">
			
				<div class="portrait" >
						<a href="#" class="photo"></a>
					</div>
									
					<span id="span_1"></span>			
					<div class="title_c">
						<i>阳台</i><strong>攻城狮：</strong>
						<p>更多小功能后期会更新，大家敬请期待。</p>
					</div>

			</div>
			
			<div>
				<ul>
				<?php foreach ($message as $k) {?>
				<li class="li_one">
					
					<div class="portrait" >
						<a href="#" class="photo photo-b"></a>
					</div>
									<!--左侧头像-->
					<span id="span_1"></span>
									<!--三角形-->
					<div class="words_h">
						<i><?php echo $k['id'].' 楼' ?></i> 
						<strong>游客 :</strong>
					</div>
									
					<div class="words_c">
						<?php echo $k['content'] ?>
					</div>
									<!--留言内容-->	
					<!-- <div class="reply">
						<ul>
							<li class="li_two">
								<p></p>
							</li>
						</ul>
						<div class="reply_b">
							<span id="span_2"></span>
								<input id="reply_input1" type="text" name=""  placeholder="回复一下">
									<input id="reply_input2" type="button" name="" value="发送">
						</div>
						
					</div> -->
				</li>
			   <?php } ?>
			</ul>
			</div>

		</div>
		
	</div>
	<!--    footer     -->
	<div class="footer">
		<p>©版权所有 星辰工作室 <a href="http://www.gzittc.net">www.gzittc.net</a> </p>
		<span>_____项目负责人 . 谢贵_____</span>
	</div>
</body>
</html>