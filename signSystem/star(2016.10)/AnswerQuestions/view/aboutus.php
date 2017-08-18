<?php 
include('../view/header.php');
echo '<link rel="stylesheet"  href="../style/aboutus.css">';
date_default_timezone_set('PRC');

$sql ="SELECT * FROM answer_results ORDER BY respondents,id DESC";
$result = mysql_query($sql);
$array = array();
while($row = mysql_fetch_array($result)){
	$array[]=$row;
}
?>

<section class="aboutus">
	<h3>辰员数据</h3>
	<div class="about_data">
	<?php 

		$name = ""; //替换变量
		$num = 0;
		foreach($array as $a){ 


			if($num ==2 AND $name == $a['respondents']){

			}else{

							if($name != $a['respondents']){//如果上一条记录不同名
							echo "</ul>";
							$name = $a['respondents'];//将当前记录的用户名放到替换变量
							$num = 0;//出现次数
							
						?>

					
						<ul class="user_data">
							<li class="about_top">姓名：<?php echo $a['respondents']; ?><span></span> </li>
							<li class="data">
								<span class="data_type">类型</span>
								<span>分数</span>
								<span class="data_time">时间</span>
							</li>

						<?php 

							} 

							$num++;//出现次数
							?>


							<li class="data">
								<span class="data_type"><?php echo $a['answer_type'] ?></span>
								<span><?php echo $a['score'] ?></span>
								<span class="data_time"><?php echo date("Y-m-d H:i:s",$a['answer_time']) ?></span>
							</li>


						
								
						<?php 
						

						}
						?>
		


	<?php } ?>
	</div>
</section>



</body>
</html>


	