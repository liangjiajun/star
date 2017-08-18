<?php
	session_start();
	require_once('inc/config.php');
	validate_role(3,$_SESSION['id']);

	$db = new db;
	$other_rules = $db->select('sign_other_rule',NULL,' order by id desc');

	if(isset($_GET['event']) && $_GET['event'] == 'del'){
		$id = $_GET['id'];
		$db->delete('sign_other_rule',array('id'=>$id));
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
		<a href="new_sign_other_rule.php" class="tool_btn">添加考勤变更</a>
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
			<tr>
				<th>ID</th>
				<th>说明</th>
				<th>类型</th>
				<th>审核人</th>
				<th>开始日期</th>
				<th>结束日期</th>
				<th>签到时间</th>
				<th>签退时间</th>
				<th>对象</th>
				<th>操作</th>
			</tr>
			<?php foreach($other_rules as $v){ ?>
			<tr>
				<td><?= $v['id']; ?></td>
				<td><?= $v['note']; ?></td>
				<td><?= $v['type']; ?></td>
				<td>
					<?php
						$user = $db->select_one('users',array('id'=>$v['user_id']));
						echo $user['username'];
					?>
				</td>
				<td><?= $v['start_date']; ?></td>
				<td><?= $v['end_date']; ?></td>
				<td><?= $v['start_time']; ?></td>
				<td><?= $v['end_time']; ?></td>
				<td>
					<?php
						$users = $db->fetch($db->query("select username from users where id in(".$v['users'].")"));
						$dt = array();
						foreach($users as $vx){
							$dt[] = $vx['username'];
						}
						echo implode(',',$dt);
					?>
				</td>
				<td><a href="manage_sign_other_rule.php?event=del&id=<?= $v['id']; ?>" class="tool_btn" onclick="return confirm('确认删除？');">删除</a></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>