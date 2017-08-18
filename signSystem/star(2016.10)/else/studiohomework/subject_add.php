<?php 
include("config.php");
include("header.php");

if(isset($_POST["btn"])){
	$name = $_POST['name'];
	$desc = $_POST["desc"];
	$people = $_POST["people"];
	$time = time();
	
	
	$sql = "INSERT INTO studio_homework_subject VALUES (NULL,'$name','$people','zz','$time','$desc')";
	mysql_query($sql);
	header("location:index.php");

	
}
?>
<form method="post">
作业标题：<br>
<input name="name" type="text" size="200" style="line-height:30px; padding:5px" /><br>
作业描述：<br>
<textarea name="desc" style="line-height:30px; padding:5px; width:200px;" ></textarea><br>
负责：<br>
<input name="people" type="text"  style="line-height:30px; padding:5px" size="200"/><br>
<input type="submit" name="btn" value="提交" style="line-height:30px; padding:15px 30px"  / >
</form>





<?php include("footer.php");?>