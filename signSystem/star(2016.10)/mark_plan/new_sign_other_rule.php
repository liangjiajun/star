<?php
	session_start();
	require_once('inc/config.php');
	validate_role(3,$_SESSION['id']);

	if(!empty($_POST)){
		$_POST['users'] = implode(',',$_POST['users']);
		$_POST['user_id'] = $_SESSION['id'];
		$db = new db();
		$db->insert('sign_other_rule',$_POST);
		jump('manage_sign_other_rule.php');
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>计划管理</title>
	<script type="text/javascript" src="script/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="script/jquery_ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="script/jquery_ui/jquery-ui.datepicker-zh-CN.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$( ".users input" ).checkboxradio({icon: false});
			$( "input[name='start_date'],input[name='end_date']" ).datepicker({
				changeMonth: true, 
				changeYear: true, 
				showButtonPanel: false, 
				dateFormat: 'yy-mm-dd',
				regional:$.datepicker.regional[ 'zh-CN' ]
			});
			$( "input[type='submit']" ).button();

			$( "select[name='type']" ).change(function(){
				if($(this).val() != '放假'){
					$('.time_input').show();
					$('.time_input input').attr('disabled',false);
				}else{
					$('.time_input').hide();
					$('.time_input input').attr('disabled',true);
				}
			});
		});
	</script>
	<link rel="stylesheet" href="script/jquery_ui/jquery-ui.min.css">
	<style type="text/css">
		form label{ display:block; line-height:40px;}
		form span{ display:inline-block; width:70px;}
		form input,form select{ padding: 5px; }
		form{ display: block; width: 400px; margin:150px auto 0; }
		.users{ padding: 20px 0; }
		.time_input{ display: none; }
	</style>
</head>
<body>

<?php include('../top.php'); ?>

<form method="post" action="">
	<label>
        <span>说明</span>：
        <input type="text" name="note">
    </label>
    <label>
        <span>类型</span>：
        <select name="type">
			<option>放假</option>
			<option>加班</option>
			<option>调整考勤</option>
		</select>
    </label>
    <label>
        <span>开始日期</span>：
        <input type="text" name="start_date" value="<?= date('Y-m-d'); ?>" readonly="readonly">
    </label>
    <label>
        <span>结束日期</span>：
        <input type="text" name="end_date" value="<?= date('Y-m-d'); ?>" readonly="readonly">
    </label>

    <div class="time_input">
	    <label>
	        <span>签到时间</span>：
	        <input type="time" name="start_time" value="08:10">
	    </label>
	    <label>
	        <span>签退时间</span>：
	        <input type="time" name="end_time" value="16:30">
	    </label>
    </div>

    <div class="users">
        <span>对象</span>：<br />
        <?php
			foreach(array_merge(get_group_users(MEMBER_GROUP),get_group_users(STUDENT_GROUP)) as $v){
				echo '<label style="display:inline-block"><input type="checkbox" name="users[]" value="'.$v['id'].'">'.$v['username'].'</label>';
			}
		?>
    </div>
    <label>
    	<input type="submit" value="提交">
    </label>
	
	
</form>
</body>
</html>

