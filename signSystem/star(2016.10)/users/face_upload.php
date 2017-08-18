<?php 
include('../config.php'); 
include('../functions.php'); 
if(!isset($_SESSION['user'])){ die('please login!');}

$mypic = $_FILES["mypic"]; 
$userid = $_POST["userid"];

if(!empty($mypic)){ 
    $picname = $_FILES['mypic']['name']; 
    $picsize = $_FILES['mypic']['size']; 
    if ($picsize > 512000) { 
        echo '图片大小不能超过500k'; 
        exit; 
    } 

    $type = strstr($picname, '.'); 
    if ($type != ".gif" && $type != ".jpg" && $type != ".png") { 
        echo '图片格式不对！'; 
        exit; 
    } 

	$url = "img/face/".$userid.$type;
    if(move_uploaded_file($mypic["tmp_name"],$url)){
    	$sql = "UPDATE users SET face_url = '$url' WHERE id = '$userid'";
		mysql_query($sql);
    } 
} 
?> 


<meta charset="utf-8"> 
<form action="" method="post" enctype="multipart/form-data"> 
<input type="file" name="mypic"> 
<input type="submit" value="上传"> 
</form>  