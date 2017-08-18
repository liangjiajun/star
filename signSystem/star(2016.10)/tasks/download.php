<?php 
header("Content-type: text/html; charset=utf-8");  
include('../config.php'); 
include('../functions.php'); 
if(!isset($_SESSION['user'])){ die('没有登陆');}
$id = $_GET['id'];
$sql = "SELECT *,tasks.name as 'tname', users.username as 'uname',tasks.id as 'tid' FROM users RIGHT JOIN tasks ON tasks.user_id = users.id WHERE tasks.id = '$id'";
$r = mysql_query($sql);
$row = mysql_fetch_array($r);



if(isset($_SESSION["downloadTask"]) AND  in_array($row["tid"],$_SESSION["downloadTask"])){
}else{
    //增加下载次数
    $times = $row["downloadTimes"]+1;
    $sql = "UPDATE tasks SET downloadTimes = '$times' WHERE id = '".$row["tid"]."'";
    mysql_query($sql);
    $_SESSION["downloadTask"][] = $row["tid"];
    // die();

}

       $file_url=$row['download_path']; //路径 



       // if(file_exists("upload/564be883beeae.rar")){echo 111;}
 
       //  die();
    


       // $file_url = iconv('UTF-8','gb2312',$file_url); //linux 可能不需要



        $file_name=basename($file_url);
        $file_type=explode('.',$file_url);
       
        $downloadName = $row['uname'].$row['calendar'].$file_name;


    if (!file_exists ($file_url)) {    
        echo "文件找不到";    
        exit ();  

    } else {    
        //打开文件    
        $file = fopen ( $file_url, "r" );    
  
        Header ( "Content-type: application/octet-stream" );    
        Header ( "Accept-Ranges: bytes" );    
        Header ( "Accept-Length: " . filesize ($file_url) );    
        Header ( "Content-Disposition: attachment; filename=" . $downloadName);   
        echo fread ( $file, filesize ($file_url) );    
        fclose ( $file );    
        exit ();    
    }    