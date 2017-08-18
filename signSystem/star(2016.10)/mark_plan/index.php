<?php
	session_start();

	//$_SESSION['role'] = 2;
	//$_SESSION['id'] = 58;

	
	require_once('inc/config.php');


	//调整时间格式
	
	// $db = new db;
	// $dt = $db->select('mark_plan');
	// foreach($dt as $v){
	// 	$x['start_date'] = $v['year'].'-'.$v['month'].'-'.$v['start'];
	// 	$x['end_date'] = $v['year'].'-'.$v['month'].'-'.$v['end'];
	// 	$db->update('mark_plan',$x,array('id'=>$v['id']));
	// }
	// exit();
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>计划管理</title>
<script type="text/javascript" src="script/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="script/jquery_ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="script/jquery_ui/jquery-ui.datepicker-zh-CN.js"></script>
<script>
	var nm_w;
	var add_dialog;
	var date;
	var year;
	var month;
	var day;
	var day_nm;

	var getCountDays = function(y,m) {
		var curDate = new Date();
		curDate.setYear(y);
		curDate.setMonth(m);
		curDate.setDate(0);
		return curDate.getDate();
	}
	
	var day_of_week = function(y,m,d) {
		var curDate = new Date();
		curDate.setYear(y);
		curDate.setMonth(m-1);
		curDate.setDate(d);
		return curDate.getDay();
	}

	var get_color = function(event_id,is_teacher,end_date){
		var now_date=new Date(year+'-'+month+'-'+day);
		var end_date=new Date(end_date);

		if(event_id == 0 && end_date < now_date){ //已经过期，未改状态的任务
			return '#666';
		}
		if(event_id == 0 && is_teacher == 1){ //教师发布的任务
			return '#ff8400';
		}
		if(event_id == 1){ //已完成的任务
			return '#000';
		}
		if(event_id == 2){ //未完成的任务
			return 'red';
		}
		return 'green'; //正常状态中的任务
	}
	
	var get_and_format_data = function(){
		var user_id = $('#user_id').val();
		var year = $('#select_date .ui-datepicker-year').val();
		var month = parseInt($('#select_date .ui-datepicker-month').val())+1;
		format_data(year,month,user_id);
	}

	var get_sign_class = function(event){
		var sign_class = '';
		switch(event){
			case 'out' :
				break;
			case 'normal' :
				sign_class = 'sign_normal';
				break;
			case 'no_data' :
				sign_class = 'sign_no_data';
				break;
			case 'late' :
				sign_class = 'sign_late';
				break;
			case 'early' :
				sign_class = 'sign_early';
				break;
			case 'holiday' :
				sign_class = 'sign_holiday';
				break;
		}
		return sign_class;
	}

	var show_sign = function(year,month,user_id){
		$.getJSON('get_sign_data.php',{'year':year,'month':month,'user':user_id},function(data){
			for(var user in data){
				if($('div[data-user="'+user+'"]').length <= 0){
					$('#data_div').append('<div class="sign_div"><div data-user="'+user+'" class="tb"></div><div>');
					$('.tb[data-user='+user+']').append('<div data-user="'+user+'" class="user" style="overflow:hidden;width:'+nm_w*2+'px;height:'+nm_w/2+'px;left:-'+nm_w*2+'px">'+user+'</div>');
				}else{
					$('.tb[data-user='+user+']').prepend('<div class="sign_div"><div data-user="'+user+'" class="tb"></div><div>');
					$('.user[data-user='+user+']').css('height',(parseFloat($('.user[data-user='+user+']').css('height'))+nm_w/2)+'px');
					for(var i in $('.tb_row')){
						$('.tb[data-user='+user+'] .tb_row:eq('+i+')').css('top',(parseFloat($('.tb[data-user='+user+'] .tb_row:eq('+i+')').css('top'))+nm_w/2)+'px');
					}
				}
				$sign_html = '';
				for(var sign_data in data[user]){
					var sign_class = get_sign_class(data[user][sign_data].sign);
					var sign_out_class = get_sign_class(data[user][sign_data].sign_out);
					$sign_html += '<div class="top_nm tb_tb '+sign_class+'">&nbsp;</div><div class="top_nm tb_tb '+sign_out_class+'">&nbsp;</div>';
				}
				$('.sign_div .tb[data-user='+user+']').append($sign_html);
				$('.sign_div .tb[data-user='+user+']').append('<div class="clear"></div>');
				$('.sign_div .tb[data-user='+user+'] .tb_tb').css({'width':(nm_w/2)+'px','height':(nm_w/2)+'px'});
				$('.sign_div .tb[data-user='+user+'] .tb_tb:last').addClass('top_nm_last');

				$('.sign_div .tb[data-user='+user+'] .tb_tb:eq('+(day*2-1)+'),.sign_div .tb[data-user='+user+'] .tb_tb:eq('+(day*2-2)+')').addClass('yellow');
			}		
		});
	}
	
	var format_data = function(year,month,user_id){
		if(!user_id){
			user_id = '';
		}

		$('#top,#data_div').html('');
		
		var day_nm = getCountDays(year,month);
		var today_date = new Date;
		var today_year = date.getFullYear(); 
		var today_month = date.getMonth()+1;
		nm_w = Math.floor($('#main').width()/day_nm);

	
		for(var i=1;i<=day_nm;i++){
			var is_sunday = '';
			var is_today = '';
			var dow = day_of_week(year,month,i);
			if( dow % 6 == 0 || dow % 7 == 0){
				is_sunday = ' red ';
			}
			
			var is_today = (day == i && today_year == year && today_month == month) ? ' yellow ' : '';
			
			if(i==day_nm){
				$('#top').append('<div class="top_nm top_nm_last '+is_sunday+is_today+'">'+i+'</div>');
			}else{
				$('#top').append('<div class="top_nm '+is_sunday+is_today+'">'+i+'</div>');
			}
			$('.top_nm').css({'width':nm_w+'px','line-height':nm_w+'px'});
		}
		
		$.getJSON('get_plan_data.php',{'year':year,'month':month,'user':user_id},function(data){
			for(var user in data){
				$('#data_div').append('<div data-user="'+user+'" class="tb"></div>');
				$('.tb[data-user='+user+']').append('<div data-user="'+user+'" class="user" style="overflow:hidden;width:'+nm_w*2+'px;left:-'+nm_w*2+'px">'+user+'</div>');
				for(var row in data[user]){
					for(var dt in data[user][row]){
						var width = (data[user][row][dt]['end'] - data[user][row][dt]['start'] + 1) * nm_w;
						var left = (data[user][row][dt]['start'] - 1) * nm_w
						
						$('.tb[data-user='+user+']').append('<div title="'+data[user][row][dt]['content']+'" class="tb_row" data-id="'+data[user][row][dt]['id']+'" data-user_id="'+data[user][row][dt]['user_id']+'" data-session_id="<?= $_SESSION['id']; ?>" data-session_role="<?= $_SESSION['role']; ?>" style="width:'+width+'px;height:'+nm_w+'px;left:'+left+'px;line-height:'+nm_w+'px;left:'+left+'px;top:'+((row-1)*(nm_w))+'px;background:'+get_color(data[user][row][dt]['event'],data[user][row][dt]['is_teacher'],data[user][row][dt]['end_date'])+';">'+data[user][row][dt]['content']+'</div>');
						$('.user[data-user='+user+']').css({'line-height':(row*nm_w)+'px','height':(row*nm_w)+'px'});
					}
					var empty_tb = '';
					for(var i=1;i<=day_nm;i++){
						var is_today = (day == i && today_year == year && today_month == month) ? ' yellow ' : '';
						if(i==day_nm){
							empty_tb += '<div class="top_nm top_nm_last tb_tb '+is_today+'">&nbsp;</div><div class="clear"></div>';
						}else{
							empty_tb += '<div class="top_nm tb_tb '+is_today+'">&nbsp;</div>';
						}
					}
					$('.tb[data-user='+user+']').append(empty_tb);
					$('.top_nm').css({'width':nm_w+'px','height':nm_w+'px'});
				}
			}
			$('.user:first').addClass('first_user');
			$( '.tb_row' ).tooltip({track: true,delay:0});
			
			<?php if($_SESSION['role'] == 2 || $_SESSION['role'] == 1){ ?>
				$('#top').selectable({
					stop:function(){
						var add_start = $(".ui-selected:first").html();
						var add_stop = $(".ui-selected:last").html();
						var year = $('#select_date .ui-datepicker-year').val();
						var month = parseInt($('#select_date .ui-datepicker-month').val())+1;

						$('#add_end').val(year+'-'+month+'-'+add_stop);
						$('#add_start').val(year+'-'+month+'-'+add_start);

						add_dialog.dialog( "open" );
						$(".ui-selected").removeClass('ui-selected');
					}	
				});
			<?php } ?>
			if($('#show_sign').is(':checked')){
				show_sign(year,month,user_id);
			}
		});
	}

	$(document).ready(function() {
		date=new Date;
		year=date.getFullYear(); 
		month=date.getMonth()+1;
		day=date.getDate();
		day_nm = getCountDays(year,month);
		nm_w = Math.floor($('#main').width()/day_nm);
		
		format_data(year,month<?php if($_SESSION['role'] == 1){echo ',"user_'.$_SESSION['id'].'"';} ?>);

		$('form').submit(function(){return false;});
		
		$('#select_date').datepicker( {
			changeMonth: true, 
			changeYear: true, 
			showButtonPanel: false, 
			dateFormat: 'yy/MM',
			regional:$.datepicker.regional[ 'zh-CN' ],
			onChangeMonthYear: function(year,month){
				var user_id = $('#user_id').val();
				format_data(year,month,user_id);
			}
		});

		$( "#user_id" ).selectmenu({
			width:150,
			change: function( event, data ) {
				get_and_format_data();
			}
		});
		
		$(".add").button();
		$(".tool_btn").button();

		$("#show_sign").checkboxradio({icon: false});
		
		$('#data_div').on('click','.tb_row',function(){
			if($(this).attr('data-session_id') == $(this).attr('data-user_id') || $(this).attr('data-session_role') == 2){
				var data={};
				data.id = $(this).attr('data-id');
				$.get('edit.php?id='+$(this).attr('data-id'),function(data){
					$('#edit_form').html(data);
					format_edit_form();
					edit_dialog.dialog("open");
				});
			}
		});
		
		//--------------------add表单部分--------------------
		add_dialog = $( "#add-dialog-form" ).dialog({ //dialog定义
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"新建任务":
					function(){
						var data = {}
						data.start_date = $('#add_start').val();
						data.end_date = $('#add_end').val();
						data.content = $('#add_content').val();
						if($('#add_user_id').length > 0){
							data.user_id = $('#add_user_id').val();
						}
						$.post('add.php',data,function(data){
							get_and_format_data();
							add_dialog.dialog( "close" );
						});
					},
				"取消":
					function() {
						add_dialog.dialog( "close" );
					}
			},
		});
		
		$('.add').click(function(){ //dialog触发
			add_dialog.dialog( "open" );
			return false;
		});

		$('#show_sign').change(function(){
			get_and_format_data();
		});
		
		//初始化add表单

		var format_add_form = function(year,month){ //格式化表单方法
			$('#add_start,#add_end').val(year+'-'+month+'-'+day);
			$('#add_start,#add_end').datepicker({
				changeMonth: true, 
				changeYear: true, 
				showButtonPanel: false, 
				dateFormat: 'yy-mm-dd',
				regional:$.datepicker.regional[ 'zh-CN' ]
			});
		}

		format_add_form(year,month);
		
		//^^^^^^^^^^^^^^^^^^^^add表单部分结束^^^^^^^^^^^^^^^^^^^^
		
		
		//--------------------edit表单部分--------------------
		edit_dialog = $( "#edit-dialog-form" ).dialog({ //dialog定义
			autoOpen: false,
			height: 350,
			width: 350,
			modal: true,
			buttons: {
				"删除任务":
					function(){
						if(confirm("确认删除？")){
							$.get('del.php?id='+$('#edit_id').val());
							get_and_format_data();
						}
						edit_dialog.dialog( "close" );
					},
				"修改任务":
					function(){
						var id = $('#edit_id').val();
						var data={};
						data.start_date = $('#edit_start').val();
						data.end_date = $('#edit_end').val();
						data.content = $('#edit_content').val();
						data.eve = $('#edit_event').val();
						data.user_id = $('#edit_user_id').val();
						$.post('edit.php?id='+id,data,function(){
							get_and_format_data();
						});
						edit_dialog.dialog( "close" );
					},
				"取消":
					function() {
						edit_dialog.dialog( "close" );
					}
			},
		});
		
		var format_edit_form = function(){ //格式化edit表单
			$('#edit_start,#edit_end').datepicker({
				changeMonth: true, 
				changeYear: true, 
				showButtonPanel: false, 
				dateFormat: 'yy-mm-dd',
				regional:$.datepicker.regional[ 'zh-CN' ]
			});
		}
	
		//^^^^^^^^^^^^^^^^^^^^edit表单部分结束^^^^^^^^^^^^^^^^^^^^
		$( "#selectable" ).selectable();
	});
</script>
<link rel="stylesheet" href="script/jquery_ui/jquery-ui.min.css">
<style>
	*{ padding:0; margin:0; font-family:'Arial','微软雅黑'; box-sizing:border-box;}
	#main{ width:81%; margin:0 auto;}
	.top_nm{ float:left; text-align:center; border:#aaa 1px solid; border-right:none;}
	.top_nm_last{ border-right:#aaa 1px solid;}
	.red{ color:red;}
	.yellow{ background:#fff298;}
	.tb{ position:relative;}
	.tb_row{ position:absolute; color:#fff; text-align:center; opacity:0.8; cursor:pointer; overflow:hidden; font-size:12px; border-radius:5px;}
	.tb_row:hover{ opacity:1;}
	.user{ border:#aaa 1px solid;position:absolute; text-align:center; border-right:none; border-top:none; top:0;}
	.first_user{border-top:#aaa 1px solid;}
	.tb_tb{ border-top:none; -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none;}
	#top .ui-selecting{ background: #FECA40;}
	.date_select{ width:80%; margin:0 auto; padding-top:20px;}
	.page{ width:80%; margin:0 auto; text-align:center; line-height:50px;}
	.clear{ clear:both;}
	#add-dialog-form label{ display:block; line-height:40px;}
	#add-dialog-form label span{ display:inline-block; width:70px;}
	#edit-dialog-form label{ display:block; line-height:40px;}
	#edit-dialog-form label span{ display:inline-block; width:70px;}
	.date_select .ui-datepicker-calendar {display: none; }
	.date_select .ui-datepicker-inline{ border:none; padding:0;}
	#select_date{ float:left;}
	#select_date .ui-datepicker-prev,#select_date .ui-datepicker-next{ margin-top: 3px; }
	#select_date .ui-datepicker-year,#select_date .ui-datepicker-month{ font-size:14px; height:30px; float:left; width:45%; margin-left:7px;}
	#select_date .ui-datepicker-header{ height:40px;}
	.date_select .ui-selectmenu-button{float:left; margin:0 5px;}
	.add{ display:block; float:left;}
	.tool_btn{ display:block; float:left;}
	.clear{ clear:both;}

	.sign_normal{ background: url('./images/normal.png') no-repeat; background-position:50% 50%;}
	.sign_no_data{ background: url('./images/late.png') no-repeat; background-position:50% 50%; opacity: 0.7;}
	.sign_late{ background: url('./images/no_data.png') no-repeat; background-position:50% 50%; opacity: 0.7;}
	.sign_early{ background: url('./images/no_data.png') no-repeat; background-position:50% 50%; opacity: 0.7;}
	.sign_holiday{ background: #88f0ff; opacity: 0.5;}

	.red_span{ display:inline-block;background: red; height: 20px; width: 20px; color: #fff; text-align: center; line-height: 20px; border-radius: 10px;}

</style>
</head>

<body>

<?php include('../top.php'); ?>

<div class="date_select">
	<div id="select_date"></div>
    <select id="user_id">
    	<option value="">全员</option>
    	<option value="group_<?= MEMBER_GROUP ?>"><?= MEMBER_GROUP ?></option>
    	<option value="group_<?= STUDENT_GROUP ?>"><?= STUDENT_GROUP ?></option>
    	<?php
			$users = array_merge(get_group_users(MEMBER_GROUP),get_group_users(STUDENT_GROUP));
			foreach($users as $v){
		?>
    	<option value="user_<?= $v['id'] ?>" <?php if($v['id']==$_SESSION['id']){ echo "selected='selected'";} ?> ><?= $v['username'] ?></option>
        <?php } ?>
    </select>
    <?php if($_SESSION['role'] == 2 || $_SESSION['role'] == 1){ ?>
    	&nbsp; &nbsp; <a href="add.php" class="add">添加计划</a>
    <?php } ?>
    <label for="show_sign">显示考勤信息</label>
    <input type="checkbox" name="show_sign" id="show_sign" checked="checked">
    <div style="float:right;">
    	<?php
    		if(get_role($_SESSION['id']) >= 3){
    			echo '<a href="manage_sign_other_rule.php" class="tool_btn">管理考勤变更</a>';
    		}
    		if(get_role($_SESSION['id']) >= 2){
    			$db = new db;
    			$sql = 'select count(*) as ct from sign_work_off';
    			$ct = $db->fetch($db->query($sql));
    			if($ct[0]['ct'] > 0){
    				$ct = ' &nbsp <span class="red_span">'.$ct[0]['ct'].'</span>';
    			}else{
    				$ct = '';
    			}
    			echo '<a href="manage_work_off.php" class="tool_btn">请假审批'.$ct.'</a>';

    		}
    		if(get_role($_SESSION['id']) >= 1){
    			echo '<a href="new_work_off.php" class="tool_btn">请假</a>';
    		}
    	?>
    </div>
    <div class="clear"></div>
</div>

<div id="main">
	<div id="top"></div>
    <div class="clear"></div>
    <div id="data_div"></div>
</div>
<div class="page">
	<span style="color:#ff8400">黄色</span>：指教师指派的任务，<span style="color:green">深绿色</span>：指学生自定义的任务，<span style="color:#666">灰色</span>：指过期未指定状态的任务，<span style="color:#000">黑色</span>：指已完成任务，<span style="color:red">红色</span>：指未完成任务。<br />
</div>
<div id="edit-dialog-form" title="修改任务">
	<form id="edit_form"></form>
</div>
<div id="add-dialog-form" title="创建新任务">
    <form>

        <label>
            <span>事项内容</span>：
            <input name="content" type="text" id="add_content">
        </label>
       
        <?php if($_SESSION['role']==2){ ?>
        <label>
            <span>指派给</span>：
            <select name="add_user_id" id="add_user_id">
                <?php
                    $db = new db;
                    $users = $db->select('users',array('role'=>1));
					echo "<option value='".$_SESSION['id']."'>".$_SESSION['user']."</option>";
                    foreach($users as $v){
                        echo "<option value='".$v['id']."'>".$v['username']."</option>";
                    }
                ?>
            </select>
        </label>
        <?php } ?>

        <label>
            <span>起始日期</span>：
            <input type="text" readonly="readonly" name="start_date" id="add_start">
        <label>
        
        <label>
            <span>结束日期</span>：
            <input type="text" readonly="readonly" name="end_date" id="add_end">
        </label>

    </form>
</div>
</body>
</html>