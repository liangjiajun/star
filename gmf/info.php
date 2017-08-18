<?php 

/*
查询日志分析
*/
header("Content-type:text/html;charset=utf-8");
/*
	姓名、学号、班级
*/
include('config.php');
date_default_timezone_set('PRC');





$sql = "SELECT * FROM `log`,students WHERE `log`.num = `students`.number";
$r = mysql_query($sql);


echo "<table border='1'>";

while($row = mysql_fetch_assoc($r)){
	echo "<tr>";
	echo "<td>".$row['id']."</td>";
	echo "<td>".$row['name']."</td>";
	echo "<td>".date("Y-m-d H:i:s",$row['time'])."</td>";
	echo "<td>".$row['class']."</td>";
	echo "</tr>";
}
echo "</table>";

