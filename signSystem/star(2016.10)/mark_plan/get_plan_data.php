<?php
	require_once('inc/config.php');

	class get_plan_data{
		public $db;
		public $year;
		public $month;
		public $start_day;
		public $end_day;
		public $max_start_time;
		public $max_end_time;
		public $users = array();
		public $data = array();

		public function __construct(){
			$this->check_err();
			$this->db = new db;
			$this->year = $_GET['year'];
			$this->month = $_GET['month'];
			$this->start_day = $this->year.'-'.$this->month.'-1';
			$this->end_day = $this->year.'-'.$this->month.'-'.date("t",strtotime($this->year.'-'.$this->month ));//cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
			$this->max_start_time = strtotime($this->start_day);
			$this->max_end_time = strtotime($this->end_day);
			$this->set_users();
			$this->format_data();
		}

		public function get_time($time_str){
			return strtotime($time_str);
		}

		public function set_start_end(&$arr){
			foreach($arr as $k => $v){
				$start_timer = $this->get_time($v['start_date']);
				$arr[$k]['start'] = $start_timer <= $this->max_start_time ? (int)date('d',$this->max_start_time) : (int)date('d',$start_timer);
				$end_timer = $this->get_time($v['end_date']);
				$arr[$k]['end'] = $end_timer >= $this->max_end_time ? (int)date('d',$this->max_end_time) : (int)date('d',$end_timer);
			}
		}

		public function check_err(){
			if(!isset($_GET['year'],$_GET['month'],$_GET['user'])){
				echo 'err';
				exit();
			}
		}

		public function set_users(){
			if(empty($_GET['user'])){
				$this->users = array_merge(get_group_users(MEMBER_GROUP),get_group_users(STUDENT_GROUP));
				$this->users[] = array('id'=>'team','username'=>'团队计划'); //加一个团队任务标识 
			}else{
				$events = explode('_',$_GET['user']);
				switch($events[0]){
					case 'group' :
						$this->users = get_group_users($events[1]);
						break;
					case 'user' :
						$this->users = $this->db->select('users',array('id'=>$events[1]));
						break;
				}
			}
		}

		public function format_data(){
			foreach($this->users as $user){

				if($user['id'] == 'team'){
					$group_id = find_group_id(TEACHER_GROUP);
					$user_ids = get_group_user_ids($group_id);
					$sql = "select mark_plan.* from mark_plan left join users on users.id = mark_plan.user_id where users.id in (".implode(',',$user_ids).") and mark_plan.end_date >= '".$this->start_day."' and mark_plan.start_date <= '".$this->end_day."'";
					$dt = $this->db->fetch($this->db->query($sql));
				}else{
					$dt = $this->db->select('mark_plan',array('user_id'=>$user['id'])," and end_date >= '".$this->start_day."' and start_date <= '".$this->end_day."'");
				}

				if(!empty($dt)){
					$this->set_start_end($dt);
					if(!isset($this->data[$user['username']])){
						$this->data[$user['username']] = array();
					}
					foreach($dt as $d){
						$is_exits = false;
						$is_done = false;
						$i = 1;
						foreach($this->data[$user['username']] as $kr => $r){
							foreach($r as $krw => $rw){
								if($is_done == false && $is_exits == false && (($d['start'] - $rw['end'] > 0 && $d['end'] - $rw['start'] > 0) || ($d['start'] - $rw['end'] < 0 && $d['end'] - $rw['start'] < 0))){
								}else{
									$is_exits = true;
								}
							}
							if($is_exits == false){
								$this->data[$user['username']][$i][] = $d;
								$is_done = true;
								break;
							}
							$is_exits = false;
							$i++;
						}
						if($is_done == false && $is_exits == false){
							$this->data[$user['username']][$i][] = $d;
						}
					}
				}
			}
		}


		public function format_json(){
			return json_encode($this->data);
		}


	}

	$dt = new get_plan_data;
	echo $dt->format_json();

?>