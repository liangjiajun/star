<div class="clear"></div>
<div class="page-header bg">
	 <form class="Calendar" action="calendar.php"  method="post" accept-charset="utf-8">
	 	<span><b>按时间查询：</b></span>
	 	<input class="Wdate" type="text" name="CalendarStart" onClick="WdatePicker()" placeholder="请输入起始时间">
	 	<span>-</span>
	 	<input class="Wdate" type="text" name="CalendarEnd" onClick="WdatePicker()" placeholder="请输入结束时间">
	 	<input class="btn btn-default btn-sm" type="submit" name="CalendarnName" value="搜索"> 
	</form>
	<ul class="pagemenu">
		<li><a href="index.php"><button type="button" class="btn btn-default">首页</button></a></li>
		<li><a>&nbsp;</a></li>
		<li><a>&nbsp;</a></li>
		<li><a href="fuzzy.php?page=<?php echo $page <= 1? 1 :$page-1; ?>"><button type="button" class="btn btn-default">上一页</button></a></li>
		<li><a href="fuzzy.php?page=<?php echo $page >= $all_page? $all_page :$page+1; ?>"><button type="button" class="btn btn-default">下一页</button></a></li>
		<li><a href="fuzzy.php?page=<?php echo $all_page ?>"><button type="button" class="btn btn-default">尾页</button></a></li>
	</ul>
	<select  class="thispage" onchange="location.href='fuzzy.php?page='+this.value;">
		<?php for($i=1;$i<=$all_page;$i++){ ?>
		<option ><?php if($i){echo $i;}else{echo $i;} ?></option>
		<?php } ?>
	</select>
	<a href="upload.php" class="btn btn-primary btn-default active shangchuang" role="button">提交作品</a>
</div>