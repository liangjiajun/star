<?php 
/*

提交作业页面

*/

include("config.php");
include("header.php");



//拿作业列表
$subject_id  = $_GET['id'];


//拿主题
$sql = "SELECT * FROM homework_subject WHERE  id = '$subject_id'";
$r = mysql_query($sql);
$subject = mysql_fetch_assoc($r);

//拿对应主题的作业列表
$sql = "SELECT * FROM homework_jobs WHERE subject_id = '$subject_id' ORDER BY id DESC";
$r = mysql_query($sql);

?>
<h1><a href="index.php">返回</a></h1>


<?php 
//主题输出
echo  "<h2>".$subject['name']."</h2>";
echo "发布时间:".date("Y-m-d",$subject['time']);
echo  " | 负责同学：".$subject['people'];
?>



<ul>
<?php while($row = mysql_fetch_assoc($r)) {?>
	<li>[<?php echo  date("Y-m-d",$row['time']); ?>] - <a href="<?php echo $row['path'] ?>">(<?php echo $row['who'] ?>)下载</a></li>
<?php } ?>

</ul>
<script src="dropzone.js"></script>
<div id="dropz">点击选择作品，或直接把作品拖进来</div>
<style>#dropz{ width:100%; height:300px; border:dashed 1px red; color:red; line-height:300px; text-align:center;}</style>
<script>
    var dropz = new Dropzone("#dropz", {
        url: "handle-upload.php?subject_id=<?php echo $subject_id; ?>",
        maxFiles: 10,
        maxFilesize: 2048,
	 	init: function() {
			this.on("success", function(file) {
				location.reload();
			});
			this.on("removedfile", function(file) {
				console.log("File " + file.name + "removed");
			});
        }
    });
</script>


<?php include("footer.php");?>



