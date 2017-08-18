<?php  
require_once 'config/config.php';

$data_time_today='';
$date_all_today=array();
$date=date('Y-m-d'); 
$first=1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
$w=date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6 
$now_start=date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
$now_end=date('Y-m-d',strtotime("$now_start +6 days"));//获取本周结束日期

$now_start_explode = explode('-', $now_start);//格式化本周开始日期
$now_end_explode = explode('-', $now_start);//格式化本周结束日期

/*拿到本周的签到的日期*/
if(isset($_POST['newDate'])){
	$colum = $db->fetch($db->query('SELECT * FROM `sign_data` WHERE `sign_data`.new_date ="'.$_POST['newDate'].'" GROUP BY `new_date` '));
}

$date_all_time = $db->fetch($db->query('SELECT * FROM `sign_data` GROUP BY `new_date`'));

/*签到的用户名单*/
$user = $db->select('users_data',['id','name','username','password'],['show_switch'=>0]);
$new_date = date('Y-m-d',time());



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>签到考勤表</title>
	<link rel="stylesheet" href="sourcus/css/main.css">
</head>
<body>


<div class="wrap list-width position">

<a href="back.php"> &lt; 返回首页</a>

<form method="post" class="right" action="search.php">
	<select name="newDate">
	<?php foreach ($date_all_time as $k => $v) {?>
		<option value="<?=$v['new_date']?>"><?=$v['new_date']?></option>
	<?php }  ?>
	</select>
	<button type="submit" name="search">提交</button>
</form>
<h2>签到考勤</h2>
<table cellpadding="0" cellspacing="0">
	<caption align="top">早上8:10前签到（周一早上9:00前）<br>下午16:30后签退</caption>
	<tr>
	  <th></th>
<?php foreach ($colum as $k => $v) {?>	  
	  <th><?=$v['new_date']?></th>
<?php } ?>
	</tr>

<?php foreach ($user as $k1 => $u) { 
	if($u['id']!= 9 && $u['id']!=14 &&$u['id']!=15){
?>	  
	<tr>
	  <td><?= $u['name'] ?></td>

	<?php foreach ($colum as $k => $v) {

		

	 	/*
			拿一天中最早的签到时间
	 	*/
		$start_time = $db->fetch($db->query('SELECT `start_time`,`new_date` FROM `sign_data` WHERE `user_id` ='.$u['id'].' AND `new_date`="'.$v['new_date'].'" ORDER BY `start_time` ASC LIMIT 1'));

	 	/*
			拿一天中最晚的签退时间
	 	*/
		$end_time = $db->fetch($db->query('SELECT `end_time`,`new_date` FROM `sign_data` WHERE `user_id` ='.$u['id'].' AND `new_date`="'.$v['new_date'].'" ORDER BY `end_time` DESC LIMIT 1'));

		if(!empty($start_time)){
			$set_time = date('w',$start_time[0]['start_time']) == 1 ? '09:00:00' : '08:10:00';
	 ?>

	  	<td>
	  		<?php if(date('H:i:s',$start_time[0]['start_time']) > $set_time){ ?>
	  			<span class="error"><?= date('H:i:s',$start_time[0]['start_time'])?></span>
	  		<?php }else{ ?>
	  			<span class="current"><?= date('H:i:s',$start_time[0]['start_time'])?></span>
	  		<?php } if($end_time[0]['end_time']!=0){ ?>
	  			<span class="current2"><?=date('H:i:s',$end_time[0]['end_time'])?></span>
	 		<?php }else{  
	  			if(strtotime($new_date) > strtotime($v['new_date'])){
	  		?>
	  			<span class="error">未签退</span>
	  			
	  		<?php }else{echo '<span>未签退</span>';} } ?>
	  	</td>

	<?php  }else{ echo "<td class='sd'>未签到</td>"; }  } ?>
	</tr>
<?php }} ?>


</table>
	
</div>

</body>
</html>