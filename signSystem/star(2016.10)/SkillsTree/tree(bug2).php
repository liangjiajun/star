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
					<text><tspan>似懂非懂</tspan><tspan>似懂非懂似</tspan><tspan>cc</tspan></text>
				</g>
			</g>
			<g class="node" transform="translate(0 160)">
				<rect/>
				<g class="text">
					<text><tspan>似懂非懂</tspan><tspan>似懂</tspan><tspan>cc</tspan></text>
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

		var svg_w = svg_w/2 - $('#overall')[0].getBBox().width/2;
		var svg_h = svg_h/2 - $('#overall')[0].getBBox().height/2;
		$('#overall').attr({'transform': 'translate('+(svg_w)+' '+(svg_h)+')'});//整体居中
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

			var size = 100;
			var diff = 20;
			var rad = 8;

			rect_tab.attr({
				'width': size,
				'height': size,
				'transform': 'translate('+(-size/2)+' '+(-size/2)+')',
				// 'stroke': '#2b72bf',
				// 'stroke-width': 4,
				'rx': rad,
				'ry': rad,
			});

			var text_h = tspan_tab.height() * tspan_tab.length;
			tspan_tab.attr({
				'dy': tspan_tab.height(),
				'x': 0,
			});
			text_tab.attr({
				'transform': 'translate(0 '+(-text_h/2)+')'
			});
		});
	}
	
</script>

</body>
</html>