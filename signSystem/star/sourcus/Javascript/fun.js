/*获取URL后面的key参数*/
function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}


/*时间格式*/
function format(v) {
	v = v<10 ? '0'+v: v;
	return v;
}

/*获取当前日期*/
function dateYear(){
  var time = new Date();
  var Y = format(time.getFullYear()); 
  var m = format(time.getMonth()+1); 
  var d = format(time.getDate()); 
  return Y+'-'+m+'-'+d;
}



/*获取下一天的时间*/
function getNextDay(d){
    d = new Date(d);
    d = +d + 1000*60*60*24;
    d = new Date(d);
    return d.getFullYear()+"-"+(format(d.getMonth()+1))+"-"+format(d.getDate());
     
}
/*获取上一天的时间*/
function getUpDay(d){
    d = new Date(d);
    d = +d - 1000*60*60*24;
    d = new Date(d);
    return d.getFullYear()+"-"+(format(d.getMonth()+1))+"-"+format(d.getDate());
     
}
