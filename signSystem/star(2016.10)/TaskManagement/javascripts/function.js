$('#add-task').click(2000,function(){$('#black').show();$('#post').toggle("fold",1000)});$('#hide').click(function(){$('#black').hide();$('#post').hide()});$('.sub-hover').mouseover(function(){$('.sub-right-nav').show()});$('.sub-hover').mouseout(function(){$('.sub-right-nav').hide()});$(document).keydown(function(e){if(e.which==78){$('#black').show();$('#post').toggle("fold",1000)}if(e.which==27){$('#black').hide();$('#post').hide()}});$('.task-conter li div').css('cursor','move');$B=$('.task-conter li:eq(0)');$I=$('.task-conter li:eq(1)');$D=$('.task-conter li:eq(2)');$B.sortable({connectWith:$I,});$I.sortable({connectWith:$D,update:function(eve,ui){doajax(ui,'B')}});$D.sortable({update:function(eve,ui){doajax(ui,'D')}});function time(){var d=new Date();var vYear=d.getFullYear();var vMon=d.getMonth()+1;var vDay=d.getDate();var h=d.getHours();var m=d.getMinutes();var se=d.getSeconds();return s=vYear+"-"+(vMon<10?"0"+vMon:vMon)+"-"+(vDay<10?"0"+vDay:vDay)+" "+ +(h<10?"0"+h:h)+":"+(m<10?"0"+m:m)+":"+(se<10?"0"+se:se)}function doajax(ui,t){$.ajax({url:'php/update.php',method:'post',data:"StartTime="+time()+"&StatusId="+t+"&TaskId="+ui.item.attr('id')+"",})}$(".sub-right-nav li").click(function(){var style=$(this).attr("id");$("link[title='"+style+"']").removeAttr("disabled");$("link[title!='"+style+"']").attr("disabled","disabled");$.cookie("mystyle",style,{expires:30});$(this).addClass("cur").siblings().removeClass("cur")});var cookie_style=$.cookie("mystyle");if(cookie_style==null){$("link[title='link1']").removeAttr("disabled");$("#styles li#link1").addClass("cur")}else{$("link[title='"+cookie_style+"']").removeAttr("disabled");$("#styles li[id='"+cookie_style+"']").addClass("cur");$("link[title!='"+cookie_style+"']").attr("disabled","disabled")}