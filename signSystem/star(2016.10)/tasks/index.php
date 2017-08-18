<?php
/*
* 首页
*/
?>
<?php 
include('../config.php'); 
include('../functions.php');
$pageTitle = '成果提交平台';
include('header.php');
?>
<body>
<?php 
include('../top.php');
?>


<?php include('searchForm.php');?>
<section class="cont">
	<?php include('sidebar.php'); ?>
	<div class="right">

			<!-- 内容输出 -->
			<table class="table table-hover table-striped">
			  <thead>

			    <tr>
			      <th>提交时间</th>
			      <th>作品名称</th>
			      <th>用户名</th>

			      <?php 
			         if(isset($_SESSION['user'])){
			      		echo "<th>下载</th>";
			      		}
			       ?>
			    </tr>
			  </thead>
			  <tbody>

<?php 

$sql = "SELECT count(id) FROM tasks";
$result = mysql_query($sql);
$count = mysql_fetch_assoc($result);
$count = $count['count(id)'];
$limit = 20; //每页显示21条
$page = isset($_GET['page'])?$_GET['page']:1;
$all_page = floor($count/$limit);
$start = ($page - 1)*$limit;
$sql = "SELECT *,tasks.id as `tid` FROM tasks INNER JOIN users  ON tasks.user_id=users.id WHERE tasks.trash != '1'  order by tasks.id desc limit $start, $limit";
$result = mysql_query($sql); 

	while($user = mysql_fetch_array($result)){

		// echo "<tr>".'<td>'.'['.$user['calendar'].$time.']'.'</td><td>'.$user['name'].'</td><td>'.$user['username'].'</td>';
		
		if($user['timestamp']==0){
			echo "<tr>".'<td>'.$user['calendar'].'</td><td>'.$user['name'].'</td><td><a href="../users/personal.php?userid='.$user['id'].'">'.$user['username'].'</a></td>'; 
		}else{
			
				echo "<tr>".'<td>'.T($user['timestamp']).'</td><td>'.$user['name'].'</td><td>';

				if($user['face_url'] != ""){
					echo '<img src="../users/'.$user['face_url'].'" style="width:20px; height:20px; border-radius:20px;"/>';
				}else{
					echo '<img src="../users/img/favicon.png" style="width:20px; height:20px; border-radius:20px;"/>';
					
				}
				echo '<a href="../users/personal.php?userid='.$user['id'].'">'.$user['username'].'</a></td>';
		}
		
		if(isset($_SESSION['user'])){
			echo " <td><a href='download.php?id=".$user['tid']."'><button type='button' class='btn btn-default'>下载(".$user['downloadTimes'].")</button></a></td></tr>";
			// echo " <td><a href='$user[download_path]'><button type='button' class='btn btn-default'>下载</button></a></td>"."</tr>";
		}

	}

?>

		   </tbody>

		</table>

	</div>

</section>

<?php 
include('footer_01.php');
include('footer.php')
?>