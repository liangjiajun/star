<?php
	session_start();
	require_once('inc/config.php');
	validate_role(2,$_SESSION['id']);

	$db = new db;
	$work_offs = $db->select('sign_work_off',NULL,' order by id desc');

	if(isset($_GET['event']) && $_GET['event'] == 'del'){
		$id = $_GET['id'];
		$db->delete('sign_work_off',array('id'=>$id));
		jump('manage_work_off.php');
	}

	if(isset($_GET['event']) && $_GET['event'] == 'add'){
		$id = $_GET['id'];
		$work_off = $db->select_one('sign_work_off',array('id'=>$id));
		$data = array();
		$data['note']=$work_off['note'];
		$data['type']='请假';
		$data['user_id']=$_SESSION['id'];
		$data['users']=$work_off['user_id'];
		$data['start_date']=$work_off['start_date'];
		$data['end_date']=$work_off['end_date'];
		$db->insert('sign_other_rule',$data);
		$db->delete('sign_work_off',array('id'=>$id));
		jump('manage_work_off.php');
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
			$('.tool_btn').button();
		});
	</script>
	<link rel="stylesheet" href="script/jquery_ui/jquery-ui.min.css">
	<style type="text/css">
		.tool_btn{ margin:10px 0; }
		.main{ width: 90%; margin:0 auto; }
		table{ text-align: center; }
		table td, table th{ padding: 10px; }
	</style>
</head>
<body>

	<?php include('../top.php'); ?>

	<div class="main">
		<a href="index.php" class="tool_btn">返回</a>
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
			<tr>
				<th>ID</th>
				<th>说明</th>
				<th>申请人</th>
				<th>开始日期</th>
				<th>结束日期</th>
				<th>操作</th>
			</tr>
			<?php foreach($work_offs as $v){ ?>
			<tr>
				<td><?= $v['id']; ?></td>
				<td><?= $v['note']; ?></td>
				<td>
					<?php
						$user = $db->select_one('users',array('id'=>$v['user_id']));
						echo $user['username'];
					?>
				</td>
				<td><?= $v['start_date']; ?></td>
				<td><?= $v['end_date']; ?></td>
				<td>
				<a href="manage_work_off.php?event=add&id=<?= $v['id']; ?>" class="tool_btn">通过</a>
				<a href="manage_work_off.php?event=del&id=<?= $v['id']; ?>" class="tool_btn" onclick="return confirm('确认删除？');">删除</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>