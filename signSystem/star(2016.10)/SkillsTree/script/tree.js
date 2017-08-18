
var href = location.href;
href_split = href.split('/');
href = href.replace(href_split[href_split.length-1],'');

var people = $('.user_list').val();
$('.user_list').change(function(){
	people = $(this).val();
	ajax_select();
});

var e_size = 60;// 元素大小
var space = 20;// 元素间距

/* -------------计算宽度------------- */
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

function t(d,left,i,json){
	var new_i = i+1;// 记录层级
	var line = 0;// 初始化画线
	for (var e in d) {
		var l = get_width(d[e])/2-(e_size/2)+left;// 所占宽度的一半，居中对齐
		var new_line = get_width(d[e])/2+left;// 新的画线点坐标
		
		/* x轴画线 */
		if(line > 0 && i!=0){
			$('#overall')[0].innerHTML += '<polyline points="'+(line)+','+(i*100-space)+' '+(new_line)+','+(i*100-space)+'"/>';
		}

		/* 是否有子节点，有则y轴画线 */
		if(typeof(d[e]) == 'object'){
			$('#overall')[0].innerHTML += '<polyline points="'+(l+(e_size/2))+','+(i*100+60)+' '+(l+(e_size/2))+','+(i*100+80)+'"/>';
		}

		/* 第一层的不画线 */
		if(i!=0){
			$('#overall')[0].innerHTML += '<polyline points="'+(l+(e_size/2))+','+(i*100-space)+' '+(l+(e_size/2))+','+(i*100)+'"/>';
		};

		/* 画标签 */
		insertNode(JSON.parse(json[e].title),e,l,i*100);
		// $('#overall')[0].innerHTML += '<g class="node" transform="translate('+l+' '+(i*100)+')"><rect></rect><text></text></g>';
		
		/* 若有子节点继续画 */
		if(typeof(d[e]) == 'object'){
			t(d[e],left,new_i,json);
		}
		left += get_width(d[e])+space;// 宽度叠加
		line = new_line;// 记录新线段的起点
	};
}
/* -------------计算宽度------------- */



/* -------------数组转换(树形结构)------------- */
function treeArr (arr, ass_id) {
	var result = [];
	for (var i in arr) {
		if (arr[i].ass_id == ass_id) {
			result[arr[i].id] = treeArr(arr, arr[i].id);
			if (result[arr[i].id].length == 0) {
				result[arr[i].id] = 1;
			};
		}
	};
	return result;
}
/* -------------数组转换(树形结构)------------- */



/* -------------审核------------- */
function check() {
	$('.check').click(function(){
		ajax_check($(this));
	});
	
	function ajax_check (_this) {
		var us_id = _this.attr('us_id');
		$.ajax({
			'url': href+'db/operate.php',
			'type': 'post',
			'data': 'check[id]='+us_id,
			success: function(e){
				ajax_select();
			}
		});
	}
}
/* -------------审核------------- */



/* -------------申请通过------------- */
$('.request').click(function(){
	ajax_request();
});

function ajax_request () {
	if ($('.node[active]:not([doing],[done])').length && $('.user_list option[selected]').val()==people) {
		var id = Number($('.node[active]').attr('n'));
		$.ajax({
			'url': href+'db/operate.php',
			'type': 'post',
			'data': 'request[skill_id]='+id,
			success: function(e){
				ajax_select();
			}
		});
	};
}
/* -------------申请通过------------- */



/* -------------删除------------- */
$('.del').click(function(){
	ajax_delete();
});

function ajax_delete () {
	if ($('.node[active]').length) {
		var id = Number($('.node[active]').attr('n'));
		$.ajax({
			'url': href+'db/operate.php',
			'type': 'post',
			'data': 'delete[id]='+id,
			success: function(e){
				ajax_select();
			}
		});
	};
}
/* -------------删除------------- */




/* -------------修改------------- */
$('.edit').click(function(){
	ajax_update();
});

function ajax_update () {
	if ($('.node[active]').length) {
		var title = $('#label2')[0].innerText.split("\n");
		if (title.length>1) {title.pop()};

		var id = 0;
		if ($('.node[active]').length) {
			id = Number($('.node[active]').attr('n'));
		}

		$.ajax({
			'url': href+'db/operate.php',
			'type': 'post',
			'data': 'update[id]='+id+'&update[title]='+JSON.stringify(title)+'&update[content]='+$('#content2').val(),
			success: function(e){
				ajax_select();
			}
		});
	};
}
/* -------------修改------------- */




/* -------------添加------------- */
$('.add').click(function(){
	ajax_insert();
});

function ajax_insert () {
	if ($('#label').html() != '') {
		var title = $('#label')[0].innerText.split("\n");
		if (title.length>1) {title.pop()};

		var ass_id = 0;
		if ($('.node[active]').length) {
			ass_id = Number($('.node[active]').attr('n'));
		}
		$.ajax({
			'url': href+'db/operate.php',
			'type': 'post',
			'data': 'insert[title]='+JSON.stringify(title)+'&insert[content]='+$('#content').val()+'&insert[ass_id]='+ass_id,
			success: function(e){
				ajax_select();
			}
		});
	};
}
/* -------------添加------------- */




/* -------------插入节点------------- */
function insertNode (label,key,x,y) {
	var label_str = '';
	for (var j in label) {
		label_str += '<tspan>'+label[j]+'</tspan>';
	};

	label_str = '<g class="node" n="'+key+'" transform="translate('+x+' '+y+')"><rect/><text>'+label_str+'</text></g>';
	$('#overall')[0].innerHTML += label_str;
}
/* -------------插入节点------------- */




/* -------------点击事件------------- */
function onclick () {
	$('#skills').click(function(e){
		if (e.target.id == 'skills') {
			$('.node').removeAttr('active');
		};
	});

	$('.node').click(function(){
		$('.node').removeAttr('active');
		$(this).attr({'active': true});

		var text = $(this).find('text').html().replace(/<tspan/g,"<div");
		text = text.replace(/<\/tspan>/g,"</div>");
		$('#label2').html(text);
	});
}
/* -------------点击事件------------- */




/* -------------自适应大小------------- */
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
/* -------------自适应大小------------- */



/* -------------获取SVG元素------------- */
function getb(str){
	return str[0].getBBox();
}
/* -------------获取SVG元素------------- */




/* -------------显示图形------------- */
ajax_select();
function ajax_select () {
	$.ajax({
		'url': href+'db/operate.php',
		'type': 'post',
		'data': 'select='+people,
		success: function(e){
			$('#overall')[0].innerHTML = '';
			var json = JSON.parse(e);
			var data = treeArr(json[0], 0);
			t(data, 0, 0, json[0]);
			
			if(json[1].length!=0){
				for(var i in json[1]){
					if(json[1][i]['status']==0){
						$('.node[n='+json[1][i]['skill_id']+']').attr('doing','');
					}else if(json[1][i]['status']==1){
						$('.node[n='+json[1][i]['skill_id']+']').attr('done','');
					}
				}
			}
			if($('.list').length){
				$('.list table')[0].innerHTML = '';
				for(var i in json[2]){
					if(json[2][i]['status']==0){
						$('.list table').append('\
							<tr>\
								<td><span>'+json[2][i]['username']+' : '+json[0][json[2][i].skill_id].title+'</span></td>\
								<td class="enter"><button class="check rad_5 block btn yellow" us_id='+json[2][i]['id']+'>Check</button></td>\
							</tr>\
						');
					}
				}
			}
			check();
			adapt();
			onclick();
			resize();
			content(json[0]);
		}
	});
}
/* -------------显示图形------------- */



function content (json) {
	$('.node').click(function(){
		var _n = json[$(this).attr('n')].content.replace(/\n/g,'<br/>');
		if($('.content').length){
			$('.content').html(_n);
		}
		if($('#content2').length){
			$('#content2').val(json[$(this).attr('n')].content);
		}
	});
}



/* -------------图形居中自适应------------- */
$(window).bind('resize',resize);
function resize(){
	var svg_w = $('svg').width()/2 - getb($('#overall')).width/2,
		svg_h = $('svg').height()/2 - getb($('#overall')).height/2;
	$('#overall').attr({'transform': 'translate('+(svg_w)+' '+(svg_h)+')'});
}
/* -------------图形居中自适应------------- */

