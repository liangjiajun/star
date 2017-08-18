<?php 
include("config.php");
include("header.php");


//拿所有用户
$sql = "SELECT * FROM users ORDER BY id DESC";
$r = mysql_query($sql);
$users = "";
while($row = mysql_fetch_assoc($r)){
	$users[] = $row;
}


//拿所有用户组
$sql = "SELECT * FROM user_group";
$r = mysql_query($sql);
$groups = "";
while($row = mysql_fetch_assoc($r)){
	$groups[] = $row;
}

//拿到用户与用户组之间的关系
$sql = "SELECT * FROM user_group_users";
$r = mysql_query($sql);
$group_user = "";
while($row = mysql_fetch_assoc($r)){
	$group_user[$row["user_id"]]=$row["user_id"].$row["group_id"];
}

//设置关系 
if(isset($_GET['set'])){
	$uid = $_GET['uid'];
	$gid = $_GET['gid'];
	$sql = "INSERT INTO user_group_users VALUES (NULL,$gid,$uid)";
	mysql_query($sql);
	header("location:index.php");
}

//取消关系
if(isset($_GET['cancel'])){
	$uid = $_GET['uid'];
	$gid = $_GET['gid'];
	 $sql = "DELETE FROM user_group_users WHERE group_id = $gid AND user_id = $uid";

	mysql_query($sql);
	header("location:index.php");
}


?>
<ul>

<table class="gridtable">
<thead>
	<th>用户名</th>
	<?php foreach($groups as $v){?>
	<th><?php echo $v['name']; ?></th>
	<?php } ?>
</thead>
<tr>
	<td>分组说明</td>
	<?php foreach($groups as $v){?>
	<td><?php echo $v['description']; ?></td>
	<?php } ?>

</tr>

<?php foreach ($users as $value){?>
	
	<tr>
		<td><?php echo $value['username'] ?></td>
		<?php foreach($groups as $v){?>

		<td>
			<?php 

				if(isset($group_user[$value["id"]])){
					if($group_user[$value["id"]] == $value["id"].$v["id"]){
						echo "yes";
						if(isset($_SESSION['role']) and $_SESSION['role']==2)
						echo "<a href='?cancel=1&uid=".$value['id']."&gid=".$v['id']."'>取消</a>";
					}else{
						if(isset($_SESSION['role']) and $_SESSION['role']==2)
						echo "<a href='?set=1&uid=".$value['id']."&gid=".$v['id']."'>设置</a>";
					}
				}else{
					if(isset($_SESSION['role']) and $_SESSION['role']==2)
					echo "<a href='?set=1&uid=".$value['id']."&gid=".$v['id']."'>设置</a>";
				}
			?>
		</td>

		<?php } ?>
		</tr>
<?php } ?>


</table>
<?php include("footer.php");?>

<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 3px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
	text-align: center;
}
table.gridtable tr:hover td {
	background-color: #eee;

}
</style>
