<?php
/*分页*/

include('../config.php'); 
include('../functions.php');
$pageTitle = '分类筛选';
include('header.php');
?>

<body id="sections">

<?php 
include('../top.php');
?>




<?php include('searchForm.php');?>
<section class="cont">
	<?php include('sidebar.php'); ?>
	



		<div class="right">	

			<table class="table table-hover table-striped">

			  <thead>

			    <tr>

			      <th>提交时间</th>

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

		$valueid = $_GET['id'];

if(!isset($_POST['CalendarnName']) && !isset($_POST['fuzzyText'])){/*如果没有查询日期提交和名字查询的话就执行下面代码。正常显示遍历tasks数据库数据*/

		$sql = "SELECT *,tasks.id as 'tid' FROM tasks INNER JOIN users ON tasks.user_id=users.id 

					WHERE type_id='$valueid'

					ORDER BY `tasks`.`calendar` DESC";

		/*按照tasks表的calendar时间字段倒序排序。从新到旧*/

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

		}


}
// else{	/*如果有查询日期提交和名字查询的话就执行下面代码。*/

// 	if(isset($_POST['CalendarStart'])){/*如果有CalendarStart就显示遍历tasks数据库calendar字段的数据*/

// 		$CalendarStart = $_POST['CalendarStart'];

// 		$CalendarEnd = $_POST['CalendarEnd'];



// 		$sql = "SELECT * FROM tasks INNER JOIN users  ON tasks.user_id=users.id  WHERE  calendar  between '$CalendarStart' and '$CalendarEnd' ORDER BY `tasks`.`calendar` DESC ";

// 		$result = mysql_query($sql); 



// 		if($user['time'] < 12){

// 			$time = '上午';

// 		}else{

// 			$time = '下午';

// 		}



// 		while($Calendarn = mysql_fetch_array($result)){

// 			echo "<li>".'['.$Calendarn['calendar'].$time.']----'.$Calendarn['name'].'||'.$Calendarn['username'];



// 			if(isset($_SESSION['user'])){

// 				echo " <a class='right_sub' href='$Calendarn[download_path]'>↓</a>"."</li>";

// 			}

// 		}

// 	}else{/*如果有CalendarStart就显示遍历tasks数据库name字段的数据*/

// 		if(empty($_POST['fuzzyText'])){

// 		 	$err = '请输入查询字段';

// 		}else{

// 			$fuzzyText = $_POST['fuzzyText'];

// 			$fuzzyTexts = explode(" ", $fuzzyText);

			



// 			if(count($fuzzyTexts)>1){  /*判断数组的值是否大于一，如果大于一就执行两个模糊搜索*/

// 				$sql = "SELECT * FROM tasks INNER JOIN users  ON tasks.user_id=users.id where name like '%$fuzzyTexts[0]%' or name like '%$fuzzyTexts[1]%' ORDER BY `tasks`.`calendar` DESC ";

// 			}else{

// 				$sql = "SELECT * FROM tasks INNER JOIN users  ON tasks.user_id=users.id where name like '%$fuzzyTexts[0]%' ORDER BY `tasks`.`calendar` DESC ";



// 			}

			

// 			$result = mysql_query($sql); 



// 			if($user['time'] < 12){

// 				$time = '上午';

// 			}else{

// 				$time = '下午';

// 			}



// 			while($fuzzy = mysql_fetch_array($result)){

// 				echo "<li>".'['.$fuzzy['calendar'].$time.']----'.$fuzzy['name'].'||'.$fuzzy['username'];



// 				if(isset($_SESSION['user'])){

// 					echo " <a class='right_sub' href='$fuzzy[download_path]'>↓</a>"."</li>";

// 				}

// 			}

// 		}

// 	}

// }



?>

<?php 



	$sql = "SELECT count(id) FROM tasks";

	$result = mysql_query($sql);

	$count = mysql_fetch_assoc($result);

	//print_r($count) ;

	$count = $count['count(id)'];



	$limit = 11;

	$page = isset($_GET['page'])?$_GET['page']:1;

	$all_page = ceil($count/$limit);



	if($page <= 1){

	$page = 1;

	}

	if($page >= $all_page){

	$page = $all_page;

	}



	$start = ($page - 1)*$limit

?>

		 		   </tbody>

		 		</table>

		 	</div>

		 </section>



<?php 
include('footer_01.php');
include('footer.php')
?>

<!-- 时间查询的My97DatePicker控件js链接 -->

<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

