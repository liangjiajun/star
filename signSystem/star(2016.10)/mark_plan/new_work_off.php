<?php
	session_start();
	require_once('inc/config.php');
	validate_role(1,$_SESSION['id']);

	if(!empty($_POST)){
		$_POST['user_id'] = $_SESSION['id'];
		$db = new db();
		$db->insert('sign_work_off',$_POST);
		jump('index.php');
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
        <span>开始日期</span>：
        <input type="text" name="start_date" value="<?= date('Y-m-d'); ?>" readonly="readonly">
    </label>
    <label>
        <span>结束日期</span>：
        <input type="text" name="end_date" value="<?= date('Y-m-d'); ?>" readonly="readonly">
    </label>
    <label>
    	<input type="submit" value="提交">
    </label>
</form>
</body>
</html>

