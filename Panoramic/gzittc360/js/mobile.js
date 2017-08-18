$(function(){
	$('#panorama').hide();
	$('.logo2').css('top','20%');
	setTimeout(function(){
		$('#welcome').fadeOut(500)
	},3000);
var target_btn = '';
	$('#content ul li').mousedown(function(){
/*		$('#window_li').css('width','96%').css('height','70%').css('padding','30% 2%');*/
		$('#window_li').animate({width:'96%',padding:'15% 1%'},"slow");
	    $('#window_li').animate({height:'70%',padding:'30% 2%'},"slow");
	    $('#window_li img').attr('src','img/mobile_li_img/' + $(this).attr('title') + '.jpg');
	    target_btn = $(this).attr('title');
	    switch(target_btn){
	    	case 'cad':$('#window_li p').html("CAD 基地<br>先进制造产业系<br>工业设计(数字设计与制造)");break;
	    	case 'demaji':$('#window_li p').html("德玛吉<br>先进制造产业系<br>数控编程<br>模具设计");break;
	    	case 'zhilengjidi':$('#window_li p').html("空调制冷基地<br>先进制造产业系<br>制冷设备运用与维修");break;
	    	case 'kaerlade':$('#window_li p').html("卡尔拉得<br>新能源应用产业系<br>汽车维修<br>新能源汽车检测与维修<br>汽车钣金与涂装");break;
	    	case 'chenggui':$('#window_li p').html("城轨实践室<br>先进制造产业系<br>机电一体化<br>城市轨道交通电气自动化方向");break;
	    	case 'sheyingpeng':$('#window_li p').html("摄影棚<br>文化创意产业系<br>多媒体制作（影视技术方向）<br>计算机游戏制作<br>计算机动画制作（动漫设计与制作方向）");break;
	    	case 'webstudio':$('#window_li p').html("陈立准工作室<br>信息服务产业系<br>网站开发与维护");break;
	    	case 'buxian':$('#window_li p').html("网络布线基地<br>信息服务产业系<br>计算机网络应用");break;
	    	case 'wangguan':$('#window_li p').html("网管基地<br>信息服务产业系<br>计算机网络应用");break;
	    	case 'fantang':$('#window_li p').html("校园食堂");break;
	    	case 'wenhuaguangchang':$('#window_li p').html("校园文化广场");break;
	    	case 'lanqiuchang':$('#window_li p').html("篮球场");break;
	    	case 'chengguozhanshiting':$('#window_li p').html("成果展示厅");break;
	    	case 'menkou':$('#window_li p').html("校门口");break;
	    	case 'wangguan':$('#window_li p').html("网管基地<br>信息服务产业系<br>计算机网络应用");break;
	    	case 'buxian':$('#window_li p').html("网管基地<br>信息服务产业系<br>计算机网络应用");break;
	    }


		$('#btn_li').mousedown(function(){
			$('#panorama').show(500);
			$('#container').hide();
			$('#panorama iframe').attr('src',"http://192.168.71.57/gzittc360/panorama/"+target_btn+"/index.html");
		})
	})
	$('#vr_close').mousedown(function(){
		$('#panorama').hide(500);
		$('#container').show();
		$('#panorama iframe').attr('src',"");
	})

	 var audio = document.getElementById("bgMusic");
    audio.play();
    $('.round').click(function(){
        if($('.status').hasClass("play")){
            $('.status').removeClass("play").addClass("pause");
            audio.play();
        }else{
            $('.status').removeClass("pause").addClass("play");
            audio.pause();
        }
    })
    $('#window_close').on('mousedown',function(){
    	$('#window_li').animate({height:'0%'},"slow");
	    $('#window_li').animate({width:'0%',padding:'0%'},"slow");
    })
})