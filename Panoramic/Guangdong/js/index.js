$(function(){
document.oncontextmenu=new Function("event.returnValue=false;");
document.onselectstart=new Function("event.returnValue=false;");

var svgbox = document.getElementsByTagName('svg')[0];
var pathList = svgbox.getElementsByTagName('path');
var schoolListBox = document.getElementById('school_list');
var schoolListUl = schoolListBox.getElementsByTagName('ul')[0];

var projectList = new Array();
var projectListName = new Array();
$('#vr_box').hide();
//在学校列表添加学校
var schoolNameArr = [
	'广州市工贸技师学院',
	'广东省机械技师学院',
	'广东省技师学院',
	'广州市机电技师学院',
	'广州市轻工技师学院',
	'岭南工商第一技师学院',
	'深圳技师学院',
	'东莞技师学院'
];
var schoolClassName = ['gongmao2','jixie2','jishi2','jidian2','qinggong2','lingnan2','shenzhen2','dongguan2'];
var schoolLogoColorArr = ['DarkOrange','#013684','#e97522','#ddb46e','#007fcc','#faee68','#208f99','#003b7d'];

for(var i=0;i<schoolNameArr.length;i++){
	createSchoolListSvg(schoolLogoColorArr[i],schoolClassName[i],schoolNameArr[i])
}
function createSchoolListSvg(color,schoolClass,school_naeme){
	var newSvg = "<li><svg viewBox='0 0 1174 1024' width='54.296875' height='25' class='"+schoolClass+"'><path xmlns='http://www.w3.org/2000/svg' d='M512 0C302.132205 0 132.000371 170.131834 132.000371 379.999629c0 43.993957 6.505994 82.06392 21.251979 125.531877C183.666321 588.999425 483.716028 1012.285011 483.716028 1012.285011c15.621985 15.619985 40.94596 15.621985 56.565945 0 0 0 299.113708-420.617589 330.461677-506.751505C889.749631 461.999549 891.999629 423.993586 891.999629 379.999629 891.999629 170.131834 721.869795 0 512 0zM512 599.999414c-121.501881 0-219.999785-98.495904-219.999785-219.999785S390.498119 159.999844 512 159.999844c121.501881 0 219.999785 98.495904 219.999785 219.999785S633.501881 599.999414 512 599.999414z' p-id='1580' fill='"+color+"'/></svg><span>"+school_naeme+"</span></li>";
		schoolListUl.innerHTML += newSvg;
		addClick();
	/*var newSvgSchoolName = document.createElement('span');
		newSvgSchoolName.innerHTML = school_naeme;
		appendObj.appendChild(newSvgSchoolName);*/
};
function addClick(){
		$('#ListUl li').click(function(){
			console.debug($(this).children('svg').attr('class'));
					projectList='';
					projectListName = '';
					
					
				document.getElementById('close').onclick = function(){
					document.getElementById('hint').style.cssText +='visibility:hidden;opacity:0';
				}
			switch($(this).children('svg').attr('class')){
					case 'gongmao2':
					setTimeout(function(){
						$('#hint').css('left',$('.gongmao').offset().left+35+'px').css('top',$('.gongmao').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '广州市工贸技师学院';
					projectList = [
						'CAD机械设计项目',
						'商务软件解决方案项目',
						'网络系统管理项目',
						'制冷与空调项目',
						'一体化课程改革理念',
						'一体化课程改革实施'
					];
					projectListName = [
						'cadjixiesheji',
						'shangwuruanjianjiejuefangan',
						'wangluoxitongguanli',
						'kongtiaoyuzhileng',
						'chengguozhanting',
						'xinxixiyitihuatixishishi'
					];
					projectMove(projectList,projectListName);
					break;
					case 'jixie2':
					setTimeout(function(){
						$('#hint').css('left',$('.jixie').offset().left+35+'px').css('top',$('.jixie').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '广东省机械技师学院';
					projectList = ['塑料模具工程项目','综合机械与自动化项目','西门子实训中心'];
					projectListName = ['suliaomojugongcheng','zonhejixieyuzidonghua','ximenzishixunzhongxin'];
					projectMove(projectList,projectListName);
					break;
					case 'jishi2':
					setTimeout(function(){
						$('#hint').css('left',$('.jishi').offset().left+35+'px').css('top',$('.jishi').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '广东省技师学院';
					projectList = ['电子技术项目','工业机械装调项目'];
					projectListName = ['dianzijishu','gongyejixiezhuangtiao'];
					projectMove(projectList,projectListName);
					break;
					case 'jidian2':
					setTimeout(function(){
						$('#hint').css('left',$('.jidian').offset().left+35+'px').css('top',$('.jidian').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '广州市机电技师学院';
					projectList = ['移动机械人'];
					projectListName = ['yidongjixieren'];
					projectMove(projectList,projectListName);
					break;
					case 'qinggong2':
					setTimeout(function(){
						$('#hint').css('left',$('.qinggong').offset().left+35+'px').css('top',$('.qinggong').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '广州市轻工技师学院';
					projectList = ['成远蛋雕艺术','曹锋明陶艺','欧福文掌画'];
					projectListName = ['chengyuandandiao','caofengmingtaoyidashigongzuoshi','oufuwenzhanghuadashigongzuoshi'];
					projectMove(projectList,projectListName);
					break;
					case 'lingnan2':
					setTimeout(function(){
						$('#hint').css('left',$('.lingnan').offset().left+35+'px').css('top',$('.lingnan').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '岭南工商第一技师学院';
					projectList = ['东风日产涂装培训','FANUC机器人教育培训','三维创客空间'];
					projectListName = ['dongfengrichantuzhuangpeixunshi','FANUCjiqirenhuanandiqujiaoyupeixunjidi','sanweichuangkekongjian'];
					projectMove(projectList,projectListName);
					break;
					case 'shenzhen2':
					setTimeout(function(){
						$('#hint').css('left',$('.shenzhen').offset().left+35+'px').css('top',$('.shenzhen').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '深圳技师学院';
					projectList = ['平面设计技术项目','珠宝加工项目'];
					projectListName = ['pingmianshejijishu','zhubaojiagong'];
					projectMove(projectList,projectListName);
					break;
					case 'dongguan2':
					setTimeout(function(){
						$('#hint').css('left',$('.dongguan').offset().left+35+'px').css('top',$('.dongguan').offset().top+25+'px').css('visibility','visible').css('opacity','1');
					},1)
					document.getElementById('schoolName').innerHTML = '东莞技师学院';
					projectList = ['中德机电一体化学习型工厂','中德汽车学习型工厂','中德物流实训车间'];
					projectListName = ['zhongdejidianyitihuaxuexixinggongchang','zhongdeqichexuexixinggongchang','zhongdewuliushixunchejian'];
					projectMove(projectList,projectListName);
					break;
					
				}
		})
	
}
	svgbox.onmouseover = function(event){
		event = event || window.event;
		var target = event.target || event.srcElement;
		if(target.id){
			svgbox.getElementById(target.id).setAttribute('fill','LightGreen');
			document.getElementById('regionName').innerHTML = '  -  '+target.id;
		}
	}

	svgbox.onclick = function(event){
		event = event || window.event;
		var target = event.target || event.srcElement;
		if(target.id){
			svgbox.getElementById(target.id).setAttribute('fill','Khaki');
			document.getElementById('regionName').innerHTML = '  -  '+target.id;
			/*switch(target.id){
				case '广州':
					Addanimate($('.gongmao'));
					Addanimate($('.jixie'));
					Addanimate($('.jidian'));
					Addanimate($('.qinggong'));
					Addanimate($('.lingnan'));
					break;
				case '深圳':
					Addanimate($('.shenzhen'));
					break;
				case '惠州':
					Addanimate($('.jishi'));
					break;
				case '东莞':
					Addanimate($('.dongguan'));
			}*/
		}
	}
	svgbox.onmouseout = function(event){
		event = event || window.event;
		var target = event.target || event.srcElement;
		if(target.id){
			svgbox.getElementById(target.id).setAttribute('fill','#fff');
		}
	}

	for(var i=0;i<document.getElementById('school').getElementsByTagName('svg').length;i++){
		document.getElementById('school').getElementsByTagName('svg')[i].onclick = function(event){
					projectList='';
					projectListName = '';
					var newSpanLeft =event.pageX;
					var newSpanTop = event.pageY;
					setTimeout(function(){
						document.getElementById('hint').style.cssText +='left:'+(newSpanLeft+10)+'px;top:'+(newSpanTop+10)+'px;visibility:visible;opacity:1';
					},1)
					
				document.getElementById('close').onclick = function(){
					document.getElementById('hint').style.cssText +='visibility:hidden;opacity:0';
				}
				switch(this.getAttribute('class')){
					case 'gongmao':
					document.getElementById('schoolName').innerHTML = '广州市工贸技师学院';
					projectList = [
						'CAD机械设计项目',
						'商务软件解决方案项目',
						'网络系统管理项目',
						'制冷与空调项目',
						'一体化课程改革理念',
						'一体化课程改革实施'
					];
					projectListName = [
						'cadjixiesheji',
						'shangwuruanjianjiejuefangan',
						'wangluoxitongguanli',
						'kongtiaoyuzhileng',
						'chengguozhanting',
						'xinxixiyitihuatixishishi'
					];
					projectMove(projectList,projectListName);
					break;
					case 'jixie':
					document.getElementById('schoolName').innerHTML = '广东省机械技师学院';
					projectList = ['塑料模具工程项目','综合机械与自动化项目','西门子实训中心'];
					projectListName = ['suliaomojugongcheng','zonhejixieyuzidonghua','ximenzishixunzhongxin'];
					projectMove(projectList,projectListName);
					break;
					case 'jishi':
					document.getElementById('schoolName').innerHTML = '广东省技师学院';
					projectList = ['电子技术项目','工业机械装调项目'];
					projectListName = ['dianzijishu','gongyejixiezhuangtiao'];
					projectMove(projectList,projectListName);
					break;
					case 'jidian':
					document.getElementById('schoolName').innerHTML = '广州市机电技师学院';
					projectList = ['移动机械人'];
					projectListName = ['yidongjixieren'];
					projectMove(projectList,projectListName);
					break;
					case 'qinggong':
					document.getElementById('schoolName').innerHTML = '广州市轻工技师学院';
					projectList = ['成远蛋雕艺术','曹锋明陶艺','欧福文掌画'];
					projectListName = ['chengyuandandiao','caofengmingtaoyidashigongzuoshi','oufuwenzhanghuadashigongzuoshi'];
					projectMove(projectList,projectListName);
					break;
					case 'lingnan':
					document.getElementById('schoolName').innerHTML = '岭南工商第一技师学院';
					projectList = ['东风日产涂装培训','FANUC机器人教育培训','三维创客空间'];
					projectListName = ['dongfengrichantuzhuangpeixunshi','FANUCjiqirenhuanandiqujiaoyupeixunjidi','sanweichuangkekongjian'];
					projectMove(projectList,projectListName);
					break;
					case 'shenzhen':
					document.getElementById('schoolName').innerHTML = '深圳技师学院';
					projectList = ['平面设计技术项目','珠宝加工项目'];
					projectListName = ['pingmianshejijishu','zhubaojiagong'];
					projectMove(projectList,projectListName);
					break;
					case 'dongguan':
					document.getElementById('schoolName').innerHTML = '东莞技师学院';
					projectList = ['中德机电一体化学习型工厂','中德汽车学习型工厂','中德物流实训车间'];
					projectListName = ['zhongdejidianyitihuaxuexixinggongchang','zhongdeqichexuexixinggongchang','zhongdewuliushixunchejian'];
					projectMove(projectList,projectListName);
					break;
					
				}
			}
	}
	function projectMove(arr,arr2){
		document.getElementById('projectBox').innerHTML = '';
		for(var i=0;i<arr.length;i++){
			var newprojectLi = document.createElement('li');
			newprojectLi.id = arr2[i];
			newprojectLi.innerHTML = arr[i];
			document.getElementById('projectBox').appendChild(newprojectLi);
			newprojectLi.onclick = function(){
				$('#vr_box').show(300);
				$('iframe').attr("src","./panorama/"+this.getAttribute('id')+"/index.html");
				closeFun(this.getAttribute('id'));

			}
		}

	}

/*	for(var i=0;i<pathList.length;i++){
		pathList[i].index = i;
		pathList[i].onmouseover = function(){
			
		}
	}*/
	// console.debug(document.getElementsByTagName('svg')[0].getElementsByTagName('path').length)
	 $(".li2").slideUp(0);
	  $(".li1").click(function(){
	     var arr = [0,1,2,3,4,5,6];
	    arr.splice($(this).index(),1);


	for(var i=0;i<arr.length;i++){
	        $(".li1").eq(arr[i]).children('div').slideUp(300);
	        $(".li1").eq(arr[i]).children('span').removeAttr('class');
	      }

		$(this).children('span').toggleClass('on');
		$(this).children('div').slideToggle(300);
	  });




		$('.li1 p').click(function(){
			$('#vr_box').show(300);
			$('iframe').attr("src","./panorama/"+this.getAttribute('name')+"/index.html");
			closeFun(this.getAttribute('name'));
		})
		
function closeFun(url){
	var vr_name = url;
	$('#vr_close').on('mousedown',function(){
	        $('#vr_box').hide(100);
			$('iframe').attr("src","");
	    }).on('touchstart',function(){
	        $('#vr_box').hide(100);
			$('iframe').attr("src","");
	    });
	    $('#vr_more').on('mousedown',function(){
	        $('#mask_box').show(300).on('mousedown',function(){
	            $(this).hide(200);
	            $('#more').html('');
	        });
	        more_name(vr_name);
	    }); 
	    $('#vr_more').on('touchstart',function(){
	        $('#mask_box').show(300).on('mousedown',function(){
	            $(this).hide(200);
	            $('#more').html('');
	        });
	        more_name(vr_name);
	    });
	}
	
	function more_name(morename){
	    switch(morename){
	        case 'cadjixiesheji':more_text("<h2>CAD机械设计中国集训基地</h2><p> 本场地为世界技能大赛CAD机械设计项目中国集训基地，同时也是先进制造产业系教学实训、培训和竞赛场地，主要服务于工业设计类专业群的一体化课程教学及学生实训，并可用于承接社会培训及校企合作产品研发项目。本场地占地面积约500平方米，投入超过1500万元人民币，配备了先进的教学实训设施设备，具体包括德国进口真空铸型机、以色列和美国的3D打印机、美国的手持式扫描仪、高性能的图形工作站等，能够同时满足40人的学习实训需要。场地还设有设备管理员进行日常管理，确保设备安全和工具、材料完整齐全。</p> <p>荣誉：</p> <p>荣获世界技能大赛CAD机械设计项目银牌和两个优胜奖；连续两届荣获“高教杯”全国大学生先进成图技术与产品信息建模创新大赛团体一等奖。</p>");
	        break;
	        case 'kongtiaoyuzhileng':more_text("<h2>制冷与空调項目中国集训基地</h2><p>本场地为世界技能大赛制冷与空调项目中国集训基地，同时也是先进制造产业系教学实训、培训和竞赛场地，主要服务于制冷运用与维修专业的一体化课程教学及学生实训，并可用于承接社会培训及校企合作产品研发项目。本场地占地面积约600平方米，投入超过1200万元人民币，配备了先进的教学实训设施设备，具体包括商用、家用冰箱、空调，小型冷库、中央空调、智能控制系统等，能够同时满足40人的学习实训需要。场地还设有设备管理员进行日常管理，确保设备安全和工具、材料完整齐全。</p> <p>荣誉：</p><p>荣获第42世界技能大赛制冷与空调项目铜牌、第43世界技能大赛制冷与空调项目银牌。</p>");
	        break;
	        case 'chengguozhanting':more_text("<h2>一体化课程改革理念</h2><p>一体化课程是按照经济社会发展需要和技能人才培养规律，根据国家职业标准及国家技能人才培养标准，以职业能力为培养目标，通过典型工作任务分析，构建课程体系，并以具体工作任务为学习载体，按照工作过程和学习者自主学习要求设计和安排教学活动，体现了理论教学和实践教学融通合一，专业学习和工作实践学做合一，能力培养和工作岗位对接合一。</p> <p>学生通过对工作任务、过程和环境所进行的整体化实践、感悟与反思，实现了专业能力、方法能力、社会能力和个人能力的整体提升。</p>");
	        break;
	        case 'xinxixiyitihuatixishishi':more_text("<h2>一体化课程改革实施</h2><p>一体化课程的实施需要配备一体化教师和一体化教学场地。一体化教师是企业工作者与教育工作者的结合体，是技术技能能手与教育教学能手的结合体，具备较高的教育教学能力、专业发展能力和企业工作实践能力，能够承担一体化课程的开发与实施工作。一体化教学场地指校内和校外教学场地，每个教学场地均由场地、设备、教师、企业师傅、学生、有关学习任务等要素组成的有机整体，并以学习任务为单位构建每一个学习工作站。</p> <p>在具备了适用的教学场地和合格的一体化教师后，一体化课程的教学实施是将具体的工作情境置于教学过程之中，以工作性思维来构建学生的学习过程，实现“工作即学习，学习即工作”，并采用行动导向教学模式，通过组织学生个体或小组主动、全面和合作式学习，完成完整的工作任务，培养学生的综合职业能力，实现一体化课程的目标。</p>");
	        break;
	        case 'wangluoxitongguanli':more_text("<h2>网络系统管理项目中国集训基地</h2><p class='textcenter'>由严宗浚大师工作室和网络系统管理学习工作站组成，含操实训区、教学区、设备存储区、阅读区及休息区。主要设备有：Cisco路由交换设备40余台；Cisco安全及语音设备30余套；Dell R920高性能服务器3台；不久将来将引入Cisco公司的顶级云服务器一套。</p>");
	        break;
	        case 'shangwuruanjianjiejuefangan':more_text("<h2>商务软件解决方案项目中国集训基地</h2><p>世界技能大赛商务软件解决方案项目中国集训基地是我院培养参加世界技能大赛参赛选手的基地和摇篮。</p> <p>基地建有30个高标准的培训工位，每个工位的都配备有高性能台式工作站。</p><p>采用.NET，SQL Server数据库等强大的软件开发工具进行软件开发 实现以赛促教,以赛促学,教赛结合,推动我院商务软件开发与应用专业的课程建设。</p>"); 
	        break;
	        // 广州市工贸技师学院 END

	        case 'pingmianshejijishu':more_text("<h2>平面设计项目中国集训基地</h2><p>深圳技师学院是第44届世界技能大赛平面设计项目中国集训基地。深圳技师学院成立平面设计技术全国选拔赛工作办公室，院长担任办公室主任，具体负责竞赛的组织安排和日常管理工作。主要包括：制定竞赛的具体方案及实施计划，并组织和监督实施，提供竞赛实施过程中的专项竞赛资金、后勤保障、设备维护、安全管理等。</p> <p>集训基地拥有Mac专业级设计工作站电脑80台，全套数码高清输入输出设备。该基地所培养的平面设计技术项目选手马韦欣，在第43届世界技能大赛上获得优胜奖，为祖国赢得了荣誉。</p><p>在集训过程中，与技术专家团队密切配合，并依托中国首个“设计之都”——深圳的设计资源，聘请平面设计行业经验丰富的专业技术人员参与集训工作，确保集训质量。通过承担世界技能大赛集训工作，深圳技师学院对本领域世界先进技术和理念有了深入了解，有利于促进现代高技能人才培养工作的发展。</p>");
	        break;

			case 'zhubaojiagong':more_text("<h2>珠宝加工项目中国集训基地</h2><p>深圳技师学院是第44届世界技能大赛珠宝加工项目中国集训基地。集训基地面积628.9平方米，2016年，学院投入186万余元用于基地设备、耗材采购，以及装修等费用。今后，学院还将继续加大投入完善建设。</p> <p>珠宝加工项目集训基地组建有一支专业参赛队伍，对世界技能大赛的规则、珠宝加工项目的技术文件进行了深入的了解和研究，参赛选手由校内专业教师和校外企业专家共同指导日常训练。学院选手曾在广东省市职业技能大赛贵金属首饰手工制作工竞赛项目中获得第二名、第三名；参加“中金杯”第二届全国黄金行业职业技能竞赛贵金属首饰手工制作工竞赛, 荣获学生组第二名，被授予“全国黄金行业技术能手”称号。</p> <p>通过积极组织和参与第44届世界技能大赛选拔、集训等工作，深圳技师学院珠宝首饰系首饰加工制作专业方向对本领域世界先进技术和理念有了深入了解，有力促进了高技能人才培养工作。</p>");
				break;
	        // 深圳技师学院 END
	        
	        case 'dongfengrichantuzhuangpeixunshi':more_text("<h2>东风日产涂装培训</h2><p>东风日产RTC定向培训班是我院与东风日产乘用车公司的校企合作项目。RTC定向班为东风日产乘用车公司定向培养专业的汽车生产技术人员，包括总装车间、焊装车间和涂装车间三大技术培训车间。</p><p>其中涂装车间技术难度最高，包括五个技术岗位：检查、打磨、精饰、喷涂和涂胶。经过三个技术项目，多个技术岗位的层层考核后才能成为东风日产的实习生。</p><p>通过该校企合作项目为东风日产乘用车公司高品质车辆生产提供最有力的保障。 </p>");
			break;
			case 'sanweichuangkekongjian':more_text("<h2>三维创客空间</h2><p>三维创客空间是我院学生开展创新、创业、创造专业学习和技术性社团活动的综合实训场所。</p><p>现配备有高精度3D打印机、三维人体成像仪、激光雕刻机、多点位PLM设计软件等先进软硬件设备、设施。可满足设计，机电一体化、模具、机器人等相关专业的产品设计、手板模型与样机制作、非标设计与制作等相关领域课程的实训教学。</p><p>现阶段，主要开展工业机器人与移动机器人的非标部件部分的三维工程设计、快速制样、应用调试等研发工作与创客领域实训教学工作，在三维创客空间里，学生能充分发挥创意思维和创造性天赋，在对机器人本体的操控学习的同时，同步完成机器人功能方案的设计和对应非标附件设计与制作，极大的提高学生学习的综合性和实用性。</p>"); 
			break;
			case 'FANUCjiqirenhuanandiqujiaoyupeixunjidi':more_text("<h2>FANUC机器人华南地区教育培训基地</h2><p>FANUC机器人华南地区教育培训基地是我院与世界工业机器人四大家族之一日本FANUC机器人公司共建的校企合作项目。</p><p>主要用于学院工业机器人应用与维护、机电一体化专业学生教学实训，为东风日产、珠海格力等企业输送机器人技术人才，已为福建省福州机电工程职校等省内外职业院校培养了多批的机器人专业骨干教师。</p> <p>实训基地规范管理，学员通过基地学习了方案设计、编程调试等实操训练，能使机器人完成搬动码垛、焊接、产品出入库、视觉分捡等工作任务，实训设备具有先进性及前瞻性。学员经过不同种技术项目，多个技术岗位的层层考核后成为一名合格的工业机器人技术人才。</p>"); 
				break;
	        // 岭南工商第一技师学院 END
	        case 'yidongjixieren':more_text("<h2>移动机器人项目集训基地</h2><p>第44届世界技能大赛移动机器人项目集训基地（广州市机电技师学院）建成于2015年，基地分两个区域：日常集训区和各级赛事举行区。</p><p>基地日常集训区位置在筑梦楼一楼，占地120平方米，集训基地场地布置按照世界技能大赛标准分为：程序编辑区、测试区、资料存放区、工量具存放区、试题解读区、争议仲裁区。各级赛事举行区设在图书馆二楼，占地300平方米。</p>"); 
				break;
	        // 机电技师学院 END
	        case 'zhongdejidianyitihuaxuexixinggongchang':more_text("<h2>中德机电一体化学习型工厂</h2><p>2014 年 4 月，我院与德国 BBW 职业教育集团签署共建学习型工厂及培训中心的协议，并于 6 月在德国 BBW 职业教育集团的支持下 建立了“最接近企业的实践教学，能产生双重价值的培训，把培训的 内容与企业流程紧密链接，把培训与就业相链接”的学习型工厂，并 以此为载体创立“学习型工厂”式双元培养模式。</p> <p>学习型工厂的建立能把职业培训和就业之间进行无缝的链接， 也就是说，在“学习型工厂”的框架下将职业培训的内容，通过实施 企业流程来进行传接，是把以学校为导向的职业培训转换到以企业为 导向、实习为导向的培训中去，为培养无缝对接企业的高技能人才奠 定了基础。</p><p>ＢＢＷ校企双制班是完全按照德国“双元制”教学模式进行培养 的。首先，该班教学是由德国ＢＢＷ培训中心外教进行管理并授课； 其次，该班的招生工作是由校企共同完成，该班所有学生都在入学的 同时已经成为相应企业的学徒；最重要的是该班的教学计划及教学内 容不仅完全按照德国培训框架计划及培训规则的要求进行制定，同时 还和企业共同开发教学模块，将企业的现实需求直接融入到全日制技 能培养中；学生在校期间不仅要完成在校的学习、实习，同时还要完 成各自的企业实践。</p>"); 
			break;
			case 'zhongdeqichexuexixinggongchang':more_text("<h2>中德汽车学习型工厂</h2><p>2014 年 4 月，我院与德国 BBW 职业教育集团签署共建学习型工厂及培训中心的协议，并于 6 月在德国 BBW 职业教育集团的支持下 建立了“最接近企业的实践教学，能产生双重价值的培训，把培训的 内容与企业流程紧密链接，把培训与就业相链接”的学习型工厂，并 以此为载体创立“学习型工厂”式双元培养模式。</p> <p>学习型工厂的建立能把职业培训和就业之间进行无缝的链接， 也就是说，在“学习型工厂”的框架下将职业培训的内容，通过实施 企业流程来进行传接，是把以学校为导向的职业培训转换到以企业为 导向、实习为导向的培训中去，为培养无缝对接企业的高技能人才奠 定了基础。</p><p>ＢＢＷ校企双制班是完全按照德国“双元制”教学模式进行培养 的。首先，该班教学是由德国ＢＢＷ培训中心外教进行管理并授课； 其次，该班的招生工作是由校企共同完成，该班所有学生都在入学的 同时已经成为相应企业的学徒；最重要的是该班的教学计划及教学内 容不仅完全按照德国培训框架计划及培训规则的要求进行制定，同时 还和企业共同开发教学模块，将企业的现实需求直接融入到全日制技 能培养中；学生在校期间不仅要完成在校的学习、实习，同时还要完 成各自的企业实践。</p>"); 
			break;
			case 'zhongdewuliushixunchejian':more_text("<h2>中德物流实训车间</h2><p>2014 年 4 月，我院与德国 BBW 职业教育集团签署共建学习型工厂及培训中心的协议，并于 6 月在德国 BBW 职业教育集团的支持下 建立了“最接近企业的实践教学，能产生双重价值的培训，把培训的 内容与企业流程紧密链接，把培训与就业相链接”的学习型工厂，并 以此为载体创立“学习型工厂”式双元培养模式。</p> <p>学习型工厂的建立能把职业培训和就业之间进行无缝的链接， 也就是说，在“学习型工厂”的框架下将职业培训的内容，通过实施 企业流程来进行传接，是把以学校为导向的职业培训转换到以企业为 导向、实习为导向的培训中去，为培养无缝对接企业的高技能人才奠 定了基础。</p><p>ＢＢＷ校企双制班是完全按照德国“双元制”教学模式进行培养 的。首先，该班教学是由德国ＢＢＷ培训中心外教进行管理并授课； 其次，该班的招生工作是由校企共同完成，该班所有学生都在入学的 同时已经成为相应企业的学徒；最重要的是该班的教学计划及教学内 容不仅完全按照德国培训框架计划及培训规则的要求进行制定，同时 还和企业共同开发教学模块，将企业的现实需求直接融入到全日制技 能培养中；学生在校期间不仅要完成在校的学习、实习，同时还要完 成各自的企业实践。</p>"); 
			break;			
	        // 东莞技师学院 END
	        case 'chengyuandandiao':more_text("<h2>孙开福蛋雕</h2><p>孙开福，艺名成远，广州市工艺美术协会会员、广州民间艺术家协会会员，工艺美术师、广东锃风艺术学院研究员、广州市轻工技师学院岭南特色工艺传承基地客座教授。</p><p>1982年进入江西省景德镇陶瓷美术学院学习。2006年开始从事蛋雕艺术创作，蛋雕艺术表现形式丰富，有浮雕、镂雕、镂空淡彩等，能在0.2豪米的蛋壳上，创造出玲珑剔透、美轮美奂的艺术作品，他被视为中国南派蛋雕重要代表之一。</p>");
			break;			
			case 'caofengmingtaoyidashigongzuoshi':more_text("<h2>曹锋明陶艺工作室</h2><p>曹锋明，1976年生于广东梅州。广东省陶瓷艺术大师，佛山市工艺美术大师，广东省技术能手，中国工艺美术学会会员，中国工艺美术协会会员，佛山市工艺美术学会会员，佛山市工艺美术行业协会副秘书长陶瓷艺术分会副会长，中级工艺美术技师，助理工艺美术师，毕业于于广州市轻工技师学院，现为广州市轻工技师学院在编教师。</p><p>早年创立锋明美术陶瓷创作院。1997年到佛山石湾智文美术陶瓷厂学习陶艺创作技艺，经15年艰辛求学，努力创作，在石湾陶艺界中崭露头角，并取得了可喜成绩，2012年的佛山中青年工艺美术精品展中曾得到过中国工艺美术大师廖洪标、黄松坚两位德高望重的国家级大师指导和点评，感悟了石湾陶艺创作新理念，技艺有了长足进步。《孝道》系列作品在2013年获得中央文明办宣传的优秀公益作品。他的作品题材风格主要体现中国传统文化的孝道、农村儿童田园生活的快乐之情。</p>"); 
			break;			
			case 'oufuwenzhanghuadashigongzuoshi':more_text("<h2>掌画大师欧福文</h2><p>欧福文，人称欧文，一九六八年出生。广州市荔湾区广彩技艺非物质文化传承人，中级美术师，高级技师，中国一百双巧手之一，中国手指画研究会会员，岭南指画艺术研究院院长，广州市优秀文化志愿者。现为广州市轻工技师学院在编教师。</p> <p>手掌当笔使，运用手掌、掌纹、手指、指甲、手臂等不同部位，协调运作，精确地利用掌纹肌理和手掌的各个部位，掌画出形象其妙景物拟真，立体极强的大自然画面。掌画与中国水墨画有着异曲同工之妙，其文化都是追求自然美。构图对象、颜色运用、审美原则、追求境界都打是相同。而掌画的独特之处就在于，它所创造出的山石、丛林、瀑布等景色，掌纹层次分明、色墨浓厚，具有水墨画不可取代的特点。</p>");
			break;			

	        // 广州市轻工技师学院 END

	        case 'gongyejixiezhuangtiao':more_text("<h2>工业机械装调项目中国集训基地</h2><p>在2016年11月，根据人力资源社会保障部关于确认第44届世界技能大赛中国集训基地的通知（人社部函〔2016〕271号）确定我校为工业机械装调项目世赛基地。按照世赛标准，学院先后投入500多万元完成基地硬件、软件建设。</p> <p>一、对竞赛场地进行建设或改造，打造机加工、焊工、电气安装、机械装调竞赛场地及其它辅助场地。</p> <p>二、配备相关基础设备及世赛最新公布的仪器、仪表等检测设备、工量具及材料以满足选手的培训、选拔和竞赛。</p> <p>三、确定专家及培训教练队伍，由技能优秀、教学经验丰富的教练共同组成实操教练组，按照世赛项目的规则要求对选手进行全面的实操训练。</p> <p>四、完成多场次集训、选拔及国际交流等工作。</p>"); 
	        break;
	        case 'dianzijishu':more_text("<h2>电子技术项目中国集训基地</h2><p>我院是第43、44届世界技能大赛电子技术项目国家集训基地，主要表现在以下几个方面：</p><p>1、承办大型省级、国家级技能大赛 我院电子技术项目集训基地为第43、44届世界技能大赛电子技术项目国家集训基地，于2014年先后承办了第43届世界技能竞赛电子技术项目广东省选拔赛、 国家选拔赛，是第43届世界技能竞赛电子技术项目国家集训队集训基地。</p> <p>2、技能竞赛取得了优异的成绩</p> <p>我院电子技术项目集训基地培养了多名优秀选手。</p> <p>3、硬件条件优越</p> <p>我院电子技术项目集训基地占地1200平方米，场地完全依照世界技能竞赛电子技术项目现场建设，训练设备先进，与世界技能竞赛电子技术项目设备保持同步，设备价值达500多万。</p> <p>4、具有一支优秀的专家教练团队</p> <p>5、地域优势、校企合作明显</p> <p>我院电子技术项目集训基地所处地区为珠江三角经济发达的惠州市，惠州市正在努力建设成为亚洲地区最大的电子信息产业研发、生产基地。我院与惠州周边的TCL、三星电子、LG、华通电脑、广州兴森科技、广州风标、深圳华为、中兴通讯等国内外知名电子企业均有近十年的合作，关系十分良好。依托惠州市及周边电子信息产业资源，能为我院电子技术项目集训基地提供更好的技术支持和服务。</p>");
	        break;

	        // 广东省技师学院 END
	        case 'ximenzishixunzhongxin':more_text("<h2>西门子实训中心</h2><p>文本素材更新中...</p>");
	        break;
	        case 'suliaomojugongcheng':more_text("<h2>塑料模具工程项目中国集训基地</h2><p>广东省机械技师学院承担了第42、43、44届世界技能大赛塑料模具项目的中国集训基地，培养出第43届世界技能大赛塑料模具工程项目铜牌选手黄灿杰、第42届世界技能大赛塑料模具工程项目优胜奖选手李伟国。</p> <p>学院先后投入2000多万元用于基地建设和集训保障工作，塑料模具工程基地现有竞赛工位16个，配备13台数控加工中心、6台机械加工设备和12套装配设备，专设有专家室、教练室、设计室、讨论学习室和检测室等功能区。</p>");
	        break;
	        case 'zonhejixieyuzidonghua':more_text("<h2>综合机械与自动化项目中国集训基地</h2><p>为满足世赛选拔和集训要求，广东省机械技师学院与行业、政府、企业等四方联动，科学规划集训基地，先后投入1200万元，购置各种仪器设备累计60台套，按照世界技能大赛标准场地、行业生产作业和工艺流程的规范分为“5区5室”：车削区、铣削区、装配区、自动化控制区、三坐标检测区以及选手室、专家室、教练室、讨论室和工具室，成为集技能大赛、选手集训、技术培训、职业指导为一体的高技能人才培养创新示范区。在第43届世界技能大赛上，第一次参加该项目比赛的选手方汉宏，一举夺得铜牌的优异成绩。</p>");
	        break;

	        // 广东省机械技师学院 END


	    }
	}
	function more_text(text){
	    $('#more').html('');
	    $('#more').append(text);
	}
})
