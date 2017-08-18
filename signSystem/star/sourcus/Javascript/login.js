window.onload = ()=>{
	
	/*用户信息*/
	var userLogin = new Vue({
	    el:'#content',
	    data:{
	    	userName:'',
	    	userId:'',
	    	userFace:'',
	    	userRoot:'',
			signId:'',
			userUpdate:'',
			onlineTime:'',
			signTime:'',
	    	apiUrl:'sourcus/php/user.php'
	    },
	    created(){
			var userLoginData={userData:'userGetData'}
			this.$http.post(this.apiUrl,userLoginData).then(function(data){
				console.log(data.body);
		        	if(data.body==1){
		        		window.location.href='login.html';
		        	}else{
		        		
		        		this.userName =data.body.userName;
		        		this.userId =data.body.userId;
		        		this.userRoot =data.body.userRoot;
		        		this.signId =data.body.signId;
		        		this.userUpdate = 'user.html?uid='+data.body.userId;
		        		this.userFace={
		        			background:'url('+data.body.userFace+') no-repeat center',
		        			backgroundSize: '100% 100%'
		        		}
		        		this.onlineTime = data.body.onlineTime;
		        		this.signTime = data.body.signTime;

		        		var obj = JSON.stringify(data.body);
		        		localStorage.setItem('userMessage',obj);

		        	}
		      	 

		    })

	    }
	})
}