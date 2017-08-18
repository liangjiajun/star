<?php 
include("config.php");
include("header.php");

$sql = "SELECT * FROM homework_subject ORDER BY id DESC";
$r = mysql_query($sql);
?>
<ul>
<?php while($row = mysql_fetch_assoc($r)) {?>
	<li><a href="job.php?id=<?php echo $row['id'] ?>">[<?php echo  date("Y-m-d",$row['time']); ?>] - <?php echo $row['name'] ?></a></li>
<?php } ?>

</ul>




<?php include("footer.php");?>