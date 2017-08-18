<?php  
	require 'view/header.php';
	echo '<link href="style/bootstrap.min.css" rel="stylesheet">';
	echo '<link href="style/square/_all.css" rel="stylesheet">';
	echo '<link rel="stylesheet" href="style/destyle.css">';
	echo '<link rel="stylesheet" href="style/universal.css">';

/*
	项目负责人
*/	
$id =$_GET['id'];

$sql="SELECT * FROM task_title  WHERE id = '$id'";
$result =mysql_query($sql);		
$description = mysql_fetch_array($result);
$data_arr = explode(',',$description['responsible']);




/*
	作业列表
*/
$sql = "SELECT *,task_works.id AS 'tid' FROM task_works 
		INNER  JOIN task_title ON task_works.task_title_id = task_title.id 
		INNER  JOIN users ON users.id = task_works.user_id 
		WHERE task_title_id = '$id'";
$work_result=mysql_query($sql);
$user_work='';
while($user_row =mysql_fetch_array($work_result)){
	$user_work[]=$user_row;
}



/*
	成员与组的列表
*/	
$sql="SELECT *,users.id AS 'uid',user_group.id AS 'gid' FROM user_group_users INNER  JOIN users ON user_group_users.user_id=users.id INNER  JOIN user_group  ON user_group_users.group_id =user_group.id WHERE user_group.id";
$g_result =mysql_query($sql);
$member ="";
while($row =mysql_fetch_array($g_result)){
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

$sql = "SELECT * FROM users ";
$rw = mysql_query($sql);
$userimg='';
while($user = mysql_fetch_array($rw)){
	$userimg[$user['id']] = $user;
}

$userWorkid = $_SESSION['id'];

?>
			
		<aside>
			<h3>作品详细页</h3>
			<div class="detail">
				<h2><?php echo $description['title'] ?></h2>
				<div class="area_text">
					<p><?php echo $description['des']  ?></p>
				</div>
				<div class="area_time">
					<p>剩余<span><?php echo dayLeft($description['endTime']) ?></span> </p>
					<p>开始 : <span><?php echo  date('Y-m-d',$description['startTime']) ?></span></p>
					<p>结束 : <span><?php echo  date('Y-m-d',$description['endTime']) ?></span></p>
				</div>
				

				<div class="area_responsible">
					<h4>负责人</h4>
					<div class="form_person">
			<?php
				$group_name='';
				$taskgroup = '';
				 foreach ($data_arr as $a){ 
				 	/*
						获取组的ID
				 	*/
					$sql ="SELECT * FROM user_group_users  WHERE user_id ='$a' ";
					$result_group = mysql_query($sql);
					$group = mysql_fetch_array($result_group);
					$gid = $group['group_id'];
					/*
						获取组的名字
					*/
					$sql ="SELECT * FROM user_group WHERE id ='$gid'";
					$result_g = mysql_query($sql);
					$row_task = mysql_fetch_assoc($result_g);
					$task_name = $row_task['name'];
					/*
						获取用户名
					*/
					$sql = "SELECT * FROM users WHERE id = '$a'";
	        		$re_username = mysql_query($sql);
	        		$row_username = mysql_fetch_assoc($re_username);
	        		$name_user=$row_username['username'];

					if($group_name =="" OR $gid !=$group_name){
						$group_name = $gid;						
			?>
				
			       	<div class="group">
			       		<div class="group_name">
			               	<span><?php echo $task_name ?></span>
			            </div>
			        <?php } ?>

		   			    <a href="#" class="list_user">
		   			    	<img alt="<?php echo '../users/'. $userimg[$a]['face_url'] ?>" src="<?php echo '../users/'. $userimg[$a]['face_url']; ?>" title="<?php echo $name_user; ?>" data-toggle="username" data-placement="bottom" width="30px" height="30px" style="border-radius: 50px;border:none">
		   			    </a>

					<?php } ?>
			      </div>
				    </div>
				</div>
				<div style="clear:both"></div>
				
				<div class="area_upload">
				<?php if(isset($_SESSION['user'])){ ?>
					<p id="dropz">点击或拖放到此区域上传</p>
				<?php }else{ ?>
					<p>请先登录再上传</p>
				<?php } ?>
				</div>
				<div class="area_list">
				    <h4>作品列表</h4>

					<ul class="table des_title">
						<li>项目名</li>
						<li>作者</li>
						<li>提交时间</li>
						<li>操作</li>
					</ul>


				<?php 
				if($user_work !=""){
					foreach ($user_work as $u ){ 
				?>
					<ul class="des_task_work">
						<?php if($u['file_name'] !=''){ ?>
						<li><a class="ellipsis"><?php echo $u['file_name'] ?></a></li>
						<?php }else{ ?>
						<li><a class="ellipsis"><?php echo $u['title'] ?></a></li>
						<?php } ?>
						<li class="author"><?php echo $u['username'] ?></li>
						<li title="<?php echo date("Y-m-d H:i:s",$u['time']) ?>"><?php echo date("Y-m-d",$u['time']) ?><?php echo T($u['time']) ?></li>
					<?php if(isset($_SESSION['user'])){ ?>
						<li>
							<a href="dowload.php?id=<?php echo $u['tid']; ?>">
								<button type="submit" name="download_sub" class="btn btn-default color">下载</button>
							</a>
						</li>
					<?php }else{ ?>
						<li><p class="btn btn-default colornone" title="用户登录才可下载">下载</p></li>
					<?php } ?>
					</ul>
				<?php } }else{?>
						<p class="work_none">尚未有同学提交作业</p>
				<?php } ?>
				

				</div>
			</div>
		</aside>

	</div>
	<div style="clear:both">
		
	</div>
	<footer>
			<p>&copy; 版权所有 星辰工作室  <a href="www.gzittc.net" title="">www.gzittc.net</a></p>
	</footer>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/dropzone.js"></script>
	<script >
	$(document).ready(function(){
		$('[data-toggle="username"]').tooltip();
	})

	var dropz = new Dropzone("#dropz", {
        url: "post.php?id=<?php echo $description['id']; ?>&userId=<?php echo $userWorkid;?>",
        maxFiles:10,
        maxFilesize: 2048,
	 	init: function() {
			this.on("success", function(file) {
				location.reload();
			});
        }
    });
    setTimeout(function(){
    	$('.author').each(function(){
	    	var author = $(this);
	    	$('.list_user img').each(function(){
	    		console.log(author.html() , $(this).attr('data-original-title'));
	    		if(author.html() == $(this).attr('data-original-title')){
					$(this).parent().addClass('up');
				}
	    	});
	    });
    },100)
	



	</script>
</body>
</html>