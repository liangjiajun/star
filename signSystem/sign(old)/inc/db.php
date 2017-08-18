<?php 
/** 
*数据库操作类文件
* 
*功能：增、删、改、查、获取上一步插入产生的ID
* @author      ljj 
* @version     1.0 
*/  
class db
{
	private $db;

/** 
* 构造函数
* 连接数据库
* 调用：
$config=[
	'user'=>'root', 	数据库的用户名
	'pass'=>'',			数据库的密码
	'dbsn'=>'database',	数据库的名称
];
$db=new db;   类调用

*/	
	function __construct()
	{
		$this->db=new mysqli('127.0.0.1',$GLOBALS['config']['user'],$GLOBALS['config']['pass'],$GLOBALS['config']['dbsn']);
		$this->db->set_charset('utf8');
		if(mysqli_connect_errno()){
			die('Unable to content!').mysqli_connect_error();
		}
	}




/** 
* query
* 执行mysql语句
* 
* @access public 
* @param $sql mysql语句
*/ 
	public function query($sql)
	{
		// echo $sql;
		return $this->db->query($sql);
	}


/** 
* fetch 
* 将mysql执行后的结果转化为数组
* 
* @access public 
* @param $r 执行完成后的sql语句
* @return array 
*/ 
	public function fetch($r)
	{
		$data=[];
		while ($row = mysqli_fetch_assoc($r)) {
			$data[]=$row;
		}
		return $data;
	}



/** 
* where 
* 查询语句的WHERE条件，参数以数组的形式传参
* 
* @access public 
* @param $data 条件数据['data'=>$data,'data1'=>$data2]
* @return string 
*/ 

	public function where($data)
	{
		$w="WHERE";
		foreach ($data as $k => $v) {
			$w.="`".$k."` = '".$v."' AND";
		}
		return substr($w, 0,-4);
	}


/** 
* prefix 
* 写上每个表中的列名称，用具体的列来进行查询
* 
* @access public 
* @param $d 条件数据['data','data2']
* @return string 
*/ 
	public function prefix($d)
	{
		$area='';	
		foreach ($d as $k => $v) {
			$area.='`'.$v.'` ,';
		}
		return substr($area, 0,-2);
	}

/** 
* select 
* 查询语句，参数有四个，如果只写一个参数时后面三个参数可以不写,参数之间已逗号分隔
* 
* @access public 
* @param $t 表名
* @param $p 列名称，多个名称已逗号分隔
* @param $w where条件，多个条件已逗号分隔['data'=>$data,'data1'=>$data2]
* @param $o 其他函数或方法 'ORDER BY `data` DESC'
* @return array 
*/ 
	public function select($t,$p=NULL,$w=NULL,$o=NULL)
	{
		$p = isset($p) ? $this->prefix($p) : '*' ;
		$sql='SELECT '.$p.' FROM `'.$t.'`';
		if($w){
			$sql.=$this->where($w);
		}
		$sql.=$o;
		return $this->fetch($this->query($sql));
		// echo $sql;
	}


/** 
* insert 
* 插入语句,参数之间已逗号分隔
* 
* @access public 
* @param $t 表名
* @param $d 需要插入的数据，已数组形式传参，多个条件已逗号分隔['data'=>$data,'data1'=>$data2]
*/ 
	public function insert($t,$d)
	{
		$sql='INSERT INTO `'.$t.'`';
		$k1=$v1='';
		foreach ($d as $k => $v) {
			$k1.='`'.$k.'` ,';
			$v1.="'".$v."' ,";
		}
		$sql.='('.substr($k1,0,-2).') VALUES ('.substr($v1,0,-2).')';
		$this->query($sql);
		// echo $sql;
	}


/** 
* update 
* 修改语句,参数之间已逗号分隔
* 
* @access public 
* @param $t 表名
* @param $d 需要插入的数据，已数组形式传参，多个条件已逗号分隔['data'=>$data,'data1'=>$data2]
* @param $w 需要插入的数据的具体位置，已数组形式传参
*/ 
	public function update($t,$d,$w)
	{
		$sql='UPDATE `'.$t.'` SET';
		foreach ($d as $k => $v) {
			$sql.="`".$k."` = '".$v."' ,";
		}
		$sql=substr($sql, 0,-2);
		$sql.=$this->where($w);
		$this->query($sql);
		// echo $sql;
	}


/** 
* del 
* 删除语句,参数之间已逗号分隔
* 
* @access public 
* @param $t 表名
* @param $w 需要删除的数据的具体位置，已数组形式传参
*/ 

	public function del($t,$w)
	{
		$sql='DELETE FROM `'.$t.'`';
		$sql.=$this->where($w);
		$this->query($sql);
	}


/** 
* in_id 
* 获取上一步插入产生的ID，没有参数。可在插入语句执行完成后执行
* 
* @access public 
*/ 	
	public function in_id()
	{
		return mysqli_insert_id($this->db);
	}


}





