<meta charset="UTF-8" />
<?php

include('../config.php');
include('../functions.php');




	  	$sql = "SELECT * FROM `tasks`";
        $r = mysql_query($sql);


        while($row = mysql_fetch_array($r)){

            
        	// echo $dataURL=iconv('UTF-8','GB2312',$row['download_path']);

            // echo $row['download_path'];

            echo $dataURL = $row['download_path'];

        	if (file_exists ($dataURL)) {

                echo 111;
       		
        		$newpath = 'upload/'.uniqid().".".get_extension($dataURL);

        		if(rename($dataURL,$newpath)){ //如果改名成功

        				echo $sql = "UPDATE tasks SET download_path = '$newpath' WHERE id = '$row[id]'";
        				mysql_query($sql);
                    
                    echo 222;

        		}

        		// echo get_extension($dataURL); //获得扩展名



        	}
        	echo "<br>";


        }


die();

        // $dataURL = "../tasks/".$row['download_path'];

        //Windows 下需要转一转，但Linux 可能要删除
        $dataURL=iconv('UTF-8','GB2312',$dataURL);

       // $dataURL = "../tasks/upload/f965a3279b46d8685b0312d650afe4fb打字测试成绩.jpg";
     
   		
        if (file_exists ($dataURL)) {
        	// echo 111;
            if(unlink ( $dataURL )){
                mysql_query('DELETE FROM `tasks` WHERE id = '.$did); //附件先删除，再删除记录
                header("location:personal.php?userid=".$userid);
            }else{
                
            }
         }else{
         		// echo 222;
         
         }

?>