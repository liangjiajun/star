<?php

//用php判断时间戳来输出刚刚，分钟前，小时前昨天和时间

function T($time)
{
   //获取今天凌晨的时间戳
   $day = strtotime(date('Y-m-d',time()));
   //获取昨天凌晨的时间戳
   $pday = strtotime(date('Y-m-d',strtotime('-1 day')));
   //获取现在的时间戳
   $nowtime = time();
    
   $tc = $nowtime-$time;
   if($time<$pday){
      $str = date('Y-m-d H:i:s',$time);
   }elseif($time<$day && $time>$pday){
      $str = "昨天";
   }elseif($tc>60*60){
      $str = floor($tc/(60*60))."小时前";
   }elseif($tc>60){
      $str = floor($tc/60)."分钟前";
   }else{
      $str = "刚刚";
   }
   return $str;
}


// 使用方法

// ?
// 1
// echo T("时间戳");


function currentURL(){
   return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; //.'?'.$_SERVER['QUERY_STRING'] 没有Query部分

}

function currentURLS(){
   return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']; // 

}



//多种文件格式下载
function download($file_url,$new_name=''){
                
        // $file_url=iconv('utf-8','gb2312',$file_url); 
        //将编码转为支持中英文的gb2312编码  iconv(input,output,source)

        if(!isset($file_url)||trim($file_url)==''){
            return '500';
        }
        // if(!<a href="https://www.baidu.com/s?wd=file_exists&tn=44039180_cpr&fenlei=mv6quAkxTZn0IZRqIHckPjm4nH00T1d9PWuBnHbsmH--P1N9uANB0AP8IA3qPjfsn1bkrjKxmLKz0ZNzUjdCIZwsrBtEXh9GuA7EQhF9pywdQhPEUiqkIyN1IA-EUBtkPH04P1n1njD3P1m1Pjn3PWcs" target="_blank" class="baidu-highlight">file_exists</a>($file_url)){ //检查文件是否存在
        //     return '404';
        // }
        $file_name=basename($file_url);
        $file_type=explode('.',$file_url);
        $file_type=$file_type[count($file_type)-1];
                $file_name=trim($new_name=='')?$file_name:urlencode($new_name).'.'.$file_type;
        //输入文件标签
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".filesize($file_url));
        header("Content-Disposition: attachment; filename=".$file_name);
        $file_type=fopen($file_url,'r'); //打开文件
        //输出文件内容
        $file_size=filesize($file_url);//获取文件大小
         $buffer=1024;   //定义1KB的缓存空间
                 $file_count=0;  //计数器,计算发送了多少数据
                 while(!feof($file_type) && ($file_size>$file_count)){ 
                 //如果文件还没读到结尾，且还有数据没有发送 
                 $senddata=fread($file_type,$buffer);
                 //读取文件内容到缓存区
                 $file_count+=$senddata;
                  echo $senddata;
                  }
        //echo fread($file_type,filesize($file_url));
        fclose($file_type);
    }


// function downloadFile($file){
 
//     //First, see if the file exists
//     if (!is_file($file)) { die("<b>404 File not found!</b>"); }
 
//     //Gather relevent info about file
//     $len = filesize($file);
//     $filename = basename($file);
//     $file_extension = strtolower(substr(strrchr($filename,"."),1));
 
//     //This will set the Content-Type to the appropriate setting for the file
//     switch( $file_extension ) {
//       //case "pdf": $ctype="application/pdf"; break;
//       //case "exe": $ctype="application/octet-stream"; break;
//       case "zip": $ctype="application/zip"; break;
//       case "doc": $ctype="application/msword"; break;
//       case "xls": $ctype="application/vnd.ms-excel"; break;
//       case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
//       case "gif": $ctype="image/gif"; break;
//       case "png": $ctype="image/png"; break;
//       case "jpeg":$ctype="image/jpg"; break;
//       case "jpg": $ctype="image/jpg"; break;
//       //case "mp3": $ctype="audio/mpeg"; break;
//       //case "wav": $ctype="audio/x-wav"; break;
//       //case "mpeg":
//       //case "mpg":
//       //case "mpe": $ctype="video/mpeg"; break;
//       //case "mov": $ctype="video/quicktime"; break;
//       //case "avi": $ctype="video/x-msvideo"; break;
 
//       //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
//       case "php":
//       case "htm":
//       case "html":
//       case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;
 
//       default: $ctype="application/force-download";
//     }
 

// header("Content-type: application/octet-stream");
// header("Accept-Ranges: bytes");
// header("Accept-Length: ".$len);
// header("Content-Disposition: attachment; filename=" . $filename);



//     //Begin writing headers
//     // header("Pragma: public");
//     // header("Expires: 0");
//     // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//     // header("Cache-Control: public"); 
//     // header("Content-Description: File Transfer");
     
//     //Use the switch-generated Content-Type
//     // header("Content-Type: $ctype");
 
//     // //Force the download
//     // $header="Content-Disposition: attachment; filename=".$filename.";";
//     // header($header );
//     // header("Content-Transfer-Encoding: binary");
//     // header("Content-Length: ".$len);
//     file_get_contents($file);
//     exit;
// }
 
//获得扩展名
 function get_extension($file) 
{ 
return pathinfo($file, PATHINFO_EXTENSION); 
} 

?>