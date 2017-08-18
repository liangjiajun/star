<?php 
include("config.php");
include("header.php");

if(isset($_POST["btn"])){
	$name = $_POST['name'];
	$desc = $_POST["desc"];
	$people = $_POST["people"];
	$time = time();
	
	
	$sql = "INSERT INTO homework_subject VALUES (NULL,'$name','$people','zz','$time','$desc')";
	mysql_query($sql);
	header("location:index.php");

	
}
?>


<form method="post">
作业标题：<br>
<input name="name" type="text" /><br>
作业描述：<br>
<textarea name="desc"></textarea><br>
负责同学：<br>
<input name="people" type="text" /><br>
<input type="submit" name="btn" value="提交" / >
</form>





<?php include("footer.php");?>