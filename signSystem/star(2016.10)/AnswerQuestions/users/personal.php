<?php 
include('../config.php'); 
include('../functions.php'); 


?>

<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>个人资料</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>

<body id="personal">

<?php 

include('../top.php');



//单个用户数据
$userid = $_GET['userid'];
$sql = "SELECT * FROM users WHERE id = '$userid'";
$r = mysql_query($sql);
$user = mysql_fetch_array($r);


$sql = "SELECT datetime2,datetime1,(datetime2-datetime1) FROM `sign` WHERE name = '".$user['username']."' ORDER BY id DESC";
	$result = mysql_query($sql); 
	$conetime_arr = array();
	while($conetime = mysql_fetch_array($result)){
		if($conetime['datetime2']==0){
			$conetime_arr[] = 600; //如果没有签退，算在线600秒，即十分钟;
		}else{
			 $conetime_arr[] = $conetime['(datetime2-datetime1)'];
		}
		
	}

	$ct = array_sum($conetime_arr);
	/*单次时间运算*/
		$allremain = $ct%86400;
		$allhours = intval($allremain/3600);
		$allremain = $ct%3600;	
		$allmins = intval($allremain/60);
		$allsecs = $allremain%60;
		$alltime =$allhours.'小时'.$allmins.'分钟'. $allsecs.'秒';
	/*单次时间运算*/




//删除

if(isset($_GET['did'])){

	if(!isset($_SESSION['user'])){ die('please login!');}
	$did = $_GET['did'];
	$sql = "UPDATE tasks SET trash = '1' WHERE id = '$did'";

	mysql_query($sql);
	header("location:personal.php?userid=".$userid."&task=1");



}

?>

	<section class="cont clearfix">

		<div class="left">

				<h2 class="sub-header">个人资料</h2>

				<div class="list-group">

					<div class="favicon" id="drop_area">
						<a  href="#" class="favicon_in" title="直接拖图片(100X100)过来即可换头像，注意要小于500K，才能上传" id="preview">
							<?php 
								if($user['face_url']!=""){
									echo "<img src='".$user['face_url']."' width='100' height='100'>";
								}
							?>
						</a>
					</div>
					  	<ul class="favicon_menu">
					  		<li><a class="words">姓名：<b><?php echo $user['username']?></b></a></li>
					  		<li><a class="words">等级：<b>一星级</b></a></li>
					  		<li><a class="words">积分：36</a></li>
					  		<li><a class="words">总时长：<?php echo $alltime;?><b></b></a></li>
					  	</ul>
				</div>
			</div>

		<div class="right">
				<ul style="padding:20px; margin:0">
					<a href="<?php echo currentURL()?>?userid=<?php echo $userid ?>"><li class="btn btn-primary">他的签到</li></a>
					<a href="<?php echo currentURL()?>?userid=<?php echo $userid ?>&task=1"><li class="btn btn-primary">他的作品</li></a>
					<li class="btn btn-default">他的标签</li>
					<li class="btn btn-default">他的积分</li>
				</ul>
<?php
 if(isset($_GET['task'])){


 	$sql = "SELECT *,tasks.name as 'task_name', tasks.id as 'tid' FROM tasks RIGHT JOIN task_types ON tasks.type_id = task_types.id WHERE user_id = '".$userid."' AND tasks.trash != '1' ORDER BY tasks.id  DESC";

 	$r = mysql_query($sql);


?>
	<table class="table table-hover table-striped">

				  <thead>
				    <tr>
					  <th>作品类型</th>
					  <th>作品名称</th>
			
				      <th>下载</th>
				      <th>操作</th>
				    </tr>
				  </thead>
				  <tbody>
				
						<?php

						while($row = mysql_fetch_array($r)){

							echo "<tr>";
							echo "<td>$row[name]</td><td>$row[task_name]</td><td>";

							if(isset($_SESSION["user"])){
								echo "<a href='../tasks/download.php?id=".$row['tid']."'><button type='button' class='btn btn-default'>下载(".$row["downloadTimes"].")</button></a>"; 
							}

							echo "</td><td>";

							if(isset($_SESSION['id']) and $_SESSION['id']== $userid){
								echo "<a href='".currentURLS()."&did=".$row["tid"]."'";
								?>
								onClick="javascript:return confirm('是否要删除?')"
								<?php
								echo "><button type='button' class='btn btn-default'>删除</button></a>";
							}else{
								echo "点赞";
							}


							echo "</td>";
							echo "</tr>";
						}

						?>
				

				  </tbody>
				  </table>

<?php
 }else{
?>

				<table class="table table-hover table-striped">
				  <thead>
				    <tr>
					  <th>日期</th>
					  <th>礼拜</th>
				      <th>签到时间</th>
				      <th>签退时间</th>
				      <th>在线时长</th>
		
				    </tr>
				  </thead>
				  <tbody>
<?php 
	$username = $user['username'];
	$sql = "SELECT * FROM sign WHERE name = '$username'  ORDER BY `sign`.`id` DESC";
	$result = mysql_query($sql); 
	while($user = mysql_fetch_array($result)){

		if(empty($user['datetime2'])){
			$user['datetime2'] = $user['datetime1']+600;
		}

		if(($user['datetime2']-$user['datetime1']) < 1){
			$user['datetime2'] = $user['datetime1']+1;	
		}


	
		/*单次时间运算*/
		$time  = $user['datetime2'] - $user['datetime1'];
		$remain = $time%86400;
		$hours = intval($remain/3600);
		$remain = $time%3600;
		$mins = intval($remain/60);
		$secs = $remain%60;
		$onetime =$hours.'小时'.$mins.'分钟'. $secs.'秒';
		/*单次时间运算*/
		$date = date("Y-m-d",$user['datetime1']); //日期
		$whichDay = date('l',$user['datetime1']); //礼拜

		if(($whichDay == "Saturday") or ($whichDay == "Sunday")){ //周末染红
			$whichDay = "<span style='color:red'>".$whichDay."</span>";
		}

		echo "<tr>
		<td>$date</td>
		<td>$whichDay</td>
		<td>".T($user['datetime1']).'</td>
		<td>'.T($user['datetime2']).'</td>
		<td>'.$onetime.'</td>

		</tr>';

	}

?>

			   </tbody>

			</table>


<?php } ?>



		</div><!-- right end -->

	</section>

<div class="clear"></div>
<footer class="page-header">

	<p class="copyright">&copy版权所有 星辰工作室 <a href="http://www.gzittc.net">www.gzittc.net</a></p>

</footer>

</body>

</html>

<script>
$(function(){ 

    $(document).on({ 
        dragleave:function(e){    
            e.preventDefault(); 
        }, 
        drop:function(e){  
            e.preventDefault(); 
        }, 
        dragenter:function(e){    
            e.preventDefault(); 
        }, 
        dragover:function(e){     
            e.preventDefault(); 
        } 
    }); 

    var box = document.getElementById('drop_area'); 
    box.addEventListener("drop",function(e){ 
        e.preventDefault(); 
        var fileList = e.dataTransfer.files;
      
        if(fileList.length == 0){ 
            return false; 
        } 

        if(fileList[0].type.indexOf('image') === -1){ 
            alert("您拖的不是图片！"); 
            return false; 
        } 
  
        var img = window.URL.createObjectURL(fileList[0]); 
        var filename = fileList[0].name; //图片名称 
        var filesize = Math.floor((fileList[0].size)/1024);  
        if(filesize>500){ 
            alert("上传大小不能超过500K."); 
            return false; 
        } 
        var str = "<img src='"+img+"' width='100' height='100'>"; 
        $("#preview").html(str); 
        xhr = new XMLHttpRequest(); 
        var userid = getQueryString("userid");
        xhr.open("post", "face_upload.php", true); 
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); 
         
        var fd = new FormData(); 
        fd.append('mypic', fileList[0]); 
        fd.append('userid', "<?php echo $_SESSION['id']; ?>"); 
             
        xhr.send(fd); 
        console.log(xhr.responseText)
    },false); 

  
}); 

function getQueryString(name) { 
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r != null) return unescape(r[2]); return null; 
} 



</script>