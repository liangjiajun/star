<?php
	include_once('../view/header.php');
	echo '	<link rel="stylesheet" href="../style/results.css">';
	echo '<script src="../javascripts/jquery.js"></script>';
 ?>
 
 <article class="user_echart">
 	<div id="user_all" style="height: 600px;"></div>
 </article>
 <script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
 <script type="text/javascript">
        var myChart = echarts.init(document.getElementById('user_all')); 
        var option = {
     // 气泡提示框   	
    tooltip : {
        trigger: 'axis'
    },
    // 图例，表述数据和图形的关联
    legend: {
        data:['PS','HTML','CSS','PHP','HTML5','CSS3']
    },
    // 辅助工具箱，辅助功能，如添加标线，框选缩放等
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    // 开启拖拽
    calculable : true,
    // X轴
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
        }
    ],
    // y轴
    yAxis : [
        {
            type : 'value'
        }
    ],
    // 直角系   驱动图表生成的数据内容数组，数组中每一项为一个系列的选项及数据
};
        $.ajax({
            url:'../php/data_user.php',
            success:function(data){
                var arr = data.split(",");
                arr.pop()
                option.xAxis[0].data =arr;
                console.log(1);

                        $.ajax({
                            url:'../php/data_Series.php',
                            success:function(data){
                                data = JSON.parse(data);
                                option.series = data;
                                myChart.setOption(option);
                                console.log(option);
                            }
                        });


                
            }
        });
	
	

       // myChart.setOption(option);
</script>