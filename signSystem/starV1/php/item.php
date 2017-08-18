<?php
require_once 'config.php';

/*
	输出项目列表以及用户
*/

if(isset($_COOKIE['user'])){
	$key =encrypt($_COOKIE['user'],'E','admin');
}

if(isset($_POST['itemAuthorUser'])){
	$main = $_POST['main'];

	$sql = "SELECT * FROM `item_data` WHERE `item_main` =  ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($main));
	$itemDataList = $preObj->fetchAll(PDO::FETCH_ASSOC);

	foreach ($itemDataList as $k){

		$sql = "SELECT `name`,`face_url` FROM  `users_data` WHERE `id` = ? LIMIT 1";
		$preObj = $db->prepare($sql);
		$preObj->execute(array($k['item_author']));
		$userAuthor = $preObj->fetchAll(PDO::FETCH_ASSOC);

		$data[]= array(
			'itemId'=>$k['id'],
			'itemName'=>$k['item_name'],
			'itemUrl'=>$k['item_url'],
			'itemPhoto'=>$k['item_photo'],
			'itemHot'=>$k['item_hot'],
			'itemAuthor'=>$userAuthor[0]['name'],
			'itemAuthorFace'=>$userAuthor[0]['face_url'],
			'itemDescription'=>$k['item_description'],
			'key'=>$key);
	}
		echo json_encode($data);

}

/*添加项目*/
if(isset($_POST['addItem'])){
	$name = $_POST['itemName'];
	$plane = $_POST['itemPlane'];
	$description = $_POST['itemDescription'];
	$user = explode('----', $_COOKIE['user']);
	$time = time();
	$file = $_FILES['file'];
	$imgType = explode('/', $file['type'])[1];
	$alltype = ['jpg','jpeg','png'];
	$main = intval($user[3]) > 2  ? 1 : 0;
	if(in_array($imgType,$alltype)){
		$photoName = $user[0].'_'.md5($name).'.'.$imgType;
		move_uploaded_file($file['tmp_name'], '../Photo/item/'.$photoName);
		$sql = "INSERT INTO `item_data` (`item_url`,`item_name`,`item_photo`,`item_hot`,`item_author`,`item_description`,`item_main`,`create_time`) VALUES (?,?,?,?,?,?,?,?)";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($plane,$name,$photoName,0,$user[0],$description,$main,$time));
		if($main>3){
			header('location:../index.html');
		}else{
			header('location:../item.html');
		}
	}
}

/*项目热度自增*/
if(isset($_POST['itemHotUpdate'])){
	$id = $_POST['itemHotUpdate']['itemId'];
	$hot = $_POST['itemHotUpdate']['itemHot'];
	$sql = "UPDATE `item_data` SET `item_hot` = ? where `id` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($hot+1,$id));
}

/*获取用户的自身的项目*/
if(isset($_POST['userListItem'])){
	$Where = '';
	$id = $_POST['id'];
	if($id !=9){
		$query = $db->query("SELECT * FROM `users_data` WHERE `id` =".$id." ");
		$userDataList = $query->fetch(PDO::FETCH_ASSOC);
		$Where .=' WHERE `item_author` = '.$id.'';
	}

	$sql = $db->query('SELECT * FROM `item_data` '.$Where.' ORDER BY `item_hot` DESC ');
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$userItem = $sql->fetchAll();
	foreach ($userItem as $v) {
		if($id !=9){
			$v['face_url'] = $userDataList['face_url'];
		}
		$v['key'] = $key;
		$data[]= $v;
	}
	if(isset($data)){
		echo json_encode($data);
	}
}

/*搜索单个项目*/
if(isset($_POST['itemId'])){
	$id = $_POST['itemId'];
	$sql = "SELECT * FROM `item_data` where `id` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($id));
	$arr = $preObj->fetch(PDO::FETCH_ASSOC);
	echo json_encode($arr);
}

/*删除单个项目*/
if(isset($_POST['userManageDel'])){
	$id = $_POST['delid'];
	$sql = $db->query('SELECT * FROM `item_data` WHERE `id` ='.$id.' ');
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$item = $sql->fetch();
	$file = '../Photo/item/'.$item['item_photo'];
	if(file_exists($file)){
		unlink($file);
	}
	$sql = "DELETE FROM `item_data` where id = ?";
	$preObj = $db->prepare($sql);
	$res    = $preObj->execute(array($id));

}



/*修改个人项目*/
if(isset($_POST['editItem'])){
	$name = $_POST['itemName'];
	$id = $_POST['tid'];
	$plane = $_POST['itemPlane'];
	$description = $_POST['itemDescription'];
	if(!empty($_FILES['file']['name'])){
		$file = $_FILES['file'];
		$end = explode('.', $file['name'])[1];
		$sql = $db->query('SELECT * FROM `item_data` WHERE `id` ='.$id.' ');
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$item = $sql->fetch();
		$fileName = $item['item_author'].'_'.md5($_FILES['file']['name']).'.'.$end;
		$linkPhoto = '../Photo/item/'.$item['item_photo'];
		if(file_exists($linkPhoto)){
			unlink($linkPhoto);
		}
		move_uploaded_file($file['tmp_name'], '../Photo/item/'.$fileName);
		$sql = "UPDATE `item_data` SET `item_name` = ? , `item_url` = ?,`item_photo` = ?, `item_description`  = ?   where id = ?";
		$preObj = $db->prepare($sql);
		$res    = $preObj->execute(array($name,$plane,$fileName,$description,$id));
		header('location:../manage.html');

	}else{
		$sql = "UPDATE `item_data` SET `item_name` = ? , `item_url` = ? , `item_description`  = ?   where id = ?";
		$preObj = $db->prepare($sql);
		$res    = $preObj->execute(array($name,$plane,$description,$id));
		header('location:../manage.html');
	}
}
