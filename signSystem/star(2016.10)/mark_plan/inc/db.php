<?php
	class db{
		public $db;
		
		public function __construct(){
			$this->db = new mysqli('127.0.0.1','root','gzittc123456','star');
			if ($this->db->connect_error) {
				die('Connect Error (' . $this->db->connect_errno . ') ' . $this->db->connect_error);
			}
			$this->db->set_charset("utf8");
		}
		
		public function query($sql){
			return $this->db->query($sql);
		}
		
		public function fetch($result){
			$data = array();
			if($result){
				while($row = $result->fetch_assoc()){
					$data[] = $row;
				}
			}
			return $data;
		}
		
		public function select($table,$where=NULL,$other=NULL){
			$sql = 'SELECT * FROM `' . $table . '` ';
			if($where){
				$sql .= ' WHERE ';
				foreach($where as $k => $v){
					$sql .= ' `' . $k . '` = \'' . $v . '\' AND ';
				}
				$sql = substr($sql,0,-4);
			}
			//echo $sql.$other;
			$result = $this->query($sql.$other);
			return $this->fetch($result);
		}
		
		public function select_one($table,$where=NULL,$other=NULL){
			$sql = 'SELECT * FROM `' . $table . '` ';
			if($where){
				$sql .= ' WHERE ';
				foreach($where as $k => $v){
					$sql .= ' `' . $k . '` = \'' . $v . '\' AND ';
				}
				$sql = substr($sql,0,-4);
			}
			$result = $this->query($sql.$other);
			return $result->fetch_assoc();
		}
		
		public function insert($table,$data){
			$sql = 'INSERT INTO  `' . $table . '` ';
			$keys = $values = '';
			foreach($data as $k => $v){
				$keys .= ' `'.$k . '` , ';
				$values .= ' \''.$v . '\'  , ';
			}
			$sql .= ' ('.substr($keys,0,-2).') VALUES ('.substr($values,0,-2).') ';
			$this->query($sql);
		}
		
		public function update($table,$data,$where){
			$sql = ' UPDATE `'.$table.'` SET ';
			foreach($data as $k => $v){
				$sql .= ' `'.$k . '` = \'' . $v . '\' , ';
			}
			$sql = substr($sql,0,-2);
			if($where){
				$sql .= ' WHERE ';
				foreach($where as $k => $v){
					$sql .= ' `' . $k . '` = \'' . $v . '\' AND ';
				}
				$sql = substr($sql,0,-4);
			}
			$this->query($sql);
		}
		
		public function delete($table,$where){
			$sql = ' DELETE FROM `'.$table.'` ';
			if($where){
				$sql .= ' WHERE ';
				foreach($where as $k => $v){
					$sql .= ' `' . $k . '` = \'' . $v . '\' AND ';
				}
				$sql = substr($sql,0,-4);
			}
			$this->query($sql);
		}
	}
?>