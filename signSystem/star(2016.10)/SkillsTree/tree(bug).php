<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
		body,html{ width:100%; height:100%; font-family:Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace, "微软雅黑", "黑体"; font-size:16px;}
    	*{margin: 0;padding: 0;}
		.none{ display:none;}
		.block{ display:block;}
		.oper{ position:fixed; right:0; top:0; bottom:0; width:30%; background:#fff;}
		.marg{ margin: 20px;}
		.rad_5{ border-radius: 5px;}
		.enter .input{ padding: 10px; border: 1px solid #ccc; background: #eee; min-height: 40px;}
		.enter .btn{ background: #f3a802; border: 1px solid #E69626; color: #fff; cursor: pointer; font-weight: bold; height: 40px;}
		.enter *{ box-sizing: border-box; width: 100%; margin-bottom: 10px;}
		h3{ padding: 10px; border: 1px solid #265E9B; background:#2b72bf; color: #fff;}
		/* svg */
		#skills{background:#eee; display:block;}
		text tspan{ dominant-baseline:text-after-edge; text-anchor:middle; fill: #fff;}
		
    </style>
</head>
<body>

	<svg id="skills">
    	<g id="overall">
			<g class="node">
				<rect/>
				<g class="text">
					<text><tspan>似懂非懂</tspan><tspan>似懂非懂似懂非懂</tspan><tspan>cc</tspan></text>
				</g>
			</g>
			<g class="node">
				<rect/>
				<g class="text">
					<text><tspan>似懂非懂</tspan><tspan>似懂非懂似懂非懂</tspan><tspan>cc</tspan></text>
				</g>
			</g>
		</g>
    </svg>
	<div class="oper">
    	<div class="marg">
    		<h3 class="h3 rad_5">Add Label</h3>
    		<div class="enter marg">
    			<div class="block rad_5 input label" contenteditable="true">Title</div>
    			<button class="rad_5 block btn add">Add</button>
    		</div>
    	</div>
    </div>


<script src="script/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
	
	resize();
	$(window).bind('resize',resize);
	function resize(){
		var svg_w = $(document.body).width() - $('.oper').width();
		var svg_h = $(document.body).height();
		$('#skills').css({'width': svg_w, 'height': svg_h});//屏幕自适应
		$('#overall').attr({'transform': 'translate('+(svg_w/2)+' '+(svg_h/2)+')'});//整体居中
	}
	
	$('.add').click(function(){
		// $('#overall').append();
	});
	adapt();

	/* 自适应大小 */
	function adapt(){

		var node = $('.node'),
			tspan_tab, text_tab, rect_tab;
		node.each(function(e,v){
			tspan_tab = $(v).find('tspan');
			text_tab = $(v).find('text');
			rect_tab = $(v).find('rect');

			var text_w = text_tab.width();
			var text_h = text_tab.height() * tspan_tab.length;
			var diff = 20;
			console.log(text_tab[0].getBBox());
			tspan_tab.attr({
				'dy': tspan_tab.height(),
				'x': 0,
			});
			text_tab.attr({
				'transform': 'translate(0 '+(-text_h/2)+')'
			});

			rect_tab.attr({
				'width': text_w + diff,
				'height': text_h + diff,
				'transform': 'translate('+(-text_w/2-diff/2)+' '+(-text_h/2-diff/2)+')',
				'rx': 5,
				'ry': 5,
			});
		});

		// /* 文字换行 */
		// $('.node tspan').attr({
		// 	'dy': $('.node tspan').height(),
		// 	'x': 0,
		// });
		
		// /* 文本垂直居中 */
		// $('.node .text').attr({
		// 	'transform': 'translate(0 '+(-$('.node text').height()/2)+')'
		// });
		
		// /* 矩形居中 */
		// var text_w = $('.text text').width();
		// var text_h = $('.text text').height();
		// var diff = 20;
		// $('.node rect').attr({
		// 	'width': text_w + diff,
		// 	'height': text_h + diff,
		// 	'transform': 'translate('+(-text_w/2-diff/2)+' '+(-text_h/2-diff/2)+')',
		// 	'rx': 5,
		// 	'ry': 5,
		// });
	}
	
	/*$('').bind('click',function(){
		var g = '<g class="node"></g>';
		$('#overall').append('');
	});*/
	
	$('.change').bind('blur',function(e){
		console.log($(this),this.firstChild.data,$(this).find('div'));
	});
	
</script>

</body>
</html>