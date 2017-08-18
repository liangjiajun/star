<?php 
include('../config/config.php');

$sql ="SELECT username FROM users WHERE role = 0";
$result = mysql_query($sql);
 
while($row = mysql_fetch_assoc($result)){
	echo $row["username"].",";
}

