<?php

	include('../config/config.php');
	include('../view/header.php');
	echo '<link rel="stylesheet" href="../style/addquestion.css">';
	echo '<script src="../javascripts/jquery.js"></script>';
	echo '<script src="../javascripts/dropzone.js"></script>';
	$sql ="SELECT * FROM answer_type";
	$result = mysql_query($sql);
	$type =array();
	while($row=mysql_fetch_assoc($result)){
		$type[]=$row;
	}
?>

	<address>
		<div class="question-text">
		<header>
			<h2>添加题库</h2>
		</header>
			<form action="../php/insert.php" method="post">
				<label>题目类型：<sup>*</sup></label>
				<select name="type">
					<?php foreach($type as $t){ ?>
						<?php echo '<option>'.$t['type'].'</option>' ?>
					<?php } ?>
				</select>
				<label>问题:<sup>*</sup></label>
				<textarea name="issueContent"></textarea>
				<label>正确答案：<sup>*</sup></label>
				<input type="text" name="rightIssue" value="<?php if(isset($_POST['rightIssue'])) echo $_POST['rightIssue'];?>">
				<label>错误答案：<sup>*</sup><span class="cc">请填写三个错误的答案</span></label>
				<input type="text" name="issue1" value="<?php if(isset($_POST['issue1'])) echo $_POST['issue1'];?>">
				<input type="text" name="issue2" value="<?php if(isset($_POST['issue2'])) echo $_POST['issue2'];?>">
				<input type="text" name="issue3" value="<?php if(isset($_POST['issue3'])) echo $_POST['issue3'];?>">
				<button type="submit" name="sub" id="submit">提交</button>
			</form>
		</div>
		<!-- 手动发布 -->
		<div class="question-update">
			<header>
				<h2>上传文件</h2>
			</header>
			<div class="more-question">
				<span>多题添加：文件为excel格式，可自行下载</span>
				<a href="../upload_file/sample.zip" class="sample" title="样本下载">样本下载</a>
			</div>
			<!-- 样本下载 -->
			<form action="../php/post.php" class="drop_area" id="dropArea"></form>
			<!-- 拖拽上传区域 --> 
			<form class="area_update" action="../php/post.php" method="post" enctype="multipart/form-data">
				<input type='text' id='textfield' class='txt' />
				<input type='button' class='btn' value='浏览....' />
				<input type="file" name="file" class="file" id="fileField" size="28" onchange="document.getElementById('textfield').value=this.value"/>
				<button type="submit" name="file_update">上传</button>
			</form>
			<!-- 手动上Exl传区域 -->
		</div>
	</address>
</body>
</html>
<!-- <script src="../javascripts/ajaxUpload.js"></script> -->
<script>
/*function varBlank(field,alerttxt){
	with (field){
		if (value == null||value == ""){
			$("#submit").attr('disabled','true');
    		$("#submit").html("请完整填写全部题目(=￣ω￣=)");
		}else {
			 $('#submit ').removeAttr('disabled');
      		$("#submit ").html("提交");
		}
	}
}
	
*/
$("#dropArea").dropzone({ url: "../php/post.php",});
</script>
