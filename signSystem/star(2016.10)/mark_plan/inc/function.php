<?php
	function find_group_id($group_name){
		$db = new db;
		$group = $db->select_one('user_group',array('name'=>$group_name));
		return $group['id'];
	}

	function get_group_user_ids($group_id){
		$db = new db;
		$users = $db->select('user_group_users',array('group_id'=>$group_id));
		$user_ids = array();
		foreach($users as $v){
			$user_ids[] = $v['user_id'];
		}
		return $user_ids;
	}

	function get_group_users($group_name){
		$db = new db;
		$group_id = find_group_id($group_name);
		$user_ids = get_group_user_ids($group_id);
		$users = $db->select('users',NULL,'WHERE `id` in('.implode(',',$user_ids).')');
		return $users;
	}

	function get_role($user_id){
		$db = new db;
		$sql = "select * from user_group_users left join user_group on user_group_users.group_id = user_group.id where user_group_users.user_id = '".$user_id."'";
		$groups = $db->fetch($db->query($sql));

		$group_names = array();
		foreach($groups as $v){
			$group_names[] = $v['name'];
		}

		if(in_array(TEACHER_GROUP,$group_names)){
			return 3;
		}else if(in_array(MEMBER_GROUP,$group_names)){
			return 2;
		}else if(in_array(STUDENT_GROUP,$group_names)){
			return 1;
		}else{
			return 0;
		}
	}

	function validate_role($min_role,$user_id){
		$role = get_role($user_id);
		if($role < $min_role){
			exit('权限不足！');
		}
	}

	function jump($url){
		header('location:'.$url);
	}

?>