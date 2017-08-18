<?php
require_once 'config.php';

if(isset($_POST['userData'])){
	if(isset($_COOKIE['user'])){
		$new_date = date('Y-m-d',time());
		setcookie("user", " ", time()-60*60*24*30);
		$user = explode('----', $_COOKIE['user']);

		$sql = "SELECT * FROM `sign_data` WHERE `user_id` = ? AND `new_date` = ? ORDER BY `new_date` DESC";
		$preObj = $db->prepare($sql);
		$preObj->execute(array($user[0],$user[4]));
		$userTime = $preObj->fetch(PDO::FETCH_ASSOC);

		$onlineTime = time() - $userTime['start_time'];

		if(isset($_POST['sign'])){
			$data= array(
				'signTime'=>date('H:i:s',$userTime['start_time']),
				'onlineTime'=>time2string($onlineTime)
			);
		}else{
			$data = array(
				'userId'=>$user[0],
				'signId'=>$userTime['id'],
				'userName'=>$user[1],
				'userFace'=>$user[2],
				'userRoot'=>$user[3],
				'dayTime'=>$user[4]
			);
		}
		echo json_encode($data);

	}else{
		echo 1;
	}
}

/*用户列表*/
if(isset($_POST['userListData'])){
	$query = $db->query('SELECT * FROM `users_data` WHERE `show_switch` !=0  ORDER BY `show_switch` DESC');
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$userDataList = $query->fetchAll();
	foreach ($userDataList as $k => $v) {
		$data[] = array(
			'id'=>$v['id'],
			'name'=>$v['name'],
			'face_url'=>$v['face_url'],
			'show_switch'=>$v['show_switch'],
			'email'=>$v['username']
		);

	}
	echo json_encode($data);
}

if(isset($_GET['userListData'])){
	$query = $db->query('SELECT * FROM `users_data`  ORDER BY `show_switch` DESC');
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$userDataList = $query->fetchAll();
	foreach ($userDataList as $k => $v) {
		$data[] = array(
			'id'=>$v['id'],
			'name'=>$v['name'],
			'face_url'=>$v['face_url'],
			'show_switch'=>$v['show_switch'],
			'email'=>$v['username']
		);

	}
	echo json_encode($data);
}





/*个人主页*/
if(isset($_POST['userListMsg'])){
	$id = $_POST['id'];
	$query = $db->query('SELECT id,username,name,Phone,face_url,show_switch FROM `users_data` WHERE `id` ='.$id.'  ORDER BY `show_switch` DESC');
	$userDataList = $query->fetchAll(PDO::FETCH_ASSOC);

	/*个人项目总数*/
	$itemTotal = $db->query('SELECT count(*) AS `item` FROM `item_data` WHERE `item_author` ='.$id.'')->fetch(PDO::FETCH_ASSOC)['item'];

	/*个人的第一天签到的数据以及最后一天签到的数据*/
	$start = $db->query('SELECT start_time FROM `sign_data` WHERE `user_id` ='.$id.' LIMIT 1')->fetch(PDO::FETCH_ASSOC)['start_time'];
	$end = $db->query('SELECT end_time FROM `sign_data` WHERE `user_id` ='.$id.' ORDER BY `id` DESC LIMIT 1')->fetch(PDO::FETCH_ASSOC)['end_time'];
	$end = $end!=0 ? $end : time();

	$timediff = $end - $start;
	$days = intval($timediff/86400);//计算天数

	$remain = $timediff%86400;
    $hours = intval($remain/3600);//计算时

    $remain = $remain%3600;
    $mins = intval($remain/60);//计算分
    $secs = $remain%60;//计算秒

	foreach ($userDataList as $k => $v) {
		$v['signTotal'] = $days;
		$v['itemTotal'] = $itemTotal;
		$v['day'] =$days."天".$hours."时".$mins."分".$secs."秒";
		$data[] = $v;
	}
	echo json_encode($data);
}
/*修改用户数据*/
if(isset($_POST['user_update_sub'])){
	$id = $_POST['uid'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$img = $_POST['img'];
	$faceName = '';
	/*修改头像*/
	if(strstr($img,'base64,')){
		$imageType = explode(';',explode('/',$img)[1])[0];
		$imgData = explode('base64,', $img)[1];
		$imgTypeList = ['jpg','jpeg','png','gif'];
		 if(in_array($imageType,$imgTypeList)){
			$user = explode('----', $_COOKIE['user']);
			$faceName .= $id.'.'.$imageType;

			/*删除重复的用户头像*/
			$userFacePath = explode('/',$user[2]);
			$userFacePathName = end($userFacePath);
			if(file_exists('../Photo/face/'.$userFacePathName)){
				unlink('../Photo/face/'.$userFacePathName);
			}

			/*重置cookie*/
			$user[2] = 'Photo/face/'.$faceName;
			$resetUser = implode('----', $user);
			$expire=time()+60*60*24*30;
			setcookie("user", $resetUser, $expire);
			$imgData = explode('base64,', $_POST['img'])[1];
			$img = base64_decode($imgData);
			file_put_contents('../Photo/face/'.$faceName, $img);
		}
	}else{
		$faceName =explode('/', $img)[2];
	}

	$sql = "UPDATE `users_data` SET `face_url` = ? , `username` = ? , `Phone` = ?  where `id` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($faceName,$email,$phone,$id));

	/*更新个人信息数据*/
	if(isset($_COOKIE['user'])){
		$new_date = date('Y-m-d',time());
		$user = explode('----', $_COOKIE['user']);

		$sql = "SELECT * FROM `sign_data` WHERE `user_id` = ? AND `new_date` = ? ORDER BY `new_date` DESC";
		$preObj = $db->prepare($sql);
		$preObj->execute(array($user[0],$user[4]));
		$userTime = $preObj->fetch(PDO::FETCH_ASSOC);
		$data = array(
			'userId'=>$user[0],
			'signId'=>$userTime['id'],
			'userName'=>$user[1],
			'userFace'=>$user[2],
			'userRoot'=>$user[3],
			'dayTime'=>$user[4]
		);
		echo json_encode($data);

	}

}

/*每日一句录入*/
if(isset($_POST['quotes_sub']) ){
	$chinese =empty($_POST['chinese']) ? "" : strip_tags($_POST['chinese']);
	$english =empty($_POST['english']) ? "" : strip_tags($_POST['english']);
	$uid = explode('----', $_COOKIE['user'])[0];
	$sql = "INSERT INTO `quote` (`chinese`,`english`,`uid`,`create_time`) VALUES (:chinese,:english,:uid,:create_time)";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':chinese' =>$chinese,':english'=>$english,':uid'=>$uid,':create_time'=>time()));
	header('location:../../index.html');
}

/*读取每日一句*/
if(isset($_POST['userQuote']) ){

	$query = $db->query('SELECT * FROM `quote` INNER JOIN `users_data` ON `quote`.uid =`users_data`.id ORDER BY rand() LIMIT 1');
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$qutoeList = $query->fetchAll();

	foreach ($qutoeList as $v) {
		$data[] = array('chinese'=>$v['chinese'],'english'=>$v['english'],'face'=>$v['face_url']);
	}
	echo json_encode($data);
}














