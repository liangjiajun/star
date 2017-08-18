Vue.http.options.emulateJSON = true;
/*公共区域，头部以及导航*/
var header = Vue.component('header-area', {
	template: '<div class="public-area"><header class="header wrap-height">\
		<h1><a href="index.html"><img src="Images/logo.png" alt="logo"></a></h1>\
		<nav>\
				<a href="index.html"><strong class="icon1"></strong>首页</a>\
				<a href="item.html"><strong class="icon3"></strong>成员项目</a>\
				<a href="data.html"><strong class="icon2"></strong>数据统计</a>\
				<a href="manage.html"><strong class="icon4"></strong>项目管理</a>\
		</nav>	\
	</header>\
	<section class="m-title">\
		<h2>\
			星辰管理平台\
		</h2>\
			<span>我们都是浩瀚宇宙的小小星辰</span>	\
		<div class="m-user por">\
			<span class="m-user-face por">\
				<img :src="uface" :alt="uname">\
			</span>\
			<span class="m-user-name">{{uname}}</span>\
			<span class="m-user-icon"></span>\
			<ul class="m-user-hide-list">\
				<li><a :href="userhref">个人信息</a></li>\
				<li><a :href="logouthref">登出</a></li>\
			</ul>\
		</div>\
	</section></div>',
	data(){
		return {
			uname:'',
			uface:'',
			userhref:'',
			logouthref:'',
			userUrl:'php/user.php'
		}
	},
	created(){
		userData = {userData:'userData'}
		this.$http.post(this.userUrl,userData).then(function(data){
			this.uname = data.body.userName;
			this.uface = data.body.userFace;
			this.userhref = 'user.html?uid='+data.body.userId;
			this.logouthref = 'login.php?logout&sid='+data.body.signId;
			this.$nextTick(()=>{
			   var obj = JSON.stringify(data.body);
			   localStorage.setItem('userMessage',obj);
			})
	    })
	}

});









