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
?>