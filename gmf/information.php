<?php 
/*
	信息推送页面
*/

include('config.php');


/*后台添加推送内容*/
if(isset($_POST['info_sub'])){
	$content = $_POST['content'];
	$title = $_POST['title'];
	$sql = 'INSERT INTO `gmf`.information (`content_info`,`create_time`,`time_desc`) VALUES ("'.$content.'","'.date('Y-m-d',time()).'","'.time().'")';
	mysql_query($sql);
	// echo $sql;
	header('location:information.php');
}



/*客户端推送更新内容*/
if(isset($_GET['information'])){
	header("Content-type:text/html;charset=utf-8");
	header('Content-type: application/json');
	$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
	$num = $_GET['information'];
	$sql = 'SELECT * FROM `gmf`.`information` ORDER BY `time_desc` DESC LIMIT '.$num.'';
	$r = mysql_query($sql);
	$data=array();
	while($row = mysql_fetch_assoc($r)){
		$data = array('id'=>$row['id'],'content_info'=>$row['content_info'],'create_time'=>$row['create_time']);
	}
	$data=json_encode($data);
	echo $jsoncallback.'('.$data.')';  
}
 



if(empty($_GET['information'])){


	/*搜索全部的推送内容*/
	$sql =mysql_query('SELECT * FROM `gmf`.`information` ORDER BY `time_desc` DESC');
	$data=array();
	while ($row = mysql_fetch_assoc($sql)) {
		$data[]=$row;
	}

	/*删除推送内容*/
	if(isset($_GET['del'])){
		$id = $_GET['del'];
		$sql = mysql_query('DELETE FROM `gmf`.information WHERE `id` ='.$id.' ');
		header('location:information.php');
	}





?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>信息推送</title>
	<style>
		textarea{width: 500px;height: 200px;display: block;}
	</style>
</head>
<body>
	<form method="post">
		<textarea name="content" placeholder="用句号表示换行"></textarea>
		<button type="submit" name="info_sub">提交</button>
	</form>
	<hr>
	<h3>更新日志</h3>
	<hr>
	<?php foreach ($data as $k => $v) { 
		$content = explode('。',$v['content_info']);
		$content  = array_filter($content);
	?>
	<div>
		<h4><?php echo $v['content_topic']; ?></h4>
		<time><?php echo date('Y-m-d H:i:s',$v['time_desc']); ?></time>
		<?php $i=1; foreach ($content as $k1 => $v1) { ?>
			<p><?php echo $i++.'、'.$v1; ?></p>
		<?php } ?>
		<a href="information.php?del=<?php echo $v['id']; ?>">删除</a>
	</div>
	<hr>
	<?php } ?>
</body>
</html>
<?php } ?>