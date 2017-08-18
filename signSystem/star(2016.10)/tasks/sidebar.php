<?php 


//随机拿到用户
// $sql = "SELECT * FROM users ORDER BY RAND()";
$sql = "SELECT * FROM users ORDER BY id DESC";
$r = mysql_query($sql);




//拿到作业
$sql = "SELECT count(*),user_id FROM tasks WHERE trash = '0' GROUP BY user_id ";
$r2 = mysql_query($sql);
$task = array();

while($row =  mysql_fetch_array($r2)){
	// $task[$row["user_id"]][] = $row	;
	$task[$row["user_id"]] = $row["count(*)"];
	
}
?>

<div class="left">

			<h2 class="sub-header">作品分类</h2>

				<div class="list-group">

				<!-- 作品分类页start -->

				<?php 

					$sql = "SELECT * FROM task_types";
					$result = mysql_query($sql); 
					$task_types = array();
					while($user = mysql_fetch_array($result)){
						$task_types[] = $user;
					} 

				?>

				<?php foreach ($task_types as $key => $value) { ?>

					<button type="button" class="list-group-item"><a class="displayblock" href="sections.php?id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></button>

				<?php } ?>

				<!-- 作品分类页end -->
				</div>
				<div><b>成员列表:</b></div>
				<div class="list-group">
				<ul>
				<?php 
					while($user = mysql_fetch_array($r)){

							if(isset($task[$user["id"]])){
								$num = $task[$user["id"]];

							}else{
								$num =  "0";
							}

							echo "<li><a href='../users/personal.php?userid=".$user["id"]."' title='".$user["username"]."'>";

							if($user['face_url'] != ""){
								echo '<img src="../users/'.$user['face_url'].'" style="width:20px; height:20px; border-radius:20px;"/>';
							}else{
								echo '<img src="../users/img/favicon.png" style="width:20px; height:20px; border-radius:20px;"/>';
							}
							echo $user["username"];						
							echo "(".$num.")";
							echo "</li></a>";
					}
				 ?>
				 </ul>
				</div>

		</div>