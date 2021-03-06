<?php 
	include('config/config.php');
	include('config/functions.php');

/*
	成员与组的列表
*/	
$sql="SELECT *,users.id AS 'uid',user_group.id AS 'gid' FROM user_group_users INNER  JOIN users ON user_group_users.user_id=users.id INNER  JOIN user_group  ON user_group_users.group_id =user_group.id WHERE user_group.id != 1";
$result =mysql_query($sql);
$member ="";
while($row =mysql_fetch_array($result)){
	$member[] = $row;
}

/*
	组类型
*/
$sql = "SELECT * FROM user_group";
$r = mysql_query($sql);
$groups = "";
while($row = mysql_fetch_assoc($r)){
	$groups[] = $row;
}

$sql = "SELECT * FROM users";
$rq = mysql_query($sql);
$user = mysql_fetch_array($rq);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link href="style/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style/instyle.css">
	<link rel="stylesheet" href="style/universal.css">
</head>
<body>
<?php 
	require '../top.php';
?>
	<!-- /header -->
	<div class="wrap">
		
		<section>
			<div class="area_logo">
				<a href="index.php">
					<img src="img/logo.png" alt="logo">
					<h1>作品提交平台V1.2</h1>
				</a>
			</div>

			<div class="area_search">
				<input type="text" class="form-control search_input" name="" value="" placeholder="关键字">
				<button type="submit"  class="btn btn-default search_button" name="">搜索</button>
			</div>
		</section>

		<article>
			<div class="panel-group" id="accordion">
		  <h3>成员列表</h3>
		  <?php foreach ($groups as $key) {?>
			<div class="panel">
			    <div class="panel-heading"data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key['id'] ?>">
			      <h4 class="panel-title">
				      <a class="panel-a"><?php echo $key['name']?></a>
				      <span class="glyphicon glyphicon-chevron-down panel-span"></span>
			      </h4>
			    </div>
			    <div id="collapse<?php echo $key['id'] ?>" class="panel-collapse collapse">
			      <ul class="panel-body">
			      <?php foreach($member as $mem){ 
						if($mem['gid'] == $key['id']){
				  ?>
	  		       <li class="avatar" title="<?php echo $mem['username'];?> " data-toggle="username" data-placement="bottom">
	  		       		<a href="../users/personal.php?userid=<?php echo $mem['uid'] ?>"><img src='<?php echo '../users/'.$mem['face_url'] ?>' alt="<?php echo '../users/'. $mem['face_url'] ?>" width='100%' height='100%' style="border-radius: 50px;border:none"></a>
	  		       </li>
	  		      <?php }}?>
	  		      </ul>
			    </div>
			</div>
		<?php } ?>
		</div>
		</article>
<script src="js/jquery.js"></script>
<script>

	$('.panel-body').each(function(){
		if($(this).children('li').length == 0){
			$(this).parent().parent().hide();
		}
	})	
	

</script>