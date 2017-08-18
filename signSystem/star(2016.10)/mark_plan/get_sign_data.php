<?php
	require_once('inc/config.php');

	class student_sign_data{
		public $db;
		public $all_data;
		public $year;
		public $month;
		public $start_day;
		public $end_day;
		public $all_day;
		public $work_day;
		public $sign_normal_rule;
		public $sign_other_rule;

		public function __construct($user_id,$year,$month){
			$this->db = new db;
			$this->year = $year;
			$this->month = $month;
			$this->start_day = $year.'-'.$month.'-1';
			$this->end_day = $year.'-'.($month+1).'-1';
			if(strtotime($this->start_day) > time()){
				exit();
			}
			$this->work_day = strtotime($this->end_day) > time() ? (int)date("d",time()) : (int)date("t",strtotime($year.'-'.$month ));
			$this->all_day = (int)date("t",strtotime($year.'-'.$month ));
			$this->all_data = $this->db->select('sign',array('user_id'=>$user_id),' and datetime1 >= '.strtotime($this->start_day).' and datetime1 < '.strtotime($this->end_day));
			$rule_id = 1;//等待完成
			$this->sign_normal_rule = $this->db->select_one('sign_normal_rule',array('id'=>$rule_id));
			$this->sign_other_rule = $this->db->select('sign_other_rule',NULL," where FIND_IN_SET('".$user_id."',users) " );
		}

		public function get_today_data($data,$start_time,$end_time){
			$dt = array();
			foreach($data as $v){
				if((int)$v['datetime1'] > $start_time && (int)$v['datetime1'] < $end_time){
					$dt[] = (int)$v['datetime1'];
				}
				if((int)$v['datetime2'] > $start_time && (int)$v['datetime2'] < $end_time){
					$dt[] = (int)$v['datetime2'];
				}
			}
			return $dt;
		}

		public function set_max_min($data){
			$dt = array();
			if(!empty($data)){
				$dt['max'] = max($data);
				$dt['min'] = min($data);
			}
			return $dt;
		}

		public function is_late($max_min,$day){
			//调整时间的开关
			$change_time = false;

			//加班，放假，请假，调整考勤
			foreach($this->sign_other_rule as $rule){
				if(strtotime($this->year.'-'.$this->month.'-'.$day) >= strtotime($rule['start_date']) &&  strtotime($this->year.'-'.$this->month.'-'.$day) <= strtotime($rule['end_date'])){
					switch($rule['type']){
						case '放假' : 
							$data['sign'] = 'holiday';
							$data['sign_out'] = 'holiday';
							return $data;
							break;
						case '请假' : 
							$data['sign'] = 'holiday';
							$data['sign_out'] = 'holiday';
							return $data;
							break;
						case '加班' : 
						case '调整考勤' : 
							$change_time = true;
							$change_time_start = $rule['start_time'];
							$change_time_end = $rule['end_time'];
							break;
					}
				}
			}

			//正常考勤
			if(strtotime($this->year.'-'.$this->month.'-'.$day) >= strtotime(date('Y-m-d'))){
				return 'out';
			}
			switch(date("w",strtotime($this->year.'-'.$this->month.'-'.$day))){
				case 0:
					if(!$change_time){
						$data['sign'] = 'holiday';
						$data['sign_out'] = 'holiday';
						return $data;
					}
					break;
				case 1:
					$start_rule = 'mon_start';
					$end_rule = 'mon_end';
					break;
				case 2:
					$start_rule = 'tue_start';
					$end_rule = 'tue_end';
					break;
				case 3:
					$start_rule = 'wed_start';
					$end_rule = 'wed_end';
					break;
				case 4:
					$start_rule = 'thu_start';
					$end_rule = 'thu_end';
					break;
				case 5:
					$start_rule = 'fri_start';
					$end_rule = 'fri_end';
					break;
				case 6:
					$start_rule = 'sat_start';
					$end_rule = 'sat_end';
					break;
			}
			
			if(empty($max_min)){
				$data['sign'] = 'no_data';
				$data['sign_out'] = 'no_data';
				return $data;
			}

			if($change_time){
				$start_time = strtotime($this->year.'-'.$this->month.'-'.$day.' '.$change_time_start);
				$end_time   = strtotime($this->year.'-'.$this->month.'-'.$day.' '.$change_time_end);
			}else{
				$start_time = strtotime($this->year.'-'.$this->month.'-'.$day.' '.$this->sign_normal_rule[$start_rule]);
				$end_time   = strtotime($this->year.'-'.$this->month.'-'.$day.' '.$this->sign_normal_rule[$end_rule]);
			}

			if($max_min['min'] < $start_time){
				$data['sign'] = 'normal';
			}else{
				$data['sign'] = 'late';
			}
			if($max_min['max'] > $end_time){
				$data['sign_out'] = 'normal';
			}else{
				$data['sign_out'] = 'early';
			}
			return $data;
		}

		public function set_late($data,$day){
			$start_time = strtotime($this->year.'-'.$this->month.'-'.$day);
			$end_time = strtotime($this->year.'-'.$this->month.'-'.($day+1));
			$today_data = $this->get_today_data($data,$start_time,$end_time);
			$today_max_min = $this->set_max_min($today_data);
			$late = $this->is_late($today_max_min,$day);
			return $late;
		}

		public function format_sign_as_array(){
			$sign_array = array();
			for($i=1;$i<=$this->all_day;$i++){
				$sign_array[$i] = $this->set_late($this->all_data,$i);
			}
			return $sign_array;
		}
	}

	$db = new db;
	if(empty($_GET['user'])){
		$users = array_merge(get_group_users(MEMBER_GROUP),get_group_users(STUDENT_GROUP));
	}else{
		$events = explode('_',$_GET['user']);
		switch($events[0]){
			case 'group' :
				$users = get_group_users($events[1]);
				break;
			case 'user' :
				$users = $db->select('users',array('id'=>$events[1]));
				break;
		}
	}

	$data = array();
	foreach($users as $v){
		$user_sign_data = new student_sign_data($v['id'],$_GET['year'],$_GET['month']);
		$data[$v['username']] = $user_sign_data->format_sign_as_array();
	}
	echo json_encode($data);

?>