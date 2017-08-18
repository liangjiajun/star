<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
		body,html{ width:100%; height:100%; font-family:Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace, "微软雅黑", "黑体"; font-size:14px;}
    	*{margin: 0;padding: 0;}
		.none{ display:none;}
		.block{ display:block;}

		/* oper */
		h3{ padding: 10px; border: 1px solid #265E9B; background:#2b72bf; color: #fff;}
		.oper{ position:fixed; right:0; top:0; bottom:0; width:25%; background:#fff;}
		.padd{ padding: 20px;}
		.rad_5{ border-radius: 5px;}
		.enter .input{ padding: 10px; border: 1px solid #ccc; background: #eee; min-height: 40px;}
		.enter .btn{ background: #f3a802; border: 1px solid #E69626; color: #fff; cursor: pointer; font-weight: bold; height: 40px;}
		.enter > *{ box-sizing: border-box; width: 100%; margin-bottom: 10px;}

		/* svg */
		#skills{background:#eee; display:block; font-size: 12px;}
		#skills *{ transition: all 0.2s;}
		#overall{ fill: #E5F0FB; image-rendering:optimize-speed;}
		rect{ rx: 8; ry: 8; stroke: #2b72bf; stroke-width: 1;}
		.node[active="true"] rect{ stroke-width: 3;}
		text{ dominant-baseline:central; text-anchor:middle; fill: #2b72bf;}
    </style>
</head>
<body>

	<svg id="skills" width="75%" height="100%">
    	<g id="overall">
    	</g>
    </svg>
	<div class="oper">
    	<div class="padd">
    		<h3 class="h3 rad_5">Add Label</h3>
    		<div class="enter padd">
    			<div id="label" class="block rad_5 input" contenteditable="true">Title</div>
    			<button class="add rad_5 block btn">Add</button>
    		</div>
    	</div>
    </div>


<script src="script/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
//convert  from database
data = {0:{
	"1":{
		"4":{"8":1,"9":1,"11":1 },
		"5":1,
		"10":1,
	},
	"2":{"6":1,"7":1,},
	"3":1,
}};

var dataResult = {};
	
	var e_size = 60;// 元素大小
	var space = 20;// 元素间距

	/* 计算宽度 */
	function get_width (node) {
		if (typeof(node) != 'object') {
			return e_size;// 最后一个元素返回大小
		};

		var width = 0;// 初始化宽度
		for (var i in node) {
			width += get_width(node[i])+space;// 叠加子元素的宽度
		};
		width -= space;// 减去多余的空白
		return width;
	}

	function t(d,left,i){
		var new_i = i+1;// 记录层级
		var line = 0;// 初始化画线
		for (var e in d) {
			var l = get_width(d[e])/2-(e_size/2)+left;// 所占宽度的一半，居中对齐
			var new_line = get_width(d[e])/2+left;// 新的画线点坐标
			
			/* x轴画线 */
			if(line > 0){
				$('#overall')[0].innerHTML += '<polyline points="'+(line)+','+(i*100-space)+' '+(new_line)+','+(i*100-space)+'" style="stroke:red;stroke-width:2"/>';
			}

			/* 是否有子节点，有则y轴画线 */
			if(typeof(d[e]) == 'object'){
				$('#overall')[0].innerHTML += '<polyline points="'+(l+(e_size/2))+','+(i*100+60)+' '+(l+(e_size/2))+','+(i*100+80)+'" style="stroke:red;stroke-width:2"/>';
			}

			/* 第一层的不画线 */
			if(i!=0){
				$('#overall')[0].innerHTML += '<polyline points="'+(l+(e_size/2))+','+(i*100-space)+' '+(l+(e_size/2))+','+(i*100)+'" style="stroke:red;stroke-width:2"/>';
			};

			/* 画标签 */
			$('#overall')[0].innerHTML += '<g class="node" n="1" transform="translate('+l+' '+(i*100)+')"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1</tspan></text></g>';
			
			/* 若有子节点继续画 */
			if(typeof(d[e]) == 'object'){
				t(d[e],left,new_i);
			}
			left += get_width(d[e])+space;// 宽度叠加
			line = new_line;// 记录新线段的起点
		};

	}

t(data,0,0);



// function t($d,$left,$i){
// 	$i++; //计算行数
// 	$line = 0;
// 	foreach( $d as $v){
// 		$l = get_width($v)/2-50+$left;
// 		$new_line = get_width($v)/2+$left;
// 		if($line >0){

// 		}
		
// 		echo "<div style='padding:0;position:absolute;height:100px;width:100px;background:red;left:".$l."px; top:".($i*150)."px;'>".$line.'-'.$new_line."</div>";
// 		echo '左侧'.$i.'---'.$left;
// 		echo '宽度'.get_width($v).'<br />';
// 		$line = $new_line;
// 		if(is_array($v)){
// 			t($v,$left,$i);
// 		}
// 		$left += get_width($v)+20;
// 	}
// }

// t($data,0,0);




	//考虑前一个节点
	// function recursives2 (node) {
	// 	if (typeof(node) != 'object') {
	// 		return 80;
	// 	};

	// 	var width = 0;
	// 	var x = "a"; //中间存储
	// 	for (var i in node) {
	// 		width += recursives2(node[i]);
	// 		if(node[x]){
	// 			//console.log(recursives(node[x]));
	// 			if (typeof(node[i]) == 'object') 
	// 					width += (recursives2(node[x]))

	// 		}

	// 		x = i;
	// 		dataResult[i] = width;
	// 	};

	// 	return width;
	// }



//recursives2(data)
//console.log(dataResult) ;


// var dataBase = [
// 	{id:0,title:'a',pid:999},
//     {id:1,title:'a',pid:0},
//     {id:2,title:'a1',pid:0},
//     {id:3,title:'a11',pid:0},
//     {id:4,title:'a12',pid:1},
//     {id:5,title:'a2',pid:1},
//     {id:6,title:'a21',pid:2},
// 	{id:7,title:'a21',pid:2},
// 	{id:8,title:'a21',pid:4},
// 	{id:9,title:'a21',pid:4},
// ];

// function cz (pid) {
// 	var f = false;
// 	for (var ii in dataBase) {
// 		if(dataBase[ii]['pid'] == pid) f = true;
// 	};
// 	return f;
// }


// for(var ii in dataBase){

// 	if (cz(dataBase[ii]['id'])) {

// 		dataBase[ii]['title'] = dataResult[ii]/2;
// 	}else{
// 		dataBase[ii]['title'] = dataResult[ii];
// 	};
		
	
// }

// console.log(dataBase)



	var data = [
	    {id:1,
	    	children:[
			    {id:2,
			    	children: [
		    		    {id:3,},
		    		]
				},
			]
		},
	];
	for (var i = 0; i < data.length; i++) {
		console.log(data[i]);
	};
	
	function treeArr (arr, ass_id) {
		var result = [], temp;
		for (var i = 0; i < arr.length; i++) {
			if (arr[i].ass_id == ass_id) {
				result.push(arr[i]);
				temp = treeArr(arr, arr[i].id);
				if (temp.length > 0) {
					arr[i].children = temp;
				};
			};
		};
		return result;
	}

	var id_number = 0;
	var node_arr = [];
	
	$('.add').click(function(){
		var label = getLabel();
		addArr(label.id_number, label.title, label.ass_id);
		insertNode(label);// 插入节点
		var tree_arr = treeArr(node_arr, 0);

		console.log(node_arr,tree_arr);
		onclick();// 点击事件
		adapt();// 自定义大小
		position();// 节点定位
		resize();// 整体居中
	});

	function getLabel () {
		id_number++;
		var title = $('#label')[0].innerText.split("\n");
		if (title.length>1) {title.pop()};
		var ass_id = 0;
		if ($('.node').attr('active')) {
			ass_id = Number($('.node[active]').attr('n'));
		}
		return {'id_number':id_number, 'title':title, 'ass_id':ass_id};
	}

	function addArr (id_number, title, ass_id) {
		node_arr.push({
			'id': id_number,
			'title': title,
			'ass_id': ass_id
		});
	}

	var pa = null;
	var child = null;
	/* 插入节点 */
	function insertNode (label) {
		var label_str = '';
		for (var i = 0; i < label.title.length; i++) {
			label_str += '<tspan>'+label.title[i]+'</tspan>';
		};

		label_str = '<g class="node" n="'+label.id_number+'"><rect/><text>'+label_str+'</text></g>';
		$('#overall')[0].innerHTML += label_str;
	}

	/* 点击事件 */
	function onclick () {
		$('#skills').click(function(){
			$('.node').removeAttr('active');
			pa = null;
		});

		$('.node').click(function(){
			$('.node').removeAttr('active');
			$(this).attr({
				'active': true,
			});
			pa = $(this).attr('n');
			return false;
		});
	}

	/* 节点定位 */
	function position () {
		var diff = 20;
		$('.node').each(function(){
			var node = this;
			var pos_x = ((getb($(this)).width + diff) * $(this).index());
			var pos_y = 0;
			if(pa){
				node = '[n^='+pa+'-]';
				pos_x = 0;
				pos_y = ((getb($('[n='+pa+']')).height + diff) * $('[n='+pa+']').index());
			}
			$(node).attr({
				'transform': 'translate('+pos_x+' '+pos_y+')',
			});
		});
	}

	/* 自适应大小 */
	function adapt () {
		var node = $('.node'),
			tspan_tab, text_tab, rect_tab;

		node.each(function(e,v){
			tspan_tab = $(v).find('tspan');
			text_tab = $(v).find('text');
			rect_tab = $(v).find('rect');

			var size = 50;
			var diff = 10;

			rect_tab.attr({
				'width': size+diff,
				'height': size+diff,
			});
			tspan_tab.attr({
				'dy': 14,
				'x': 0,
			});

			var text_w = getb(text_tab).width;
			var text_h = getb(text_tab).height;
			text_tab.attr({
				'transform': 'translate('+(size/2+diff/2)+' '+(-text_h/2+size/2)+')'
			});
		});
	}

	function getb(str){
		return str[0].getBBox();
	}
	
	$(window).bind('resize',resize);
	function resize(){
		var svg_w = $('svg').width()/2 - getb($('#overall')).width/2,
			svg_h = $('svg').height()/2 - getb($('#overall')).height/2;
		$('#overall').attr({'transform': 'translate('+(svg_w)+' '+(svg_h)+')'});
	}
	
</script>

</body>
</html>