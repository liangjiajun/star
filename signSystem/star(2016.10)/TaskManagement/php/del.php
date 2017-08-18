<?php    
	include('inc/config.php');
    $id =$_GET['id'];
    $sql ="DELETE FROM taskmanagment WHERE `taskmanagment`.`TaskId`= $id ";
    mysql_query($sql);
    header('location:../index.php');
 ?>