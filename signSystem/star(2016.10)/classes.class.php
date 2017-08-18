<?php 


class user{
	private $username; 
	private $face;   //头像，对应数据库users.face_url
	private $id; //用户主键，id
	private $role;   //用户角色


	function __construct(){

		if(isset($_SESSION['user'])){
			$this->username = $_SESSION['user'];
			$this->id = $_SESSION['id'];
		}
	}

	//登陆判断
	function isLogin(){
		return isset($_SESSION["user"])?true:false;
	}

	/*获得一个用户的所有信息 getUser()
	* @id 指定id查找，如果不提价id，默认是已登陆的用户。
	*/

	function getUser($id = 0){
		if($id==0){
			$id = $this->id;
			if($id == ""){
				return "用户还没有登陆！";
			}
		}

		$sql = "SELECT * FROM users WHERE id = '$id'";
		$r = mysql_query($sql);
		$row = mysql_fetch_assoc($r);
		return $row;
	}

	//返回所有用户信息，以id为索引
	function getUsers(){
		$sql = "SELECT * FROM users";
		$r = mysql_query($sql);
		$users = array();
		while($row = mysql_fetch_assoc($r)){
			$users[$row["id"]] =$row;
		}
		return $users;
	}
	

}



