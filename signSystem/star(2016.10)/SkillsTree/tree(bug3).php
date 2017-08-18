<?php
session_start();

/* 逆向运算 */
function get_width($data){
	if(!is_array($data)){
		return 100;// 最底层，返回值
	}
	$nm = count($data);
	
	$width = 0;
	for($i=0;$i<$nm;$i++){
		$width += get_width($data[$i]) + 20;// 加上子层的返回值
 	}
 	$width -= 20;
 	return $width;
}

$data = [
 	1,
 	[[[1,1],2],2,2],
 	3,
];

 //echo '宽度'.get_width($data);

function t($d,$left,$i){
	$i++; //计算行数
	$line = 0;
	foreach( $d as $v){
		$l = get_width($v)/2-50+$left;
		$new_line = get_width($v)/2+$left;
		if($line >0){

		}
		
		echo "<div style='padding:0;position:absolute;height:100px;width:100px;background:red;left:".$l."px; top:".($i*150)."px;'>".$line.'-'.$new_line."</div>";
		echo '左侧'.$i.'---'.$left;
		echo '宽度'.get_width($v).'<br />';
		
		if(is_array($v)){
			t($v,$left,$i);
		}
		$left += get_width($v)+20;
		$line = $new_line;
	}
}

t($data,0,0);


?>

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
    		<g class="node" n="1" transform="translate(320 0)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1</tspan></text></g>
    		<g class="node" n="1-1" transform="translate(160 80)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-1</tspan></text></g>
    		<g class="node" n="1-1-1" transform="translate(0 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-1-1</tspan></text></g>

    		<g class="node" n="1-1-2" transform="translate(120 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-1-2</tspan></text></g>
    		<g class="node" n="1-1-2-2" transform="translate(160 240)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-1-2-2</tspan></text></g>

    		<g class="node" n="1-1-3" transform="translate(240 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-1-3</tspan></text></g>
    		<g class="node" n="1-1-4" transform="translate(320 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-1-4</tspan></text></g>
    		
    		<g class="node" n="1-2" transform="translate(400 80)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-2</tspan></text></g>
    		<g class="node" n="1-2-1" transform="translate(400 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-2-1</tspan></text></g>
    		<g class="node" n="1-3-1" transform="translate(480 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-3-1</tspan></text></g>
    		
    		<g class="node" n="1-3" transform="translate(560 80)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-3</tspan></text></g>
    		<g class="node" n="1-3-3" transform="translate(640 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-3-3</tspan></text></g>
    		<g class="node" n="1-3-3-1" transform="translate(640 240)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-3-3-1</tspan></text></g>
    		<g class="node" n="1-3-2" transform="translate(560 160)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-3-2</tspan></text></g>
    		<g class="node" n="1-1-2-1" transform="translate(80 240)"><rect width="60" height="60"></rect><text transform="translate(30 18)"><tspan dy="14" x="0">1-1-2-1</tspan></text></g>
    	</g>
    </svg>
	<div class="oper">
    	<div class="padd">
    		<h3 class="h3 rad_5">Add Label</h3>
    		<div class="enter padd">
    			<div class="label block rad_5 input" contenteditable="true">Title</div>
    			<button class="add rad_5 block btn">Add</button>
    		</div>
    	</div>
    </div>


<script src="script/jquery-1.11.3.min.js"></script>
<script type="text/javascript">

// function get_width($data){
// 	if(!is_array($data)){
// 		return 100;
// 	}
// 	$nm = count($data);
	
// 	$width = 0;
// 	for($i=0;$i<$nm;$i++){
// 		$width += get_width($data[$i]) + 20;

// 	print_r($width);
// 	}
// 	$width -= 20;
// 	return $width;
// }

// $data = [
// 	1,
// 	[2.1,2.2],
// 	3,
// ];

// echo '宽度'.get_width($data);



function recursives (node) {
	if (typeof(node) != 'object') {
		return 80;
	};

	var width = 0;
	for (var i = 0; i < node.length; i++) {
		width += recursives(node[i]);
	};

	return width;
}

// console.log(recursives());

function skills (node) {
	var increment = '';
	node.each(function(i){
		console.log(i);
	});
}

var node_max = [];
var node_arr = [];
$('.node').each(function(){
	var split = $(this).attr('n').split('-');
	node_max[split.length-1] = 0;
	node_arr.push({'n':$(this).attr('n'), 'len':split.length});
	// if(!node_arr[split.length-1]){
	// 	node_arr[split.length-1] = [];
	// }
	// node_arr[split.length-1].push($(this).attr('n'));
});
node_max = node_max.length;

var group = {};
for(key in node_arr){
	// console.log(node_arr[key].length);
	for (var i = 0; i < node_arr[key].length; i++) {
	};
}

function a (node, inc) {
	var arr = [], temp;
	node.forEach(function(v, i){
		if (v.len == inc) {
			arr.push(v);
			temp = a(node, inc+1);
			if(temp.length > 0){
				v.child = temp;
			}
		};
	});
	return arr;
}
// console.log(node_arr);
console.log(a(node_arr, 1)[0]);
// a(node_arr, 1);



var data = [
    {id:1,title:'a',pid:0},
    {id:2,title:'a1',pid:1},
    {id:3,title:'a11',pid:2},
    {id:4,title:'a12',pid:2},
    {id:5,title:'a2',pid:1},
    {id:6,title:'a21',pid:5}
];
function fn(data,pid){
    var result = [] , temp;
    for(var i in data){
        if(data[i].pid==pid){
            result.push(data[i]);
            temp = fn(data,data[i].id);
            if(temp.length>0){
                data[i].children=temp;
            }
        }
    }
    return result;
}
console.log(fn(data , 0)[0]);
// a(node_arr,1);
// var aa = 0;
// function a (node, inc) {
// 	if(!node[inc+1]){
// 		console.log(node[inc]);
// 		return //node[inc].join('-');
// 	}

// 	// v[1]:v[1-1],v[1-2]
// 	// v[1-1]:v[1-1-1] v[1-2]:v[1-2-1],v[1-2-2]
// 	// v[1-2-1]:v[1-2-1-1]
// 	var arr = {};
// 	for (var i=0;i < node[inc].length;i++) {
// 		var parent = node[inc][i].join('-');

// 		for (var j = 0; j < node[inc+1].length; j++) {
// 			var child = node[inc+1][j].slice(0,inc).join('-');

// 			if (child == parent) {
// 				// console.log(node[inc][i],node[inc+1][j],child == parent);
// 				arr[parent] = a(node, inc+1);
// 			};
// 		};
// 		// arr[node[inc][i].join('-')] = a(node, inc+1);
// 	};
// 	return arr;
// }
// console.log(node_arr)


// var arr = [];
// function a(v){
// 	if(v == 0){
// 		return v;
// 	}
// 	v--;
// 	arr[arr.length] = [];
// 	a(v);
// 	return arr[arr.length];
// }
// console.log(a(6));





var g_node = [];
var g_arr = [];
$('.node').each(function(){
	var split = $(this).attr('n').split('-');
	g_node[$(this).attr('n')] = split;
	g_arr[split.length] = [];
});
g_node.forEach(function(v){
	g_arr[v.length].push(v);
});

var level = [];
for (var i = 1; i < g_arr.length; i++) {
	level.push(1);
};
// console.log(g_node);

var n_pos = 0;
// console.log(level);
recursive(level);
function recursive (node) {

	if (g_node[level.join('-')]) {
		n_pos += 80;
		node[node.length-1] += 1;
		// console.log(node);
		// recursive(node);
	} else{
		if (node[node.length-1] == 1) {
			n_pos += 80;
			node.pop();
			// console.log(n_pos,node);
			recursive(node);
		}
	};

	if (g_arr.length-1 == node.length) {
		// if (node.cz) {
		// 	n = n+80;
		// 	recursive(node.next);
		// } else{
		// 	if (node.name_last_str == 1) {
		// 		n = n+80;
		// 	}

		// 	recursive(node.parent+1);
		// };
	} else{
		// if (node.cz) {
		// 	recursive(node.firstchild);
		// } else{
		// 	recursive(node.parent+1);
		// };
	};
}

// if (g_node[level.join('-')]) {
// 	n_pos += 80;
// 	console.log(node);
// 	node[node.length-1] += 1;
// 	recursive(node);
// } else{
// 	console.log(g_node[node[node.length-2]+1]);
// 	if (g_node[node[node.length-2]+1]) {
// 		if (node[node.length-1] == 1) {
// 			n_pos += 80;
// 		};
// 		node[node.length-2] += 1;
// 	} else{};
// 	// recursive(node);
// };


var n = 0;//x距离
function Dg (node) {//递归

	if(node.ceng==4){//是否第四层

			if(node.cz){//存在？
				n = n+80;

				Dg(node.next);//下一个节点
			}else{//不存在
				if(node.name_last_str==1){//是否第一个
					n = n+80;
				}

				Dg(node.parent+1);//父亲下一个

			}
	}else{

			if(node.cz){
				//父节点以子节点居中
				Dg(node.firstchild);//第一个子节点
			}else{
				Dg(node.parent+1);//父亲下一个
			}
	}
}



	var n_arr = [];
	var pos_arr = {};
	var toArr = [];
	$('.node').each(function(){
		var attr = $(this).attr('n');
		var split = attr.split('-');
		n_arr.push(split);
		toArr[split.length] = [];
	});
	n_arr.sort();
	for (var i = 0; i < n_arr.length; i++) {
		toArr[n_arr[i].length].push(n_arr[i]);
	};
	// console.log(toArr);

	
	$('.add').click(function(){
		insertNode();// 插入节点
		onclick();// 点击事件
		adapt();// 自定义大小
		position();// 节点定位
		resize();// 整体居中
		$(".node").click(function(){
			// pa = $(this).attr('n');
		});
	});

	var pa = null;
	var child = null;
	
	/* 插入节点 */
	function insertNode () {
		var node_str = '<tspan>'+$('.label')[0].firstChild.nodeValue+'</tspan>';

		$('.label').find('div').each(function(){
			node_str += '<tspan>'+$(this).html()+'</tspan>';
		});

		if(pa == null){
			child = $('.node').length+1;
		}else{
			child = pa+'-'+($('[n^='+pa+'-]').length+1);
		}
		node_str = '<g class="node" n="'+child+'"><rect/><text>'+node_str+'</text></g>';

		$('#overall')[0].innerHTML += node_str;
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