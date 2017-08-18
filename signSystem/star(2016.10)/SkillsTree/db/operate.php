<?php 

include_once 'config.php';

if(isset($_SESSION['user'])){
	$get_user = $pdo->query('SELECT * FROM `users` WHERE `id` = '.$_SESSION['id'])->fetchAll();
}

if (isset($_POST['select'])) {
	$sql = "SELECT * FROM `skills`";
	$select = $pdo->query($sql);
	$arr = array();
	foreach($select as $v){
		$arr[$v['id']] = $v;
	}
	$userskills_all = $pdo->query('SELECT *,`userskills`.id FROM `userskills` JOIN `users` ON `userskills`.`user_id`=`users`.`id`')->fetchAll();
	$userskills = $pdo->query('SELECT * FROM `userskills` WHERE `user_id` = '.$_POST['select'])->fetchAll();
	echo json_encode(array($arr,$userskills,$userskills_all));
}



if (isset($_POST['check'])) {
	$id = $_POST['check']['id'];

	$sql = "UPDATE `userskills` SET `status`='1' WHERE `id`=$id";
	$pdo->exec($sql);
}

if (isset($_POST['request'])) {
	$skill_id = $_POST['request']['skill_id'];
	$user_id = $get_user[0]['id'];

	$sql = "INSERT INTO `userskills` (`skill_id`, `user_id`) VALUES ('$skill_id',$user_id)";
	$pdo->exec($sql);
}



if (isset($_POST['insert'])) {
	$title = $_POST['insert']['title'];
	$content = $_POST['insert']['content'];
	$ass_id = $_POST['insert']['ass_id'];

	$sql = "INSERT INTO `skills` (`title`, `content`, `ass_id`) VALUES ('$title','$content',$ass_id)";
	$pdo->exec($sql);
}

if (isset($_POST['update'])) {
	$title = $_POST['update']['title'];
	$content = $_POST['update']['content'];
	$id = $_POST['update']['id'];

	echo $sql = "UPDATE `skills` SET `title`='$title', `content`='$content' WHERE `id`=$id";
	$pdo->exec($sql);
}

if (isset($_POST['delete'])) {
	del($_POST['delete']['id'],$pdo);
}



function del($value,$pdo){
	$sql = 'DELETE FROM `skills` WHERE `id` = '.$value;
	$pdo->exec($sql);

	$row = $pdo->query("SELECT * FROM `skills` WHERE ass_id = ".$value);
	if ($row->rowCount()) {
		foreach ($row as $k => $v) {
			del($v['id'],$pdo);
		}
	}

	$sql = 'DELETE FROM `skills` WHERE `ass_id` = '.$value;
	$pdo->exec($sql);
}


 ?>