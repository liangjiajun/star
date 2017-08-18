<?php 
require_once 'config.php';

if(isset($_POST['userData'])){
	if(isset($_COOKIE['user'])){
		$new_date = date('Y-m-d',time());
		$user = explode('----', $_COOKIE['user']);
		if(isset($user[4])){		
			if($user[4]!=$new_date){
				setcookie("user", " ", time()-60*60*24*30);
				echo 1;
			}
				$sql = "SELECT * FROM `sign_data` WHERE `user_id` = ? AND `new_date` = ? ORDER BY `new_date` DESC";
				$preObj = $db->prepare($sql);
				$preObj->execute(array($user[0],$user[4]));
				$userTime = $preObj->fetch(PDO::FETCH_ASSOC);

				$onlineTime = time() - $userTime['start_time'];
				$data = array(
					'userId'=>$user[0],
					'signId'=>$userTime['id'],
					'userName'=>$user[1],
					'userFace'=>$user[2],
					'userRoot'=>$user[3],
					'dayTime'=>$user[4],
					'signTime'=>date('H:i:s',$userTime['start_time']),
					'onlineTime'=>time2string($onlineTime)
				);
				echo json_encode($data);
		}else{
			setcookie("user", " ", time()-60*60*24*30);
			echo 1;
		}
		
	}else{
		echo 1;
	}
}


if(isset($_POST['userListData'])){
	$query = $db->query('SELECT * FROM `users_data` WHERE `show_switch` !=0  ORDER BY `show_switch` DESC');
	$query->setFetchMode(PDO::FETCH_ASSOC); 
	$userDataList = $query->fetchAll();
	foreach ($userDataList as $k => $v) {
		$data[] = array('id'=>$v['id'],'name'=>$v['name'],'photo'=>$v['photo'],'face_url'=>$v['face_url'],'show_switch'=>$v['show_switch'],'email'=>$v['username']);
		
	}
	echo json_encode($data);
}

/*个人主页*/
if(isset($_POST['userListMsg'])){
	$id = $_POST['id'];
	$query = $db->query('SELECT * FROM `users_data` WHERE `id` ='.$id.'  ORDER BY `show_switch` DESC');
	$query->setFetchMode(PDO::FETCH_ASSOC); 
	$userDataList = $query->fetchAll();
	foreach ($userDataList as $k => $v) {
		$data[] = $v;
	}
	echo json_encode($data);
}
/*修改用户数据*/
if(isset($_POST['user_update_sub'])){
	$userName = $_POST['userName'];
	$userHeight = $_POST['userHeight'];
	$userEmail = $_POST['userEmail'];
	$userBrith = $_POST['userBrith'];
	$userClass = $_POST['userClass'];
	$userPhone = $_POST['userPhone'];
	$userQQ = $_POST['userQQ'];
	$userPlane = $_POST['userPlane'];
	$userCard = $_POST['userCard'];
	$userTeacher = $_POST['userTeacher'];
	$userParents = $_POST['userParents'];
	$uid = $_POST['uid'];
	$userPresent = $_POST['userPresent'];

	$sql = "UPDATE `users_data` SET `username` = ? , `name` = ? , `Birth` = ? , `IdCard` = ? , `class` = ? , `teacher` = ? , `Phone` = ? , `QQ` = ? , `address` = ? , `parentPhone` = ? , `height` = ? , `introduction` = ?   where `id` = ? ";
	$preObj = $db->prepare($sql);
	$preObj->execute(array($userEmail,$userName,$userBrith,$userCard,$userClass,$userTeacher,$userPhone,$userQQ,$userPlane,$userParents,$userHeight,$userPresent,$uid));
	header('location:../../user.html?uid='.$uid);
}

/*修改用户头像以及证件照*/
if(isset($_POST['user_face_sub'])){
	$id  = $_POST['uid'];
	if(isset($_FILES['paperwork'])){
		$paper = $_FILES['paperwork'];
		$str = explode('.',$paper['name']);
		$end = strtolower(end($str));
		$paperName = 'user_'.$id.'.'.$end;
		move_uploaded_file($paper['tmp_name'],'../Photo/paperwork/'.$paperName);
		$sql = "UPDATE `users_data` SET `photo` = ?  where `id` = ? ";
		$preObj = $db->prepare($sql);
		$preObj->execute(array($paperName,$id));

	}else if(isset($_FILES['userface'])){
		$user = explode('----', $_COOKIE['user']);
		$face = $_FILES['userface'];
		$str = explode('.',$face['name']);
		$end = strtolower(end($str));
		$faceName = $id.'.'.$end;


		/*删除重复的用户头像*/
		$userFacePath = explode('/',$user[2]);
		$userFacePathName = end($userFacePath);
		if(file_exists('../Photo/face/'.$userFacePathName)){
			unlink('../Photo/face/'.$userFacePathName);
		}

		/*重置cookie*/
		$user[2] = 'sourcus/Photo/face/'.$faceName;
		$resetUser = implode('----', $user);
		$expire=time()+60*60*24*30;
		setcookie("user", $resetUser, $expire);
		move_uploaded_file($face['tmp_name'],'../Photo/face/'.$faceName);
 		
		$sql = "UPDATE `users_data` SET `face_url` = ?  where `id` = ? ";
		$preObj = $db->prepare($sql);
		$preObj->execute(array($faceName,$id));
	}
	header('location:../../user.html?uid='.$id);
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














