<?php 
// 公共页面，所有对内平台都引用
//baseurl
include_once("config.php");
include_once("classes.class.php");


//求基准路径 $baseurl ,不够完美，现在只能处理放在二级目录的页面
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('/', $uri);
array_pop($uri);
array_pop($uri);
$uri = implode('/', $uri);
$baseurl = "http://".$_SERVER['HTTP_HOST'].$uri;  





 ?>
<style type="text/css">
	*{margin: 0; padding: 0; list-style: none; text-decoration: none; color: inherit;}
	.navbar_cus{ height: 50px; line-height: 50px; background: #222222; font-family:'黑体', arial;}
	.navleft_cus{float: left;}
	.navright_cus{float: right;}
	.navbar_cus li{ float: left;height: 50px;overflow: hidden;}
    .navbar_cus li::before{color: #000;}
    .navbar_cus li a::after{content:attr(data-file-name);display: block;color: #ffcf41;}/*新增*/
	.navbar_cus a{ padding: 0 15px; display: block; color: #fff; font-size: 14px;transition:transform 0.3s;}
	.navbar_cus a:hover{ transform:translate(0px,-50px);text-decoration: none;}/*去掉了背景框*/
	.clearfix:after,.clearfix:before{ content: ''; display: block; clear: both;}
	@media(max-width: 870px){
		.navbar_cus a:nth-last-of-type(1){color:#ca860b}
	}
</style>

<nav class="navbar_cus">
    <div class="navleft_cus">
        <ul class=" clearfix">
        	<li><a href="http://www.gzittc.net" style=" color: #ffcf41;" data-file-name="星辰工作室">星辰工作室</a></li>
    		<?php 
				    		/*1 判断是否登陆了*/
				if(isset($_SESSION["user"])){
			?>

				
				<!-- <li><a href="http://192.168.71.250/source_file.php" target="_blank" class="tc_fff block bg_blu_light" data-file-name="素材库">素材库</a></li> -->
                <!-- <li><a href="http://star.gzittc.net/else/homework/" class="tc_fff block bg_blu_light" data-file-name="寒假作业提交">寒假作业提交</a></li> -->
                
				<?php if(isset($_SESSION['role']) and $_SESSION['role']>0){ ?>

					<li><a href="<?php echo $baseurl ?>/mark_plan" class="tc_fff block bg_blu_light" data-file-name="计划管理器">计划管理器</a></li>
					<li><a href="http://star.gzittc.net/else/usergroup/" class="tc_fff block bg_blu_light" data-file-name="成员分组">成员分组</a></li>
	            	<li><a href="<?php echo $baseurl ?>/star.V1.2/" data-file-name="作品提交平台">作品提交平台</a></li>
	            	
					<li><a href="#" class="tc_fff block bg_blu_light" data-file-name="|">|</a></li>
                	<li><a href="http://192.168.71.198/treasuryv1.01/" target="_blank" class="tc_fff block bg_blu_light" data-file-name="小金库">小金库</a></li>
                	<li><a href="http://star.gzittc.net/AnswerQuestions/" target="_blank" class="tc_fff block bg_blu_light" data-file-name="AnswerQuestions">AnswerQuestions</a></li>
					<li><a href="<?php echo $baseurl ?>/bbs/" class="tc_fff block bg_blu_light" data-file-name="互动中心">互动中心</a></li>
					<li><a href="<?php echo $baseurl ?>/TaskManagement/" class="tc_fff block bg_blu_light" data-file-name="任务管理器">任务管理器</a></li>
					<li><a href="http://2huo.gzittc.net" class="tc_fff block bg_blu_light" target="_blank" data-file-name="二货交易市场">二货交易市场</a></li>
	                <li><a href="http://star.gzittc.net/SkillsTree/tree.php" target="_blank" class="tc_fff block bg_blu_light" data-file-name="知识技能树">知识技能树</a></li>
					<!-- <li><a href="http://star.gzittc.net/else/studiohomework/" class="tc_fff block bg_blu_light" data-file-name="成果提交">成果提交</a></li> -->
					<li><a href="<?php echo $baseurl ?>/snake_game/" class="tc_fff block bg_blu_light"  data-file-name="snake">snake</a></li>
					
				<?php } ?>

			<?php
				}

    		?>
        	<!-- <li><a href="<?php echo $baseurl ?>/tasks/" data-file-name="作品提交平台">作品提交平台</a></li> -->
        </ul>
    </div>
    <div id="navbar_cus" class="navright_cus">
        <ul class=" clearfix">
            <!-- 登录注册页面start -->
            <?php if(isset($_SESSION['user'])){ ?>
            	<li><a href="<?php echo $baseurl ?>/users/personal.php?userid=<?php echo $_SESSION['id'] ?>" data-file-name="<?php echo $_SESSION['user']; ?>"><?php echo $_SESSION['user']; ?></a></li>
            	<li><a href="<?php echo $baseurl ?>/users/logout.php"data-file-name="签退">签退</a></li>
            <?php }else{ ?>
	            <li><a href="<?php echo $baseurl ?>/users/login.php"data-file-name="签到">签到</a></li>
	<!--             <li><a href="<?php echo $baseurl ?>/users/reg.php">注册</a></li> -->
            <?php } ?>
            <!-- 登录注册页面end -->
        </ul>
    </div>
</nav>