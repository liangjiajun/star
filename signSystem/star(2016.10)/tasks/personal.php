<?php
/*
* 个人信息
*/
?>
<?php 
include('../config.php'); 
include('../functions.php');


$pageTitle = '22';
include('header.php');


?>

	<section class="cont">

		<div class="left">

				<h2 class="sub-header">个人资料</h2>

				<div class="list-group">

					<div class="head-portrait">

						

					</div>

					姓名：

				</div>

			</div>

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

				      		}

				       ?>

				    </tr>

				  </thead>

				  <tbody>

	<?php 

		$sql = "SELECT * FROM tasks INNER JOIN users  ON tasks.user_id=users.id ORDER BY `tasks`.`calendar` DESC limit 0, 11";

		/*按照tasks表的calendar时间字段倒序排序。从新到旧*/

		$result = mysql_query($sql); 



		while($user = mysql_fetch_array($result)){

			if($user['time'] < 12){

				$time = '上午';

			}else{

				$time = '下午';

			}

			echo "<tr>".'<td>'.'['.$user['calendar'].$time.']'.'</td><td>'.$user['name'].'</td><td>'.$user['username'].'</td>';



			if(isset($_SESSION['user'])){

				echo " <td><a href='$user[download_path]'><button type='button' class='btn btn-default'>下载</button></a></td>"."</tr>";

			}

		}

	?>

			   </tbody>

			</table>

		</div>

	</section>



</body>

</html>