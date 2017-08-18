<?php
/*
* 搜索结果
*/
?>
<?php 
include('../config.php'); 
include('../functions.php');
$pageTitle = '搜索结果';
include('header.php');
?>

<body id="fuzzy">

<?php 
include('../top.php');
?>

<?php include('searchForm.php'); ?>

<section class="cont">

	<?php include('sidebar.php') ?>

	<div class="right">
			<table class="table table-hover table-striped">
			  <thead>
			    <tr>
			      <th>时间</th>
			      <th>作品名称</th>
			      <th>用户名</th>
			      <?php 
			         if(isset($_SESSION['user'])){
			      		echo "<th>下载</th>";
			      		echo "<th></th>";
			      		}
			       ?>
			    </tr>
			  </thead> 
			  <tbody>
<?php 

if(!isset($_GET['page'])){
	if(empty($_POST['fuzzyText'])){
		$err = '请输入查询字段';
	}else{
		$fuzzyText = $_POST['fuzzyText'];
		$fuzzyTexts = explode(" ", $fuzzyText);
		if(count($fuzzyTexts)>1){  /*判断数组的值是否大于一，如果大于一就执行两个模糊搜索*/
			$sql = "SELECT *,tasks.id as 'tid' FROM tasks INNER JOIN users  ON tasks.user_id=users.id where username like '%$fuzzyTexts[0]%' or username like '%$fuzzyTexts[1]%' AND tasks.trash != '1' ORDER BY `tasks`.`id` DESC ";
		}else{
			$sql = "SELECT *,tasks.id as 'tid'  FROM tasks INNER JOIN users  ON tasks.user_id=users.id where username like '%$fuzzyTexts[0]%'  AND tasks.trash != '1' ORDER BY `tasks`.`id` DESC ";
		}
		$result = mysql_query($sql); 

		while($user = mysql_fetch_array($result)){



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


			// echo "<tr>".'<td>'.T($fuzzy['timestamp']).'</td><td>'.$fuzzy['name'].'</td><td><a href="../users/personal.php?userid='.$fuzzy['id'].'">'.$fuzzy['username'].'</a></td>';
			// if(isset($_SESSION['user'])){
			// 	echo " <td><a href='$user[download_path]'><button type='button' class='btn btn-default'>下载</button></a></td>"."</tr>";
			// }



		}
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