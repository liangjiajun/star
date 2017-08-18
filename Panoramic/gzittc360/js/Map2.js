    
var spanstate = 1;
var o_top = 0;
var o_left = 0;
var vr_name = '';
$(function($) {
    var map = document.getElementById('map');
    var imger = document.getElementById('imger');

    $('#side_left').hide();
    $('#side_right').hide();
    $('#vr_box').hide();
  /*  $('#qr').slideUp();*/
    $('#developer_box').hide();
    // { axis: "y" }
        /*1919 1047*/
    var imger_size = 2;
    var newspan_state = 'area';
    function scrollfun(){
        $('body').bind('mousewheel', function(event, delta) {
            ;
            removeClass_fun();
            var dir = delta > 0 ? 'Up' : 'Down';
            if(dir=='Down'){
                imger_size--;
                if(imger_size==2){
                    $('#map').css('left',$('#map').width()-$(window).width()+'px')
                                .css('top',$('#map').height()-$(window).height()-70+'px');
                }
                if(imger_size<=1){
                    imger_size=1;
                    $('#map').css('left','0px').css('top','0px');

                }
                $('#map').css('transform','scale('+imger_size+')')
                $('#range').val(4-imger_size);

            }
            
            if(dir=='Up'){
                imger_size++;
                if(imger_size==2){
                    $('#map').css('left',$('#map').width()-$(window).width()+'px')
                                .css('top',$('#map').height()-$(window).height()-70+'px');
                }
                if(imger_size>=3){
                    imger_size=3;
                }
                drag_fun();
                $('#range').val(4-imger_size);
                $('#map').css('transform','scale('+imger_size+')');
            }
            return false;
        });
    }
    scrollfun();
    $('#range').on('input',function(){
        $('#map').css('transform','scale('+(4-$(this).val())+')');
        imger_size = 4-$(this).val();
        if(imger_size==2){
            $('#map').css('left',$('#map').width()-$(window).width()+'px')
                       .css('top',$('#map').height()-$(window).height()-70+'px');
                }
        if(imger_size==1){
            $('#map').css('left','0px').css('top','0px');
        }

    });

        function drag_fun(){
            
            $('#map').draggable({
                start:function(){
                    
                    $('.newspan').css('display','none');
                    /*console.log('start');*/

                },
                drag:function(event,ui){
               
                if(imger_size==2){
                        //////////限制left不能出现空白
                        if(ui.offset.left>=0){
                            newstyle();
                            $('#map').addClass(" limit_left2");
                        }
                        if(ui.offset.left<=0){
                            newstyle();
                            $('#map').removeClass('limit_left2');
                        }
                        //////////限制right不能出现空白
                        if(ui.offset.left<=-($('#map').width()-$(window).width()+$('#map').width())){
                            newstyle();
                            $('#map').addClass(" limit_right2");
                        }
                        if(ui.offset.left>=-($('#map').width()-$(window).width()+$('#map').width())){
                            newstyle();
                            $('#map').removeClass('limit_right2');
                        }
                        /////////限制top不能出现空白
                        if(ui.offset.top>=0){
                            newstyle();
                            $('#map').addClass(" limit_top2");
                        }
                        if(ui.offset.top<=0){
                            newstyle();
                            $('#map').removeClass('limit_top2');
                        }
                        ////////限制bottom不能出现空白
                        if(ui.offset.top<=-($('#map').height()-$(window).height()+$('#map').height())){
                            newstyle();
                            $('#map').addClass(" limit_bottom2");
                        }
                        if(ui.offset.top>=-($('#map').height()-$(window).height()+$('#map').height())){
                            newstyle();
                            $('#map').removeClass('limit_bottom2');
                        }
                }else if(imger_size==1){
                        if(ui.offset.left>=0){
                            newstyle();
                            $('#map').addClass(" limit_left1");
                        }
                        if(ui.offset.left<=0){
                            newstyle();
                            $('#map').removeClass('limit_left1');
                        }
                        if(ui.offset.left<=-($('#map').width()-$(window).width())){
                            newstyle();
                            $('#map').addClass(" limit_right1");
                        }
                        if(ui.offset.left>=-($('#map').width()-$(window).width())){
                            newstyle();
                            $('#map').removeClass('limit_right1');
                        }
                        if(ui.offset.top>=0){
                            newstyle();
                            $('#map').addClass(" limit_top1");
                        }
                        if(ui.offset.top<=0){
                            newstyle();
                            $('#map').removeClass('limit_top1');
                        }
                        ////////限制bottom不能出现空白
                        if(ui.offset.top<=-($('#map').height()-$(window).height())){
                            newstyle();
                            $('#map').addClass(" limit_bottom1");
                        }
                        if(ui.offset.top>=-($('#map').height()-$(window).height())){
                            newstyle();
                            $('#map').removeClass('limit_bottom1');
                        }
                }else if(imger_size==3){
                    if(ui.offset.left>=0){
                            newstyle();
                            $('#map').addClass(" limit_left3");

                        }
                        if(ui.offset.left<=0){
                            newstyle();
                            $('#map').removeClass('limit_left3');

                        }
                        //////////限制right不能出现空白
                        if(ui.offset.left<=-($('#map').width()*2)){
                            newstyle();
                            console.log(1);
                            $('#map').addClass(" limit_right3");
                        }
                        if(ui.offset.left>=-($('#map').width()*2)){
                            newstyle();
                            $('#map').removeClass('limit_right3');
                        }
                        /////////限制top不能出现空白
                        if(ui.offset.top>=0){
                            newstyle();
                            $('#map').addClass(" limit_top3");
                        }
                        if(ui.offset.top<=0){
                            newstyle();
                            $('#map').removeClass('limit_top3');
                        }
                        ////////限制bottom不能出现空白
                        if(ui.offset.top<=-($('#map').height()*2)){
                            newstyle();
                            $('#map').addClass(" limit_bottom3");
                        }
                        if(ui.offset.top>=-($('#map').height()*2)){
                            newstyle();
                            $('#map').removeClass('limit_bottom3');
                        }
                }
                        
 
            },
            stop:function(){},
                   
            })
}

       drag_fun(); 
       /*function cursor_fun(){
        $('#body').mousedown(function(){
             $('#body').css('cursor',"url('./img/cursor/closedhand.png'),move");
         }).mouseup(function(){
            $('#body').css('cursor',"url('./img/cursor/openhand.png'),auto");
         });
       }
       cursor_fun()*/
            function removeClass_fun(){
                
                for(var i=1;i<=3;i++){
                    $('#map').removeClass("limit_left"+i)
                    .removeClass("limit_right"+i)
                    .removeClass("limit_top"+i)
                    .removeClass("limit_bottom"+i);
                }
            }
            function newstyle(){
                var stylenode = "<style>.limit_left2{left: "+ ($('#map').width()/2) +"px !important;}.limit_right2{left: "+ -($('#map').width()-$(window).width()+$('#map').width()/2) +"px !important;}.limit_top2{top: "+ ($('#map').height()/2) +"px !important;}.limit_bottom2{top: "+ -($('#map').height()-$(window).height()+$('#map').height()/2) +"px !important;}.limit_left1{left: 0px !important;}.limit_right1{left:"+ -($('#map').width()-$(window).width()) +"px !important;}.limit_top1{top: 0px !important;}.limit_bottom1{top: "+-($('#map').height()-$(window).height())+"px !important;}.limit_left3{left: "+ $('#map').width() +"px !important;}.limit_right3{left: "+ -$('#map').width()+"px !important;}.limit_top3{top: "+ $('#map').height() +"px !important;}.limit_bottom3{top: "+ -($('#map').height())+"px !important;}</style>";
                            $('style').remove();
                            $('#body').append(stylenode);
                }
    $('area').mousedown(function(event){
        var clickX = event.pageX;
        var clickY = event.pageY;
        newspan_state = 'area';
        removeClass_fun();
             /*$('.newspan').css('left',clickX+10+'px').css('top',clickY+10+'px').hide(0).show(200).html("<span id='bead'></span><span class='close'>x</span><h2>"+$(this).parent().prev().attr('title')+"</h2><img src='./img/spanimg/"+$(this).parent().attr('name')+".jpg'><span id='visit_site'></span>");
                close_bind();
                
                visit_site($(this));
                if($('.newspan').offset().top >= $(window).height()-350){
                   $('.newspan').css('top',$('.newspan').offset().top-$('.newspan').offset().top/3+'px');
                   $('#bead').hide();
                }*/
                o_top = parseFloat($('#map').css('top')) ? parseFloat($('#map').css('top')) : 0;
                o_left = parseFloat($('#map').css('left')) ? parseFloat($('#map').css('left')) : 0;

                if(imger_size==2){
                    trace2($(this).parent().prev(),$("#" + $(this).parent().attr('name') + ""),$(this).parent(),'100', $("#" + $(this).parent().attr('name') + "").height()/4, $("#" + $(this).parent().attr('name') + "").width()/3);
                }
                if(imger_size==1){
                    trace2($(this).parent().prev(),$("#" + $(this).parent().attr('name') + ""),$(this).parent(),'50');
                }
                if(imger_size==3){
                    console.log('true');
                    trace2($(this).parent().prev(),$("#" + $(this).parent().attr('name') + ""),$(this).parent(),'150',$("#" + $(this).parent().attr('name') + "").height()/2, $("#" + $(this).parent().attr('name') + "").width()/2);
                }

       return false;
        
    });
    function trace2(area_title,this_hash,this_node,this_num,this_h,this_w){
            $('#map').animate({
                top:parseInt(o_top + $(window).height()/2-this_hash.offset().top-this_h),
                left:parseInt(o_left + $(window).width()/2-this_hash.offset().left-this_w),
            },300);
            this_num = Number(this_num);
            setTimeout(function(){
                $('.newspan').css('left',this_hash.offset().left+this_num+'px').css('top',this_hash.offset().top+this_num+'px').hide(0).show(200).html("<h2>"+area_title.attr('title')+"</h2><span id='bead'></span><span class='close'>x</span><img src='./img/spanimg/"+this_node.attr('name')+".jpg'><span id='visit_site'></span>");
                visit_site(this_node);
                close_bind();
            },310)
        }
    function newspan_map_position(num){
        num = Number(num);
            /*$('#map').animate({
                top:$('#map').offset().top+num,
                left:0,
            },300);*/
            $('.newspan').animate({
                top:$('.newspan').offset().top-num,

            },300);
    }

        function visit_site(me){
            if(newspan_state=='area'){
                console.log(me);
                switch(me.attr('name')){
                    case 'menkou':
                        visit(me,'menkou','校门口');
                        break;
                    case 'fantang':
                        visit(me,'fantang','校园饭堂');
                        break;
                    case 'zhixuelou':
                        visit(me,'kaerlade','卡尔拉得');
                        visit(me,'chenggui','城轨实践室');
                        visit(me,'wangguan','网管基地');
                        break;
                    case 'dexinlou':
                        visit(me,'cad','CAD项目基地');
                        visit(me,'demaji','德玛吉');
                        break;
                    case 'zhiminglou':
                        visit(me,'webstudio','陈立准工作室');
                        visit(me,'buxian','网络布线基地');
                        visit(me,'jifang','苹果机房');
                        visit(me,'shangwuruanjian','商务软件');
                        visit(me,'yitihua','一体化课程');
                        break;
                    case 'zhixinglou':
                        visit(me,'zhilengjidi','制冷项目基地');
                        break;
                    case 'deyalou':
                        visit(me,'chengguozhanshiting','成果展示厅');
                        visit(me,'chengguo2','成果展示厅(世赛)');
                        visit(me,'chengguo3','成果展示厅(校企)');
                        visit(me,'chengguo4','成果展示厅(工学)');
                        break;
                    case 'zhiyilou':
                        visit(me,'sheyingpeng','摄影棚');
                        break;
                }
            }
            if(newspan_state=='side'){
                switch(me.attr('name')){
                    case 'menkou':
                        visit(me,me.attr('name'),me.text());
                        break;
                    case 'fantang':
                        visit(me,me.attr('name'),me.text());
                        break;
                    case 'zhixuelou':
                        visit(me,'kaerlade','卡尔拉得');
                        visit(me,'chenggui','城轨实践室');
                        visit(me,'wangguan','网络系统管理基地');
                        break;
                    case 'dexinlou':
                        visit(me,'cad','CAD项目基地');
                        visit(me,'demaji','德玛吉');
                        break;
                    case 'zhiminglou':
                        visit(me,'webstudio','陈立准工作室');
                        visit(me,'buxian','网络布线基地');
                        visit(me,'yitihua','一体化课程');
                        visit(me,'jifang','苹果机房');
                        visit(me,'shangwuruanjian','商务软件');
                        break;
                    case 'zhixinglou':
                        visit(me,'zhilengjidi','制冷项目基地');
                        break;
                    case 'deyalou':
                        visit(me,'chengguozhanshiting','成果展示厅');
                        visit(me,'chengguo2','成果展示厅(世赛)');
                        visit(me,'chengguo3','成果展示厅(校企)');
                        visit(me,'chengguo4','成果展示厅(工学)');
                        break;
                    case 'zhiyilou':
                        visit(me,'sheyingpeng','摄影棚');
                        break;
                }
            }
            
            function visit(this_site,site_name,site_chname){
            /*$('#visit_site').html('');*/
                $('#visit_site').append("<ul><li title="+site_name+"><span class='left'>"+site_chname+"</span><span class='right'><a href=''>进入全景</a></span></li></ul>");
                /**/
               
            }
            function visitClick(){
                $('#visit_site a').on('click',function(){
                    vr_box_show($(this).parent().parent().attr('title'));
                    return false;
                });
            }
            visitClick();
    }
        


    $('#map').mousedown(function(){
        $('.newspan').hide(100);
    })


    $('#btn_box ul li').mousedown(function(){
        switch($(this).index()){
            case 0:
            $('#side_left').toggle(200);
            newspan_state = 'side';
            break;
            case 1:
            $('#side_right').toggle(200);
            break;

        }
    })
    $('.side_close').on('mousedown',function(){
        $(this).parent().hide(200);
    })


    function close_bind(){
        $('.close').mousedown(function(){
            $('.newspan').hide(100);

        })
    }
    
    $(".scroll").mousedown(function(event){     
        event.preventDefault();
        removeClass_fun();
        /*var winH = parseInt($(window).height()/2);
        var hasTop = $(this.hash).offset().top;*/
        //因为锚链接已经触发了移动,所以。。。
        /*console.error($("#" + $(this).attr('name') + ""));*/
        //console.log('$(this.hash).offset().left   '+$(window).width()/2);*/
        o_top = parseFloat($('#map').css('top')) ? parseFloat($('#map').css('top')) : 0;
        o_left = parseFloat($('#map').css('left')) ? parseFloat($('#map').css('left')) : 0;

            if(imger_size==2){
                trace($("#" + $(this).attr('name') + ""),$(this),'100', $("#" + $(this).attr('name') + "").height()/3, $("#" + $(this).attr('name') + "").width()/3);
            }
            if(imger_size==1){
                trace($("#" + $(this).attr('name') + ""),$(this),'50');
            }
            if(imger_size==3){
                console.log('true');
                trace($("#" + $(this).attr('name') + ""),$(this),'150',$("#" + $(this).attr('name') + "").height()/3, $("#" + $(this).attr('name') + "").width()/3);
            }
    });
    function trace(this_hash,this_node,this_num,this_h,this_w,area_title){
            $('#map').animate({
                top:parseInt(o_top + $(window).height()/2-this_hash.offset().top-this_h),
                left:parseInt(o_left + $(window).width()/2-this_hash.offset().left-this_w),
            },300);
            this_num = Number(this_num);
            setTimeout(function(){
                $('.newspan').css('left',this_hash.offset().left+this_num+'px').css('top',this_hash.offset().top+this_num+'px').hide(0).show(200).html("<h2>"+this_node.text()+"</h2><span id='bead'></span><span class='close'>x</span><img src='./img/spanimg/"+this_node.attr('name')+".jpg'><span id='visit_site'></span>");
                visit_site(this_node);
                close_bind();
            },310)
        }
        
    $('#side_close ul li a').click(function(){
        return false;
    })
    $('#side_right ul li').on('mousedown',function(){
        vr_box_show($(this).attr('title'));
    })
    function vr_box_show(url){
        vr_name = url;
        $('#vr_box').show(200).append("<iframe src='./panorama/"+url+"/index.html'></iframe>").animate({'height':$(window).height()-100+'px'},300);
        $('#logo').css('height','40px')
            .css('width','10%')
            .css('border-radius','0px');
            $('#btn_box').css('bottom','-40px');
    }
    $('#vr_close').on('mousedown',function(){
        $('#vr_box').hide(100);
        $('#logo').removeAttr('style');
        $('#btn_box').removeAttr('style');
        $('#vr_box iframe').remove();
    });
    $('#vr_more').on('mousedown',function(){
        $('#mask_box').show(300).on('mousedown',function(){
            $(this).hide(200);
            $('#more').html('');
        });
        more_name(vr_name);
    });

    function more_name(morename){
        switch(morename){
            case 'menkou':more_text("<h2>广州市工贸技师学院</h2><p>广州市工贸技师学院创办于1958年，隶属于广州市人力资源和社会保障局，开办34个主体专业，拥有全日制学生10,074人，高级工以上层次占比88%；年均培训鉴定20,000人次。</p><p>近年来，学院不断改革创新，构建了“校企双制、工学一体”办学模式和高技能人才培养模式，被马凯副总理称为“中国特色技能人才培养模式”。通过与美国江森集团、瑞典卡尔拉得公司等400多家知名企业深入开展人才培养合作，逐步发展成为首批国家级高技能人才培训基地、首批国家中职示范校、华南地区首家“全国技工院校师资研修中心”和广东省首批全国一流技师学院创建院校。</p><p>2010年以来，学院培养出11名国手，在3届世界技能大赛上斩获2银2铜7个优胜奖，成为世赛我国参赛最早、参赛最多、获奖最多的技工院校。学院还与孟加拉国教育部达成孟加拉技能与培训提升项目合作，实现技工院校向国外职业教育师资培训服务的首次输出。因办学成绩突出，学院被人社部授予“国家技能人才培育突出贡献奖”。 </p>");break;
            case 'fantang':more_text("<h2>广州市工贸技师学院</h2><p>广州市工贸技师学院创办于1958年，隶属于广州市人力资源和社会保障局，开办34个主体专业，拥有全日制学生10,074人，高级工以上层次占比88%；年均培训鉴定20,000人次。</p><p>近年来，学院不断改革创新，构建了“校企双制、工学一体”办学模式和高技能人才培养模式，被马凯副总理称为“中国特色技能人才培养模式”。通过与美国江森集团、瑞典卡尔拉得公司等400多家知名企业深入开展人才培养合作，逐步发展成为首批国家级高技能人才培训基地、首批国家中职示范校、华南地区首家“全国技工院校师资研修中心”和广东省首批全国一流技师学院创建院校。</p><p>2010年以来，学院培养出11名国手，在3届世界技能大赛上斩获2银2铜7个优胜奖，成为世赛我国参赛最早、参赛最多、获奖最多的技工院校。学院还与孟加拉国教育部达成孟加拉技能与培训提升项目合作，实现技工院校向国外职业教育师资培训服务的首次输出。因办学成绩突出，学院被人社部授予“国家技能人才培育突出贡献奖”。 </p>");break;
            case 'wenhuaguangchang':more_text("<h2>广州市工贸技师学院</h2><p>广州市工贸技师学院创办于1958年，隶属于广州市人力资源和社会保障局，开办34个主体专业，拥有全日制学生10,074人，高级工以上层次占比88%；年均培训鉴定20,000人次。</p><p>近年来，学院不断改革创新，构建了“校企双制、工学一体”办学模式和高技能人才培养模式，被马凯副总理称为“中国特色技能人才培养模式”。通过与美国江森集团、瑞典卡尔拉得公司等400多家知名企业深入开展人才培养合作，逐步发展成为首批国家级高技能人才培训基地、首批国家中职示范校、华南地区首家“全国技工院校师资研修中心”和广东省首批全国一流技师学院创建院校。</p><p>2010年以来，学院培养出11名国手，在3届世界技能大赛上斩获2银2铜7个优胜奖，成为世赛我国参赛最早、参赛最多、获奖最多的技工院校。学院还与孟加拉国教育部达成孟加拉技能与培训提升项目合作，实现技工院校向国外职业教育师资培训服务的首次输出。因办学成绩突出，学院被人社部授予“国家技能人才培育突出贡献奖”。 </p>");break;
            case 'lanqiuchang':more_text("<h2>广州市工贸技师学院</h2><p>广州市工贸技师学院创办于1958年，隶属于广州市人力资源和社会保障局，开办34个主体专业，拥有全日制学生10,074人，高级工以上层次占比88%；年均培训鉴定20,000人次。</p><p>近年来，学院不断改革创新，构建了“校企双制、工学一体”办学模式和高技能人才培养模式，被马凯副总理称为“中国特色技能人才培养模式”。通过与美国江森集团、瑞典卡尔拉得公司等400多家知名企业深入开展人才培养合作，逐步发展成为首批国家级高技能人才培训基地、首批国家中职示范校、华南地区首家“全国技工院校师资研修中心”和广东省首批全国一流技师学院创建院校。</p><p>2010年以来，学院培养出11名国手，在3届世界技能大赛上斩获2银2铜7个优胜奖，成为世赛我国参赛最早、参赛最多、获奖最多的技工院校。学院还与孟加拉国教育部达成孟加拉技能与培训提升项目合作，实现技工院校向国外职业教育师资培训服务的首次输出。因办学成绩突出，学院被人社部授予“国家技能人才培育突出贡献奖”。 </p>");break;
            case 'cad':more_text("<h2>CAD机械设计项目中国集训基地。</h2><p>本场地为世界技能大赛CAD机械设计项目中国集训基地，同时也是先进制造产业系教学实训、培训和竞赛场地，主要服务于工业设计类专业群的一体化课程教学及学生实训，并可用于承接社会培训及校企合作产品研发项目。本场地占地面积约500平方米，投入超过1500万元人民币，配备了先进的教学实训设施设备，具体包括德国进口真空铸型机、以色列和美国的3D打印机、美国的手持式扫描仪、高性能的图形工作站等，能够同时满足40人的学习实训需要。场地还设有设备管理员进行日常管理，确保设备安全和工具、材料完整齐全。<p></p>荣获世界技能大赛CAD机械设计项目银牌和两个优胜奖；连续两届荣获“高教杯”全国大学生先进成图技术与产品信息建模创新大赛团体一等奖。</p>");break;
            case 'demaji':more_text("<h2>德马吉</h2><p>本场地为先进制造产业系教学实训场地，主要服务于数控编程专业的一体化课程教学及学生实训，并可用于承接社会培训及校企合作产品研发项目。本场地占地面积550平方米，投入超过3000万元人民币，配备了先进的教学实训设施设备，具体包括德马吉CTX310 ECO V3车削中心4台；德马吉DMU 50五轴加工中心6台；德马吉DMU 60五轴加工中心1台；德马吉CTX gamma 1250TC车铣复合加工中心1台。能够同时满足40人的学习实训需要。场地还设有设备管理员进行日常管理，确保设备安全和工具、材料完整齐全。</p><p>荣获第六届全国数控技能大赛数控车工项目第七名、数控铣工项目第八名；第七届全国数控技能大赛加工中心操作工（五轴）项目第五名。</p>");break;
            case 'kaerlade':more_text("<h2>卡尔拉得</h2><p>华南地区唯一一家卡尔拉得汽车钣金技术培训中心。</p><p>卡尔拉得公司与学院共建的卡尔拉得培训学院（广州）培训中心是中国设备最高端、条件最好的汽车钣金技术培训中心，工贸汽车钣金专业学生将会是中国汽车钣金技术的未来。</p><p>广州培训中心不仅将服务于汽车制造主机厂的钣金技工培训，还将面向工贸汽车钣金专业学生，为他们提供包括车身维修技术、操作流程、管理和提升效率方面的培训，使他们成为高素质技能人才。</p>");break;
            case 'zhilengjidi':more_text("<h2>制冷与空调项目中国集训基地。</h2><p>本场地为世界技能大赛制冷与空调项目中国集训基地，同时也是先进制造产业系教学实训、培训和竞赛场地，主要服务于制冷运用与维修专业的一体化课程教学及学生实训，并可用于承接社会培训及校企合作产品研发项目。本场地占地面积约600平方米，投入超过1200万元人民币，配备了先进的教学实训设施设备，具体包括商用、家用冰箱、空调，小型冷库、中央空调、智能控制系统等，能够同时满足40人的学习实训需要。场地还设有设备管理员进行日常管理，确保设备安全和工具、材料完整齐全。</p><p>荣获第42世界技能大赛制冷与空调项目铜牌、第43世界技能大赛制冷与空调项目银牌。</p>");break;
            case 'chenggui':more_text("<h2>城轨实训室</h2><p>这里有城市轨道交通教学的完整设备，包括列车模拟驾驶系统、票务管理系统、站车班组管理系统、城际轨道交通列车控制系统和轨道交通车站乘客信息系统等，既建有硬件设备，也配有软件设施等等。它也是同类院校中顶尖的实训场地，真正做到工学一体，为企业打造高技能人才。</p>");break;
            case 'chengguozhanshiting':more_text("<h2>办学成果展示厅</h2><p>“校企双制 工学一体”办学成果展示厅：本展厅以文字、图片、实物、视频等多种形式，生动翔实地介绍了我院创建“校企双制  工学一体”办学模式的成功经验和取得的丰硕成果。展室由五个主体区和六个辅助区组成。五个主体区分别是 “‘校企双制'办学模式创建与实践”、“‘工学一体'一体化课程教学改革”、“通用职业素质课程开发与实践”、“世界技能大赛与世界技能人才培养”和“学院办学历程大事记”；六个辅助区分别是CAD机械设计、制冷与空调、信息网络布线、网站设计、时装技术、汽车技术世界技能大赛参赛项目简介</p>");break;
            case 'sheyingpeng':more_text("<h2>多功能摄影棚</h2><p>摄影棚总投资超过640万，占地面积300多平米，于2012年建成。</p><p>摄影棚内部分为演播室、动作捕捉室、导控室、高清编辑室、3D体验区、摄影区、定格动画区、化妆室等区域，可满足摄影摄像、高清编辑、动作捕捉、定格动画、节目录制等各种需要，它的建成大大推进了动漫和广告专业的教学，同时也为影视专业的开发奠定了坚实的物质基础。</p>");break;
            case 'webstudio':more_text("<h2>陈立准工作室</h2><p>本场地为信息产业系教学实训场地，主要服务于网站开发与维护专业的一体化课程教学及学生实训，并可用于承接社会培训及校企合作产品研发项目。本场地占地面积120平方米，配备了先进的教学实训设施设备，具体包括了8台DELL PRECISION TOWER 7810工作站、16台Z220工作站等，能够同时满足16-24人的学习实训需要。场地还设有设备管理员进行日常管理，确保设备安全和工具、材料完整齐全。</p><p>陈立准工作室也是国家级大师工作室，在这间工作室先后出了大批优秀的信息专业技术人才，包括第41、42、43届世界技能大赛优胜奖得主李骞、田科、冯俊杰等等。</p>");break;
            case 'wangguan':more_text("<h2>网络系统管理学习工作站</h2><p>由严宗浚大师工作室和网络系统管理学习工作站组成，含操实训区、教学区、设备存储区、阅读区及休息区。主要设备有：Cisco路由交换设备40余台；Cisco安全及语音设备30余套；Dell R920高性能服务器3台；不久将来将引入Cisco公司的顶级云服务器一套。</p>");break;
            case 'buxian':more_text("<h2>信息网络布线实训基地</h2><p>信息网络布线实训场地占地总面积超过400平方米，分为理论教学区，技能实训区、光纤熔接区、铜缆端接区、工具材料区等。学院先后引进该项目标准训练工位8套、两层钢结构模拟智能楼宇1套，参照2013世界技能大赛信息网络布线项目比赛标准建设工位1套。配备FLUKE DSX 5000 3台，FLUKE OTDR 3台，藤仓80S光纤熔接机10台，住友TYPE-81C光纤熔接机2台，同时实训场地配备多媒体网络教学系统，配备多套先进的实训工具，批量训练耗材，不仅能满足日常训练需求，也可满足比赛需要。该项目设备齐全、先进，能满足世赛全国选拔赛和集训工作。</p>");break;
            case 'jifang':more_text("<h2>无纸动画学习工作站</h2><p>无纸动画学习工作站是广州市高技能人才公共实训基地建设项目之一，主要由苹果电脑、二维无纸动画软件、手绘板等设备项构成，可供30个学生进行学习和创作，本学习工作站能完成故事版创作、无纸动画输入、无纸动画上色、无纸动画输出、数字动画创作等学习任务。通过在本工作站的学习，学生能熟练掌握二维动画技法、熟悉动画前期的分镜头脚本、设计稿、原画等，中期的动画、上色等，以及后期的合成、镜头运动、特效、输出等制作流程。</p>");break;
            case 'shangwuruanjian':more_text("<h2>商务软件解决方案实训基地</h2><p>商务软件解决方案项目中国集训基地场地200平方米，建有40个高标准的培训工位，每个工位的都配备有高性能台式工作站。软件环境配置与世赛开发环境保持一致，符合世界能大赛要求。</p>");break;
            case 'yitihua':more_text("<h2>一体化课程</h2><p>一体化课程是按照经济社会发展需要和技能人才培养规律，根据国家职业标准及国家技能人才培养标准，以职业能力为培养目标，通过典型工作任务分析，构建课程体系，并以具体工作任务为学习载体，按照工作过程和学习者自主学习要求设计和安排教学活动，体现了理论教学和实践教学融通合一，专业学习和工作实践学做合一，能力培养和工作岗位对接合一。学生通过对工作任务、过程和环境所进行的整体化实践、感悟与反思，实现了专业能力、方法能力、社会能力和个人能力的整体提升。</p>");break;
        }
        
        }
    function more_text(text){
        $('#more').html('');
        $('#more').append(text);
    }


    $('#copy').on('mousedown',function(){
        $('#developer_box').toggle(200);
    });
    $('#mobile_box').on('mousedown',function(){
        $('#qr').slideToggle(100);
    })
});
/*
    $('#planetmap area').on('mouseover',function(){

        showBorder(this);
    }).on('mouseout',function(){
      hideBorder();
    })

 
function getOffset(obj){
    var x = obj.offsetLeft, y = obj.offsetTop;
    while(obj.offsetParent){
        obj = obj.offsetParent;
        x += obj.offsetLeft;
        y += obj.offsetTop;
    }
    return {x : x, y : y};
};
function showBorder(obj){
    var img = document.getElementById("imger");
    var div = document.getElementById("border");
    var offset = getOffset(img);
    var coords = obj.coords.split(",");
     
    div.style.display = "block";
    div.style.left = offset.x + parseInt(coords[0]) + "px";
    div.style.top = offset.y + parseInt(coords[1]) + "px";
    div.style.width = parseInt(coords[2]) - parseInt(coords[0]) + "px";
    div.style.height = parseInt(coords[3]) - parseInt(coords[1]) + "px";
}
function hideBorder(){
    document.getElementById("border").style.display = "none";
}*/
