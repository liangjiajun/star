<?php  
	require 'view/header.php';
/*
	项目Tab标签分页
*/
$sql = "SELECT * FROM task_types";
$result=mysql_query($sql);

$sql = "SELECT * FROM task_types";
$resultType=mysql_query($sql);
$resultRow=mysql_fetch_array($resultType);
/*
	项目标题输出
*/	
$sql="SELECT * FROM task_title";
$resultTitle =mysql_query($sql);		
$description ='';
while($title=mysql_fetch_array($resultTitle)){
	$description[]=$title;
}


/*
	引用进度条
*/
$sql="SELECT task_title_id,user_id FROM task_works";
$works =mysql_query($sql);
$works_num ='';
while($files=mysql_fetch_array($works)){
    $works_num[$files['user_id']]=$files;
}
$progress = calc_progress($description, $works_num);

/*
	项目负责人
*/
$sql="SELECT * FROM task_title INNER JOIN user_group ON task_title.responsible = user_group.name  WHERE user_group.name";
$group_type = mysql_query($sql);
$responsible = '';
while($rep = mysql_fetch_array($group_type)){
	$responsible[] = $rep;
}



?>
		<aside class='tabbable'>
		<?php if(isset($_SESSION['role']) and $_SESSION['role']>0){ ?>
			<a href="upload.php" class="release">发布任务</a>
		<?php } ?>
		<ul class="nav nav-tabs">
				<li  class="active_more"><a href="#tab10" data-toggle="tab">所有</a></li>
		  <?php while($row = mysql_fetch_array($result)){ ?>
				<li  class="active_more"><a href="#tab<?php echo $row['id'] ?>" data-toggle="tab"><?php echo $row['name'] ?></a></li>
		  <?php } ?>
		</ul>
		<div class="tab-content work">
		

		<div class="tab-pane active" id="tab10" >
				<table class="table">
					<thead>
						<tr>
							<th>项目名</th>
							<th>时间</th>
							<th>当前进度</th>
							<th>负责人</th>
							<th>操作</th>
						</tr>
					</thead>


				<?php 
					foreach($description as $d){ 
				
				?>
					<tbody>
				<tr>
					<td><a href="description.php?id=<?php echo $d['id']; ?>"><?php echo $d['title'] ?></a></td>
					<td><?php echo date('Y-m-d',$d['startTime'])  ?>(剩余<?php echo dayLeft($d['endTime']) ?>)</td>
					<td>
						<span><?php echo $progress[$d['id']].'%' ?></span>
						<div class="progress-bar progress-bar-striped active" style="width: <?php echo $progress[$d['id']].'%' ?>">
					</td>
					<td>
					<?php 
							$date_rep = getRespon($d['responsible']);
							foreach ($date_rep as $v) {
								$str = '';
								foreach($v['user'] as $k){
									$str .= $k.' , ';
								}
								$str = rtrim($str,' , ');
								echo '<span title="'.$str.'" data-toggle="username" data-placement="bottom">'.$v['group'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
							}
					?>
					</td>
					<td>
						<a href="description.php?id=<?php echo $d['id']; ?>">
						<?php  
							$user =$_SESSION['id'];
							// $user ="38";
							$res=$d['responsible'];
							if(strpos($res,$user) !== false){
						?>
							<button type="button" class="btn btn-defrult">提交作品</button>
						<?php }else{ ?>
							<button type="button" class="btn gray">项目详情</button>
						<?php } ?>

						</a>
					</td>
				</tr>
			</tbody>
				<?php 
					
				 }?>

			</table>		
			</div>
	

		<?php
		$sql = "SELECT * FROM task_types";
		$result=mysql_query($sql);
		$num =1;
	










		 while($row = mysql_fetch_array($result)){ ?>
			<div class="tab-pane" id="tab<?php echo $row['id'];?>" >
				<table class="table">
					<thead>
						<tr>
							<th>项目名</th>
							<th>时间</th>
							<th>当前进度</th>
							<th>负责人</th>
							<th>操作</th>
						</tr>
					</thead>
				<?php 
					foreach($description as $d){ 
						if($row['id'] == $d['type_id']){	
				?>
					<tbody>
				<tr>
					<td><a href="description.php?id=<?php echo $d['id']; ?>"><?php echo $d['title'] ?></a></td>
					<td><?php echo date('Y-m-d',$d['startTime'])  ?>(剩余<?php echo dayLeft($d['endTime']) ?>)</td>
					<td>
						<span><?php echo $progress[$d['id']].'%' ?></span>
						<div class="progress-bar progress-bar-striped active" style="width: <?php echo $progress[$d['id']].'%' ?>">
					</td>
					<td>
					<?php 
							$date_rep = getRespon($d['responsible']);
							foreach ($date_rep as $v) {
								$str = '';
								foreach($v['user'] as $k){
									$str .= $k.' , ';
								}
								$str = rtrim($str,' , ');
								echo '<span title="'.$str.'" data-toggle="username" data-placement="bottom">'.$v['group'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
							}
					?>
					</td>
					<td>
						<a href="description.php?id=<?php echo $d['id']; ?>">
						<?php  
							$user =$_SESSION['id'];
							// $user ="38";
							$res=$d['responsible'];
							if(strpos($res,$user) !== false){
						?>
							<button type="button" class="btn btn-defrult">提交作品</button>
						<?php }else{ ?>
							<button type="button" class="btn gray">项目详情</button>
						<?php } ?>

						</a>
					</td>
				</tr>
			</tbody>
				<?php 
					}
				 }?>
				</table>		
			</div>
		<?php } ?>
			<div class="area_page">
					<!--页码-->
					<span>2 / 6</span>

					<ul>
					   <li>
					   		<a href="" title=""><button type="button" class="btn btn-default">首页</button></a>
					   </li>
					   <li>
					   	<a href="" title=""><button type="button" class="btn btn-default">上一页</button></a>
					   </li>
					   <li>
					   	<a href="" title=""><button type="button" class="btn btn-default">1</button></a>
					   </li>
					   <li>
					   	<a href="" title=""><button type="button" class="btn btn-default">2</button></a>
					   </li>
					   <li>
					   	<a href="" title=""><button type="button" class="btn btn-default">3</button></a>
					   </li>
					   <li>
					   	<a href="" title=""><button type="button" class="btn btn-default">下一页</button></a>
					   </li>
					   <li>
					   	<a href="" title=""><button type="button" class="btn btn-default">尾页</button></a>
					   </li>
					</ul>
					<div style="clear: both;"></div>
			</div>
		</div>
	</aside>
		<div style="clear: both;"></div>
	</div>
	<footer>
		<p>&copy; 版权所有 星辰工作室  <a href="www.gzittc.net" title="">www.gzittc.net</a></p>
	</footer>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(function () { 

		  $('.panel').on('show.bs.collapse', function () {
					$(this).children('div').children('h4').children('span').removeClass('glyphicon-chevron-down','glyphicon-chevron-up');
					$(this).children('div').children('h4').children('span').addClass('glyphicon-chevron-up');
		  	}).on('hide.bs.collapse', function () {
		    	$(this).children('div').children('h4').children('span').removeClass('glyphicon-chevron-down','glyphicon-chevron-up');
		    	$(this).children('div').children('h4').children('span').addClass('glyphicon-chevron-down');
		 })
		  
		 $('.nav-tabs li:first-child').addClass('active');
		$('[data-toggle="username"]').tooltip();

		});
	</script> 
</body>
</html>