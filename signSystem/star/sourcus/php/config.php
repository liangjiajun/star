<?php 
date_default_timezone_set('PRC');
$db = new PDO("mysql:host=localhost;dbname=star","star","123456"); 
$db->exec("set names utf8");


//时间戳相减后的总时长运算 ($second时间戳相减后的结果)
function time2string($second){
	$second = $second%(3600*24);
	$hour = floor($second/3600);
	$second = $second%3600;
	$minute = floor($second/60);
	$second = $second%60;
	return $hour.'小时'.$minute.'分'.$second.'秒';
}

/*获取用户的ip*/
function GetIP(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "无法获取！";
    }
    return $cip;
}

/*
	加密解密函数

*encrypt($string,$operation,$key)
*$string：需要加密解密的字符串；
*$operation：判断是加密还是解密，E表示加密，D表示解密；
*$key：密匙。

*/
function encrypt($string,$operation,$key=''){ 
    $key=md5($key); 
    $key_length=strlen($key); 
      $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string; 
    $string_length=strlen($string); 
    $rndkey=$box=array(); 
    $result=''; 
    for($i=0;$i<=255;$i++){ 
           $rndkey[$i]=ord($key[$i%$key_length]); 
        $box[$i]=$i; 
    } 
    for($j=$i=0;$i<256;$i++){ 
        $j=($j+$box[$i]+$rndkey[$i])%256; 
        $tmp=$box[$i]; 
        $box[$i]=$box[$j]; 
        $box[$j]=$tmp; 
    } 
    for($a=$j=$i=0;$i<$string_length;$i++){ 
        $a=($a+1)%256; 
        $j=($j+$box[$a])%256; 
        $tmp=$box[$a]; 
        $box[$a]=$box[$j]; 
        $box[$j]=$tmp; 
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256])); 
    } 
    if($operation=='D'){ 
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){ 
            return substr($result,8); 
        }else{ 
            return''; 
        } 
    }else{ 
        return str_replace('=','',base64_encode($result)); 
    } 
}
