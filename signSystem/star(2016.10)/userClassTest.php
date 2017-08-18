<meta charset="UTF-8" />
<?php 
include_once("top.php");

/*先要实例化*/
$user = new user();



echo "<hr>";



/*1 判断是否登陆了*/
if($user->isLogin()){
	echo '已经登陆!';
}else{
	echo '还没有登陆！';
}
//

echo "<hr>";


/*2 拿到登陆用户的信息*/
$u = $user->getUser();
echo $u["id"];
echo $u["username"];
echo $u["face_url"];
//
echo "<hr>";

/*3 拿到指定ID的用户信息*/
$u = $user->getUser("28");
echo $u["username"];
//

echo "<hr>";


/*4 拿到所有用户*/
$users = $user->getUsers();
print_r($users);
//

echo "<hr>";

/*5 如果已经拿到了所有用户的信息后，再拿某个用户的信息*/
echo $users[28]["username"];









 ?>