<?php 
require_once 'config.php';

/*
	输出项目列表以及用户
*/

$key =encrypt($_COOKIE['user'],'E','admin');

if(isset($_POST['itemAuthorUser'])){
	$main = $_POST['main'];
	$query = $db->query('SELECT `id`,`name` FROM `users_data` ORDER BY `show_switch` DESC');
	$query->setFetchMode(PDO::FETCH_ASSOC); 
	$userDataList = $query->fetchAll();

	foreach ($userDataList as $v) {
		$data['user'][] = array('userid'=>$v['id'],'username'=>$v['name']);
	}

	$sql = "SELECT * FROM `item_data` WHERE `item_main` =  ?  ORDER BY `item_data`.`item_hot` DESC";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($main));
	$itemDataList = $preObj->fetchAll(PDO::FETCH_ASSOC);

	foreach ($itemDataList as $k){

		$sql = "SELECT `name`,`face_url` FROM  `users_data` WHERE `id` = ? LIMIT 1";
		$preObj = $db->prepare($sql);
		$preObj->execute(array($k['item_author']));
		$userAuthor = $preObj->fetchAll(PDO::FETCH_ASSOC);

		$data['item'][] = array('itemId'=>$k['id'],'itemName'=>$k['item_name'],'itemUrl'=>$k['item_url'],'itemPhoto'=>$k['item_photo'],'itemHot'=>$k['item_hot'],'itemAuthor'=>$userAuthor[0]['name'],'itemAuthorFace'=>$userAuthor[0]['face_url'],'itemDescription'=>$k['item_description'],'key'=>$key);
	}
		echo json_encode($data);
	
}

/*添加项目*/
if(isset($_POST['addItem'])){
	$photo = $_POST['photo'];
	$end = explode('/',$photo)[1];
	$strend =  explode(';',$end)[0];
	$name = $_POST['name'];
	$url = $_POST['url'];
	$main = $_POST['main'];
	$author = $_POST['author'];
	$description = $_POST['description'];
	$alltype = ['jpg','jpeg','png'];
	if(in_array($strend,$alltype)){
		$photoName = $author.'_'.md5($name).'.'.$strend;
		$imgdata = substr($photo,strpos($photo,",") + 1);
		$decodedData = base64_decode($imgdata);
		file_put_contents('../Photo/item/'.$photoName,$decodedData);
		$sql = "INSERT INTO `item_data` (`item_url`,`item_name`,`item_photo`,`item_hot`,`item_author`,`item_description`,`item_main`,`create_time`) VALUES (:url,:name,:photo,:hot,:author,:description,:main,:create_time)";
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':url' => $url,':name'=>$name,':photo'=>$photoName,':hot'=>0,':author'=>$author,':description'=>$description,':main'=>$main,':create_time'=>time()));
	}else{
		echo 1;
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
		$query->setFetchMode(PDO::FETCH_ASSOC); 
		$userDataList = $query->fetch();
		$Where .=' WHERE `item_author` = '.$id.'';
	}

	$sql = $db->query('SELECT * FROM `item_data` '.$Where.' ORDER BY `item_hot` DESC ');
	$sql->setFetchMode(PDO::FETCH_ASSOC); 
	$userItem = $sql->fetchAll();
	foreach ($userItem as $v) {
		if($id !=9){
			$v['face_url'] = $userDataList['face_url'];
		}
		$v['key']= $key;
		$data[]= $v;
	}
	if(isset($data)){
		echo json_encode($data);
	}
}

/*搜索单个项目*/
if(isset($_GET['itemId'])){
	$id = $_GET['itemId'];
	$sql = "SELECT * FROM `item_data` where `id` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($id));
	$arr = $preObj->fetch(PDO::FETCH_ASSOC);
	echo json_encode($arr);
}
/*删除单个项目*/
if(isset($_GET['delId'])){
	$id = $_GET['delId'];
	$img = $_GET['img'];
	$file = '../Photo/item/'.$img;
	if(file_exists($file)){
		unlink($file);
	}
	$sql = "DELETE FROM `item_data` where id = ?";
	$preObj = $db->prepare($sql);
	$res    = $preObj->execute(array($id));
}



/*修改个人项目*/
if(isset($_POST['editItem'])){
	$photo = $_POST['photo'];
	$name = $_POST['name'];
	$url = $_POST['url'];
	$itemNameImg = $_POST['imgName'];
	$description = $_POST['description'];
	$id = $_POST['tid'];
	$imgName = '';
	$photoName = '';
	$author = explode('_',$itemNameImg)[0];

	if(strlen($photo)>500){
		$end = explode('/',$photo)[1];
		$strend =  explode(';',$end)[0];
		$alltype = ['jpg','jpeg','png'];
		if(in_array($strend,$alltype)){
			unlink('../Photo/item/'.$itemNameImg);
			$photoName .= $author.'_'.md5($name).'.'.$strend;
			$imgdata = substr($photo,strpos($photo,",") + 1);
			$decodedData = base64_decode($imgdata);
			file_put_contents('../Photo/item/'.$photoName,$decodedData);
		}
	}
	$imgName = strlen($photo)>500 ? $photoName : $itemNameImg;  

	$sql = "UPDATE `item_data` SET `item_name` = ? , `item_url` = ? ,`item_photo` = ? , `item_description`  = ?   where id = ?";
	$preObj = $db->prepare($sql);
	$res    = $preObj->execute(array($name,$url,$imgName,$description,$id));	
}
