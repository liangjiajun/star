<?php 
	require 'view/header.php';
	echo '<link href="style/bootstrap.min.css" rel="stylesheet">';	
	echo '<link href="style/square/_all.css" rel="stylesheet">';
	echo '<link rel="stylesheet" href="style/upstyle.css">';
	echo '<link rel="stylesheet" href="style/universal.css">';
	echo '<link rel="stylesheet" href="style/bootstrap-datetimepicker.min.css">';

	/*
		项目数据插入
	*/

if(isset($_POST['task_title_btn'])){
	$title =$_POST['title'];
	$taskType =$_POST['taskType'];
	$startTime =strtotime($_POST['startTime']);
	$endTime =strtotime($_POST['endTime']);
	$content =$_POST['content'];
	$arr = '';
	foreach($_POST as $key=>$val){
		if($key == strstr($key,'userid')){
			$arr .= $val.',';
		}
	}
	$userid = rtrim($arr, ",");
	$author = $_SESSION['id'];
$sql = "INSERT INTO `task_title` ( `title`, `des`, `type_id`, `startTime`, `endTime`, `responsible`, `author`) VALUES ('$title', '$content', '$taskType', '$startTime', '$endTime','$userid','$author')";
	if(mysql_query($sql)){
		$url = "index.php";  
		echo "<script type='text/javascript'>window.location.href='".$url."'</script>";
	}
}

/*
	成员与组的列表
*/	
$sql="SELECT *,users.id AS 'uid',user_group.id AS 'gid' FROM user_group_users INNER  JOIN users ON user_group_users.user_id=users.id INNER  JOIN user_group  ON user_group_users.group_id =user_group.id WHERE user_group.id";
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

?>
		<aside>
			<h3>任务发布</h3>
			<form method="post">
				<div class="form-group">
					<label class="control-laabel">标题</label>
					<input class="form-control" type="text" name="title" placeholder="请输入标题" required>
				</div>
				<div class="form-group">
					<label class="control-laabel">分类</label>
					<ul class="category">
					<?php 
				/*
					分页类型
				*/
					$sql = "SELECT * FROM task_types";
					$result =mysql_query($sql);
					while($t=mysql_fetch_array($result)){ 
					?>
						<li><span><input type="radio" class="input" name="taskType" required value="<?php echo $t['id'] ?>"> <?php echo $t['name'] ?></span></li>
					<?php } ?>
					</ul>
				</div>
				<div class="form-group">
					<label class="control-laabel">时间</label>
					
					<div class="container" style="padding: 0 15px;">  
	     			<input type="text"  id="datetimepicker" required name="startTime">
	     			<span>-</span>
	     			<input type="text"  id="datetimepicker1" required name="endTime">
					</div>
					<div class="test"></div>
				
				</div>
				<div class="form-group">
					<label class="control-laabel">描述</label>
					<textarea name="content" class="form-control" required placeholder="项目的详细描述"></textarea>
				</div>
				<div class="form-group">
					<label class="control-laabel">负责人</label>

					<div class="form_person">

					<?php foreach ($groups as $key) {  ?>
				    	<div class="group">
				    		<div class="group_name">
				            	<span><input type="checkbox" class="input check_all" ><?php echo $key['name']?></span>
				            </div>
				            <ul class="group_list">
				              <?php foreach($member as $mem){ 
									if($mem['gid'] == $key['id']){
				 			  ?>
				                <li>
				                    <span>
				                        <input type="checkbox"  class="input check_this" name="userid_<?php echo $mem['uid'] ?>" value="<?php echo $mem['uid'] ?>" >
				                        <img alt="<?php echo '../users/'. $mem['face_url'] ?>" src="<?php echo '../users/'. $mem['face_url'] ?>" title="<?php echo $mem['username'];?>" data-toggle="username" data-placement="bottom" width="30px" height="30px" style="border-radius: 50px;border:none">
				                    </span>
				                </li>
				            <?php }} ?>   
				            </ul>
				    	</div>
				    <?php } ?>    
				    </div>
				</div>
				<button type="submit" name="task_title_btn">发布</button>
			</form>
		</aside>
		<div style="clear:both"></div>
	</div>
	<footer>
		<p>&copy; 版权所有 星辰工作室  <a href="www.gzittc.net" title="">www.gzittc.net</a></p>
	</footer>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/bootstrap-datetimepicker.js"></script>
	<script src="js/bootstrap-datetimepicker.zh-CN.js"></script>
	<script>

/*按钮*/
    $(document).ready(function(){
		$('.input').iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		});

	$('.group').each(function(i,v){
			var check_all = $(v).find('.check_all');
			var check_this = $(v).find('.check_this');
			
			check_all.on('ifClicked', function(event){
				if (!$(this).parent().hasClass('checked')) {
					check_this.iCheck('check');
				} else {
					check_this.iCheck('uncheck');
				}
			});
			
			check_this.on('ifClicked', function(event){
				console.log(this.className);
				setTimeout(function(){
					if(check_this.length <= $(v).find('.group_list .checked').length){
						check_all.iCheck('check');
					}else{check_all.iCheck('uncheck');}	
				},50);
			});
		});
		
		$('[data-toggle="username"]').tooltip();


		$('.group_list').each(function(){
			console.log($(this).children('li').length);
			if($(this).children('li').length == 0){
				$(this).parent().hide();
			}
		})
    });

/*时间条*/
     $(function () {
        $('#datetimepicker').datetimepicker({
        　　minView: "month", //选择日期后，不会再跳转去选择时分秒 
        　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
        　　language: 'zh-CN', //汉化 
        　　autoclose:true //选择日期后自动关闭 
        });

         $('#datetimepicker1').datetimepicker({
        　　minView: "month", //选择日期后，不会再跳转去选择时分秒 
        　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
        　　language: 'zh-CN', //汉化 
        　　autoclose:true //选择日期后自动关闭 
        })
   		.on('changeDate', function(ev){
	        console.log($('#datetimepicker').val())
	        console.log($('#datetimepicker1').val())
	    })
    });
/*按钮组*/
			
			


    </script>
</body>
</html>