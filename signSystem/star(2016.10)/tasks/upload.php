<?php 
/*
* 作品提交
*/

	// header("Content-type:text/html;charset=gb2312");    

	header("Content-type:text/html;charset=utf-8");  

	include('../config.php');
	include('../functions.php');

	/*判断是否有文件提交和post提交*/

if(isset($_FILES['file']) && isset($_POST['sub']) && isset($_POST['name']) && $_POST['name'] != "" && $_POST['task_type'] != ""){


	 $fileinfo = $_FILES['file'];
	$error = $fileinfo['error'];
	$name = $_POST['name'];
	$extension =  get_extension($fileinfo['name']);


	/*执行数据库查找，是否有重命名的文件名*/

		/*遍历数据库*/

	$sql = "SELECT name FROM tasks WHERE name = '$name' ";

	$result = mysql_query($sql);

	$row = mysql_fetch_assoc($result);

		/*遍历数据库end*/

	/*用重命名就不予命名文件返回用户重新命名*/

	if(isset($row['name'])){

		$err = "已有重名文件，请重新输入";

	}else{



		$calendar = date('Y-m-d');

		$t = date('H:i:s');
		$timestamp = time(); //记录一个时间戳方便后期使用

		$task_type =  $_POST['task_type'];

		$download_path = "upload/".uniqid().".".$extension;

			
		// $download_path=iconv('UTF-8','GB2312',$download_path); //linux 下要删除此句


		 /*判断文件上传是不是正确，正确保存上传文件的用户ID，错误就放回错误值*/

		 if($error == 0){

		 	if(move_uploaded_file($_FILES["file"]["tmp_name"],$download_path)){
		 	// if(move_uploaded_file($_FILES["file"]["tmp_name"],$download_path)){ //mac linux ，windows使用上面

		 		if(isset($_SESSION['user'])){
		 			$userid = $_SESSION['id'];
		 		}else{

		 			$userid = 0;

		 		}

		 }else{

				switch($error){

					case 1:

						$err1 = '上传文件超过PHP配置文件中upload_max_filesize的值';

					break;

					case 2:

						$err2 = '超过表单MAX_FILE_SIZE限制的大小';

					break;

					case 3:

						$err3 =  '文件部分被上传';

					break;

					case 4:

						$err4 =  '没有选择上传文件';

					break;

					case 6:

						$err5 = '没有找到临时目录';

					break;

					case 7 :

						$err7 = '系统错误';

					break;

					case 8 :

						$err8 = '系统错误';

					break;

				}

			}/*文件插入的错误放回end*/



		/*把作品提交的数据插入数据库*/

			$sql = "INSERT INTO `tasks`( `user_id`, `name`, `type_id`, `calendar`,`time`, `download_path`,`timestamp`) 

				    VALUES ('$userid','$name','$task_type','$calendar','$t','$download_path','$timestamp ')";

				if(mysql_query($sql)){

					header('location:index.php');

				}/*把作品提交的数据插入数据库end*/

			}/*判断文件上传是不是正确，正确保存上传文件的用户ID，错误就放回错误值end*/

	}/*用重命名就不予命名文件返回用户重新命名end*/

}/*如果有提交就执行end*/

?>

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

 <body id="upload">

	 	<div class="blur">

	     	<div id="wrap">

		     	<a href="index.php" class="glyphicon glyphicon glyphicon-chevron-left aindex"></a>

		     	<h1 class="title1">上传作业区</h1>

	         	<h4 class="title4">选择作业类型</h4>

	       			<form method="post" enctype="multipart/form-data" id="form_left">

					



					
						
	                    <input type="hidden" name="type" value="1">

	                 	<input maxlength="35" name="name" class="input inputt" id="input_one" type="text" placeholder="(^_^) 输入作业名称">

	                 	<span class="err"><?php if(isset($err)){echo $err;} ?></span>

	                    <br/>

	                    <input type="file" name="file"id="file">

	                    <input name="filetosub" class="input btn btn-info inputf filetosub" type="button" value="(=^_^=) 点击选择文件">

	                    <br/>

	                    <input name="sub"  class="input btn btn-primary btn-lg inputs" type="submit" value="\^o^/ 提交作业">
	                    <div id="left">
	                     	<label><input type="radio" name="task_type" value="1" >前端</label>
	                     	<label><input type="radio" name="task_type" value="2">后端</label>
	                     	<label><input type="radio" name="task_type" value="3">设计</label>
	                     	<label><input type="radio" name="task_type" value="4">打字测试</label>
						</div>

	                    



	                 	<span class="err1">

		                 	<?php  if(isset($err1)){echo $err1;} ?>

		                 	<?php  if(isset($err2)){echo $err2;} ?>

		                 	<?php  if(isset($err3)){echo $err3;} ?>

		                 	<?php  if(isset($err4)){echo $err4;} ?>

		                 	<?php  if(isset($err6)){echo $err6;} ?>

		                 	<?php  if(isset($err7)){echo $err7;} ?>

		                 	<?php  if(isset($err8)){echo $err8;} ?>

	                 	</span>

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

						<style>
							label{ display: block;}
							#left{ color: #fff; margin-top:60px; font-weight: normal;  font-family: '宋体'}
							#left label:hover{ color: green;}
						</style>


