<?php
include('../config.php');
ob_start();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>留言板</title>
	<link rel="stylesheet" href="style1.css">
</head>
<body>
<?php include("../top.php"); ?>

<?php 

		$user = new user();														/*先要实例化*/
		$u =     $user->getUser();
		$users = $user->getUsers();

		if(isset($_POST['sub1'])){												/*----提交按钮sub1------*/	
			$m = addslashes($_POST['content']);
			$m = strip_tags($m);
			$uid = $u["id"];

			$sql="INSERT INTO messages (content,share,uid)VALUES('$m','1','$uid')";	
			mysql_query($sql);
			header("location:index.php");										#跳转页面，写在这里

		}
		if(isset($_POST['sub2'])){												/*----分享按钮sub2------*/
			$n = addslashes($_POST['content']);
			$n = strip_tags($n);
			$uid = $u["id"];

			$sql="INSERT INTO messages (content,share,uid)VALUES('$n','2','$uid')";
			mysql_query($sql);
			header("location:index.php");
		}

		if(isset($_POST['sub3'])){	
			$id = $_POST["id"];													/*----留言按钮sub3------*/
			$b = addslashes($_POST['content']);
			$b = strip_tags($b);
	
			$sql = "UPDATE messages SET reply = '$b' WHERE id = '$id'";
			//$sql="INSERT INTO messages (content,share,uid)VALUES('$b','3','$uid')";
			mysql_query($sql);
			header("location:index.php");
		}


		$sql= "SELECT * FROM messages order by id desc";                         # 倒序						    
		$result=mysql_query($sql);
		$message=array();
		while ($row = mysql_fetch_array($result)) {
		$message[] =$row;
		}

?>

			<div class="header_logo" id="top">									<!--*******logo图片*******-->
				<h1>
					<a href="index.php">
						<img id="logo" src="img/logo.png">
					</a>
				</h1>
			</div>
			
			<div id="form">														<!--*******输入框*******-->
				<div class="form_l">
					<form method="post" id="only_form">																	
						<textarea  name="content" wrap="physical"
						placeholder="期待你的建议或分享" required></textarea> 
						<br>
						<input class="input" type="submit" name="sub1" value="提交">
						<input class="input" type="submit" name="sub2" value="分享">
					</form>
					<div class="form_l_c">										<!--*******分享区*******-->
						<span>分享区</span>
						<ul>
							<?php foreach ($message as $j) {
								if($j['share'] =="2"){
							?>
								<li class="li_share">
									<div class="share_c">
										<p><?php echo $j['content'] ?></p>
									</div>
									<div class="share_h">						<!--*******头像*******-->
											<?php
												if($j['uid'] != "0"){			
													echo "<img src='../users/" . $users[$j['uid']]['face_url'] . "'>";}
												else{
													echo "<img src='../users/img/favicon.png'>";}
											?>
										<strong>
											<?php
												if($j['uid'] != "0"){
													echo $users[$j['uid']]['username'];}
												else{
													echo '游客的分享';}
											?>
										</strong>
									</div>					
								</li>
							<?php } }?>
						</ul>
					</div>
				</div>
				<div class="form_r">
					<div id="title">												<!--*******置顶公告*******-->
						<div class="portrait" >
							<a href="#" class="photo"></a>
						</div>									
						<div class="title_c">
							<strong>公告：</strong>
							
							<p>新功能：可以在左侧分享区给我们分享内容。例如，一些好玩的炫酷的网站或者一些PS技巧。新增返回顶部小球、管理员审批功能</p>
						</div>
					</div>
					
					<ul>															<!--*******提交区*******-->
								<?php foreach ($message as $k) {
									if($k["share"] =="1"){
								?>
						<li class="li_one">
							<div class="portrait" >									<!--*******左侧头像*******-->
								<?php
									if($k['uid'] != "0"){
										echo "<img src='../users/".$users[$k['uid']]['face_url']."'>";
								}
									else{
										echo "<img src='../users/img/favicon.png'>";
								}

								?>
							</div>
								<span id="span_1"></span>							<!--*******三角形*******-->
							<div class="words_h">
								<strong>
									<?php
										if($k['uid'] != "0"){
											echo $users[$k['uid']]['username'];
									}
										else{
											echo '游客';
									}
									
									?> :
								</strong>
							</div>
							
							<div class="words_c">									<!--*******内容*******-->
								<?php echo $k['content'] ?>
							</div>
																							
								<div class="reply">									<!--*******留言内容*******-->
									<p>
										<?php
											if($k['reply'] !=""){
												echo '管理员：'.$k['reply'] ;
										}
											else{
												echo '';
											}
										?>
									</p>
								<div class="reply_b">
								

								<?php if(isset($_SESSION['role']) and $_SESSION['role']>=1){?>
									<form method="post">
										<input type="hidden" value="<?php echo $k['id']  ?>" name="id">
										<input id="reply_input1" type="text" name="content"  placeholder="已采纳、已解决、已收到">
										<input id="reply_input2" type="submit" name="sub3" value="回复">
									</form>
								<?php } ?>
								</div>

								</div>
							</li>
						<?php }} ?>
					</ul>
					<div class="return">											<!--*******返回顶部*******-->
						<a href="#top">返回顶部</a>
					</div>
				</div>
			</div>
	<div class="footer">															<!--*******页脚*******-->
		<p>©版权所有 星辰工作室 <a href="http://www.gzittc.net">www.gzittc.net</a> </p>
		<span>_____项目负责人 . XG_____</span>
	</div>
</body>
</html>