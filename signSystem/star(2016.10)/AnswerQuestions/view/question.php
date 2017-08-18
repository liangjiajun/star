<?php 
	include('../view/header.php');
	echo '<link rel="stylesheet"  href="../style/question.css">';
	echo '<script src=" ../javascripts/jquery.js"></script>';
	$question_num=10;
	$type=$_GET['type'];
	$sql="SELECT * FROM answer_question WHERE askType = '$type' ORDER BY rand() LIMIT $question_num ";
	$result=mysql_query($sql);
	$question = array();
	while($row = mysql_fetch_assoc($result)){
		$question[]=$row;
	}
 ?>
	<address>
		<div class="question">
			<header>
				<img src="../images/1.png" alt="<?php echo $type ?>">
				<span class="type"><?php echo $type ?></span>
				<div class="type-level">级别:
					<span class="rank">简单</span>	
				</div>
			</header>
			<div class="question-content" >
					<?php  $i=1; 
					foreach($question as $q){ 
		                        $arr = array(); 
		                        $arr[]=$q['issue1'];
		                        $arr[]=$q['issue2'];
		                        $arr[]=$q['issue3'];
		                        $arr[]=$q['issue4'];   
		                        shuffle($arr);
		             ?>
					<div class="q_in" id="<?php echo $q['id'] ?>">
						<p class="fzw"><?php echo $i++.'、'. $q['issueContent']?></p>
						<ul>
							<li><a><?php echo trim($arr[0]);?></a></li>
							<li><a><?php echo trim($arr[1]);?></a></li>
							<li><a><?php echo trim($arr[2]);?></a></li>
							<li><a><?php echo trim($arr[3]);?></a></li>
						</ul>
					</div>
					<?php } ?>
				<form class="answer_btn">
					<button class="answer_result" type="button">提交</button>					
				</form>
			<div class="clear"></div>
			</div>
		</div>
	</address>
	<ul class="question_btn">
			<?php  $i=1; foreach ($question as $value) { ?>
				<li><?php echo $i++ ?><span><?php echo $value['issueContent'] ?></span></li>
			<?php } ?>
			<li class="top">top</li>
	</ul>	
	<div class="num_uesr"><h3>分数 </h3><span>0</span></div>
	<div class="wrap_bg">
		<h3>完成答题！</h3>
		<nav>
			<ul>
				<li><a href="index.php" title="首页">继续答题</a></li>
				<li><a href="aboutus.php" title="关于我们">查看成绩</a></li>
			</ul>
		</nav>

	</div>
</body>
</html>	
<script>
/*
	判断题目对错
*/
$q_ulHeight = $('.q_in ul').height();
$q_ul = $('.q_in ul');
$i=10;
$('.q_in ul li').click(function(){
	var this2 = $(this);
	$.ajax({
			url: '../php/question_answer.php',
			method: 'get',
			data: "issue=" + $(this).text()+ "&answerId="+$(this).parent().parent().attr('id') +"",
			success:function(data){
				var arr = data.split('-');
				if(arr[0] ==1){
					this2.addClass('right');
					$('.num_uesr span').each(function(){
						$(this).html($i+Number($(this).html()));
					});
					var t = $(window).scrollTop();
					$('body,html').animate({'scrollTop':t+400},1000);
				}else if(arr[0] ==0){
					this2.addClass('worng');
					this2.siblings().unbind('click');
				}else{

				}					
			}
	})
});  

$('.answer_result').click(function(){
	$.ajax({
		url: '../php/question_result.php',
		method: 'post',
		data: "score=" + $('.num_uesr span').text()+"&usernames="+$('.top-right li a').attr('title')+"&type="+$('.type').text()+"",
		success:function(e){
			$('.wrap_bg').show(500);
		}
	})
});







/*
返回顶部，效果已做出来，不过没有好的用户体验效果，刚开始隐藏还没做
*/
/*$(window).scroll(function(){
	$windownH=window.screen.height; 
    if($(window).scrollTop(1080+'px') < $windownH){
        $(".top").fadeOut(1000);
    }else{
        $(".top").fadeIn(1000);
    }
});*/
$(".top").click(function(){
    $('body,html').animate({scrollTop:0},1000);
});





</script>					

