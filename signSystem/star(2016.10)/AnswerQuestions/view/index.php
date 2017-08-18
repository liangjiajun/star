<?php
	include('../config/config.php');
	include('../view/header.php');
	echo '<link rel="stylesheet" href="../style/index.css">';
	echo '<script src="../javascripts/jquery.js"></script>';
	$sql="SELECT * FROM answer_type";
	$result=mysql_query($sql);
	$question = array();
	while($row = mysql_fetch_assoc($result)){
		$question[]=$row;
	}
 ?>
	<section class="content">
		<h2>欢迎来到答题系统</h2>
			<div class="box">
				<div class="lineF">
		<?php foreach($question as $q){ ?>
					<ul class="boxF">
						<li class="boxS">
						<?php if(isset($_SESSION['user'])){ ?>
							<a class="boxT" style="background-image: url(../<?php echo $q['type_icon'] ?>);" 
							 href="question.php?type=<?php echo $q['type']; ?>" ></a>
						<?php }else{ ?>
							<a class="boxT" style="background-image: url(../<?php echo $q['type_icon'] ?>);" href="#" ></a>
						<?php } ?>
						</li>
					</ul>
		<?php } ?>
				</div>
			</div>
	</section>
	<!-- 管理面板 -->
	<address class="admin">
		<div class="por">
			<span class="admin_content_icon">管理面板</span>
			<div class="admin_content"></div>
			<form method="post"  class="form_text">
				<input type='text' id='tfile' class='txt'placeholder="请选择图片文件" />
				<input type='button' class='btn' value='浏览....' />
				<input type="file" name="file" class="file" id="filepoa" size="28" onchange="document.getElementById('textfield').value=this.value"/>
				<input type="text" name="" id="rank" placeholder="请输入题目类型">
				<button>上传</button>
			</form>
		</div>
	</address>
</body>
</html>