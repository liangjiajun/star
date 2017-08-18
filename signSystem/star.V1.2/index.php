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


?>
		<aside class='tabbable'>
		<a href="upload.php" class="release">发布任务</a>
		<ul class="nav nav-tabs">
		  <!-- <li class="active"><a href="#tab" data-toggle="tab">全部</a></li> -->
		  <?php while($row = mysql_fetch_array($result)){ ?>
				<li><a href="#tab<?php echo $row['id'] ?>" data-toggle="tab"><?php echo $row['name'] ?></a></li>
		  <?php } ?>
		</ul>
		<div class="tab-content work">

		<?php
		$sql = "SELECT * FROM task_types";
		$result=mysql_query($sql);
		$num =1;
	
		 while($row = mysql_fetch_array($result)){ ?>
			<div class="tab-pane <?php if($num ==1){ echo "active";$num=0;}?>" id="tab<?php echo $row['id'];?>" >
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
					<td><?php echo date('Y-m-d',$d['startTime'])  ?>(剩余7天)</td>
					<td>
						<span>30%</span>
						<div class="progress-bar progress-bar-striped active" style="width: 30%">
					</td>
					<td>设计组 前段布局组</td>
					<td>
						<a href="description.php?id=<?php echo $d['id']; ?>">
						<?php  
							$user ='28';/*SESSION ID*/
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
				<?php } }?>
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

		});
	</script> 
</body>
</html>